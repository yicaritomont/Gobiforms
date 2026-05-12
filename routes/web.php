<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MadurityLevelController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\DimensionsController;
use App\Http\Controllers\DimensionScoreController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ConstructFormController;
use App\Http\Controllers\Auth\RemindersController;
use App\Http\Controllers\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('startPage.index');
});

// RUTAS DE REGISTRO
Auth::routes();
Route::get('/register/verify/{code}', 'Auth\RegisterController@verify');
Route::resource('reminder', RemindersController::class);
Route::get('reminder',[RemindersController::class, 'getRemind'])->name('reminder');
Route::post('postRemind',['as'=>'postRemind','uses' => 'RemindersController@postRemind']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Rutas gestionadas una vez se inicia la sesion.
 */
Route::group( ['middleware' => ['auth']], function() { 
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    // RUTAS DASHBOARD
    Route::get('dashBoardAdmin',[App\Http\Controllers\DashboardController::class, 'dashBoardAdmin'])->name('dashBoardAdmin');
    Route::get('dashBoardUser',[App\Http\Controllers\DashboardController::class, 'dashBoardUser'] )->name('dashBoardUser');

    // RUTAS PARAMETRIZACION
    Route::resource('roles', RoleController::class);
    Route::put('/roles/{id}/update-status', [App\Http\Controllers\RoleController::class, 'rolUpdateStatus'])->name('roles.updateStatus');

    Route::resource('madurityLevel', MadurityLevelController::class);
    Route::put('/madurityLevel/{id}/update-status', [App\Http\Controllers\MadurityLevelController::class, 'UpdateStatus'])->name('madurityLevel.updateStatus');

    Route::resource('factor', FactorController::class);
    Route::put('/factor/{id}/update-status', [App\Http\Controllers\FactorController::class, 'UpdateStatus'])->name('factor.updateStatus');
    
    Route::resource('dimension', DimensionsController::class);
    Route::put('/dimension/{id}/update-status', [App\Http\Controllers\DimensionsController::class, 'UpdateStatus'])->name('dimension.updateStatus');

    Route::resource('dimensionScore', DimensionScoreController::class);

    Route::resource('form', FormsController::class);
    Route::put('/form/{id}/update-status', [App\Http\Controllers\FormsController::class, 'UpdateStatus'])->name('form.updateStatus');

    Route::resource('question', QuestionsController::class);
    Route::put('/questions/{id}/update-status', [App\Http\Controllers\QuestionsController::class, 'UpdateStatus'])->name('question.updateStatus');
    
    Route::get('/answer/{question_id}/add', [App\Http\Controllers\AnswerController::class, 'create'])->name('answer.addAnswer');
    Route::get('/answer/{question_id}/edit', [App\Http\Controllers\AnswerController::class, 'edit'])->name('answer.edit');
    Route::put('/answer/{question_id}/update', [App\Http\Controllers\AnswerController::class, 'update'])->name('answer.update');
    Route::get('/answer/{question_id}/list', [App\Http\Controllers\AnswerController::class, 'list'])->name('answer.listAnswer');
    Route::post('/answer/store', [App\Http\Controllers\AnswerController::class, 'store'])->name('answer.store');
    Route::put('/answer/{id}/update-status', [App\Http\Controllers\AnswerController::class, 'UpdateStatus'])->name('answer.updateStatus');

    // RUTAS PARA MEDICIÓN
    Route::resource('startForm', ConstructFormController::class);
    Route::get("showResults", [App\Http\Controllers\ConstructFormController::class, 'showResults'])->name('showResults');
    Route::get("showRecomendations", [App\Http\Controllers\ConstructFormController::class, 'showRecomendations'])->name('showRecomendations');

    // Ruta para Resumen
    Route::get("showResume/{attemp_id}", [App\Http\Controllers\ConstructFormController::class, 'showResume'])->name('showResume');

    // Rutas para Reportes
    Route::get("completedMedition",[App\Http\Controllers\ReportsController::class, 'completedMedition'])->name('completedMedition');
    Route::get("consolidatedReport",[App\Http\Controllers\ReportsController::class, 'consolidatedReport'])->name('consolidatedReport');



    Route::resource('users', UserController::class);


});
