<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class CampaignController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function create(Request $request)
    {
        $id_campaign = substr(md5(uniqid(rand(), true)), 0, 8);

        DB::insert(
            'INSERT into campaigns (name, meta, id_campaign, fecha_init, fecha_end) values (?, ?, ?, ?, ?)',
            [$request->name, $request->meta, $id_campaign, $request->fecha_init, $request->fecha_end]
        );


        return response()->json([
            'success' => true,
            'message' => 'Campaña creada correctamente',
        ], 201);
    }

    public function actualizar(Request $request)
    {
        DB::update('UPDATE campaigns SET name = ?, meta = ?, fecha_init = ?, fecha_end = ? WHERE id = ?', [$request->name, $request->meta, $request->fecha_init, $request->fecha_end, $request->id]);

        return response()->json([
            'success' => true,
            'message' => "Campaña actualizada correctamente",
        ], 201);
    }

    public function listar()
    {

        $campaigns = DB::select('SELECT *, @n := @n + 1 n from campaigns, (SELECT @n := 0) m');


        return response()->json($campaigns);
    }

    public function detalles($id)
    {

        $detalles = DB::select('SELECT SUM(monto) AS total FROM transacciones WHERE id_campaign = "' . $id . '"');
        $campaign = DB::select('SELECT id, name, meta, fecha_init, fecha_end, id_campaign FROM campaigns WHERE id_campaign = "' . $id . '"');
        $campaign_rows = DB::select('SELECT transaccion_id, user_id, monto, tipo_donacion, created_at, @n := @n + 1 n  FROM transacciones, (SELECT @n := 0) m WHERE id_campaign = "' . $id . '" ');



        $total = $detalles[0]->total == null ? 0 : $detalles[0]->total;

        $porcentaje = number_format(100 - (($campaign[0]->meta - $total) / $campaign[0]->meta * 100), 2);

        $donacion_faltante = ($campaign[0]->meta - $total);

        if($donacion_faltante <= 0){
            $meta_resume = "Meta cumplida";
            $donacion_faltante_resume = ($total - $campaign[0]->meta);
        }else {
            $meta_resume = "Meta no cumplida";
            $donacion_faltante_resume = $donacion_faltante;
        }

        $data = [
            'name' => $campaign[0]->name,
            'meta' => $campaign[0]->meta,
            'id' => $campaign[0]->id,
            'porcentaje' => $porcentaje,
            'donacion_total' => $total,
            'donacion_faltante' => $donacion_faltante_resume,
            'meta_resume' => $meta_resume,
            'fecha_init' => $campaign[0]->fecha_init,
            'fecha_end' => $campaign[0]->fecha_end,
            'codigo' => $campaign[0]->id_campaign,
            'rows' => $campaign_rows,
            'name_report' => "CAMPAÑA_" . $campaign[0]->id_campaign . ".xls",
        ];

        return response()->json($data);

    }

    public function eliminar($id)
    {

        DB::select('DELETE from campaigns WHERE id = "' . $id . '"');

        return response()->json([
            'success' => true,
            'message' => 'Campaña eliminada correctamente',
        ], 201);
    }

}
