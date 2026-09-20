<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:5120', // 5 MB expresado en KB
            ],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max'      => 'El nombre no puede superar los 255 caracteres.',
            'file.required' => 'Debes seleccionar una imagen.',
            'file.file'     => 'El archivo enviado no es válido.',
            'file.uploaded' => 'No se pudo subir el archivo. Revisa que no supere el tamaño máximo permitido.',
            'file.mimes'    => 'El archivo debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'file.max'      => 'La imagen no puede superar los 5 MB.',
        ]);

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
}
