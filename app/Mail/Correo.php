<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Correo extends Mailable
{
    use Queueable, SerializesModels;

    public $archivoAdjunto;
    public $nombre_archivo;
    public $mensaje;
    public $nombre;
    public $asunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($archivoAdjunto, $nombre_archivo, $mensaje, $nombre, $asunto)
    {
        $this->archivoAdjunto = $archivoAdjunto;
        $this->nombre_archivo = $nombre_archivo;
        $this->mensaje = $mensaje;
        $this->nombre = $nombre;
        $this->asunto = $asunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->nombre_archivo != "") {
            return $this->view('mail.correo')
                ->subject($this->asunto)
                ->attach($this->archivoAdjunto, [
                    'as' => $this->nombre_archivo,
                ]);
        } else {
            return $this->view('mail.correo')
                ->subject($this->asunto);
        }
    }
}
