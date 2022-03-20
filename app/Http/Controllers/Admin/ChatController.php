<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChatController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function status_chat($chat_id)
    {
        $status = Solicitudes::where('chat_id', $chat_id)->get();

        return response()->json($status[0]->status);
    }

    public function solicitud($esp)
    {
        $solicitud = Solicitudes::create([
            'abogado' => NULL,
            'esp' => $esp,
            'cliente' => Auth::user()->id,
            'chat_id' => md5(now()),
            'status' => 1
        ]);

        $solicitud->join('users', 'solicitudes.cliente', '=', 'users.id')
        ->join('areas_practica', 'solicitudes.esp', '=', 'areas_practica.id')
        ->select('solicitudes.*', 'users.fullname', 'areas_practica.nombre')
        ->get();

        return response()->json($solicitud);
    }

    public function listar_sol($type)
    {
        if ($type == "all") {
            $lista = Solicitudes::where('status', '1')
                ->join('users', 'solicitudes.cliente', '=', 'users.id')
                ->join('areas_practica', 'solicitudes.esp', '=', 'areas_practica.id')
                ->select('solicitudes.*', 'users.fullname', 'areas_practica.nombre')
                ->get();
        } elseif ($type == "lawchat") {
            $lista = Solicitudes::where('status', '2')
                ->where('abogado', Auth::user()->id)
                ->join('users', 'solicitudes.cliente', '=', 'users.id')
                ->join('areas_practica', 'solicitudes.esp', '=', 'areas_practica.id')
                ->select('solicitudes.*', 'users.fullname', 'areas_practica.nombre')
                ->get();
        } elseif ($type == "mychat") {
            $lista = Solicitudes::where('status', '1')
                ->orWhere('status', '2')
                ->where('cliente', Auth::user()->id)
                ->join('users', 'solicitudes.cliente', '=', 'users.id')
                ->join('areas_practica', 'solicitudes.esp', '=', 'areas_practica.id')
                ->select('solicitudes.*', 'users.fullname', 'areas_practica.nombre')
                ->get();
        }
        return response()->json($lista);
    }

    public function tomar_chat($chat_id)
    {
        $user = Auth::user();

        Solicitudes::where('chat_id', $chat_id)->update([
            'abogado' => $user->id,
            'status' => 2
        ]);
    }

    public function message($chat_id)
    {
        $message = Message::where('chat_id', $chat_id)->get();

        return response()->json($message);
    }



    public function sendmessage(Request $request)
    {
        $user = Auth::user();

        $message = Message::create([
            "mensaje" => $request->mensaje,
            "abogado" => $request->abogado,
            "sender" => $user->id,
            "cliente" => $request->cliente,
            "chat_id" => $request->chat_id
        ])
            ->where('chat_id', $request->chat_id)
            ->get();

        return response()->json($message);
    }

    public function close_chat($chat_id)
    {
        Solicitudes::where('chat_id', $chat_id)->update([
            'status' => 3
        ]);
    }
}
