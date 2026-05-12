<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attempt;
use App\Models\User;
use App\Models\Dimension;
use App\Models\MadurityLevel;
use App\Models\AnsweredUser;
use App\Http\Helpers\Equivalencias;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * List completed attempts with optional subregion filtering.
     */
    public function completedMedition(Request $request){
        $subregion = $request->input('subregion');
        
        $query = Attempt::where('completed', 1);

        if ($subregion) {
            $query->whereHas('user', function($q) use ($subregion) {
                $q->where('size_organization', $subregion);
            });
        }

        $attempts = $query->with('user')->get();
        return view("reports.completedMedition", compact("attempts", "subregion"));
    }

    /**
     * Display a consolidated dashboard with charts and general stats.
     */
    public function consolidatedReport(Request $request) {
        $subregion = $request->input('subregion');
        $search = $request->input('search');
        
        // 1. All Completed Attempts (Global)
        $allAttemptIds = Attempt::where('completed', 1)->pluck('id');
        $totalGlobalAttempts = $allAttemptIds->count();

        // 2. Filtered Attempts
        $attemptsQuery = Attempt::where('completed', 1);
        if ($subregion) {
            $attemptsQuery->whereHas('user', function($q) use ($subregion) {
                $q->where('size_organization', $subregion);
            });
        }
        if ($search) {
            $attemptsQuery->whereHas('user', function($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('document', 'LIKE', "%{$search}%");
                });
            });
        }
        $attemptIds = $attemptsQuery->pluck('id');
        $totalAttempts = $attemptIds->count();

        // --- STATS CALCULATION ---

        $dimensions = Dimension::where('status', 1)->get();
        $dimensionStats = [];

        if ($totalGlobalAttempts > 0) {
            // Global Scores
            $globalScores = DB::table('answered_user as b')
                ->join('answer as c', 'b.answer_id', '=', 'c.id')
                ->join('question as d', 'c.question_id', '=', 'd.id')
                ->join('form as e', 'd.form_id', '=', 'e.id')
                ->join('dimension as f', 'e.dimension_id', '=', 'f.id')
                ->select('f.id', DB::raw('SUM(c.points) as total_score'))
                ->whereIn('b.attemp_id', $allAttemptIds)
                ->groupBy('f.id')
                ->get();

            // Filtered Scores
            $filteredScores = collect();
            if ($totalAttempts > 0) {
                $filteredScores = DB::table('answered_user as b')
                    ->join('answer as c', 'b.answer_id', '=', 'c.id')
                    ->join('question as d', 'c.question_id', '=', 'd.id')
                    ->join('form as e', 'd.form_id', '=', 'e.id')
                    ->join('dimension as f', 'e.dimension_id', '=', 'f.id')
                    ->select('f.id', DB::raw('SUM(c.points) as total_score'))
                    ->whereIn('b.attemp_id', $attemptIds)
                    ->groupBy('f.id')
                    ->get();
            }

            foreach ($dimensions as $dim) {
                $gScore = $globalScores->where('id', $dim->id)->first();
                $fScore = $filteredScores->where('id', $dim->id)->first();
                
                $dimensionStats[] = [
                    'name' => $dim->name,
                    'global_avg' => round(($gScore ? $gScore->total_score : 0) / $totalGlobalAttempts, 2),
                    'filtered_avg' => $totalAttempts > 0 ? round(($fScore ? $fScore->total_score : 0) / $totalAttempts, 2) : 0,
                    'max' => $dim->max_range
                ];
            }
        }

        // Maturity Levels (Filtered only for Bar Chart)
        $maturityDist = DB::table('attemps as a')
            ->join('answered_user as b', 'a.id', '=', 'b.attemp_id')
            ->join('answer as c', 'b.answer_id', '=', 'c.id')
            ->select('a.id', DB::raw('SUM(c.points) as total_points'))
            ->whereIn('a.id', $attemptIds)
            ->groupBy('a.id')
            ->get();

        $levels = MadurityLevel::where('status', 1)->get();
        $levelCounts = [];
        foreach ($levels as $level) {
            $count = $maturityDist->filter(function($item) use ($level) {
                return $item->total_points >= $level->min_range && $item->total_points <= $level->max_range;
            })->count();
            $levelCounts[] = ['name' => $level->visible_name, 'count' => $count];
        }

        // 4. Aggregated Responses per Question (Frequency Analysis with Regional Segregation)
        $questionBreakdown = [];
        if ($totalAttempts > 0) {
            $rawBreakdown = DB::table('answered_user as b')
                ->join('answer as c', 'b.answer_id', '=', 'c.id')
                ->join('question as d', 'c.question_id', '=', 'd.id')
                ->join('users as u', 'b.user_id', '=', 'u.id')
                ->select('d.id as q_id', 'd.statement', 'c.option', 'u.size_organization as subregion', DB::raw('COUNT(b.id) as count'))
                ->whereIn('b.attemp_id', $attemptIds)
                ->groupBy('d.id', 'd.statement', 'c.id', 'c.option', 'u.size_organization')
                ->orderBy('d.id')
                ->get();
            
            foreach ($rawBreakdown as $row) {
                $questionBreakdown[$row->q_id]['statement'] = $row->statement;
                // Grouping by option and then by subregion
                $questionBreakdown[$row->q_id]['options'][$row->option]['subregions'][$row->subregion] = $row->count;
                
                // Track total for the option across shown subregions
                if (!isset($questionBreakdown[$row->q_id]['options'][$row->option]['total'])) {
                    $questionBreakdown[$row->q_id]['options'][$row->option]['total'] = 0;
                }
                $questionBreakdown[$row->q_id]['options'][$row->option]['total'] += $row->count;
            }
        }

        // 5. Detailed Responses (1 by 1)
        $detailedResponses = AnsweredUser::with(['user', 'question', 'anwser'])
            ->whereIn('attemp_id', $attemptIds)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // 6. Average Score per Subregion (Regional Benchmarking)
        $regionalAverages = DB::table('attemps as a')
            ->join('answered_user as b', 'a.id', '=', 'b.attemp_id')
            ->join('answer as c', 'b.answer_id', '=', 'c.id')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->select('u.size_organization as subregion', DB::raw('SUM(c.points) / COUNT(DISTINCT a.id) as avg_score'))
            ->where('a.completed', 1)
            ->groupBy('u.size_organization')
            ->get();

        $regionalLabels = [];
        $regionalData = [];
        foreach ($regionalAverages as $reg) {
            $regionalLabels[] = Equivalencias::whichZone($reg->subregion);
            $regionalData[] = round($reg->avg_score, 2);
        }

        return view("reports.consolidated", compact(
            "totalAttempts", 
            "totalGlobalAttempts",
            "levelCounts", 
            "dimensionStats", 
            "subregion",
            "search",
            "detailedResponses",
            "questionBreakdown",
            "regionalLabels",
            "regionalData"
        ));
    }
}
