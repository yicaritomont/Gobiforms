<?php

/**
 * Equivalencia.php
 * Ruta:app/Http/Helpers
 * Fecha Creación:    Julio 2020
 * Clase equivalencia que permite gestionar los valores estándar que utilizaran
 * en la aplicación
 *
 * @author           Yineth Carolina Montes Gomez
 * @copyright        2020
 * @license          GPL 2 or later
 * @version          2020
 *
 */

namespace App\Http\Helpers;
use Illuminate\Support\Carbon;

class Equivalencias {
    private static $tieneTodosLosPermisos = 'A';

    private static $esUsuarioAdmin = [
        '1' => 'Administrador',
    ];
    private static $tiposUsuarioRegistro = [
        '2' => 'Usuario',
        '3' => 'Invitado',
    ];

    private static $regimenTributario = [
        
        'RC' => 'Régimen Común',
        'RS' => 'Régimen Simplificado',
        'RE' => 'Régimen Especial'
    ];
    private static $pais = [
        ''  => 'Seleccione',
        '1' => 'Colombia',
        '2' => 'Otro....'
    ];
    // EQUIVALENCIAS EMPRESA
    private static $tipoEmpresa = [
        
        '1' => 'Tipo 1',
        '2' => 'Tipo 2'
    ];

    private static $estiloAlert = "position: relative;
                    padding: 0.75rem 1.25rem;
                    margin-bottom: 1rem;
                    border: 1px solid transparent;
                    border-radius: 0.25rem;";
    private static $success = "color: #1d643b;
                    background-color: #d7f3e3;
                    border-color: #c7eed8;";
    private static $danger =  "color: #761b18;
                    background-color: #f9d6d5;
                    border-color: #f7c6c5;";


    
    private static $numeroMaximoInvitacionesEnviar = 5;

    public static function tieneTodosLosPermisos()
    {
        return self::$tieneTodosLosPermisos;
    }

    public static function esUsuarioAdmin()
    {
        return self::$esUsuarioAdmin;
    }

    public static function tiposUsuarioRegistro()
    {
        return self::$tiposUsuarioRegistro;
    }

    public static function estiloAlert()
    {
        return self::$estiloAlert;
    }

    public static function success()
    {
        return self::$success;
    }

    public static function danger()
    {
        return self::$danger;
    }

    public static function tipoEmpresa()
    {
        return self::$tipoEmpresa;
    }

    public static function parceFecha($fecha)
    {

        $parse = Carbon::parse($fecha);
        $fechas =  Carbon::createFromFormat('Y-m-d H:i:s', $parse);
        return ['fecha_escogida' => $fecha, 'fecha_60_min' => $fechas->addMinutes(60)];
    }

    public static function whichZone($zone) {
        switch ($zone) {
            case "SNOR":
            $stringZone= "Subregión Norte";
            break;

            case "SNEV":
            $stringZone= "Subregión Nevados";
            break;

            case "SCEN":
            $stringZone= "Subregión Ibagué (centro)";
            break;

            case "SORI":
            $stringZone= "Subregión Oriente";
            break;

            case "SURO":
            $stringZone= "Subregión Sur-Oriente";
            break;

            case "SSUR":
            $stringZone= "Subregión Sur";
            break;

            case 'value':
            # code...
            break;
            
            default:
            $stringZone ="NR";
            break;
        }
        return $stringZone;
    }
}
