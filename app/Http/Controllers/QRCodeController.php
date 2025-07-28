<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empacotamento;

class QRCodeController extends Controller
{
    /**
     * Rastrear empacotamento por QR Code
     */
    public function rastrear($codigo)
    {
        $empacotamento = Empacotamento::where('codigo_qr', $codigo)
                                    ->with(['coleta.estabelecimento', 'usuario'])
                                    ->first();

        if (!$empacotamento) {
            return view('qrcodes.nao-encontrado', compact('codigo'));
        }

        return view('qrcodes.rastrear', compact('empacotamento'));
    }

    /**
     * Gerar QR Code para empacotamento
     */
    public function gerar($empacotamento_id)
    {
        $empacotamento = Empacotamento::findOrFail($empacotamento_id);

        // Aqui você pode implementar a lógica de geração do QR Code
        // Por exemplo, usando uma biblioteca como SimpleSoftwareIO/simple-qrcode

        return response()->json([
            'success' => true,
            'codigo' => $empacotamento->codigo_qr,
            'url' => route('qrcodes.rastrear', $empacotamento->codigo_qr)
        ]);
    }
}
