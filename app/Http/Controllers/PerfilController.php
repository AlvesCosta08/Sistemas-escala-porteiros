<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFotoRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class PerfilController extends Controller
{
    public function edit(): View
    {
        return view('perfil.edit', ['user' => auth()->user()]);
    }

    public function updateFoto(UpdateFotoRequest $request): RedirectResponse
    {
        $this->salvarFoto($request->user(), $request->file('foto'));

        return redirect()
            ->route(auth()->user()->isAdmin() ? 'perfil.edit' : 'minha-escala')
            ->with('status', 'Foto atualizada.');
    }

    public function updateFotoAdmin(UpdateFotoRequest $request, User $user): RedirectResponse
    {
        $this->salvarFoto($user, $request->file('foto'));

        return redirect()
            ->route('admin.ausencias.index')
            ->with('status', "Foto de {$user->name} atualizada.");
    }

    /**
     * Salva o original e gera a thumbnail quadrada WebP 200×200.
     */
    private function salvarFoto(User $user, $upload): void
    {
        DB::transaction(function () use ($user, $upload) {
            // Remove o original anterior (se existir)
            if ($user->foto_path) {
                Storage::disk('public')->delete($user->foto_path);
            }

            // Salva o original
            $originalPath = $upload->store('fotos/originais', 'public');

            // Gera a thumbnail WebP 200×200 via GD nativo (crop centralizado)
            $thumbContent = $this->gerarThumbnailWebp($upload->getRealPath(), 200);

            $thumbPath = "fotos/thumbs/{$user->id}.webp";
            Storage::disk('public')->put($thumbPath, $thumbContent);

            $user->update([
                'foto_path' => $originalPath,
                'foto_thumb_path' => $thumbPath,
            ]);
        });
    }

    /**
     * Gera uma thumbnail quadrada (crop centralizado) em WebP usando GD.
     */
    private function gerarThumbnailWebp(string $sourcePath, int $size): string
    {
        $data = @file_get_contents($sourcePath);
        if ($data === false) {
            throw new RuntimeException('Não foi possível ler o arquivo de imagem.');
        }

        $src = @imagecreatefromstring($data);
        if ($src === false) {
            throw new RuntimeException('Formato de imagem não suportado.');
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);
        $lado = min($srcW, $srcH);
        $srcX = (int) (($srcW - $lado) / 2);
        $srcY = (int) (($srcH - $lado) / 2);

        $dst = imagecreatetruecolor($size, $size);

        // Fundo branco (evita bordas pretas em PNGs com transparência)
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $size, $size, $lado, $lado);

        ob_start();
        imagewebp($dst, null, 80);
        $webp = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        return $webp;
    }
}