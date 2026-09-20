<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Muestra el formulario de carga y la galería.
     */
    public function index(): View
    {
        $media = Media::latest()->get();

        return view('admin.media.index', compact('media'));
    }

    /**
     * Valida, guarda el archivo en Storage y registra sus datos en la BD.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => $this->fileRules(),
        ], $this->validationMessages());

        $file = $request->file('file');

        // Se leen los metadatos antes de guardar el archivo.
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        // Laravel genera un nombre aleatorio; no se usa el nombre original.
        $path = $file->store('media', 'public');

        Media::create([
            'name'      => $validated['name'],
            'path'      => $path,
            'mime_type' => $mimeType,
            'size'      => $size,
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Archivo cargado correctamente.');
    }

    /**
     * Reemplaza el archivo de una imagen existente y borra el anterior.
     */
    public function update(Request $request, Media $media): RedirectResponse
    {
        $request->validate([
            'file' => $this->fileRules(),
        ], $this->validationMessages());

        $file = $request->file('file');

        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $oldPath = $media->path;

        // 1. Primero se guarda el archivo nuevo.
        $newPath = $file->store('media', 'public');

        // 2. Se actualiza el registro. Si falla, se elimina el archivo nuevo
        //    para no dejar residuos y la imagen anterior queda intacta.
        try {
            $media->update([
                'path'      => $newPath,
                'mime_type' => $mimeType,
                'size'      => $size,
            ]);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($newPath);

            throw $e;
        }

        // 3. Solo cuando todo salió bien se borra el archivo anterior.
        Storage::disk('public')->delete($oldPath);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Imagen reemplazada correctamente.');
    }

    /**
     * Elimina el registro y el archivo físico.
     */
    public function destroy(Media $media): RedirectResponse
    {
        $path = $media->path;

        $media->delete();

        Storage::disk('public')->delete($path);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Imagen eliminada correctamente.');
    }

    /**
     * Reglas del archivo (se reutilizan al subir y al reemplazar).
     */
    private function fileRules(): array
    {
        return [
            'required',
            'file',
            'mimes:jpg,jpeg,png,webp,gif',
            'max:5120', // 5 MB expresado en KB
        ];
    }

    /**
     * Mensajes de validación en español.
     */
    private function validationMessages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max'      => 'El nombre no puede superar los 255 caracteres.',
            'file.required' => 'Debes seleccionar una imagen.',
            'file.file'     => 'El archivo enviado no es válido.',
            'file.uploaded' => 'No se pudo subir el archivo. Revisa que no supere el tamaño máximo permitido.',
            'file.mimes'    => 'El archivo debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'file.max'      => 'La imagen no puede superar los 5 MB.',
        ];
    }
}