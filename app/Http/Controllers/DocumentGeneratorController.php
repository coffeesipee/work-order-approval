<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentGeneratorController extends Controller
{
    /**
     * Generate PDF berita acara dari laporan kerusakan 
     * File PDF akan di keluarkan sebagai response.
     * @return void
     */
    public function generateBeritaAcara(\Illuminate\Http\Request $request, \App\Models\Damage $damage, \App\Services\DamageService $service)
    {
        $content = null;
        if ($request->has('content_key')) {
            $content = \Illuminate\Support\Facades\Cache::get($request->input('content_key'));
        }

        $dto = new \App\Class\CreateBeritaAcara($damage, isCustom: !!$content, content: $content);
        $pdf = $service->generateBeritaAcara($dto);

        return $pdf->stream('berita_acara.pdf');
    }
}
