<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmation;
use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'name.max'         => 'El nombre no puede superar los 100 caracteres.',
            'name.not_regex'   => 'El nombre contiene caracteres no permitidos.',
            'email.required'   => 'El correo es obligatorio.',
            'email.email'      => 'Escribe un correo válido.',
            'email.max'        => 'El correo no puede superar los 255 caracteres.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max'      => 'El mensaje no puede superar los 5000 caracteres.',
        ]);

        // 1. Aviso al administrador: es el envío importante.
        try {
            Mail::to(config('cms.admin_email'))->send(
                new ContactMessage($data['name'], $data['email'], $data['message'])
            );
        } catch (\Throwable $e) {
            // El detalle técnico va al log, no a la pantalla del visitante.
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'mail' => 'No pudimos enviar tu mensaje en este momento. Inténtalo de nuevo más tarde.',
                ]);
        }

        // Pausa opcional para servicios de prueba con límite por segundo.
        $delay = (int) config('cms.mail_delay_seconds', 0);

        if ($delay > 0) {
            sleep($delay);
        }

        // 2. Confirmación al usuario: si falla, el mensaje ya llegó al administrador.
        try {
            Mail::to($data['email'])->send(
                new ContactConfirmation($data['name'], $data['message'])
            );
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('contact.show')
                ->with('success', 'Tu mensaje fue enviado. Sin embargo, no pudimos enviarte el correo de confirmación.');
        }

        return redirect()
            ->route('contact.show')
            ->with('success', 'Tu mensaje fue enviado. Te enviamos una confirmación por correo.');
    }
}