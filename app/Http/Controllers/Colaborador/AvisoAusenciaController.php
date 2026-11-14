<?php

namespace App\Http\Controllers\Colaborador;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAvisoAusenciaRequest;
use App\Models\Alocacao;
use App\Models\AvisoAusencia;
use App\Models\User;
use App\Notifications\AvisoAusenciaCriado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AvisoAusenciaController extends Controller
{
    public function create(Alocacao $alocacao)
    {
        $this->authorize('marcarAusencia', $alocacao);
        $alocacao->load(['posto', 'turno']);

        return view('colaborador.aviso-ausencia', compact('alocacao'));
    }

    public function store(StoreAvisoAusenciaRequest $request, Alocacao $alocacao)
    {
        $urgente = now()->diffInHours($alocacao->data, false) < 24;

        $aviso = DB::transaction(function () use ($request, $alocacao, $urgente) {
            $aviso = AvisoAusencia::create([
                'alocacao_id' => $alocacao->id,
                'user_id' => $request->user()->id,
                'motivo' => $request->motivo,
                'observacao' => $request->observacao,
                'anexo_path' => $request->file('anexo')?->store('anexos/ausencias', 'local'),
                'urgente' => $urgente,
                'status' => 'pendente',
            ]);

            $alocacao->update([
                'status' => 'pendente',
                'aviso_id' => $aviso->id,
            ]);

            return $aviso;
        });

        // Notifica todos os admins APÓS o commit
        $aviso->load(['user', 'alocacao.posto', 'alocacao.turno']);
        Notification::send(
            User::role('admin')->get(),
            new AvisoAusenciaCriado($aviso),
        );

        return redirect()
            ->route('minha-escala')
            ->with('status', 'Aviso registrado.');
    }
}