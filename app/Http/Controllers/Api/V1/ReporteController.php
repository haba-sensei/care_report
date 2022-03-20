<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReporteController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function basico()
    {

        $trans_generales = count(DB::select('SELECT * from transacciones'));
        $trans_puntuales = count(DB::select('SELECT * from transacciones where tipo_donacion="Puntual"'));
        $trans_mensuales = count(DB::select('SELECT * from transacciones where tipo_donacion="Mensual"'));
        $donadores = count(DB::select('SELECT DISTINCT documentoIdentidad from donadores'));


        $data = [
            'totalTransacciones' => $trans_generales,
            'totalTransPuntuales' => $trans_puntuales,
            'totalTransMensuales' => $trans_mensuales,
            'totalDonadores' => $donadores,
        ];

        return response()->json($data);
    }

    public function general($rango)
    {
        $init_date =  substr($rango, 0, 10);
        $end_date = substr(str_replace(array(' a ', ','), '', $rango), -10);

        $trans_generales = DB::select('SELECT transaccion_id, user_id, monto, tipo_donacion, created_at, @n := @n + 1 n  FROM transacciones, (SELECT @n := 0) m where created_at BETWEEN "' . $init_date . '" AND "' . $end_date . '";');

        $total = 0;

        foreach ($trans_generales as $key => $value) {
            $total += $value->monto;
        }

        $data = [
            'rows' => $trans_generales,
            'name_report' => "GENERAL_MONTO_TOTAL_".$total.".xls",
        ];

        return response()->json($data);
    }

    public function unico($rango)
    {
        $init_date =  substr($rango, 0, 10);
        $end_date = substr(str_replace(array(' a ', ','), '', $rango), -10);

        $trans_unico = DB::select('SELECT transaccion_id, user_id, monto, tipo_donacion, created_at, @n := @n + 1 n  FROM transacciones, (SELECT @n := 0) m where created_at BETWEEN "' . $init_date . '" AND "' . $end_date . '" AND tipo_donacion = "Puntual";');

        $total = 0;

        foreach ($trans_unico as $key => $value) {
            $total += $value->monto;
        }

        $data = [
            'rows' => $trans_unico,
            'name_report' => "UNICO_MONTO_TOTAL_".$total.".xls",
        ];

        return response()->json($data);
    }

    public function mensual($rango)
    {
        $init_date =  substr($rango, 0, 10);
        $end_date = substr(str_replace(array(' a ', ','), '', $rango), -10);

        $trans_mensual = DB::select('SELECT transaccion_id, user_id, monto, tipo_donacion, created_at, @n := @n + 1 n  FROM transacciones, (SELECT @n := 0) m where created_at BETWEEN "' . $init_date . '" AND "' . $end_date . '" AND tipo_donacion = "Mensual";');

        $total = 0;

        foreach ($trans_mensual as $key => $value) {
            $total += $value->monto;
        }

        $data = [
            'rows' => $trans_mensual,
            'name_report' => "MENSUAL_MONTO_TOTAL_".$total.".xls",
        ];

        return response()->json($data);
    }

    public function donadores()
    {

        $donadores = DB::select('SELECT DISTINCT documentoIdentidad, nombres, apellidos, tipoDocumento, pais, region, telefono, email, @n := @n + 1 n from donadores, (SELECT @n := 0) m ');

        $total = count(DB::select('SELECT DISTINCT documentoIdentidad, @n := @n + 1 n from donadores, (SELECT @n := 0) m '));



        $data = [
            'rows' => $donadores,
            'name_report' => "DONADORES_TOTALES_" . $total . ".xls",
        ];

        return response()->json($data);
    }

    public function allReport($rango)
    {
        $init_date =  substr($rango, 0, 10);
        $end_date = substr(str_replace(array(' a ', ','), '', $rango), -10);

        $datos_generales = DB::select('SELECT DATE_FORMAT(created_at, "%m/%y") AS fecha, SUM(monto) AS total FROM transacciones where created_at BETWEEN "'.$init_date.'" AND "'.$end_date.'" AND status = "Authorized" GROUP BY fecha');

        foreach ($datos_generales as $key => $value) {
            $fechas[] = $value->fecha;
            $montos[] = $value->total;
        }


        $data = [
            'montos_generales' => $montos,
            'fechas_generales' => $fechas,
        ];

        return response()->json($data);
    }




}
