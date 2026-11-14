<?php

namespace App\Http\Controllers\Colaborador;

use App\Http\Controllers\Controller;
use App\Models\Alocacao;
use Illuminate\Http\Request;

class MinhaEscalaController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));

        $alocacoes = Alocacao::with([
                'user:id,name,foto_thumb_path',
                'posto:id,nome',
                'turno:id,nome,hora_inicio,hora_fim',
                'aviso:id,alocacao_id,status',
            ])
            ->where('user_id', $request->user()->id)
            ->doMes($mes)
            ->orderBy('data')
            ->get();

        return view('colaborador.minha-escala', compact('alocacoes', 'mes'));
    }
}