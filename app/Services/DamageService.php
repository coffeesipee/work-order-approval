<?php

namespace App\Services;

use App\Class\CreateBeritaAcara;

class DamageService
{
    /**
     * Generate PDF untuk berita acara dari laporan kerusakan,
     * Dokument berita acara ini akan di tandatangi oleh pembuat laporan kerusakan,
     * User dengan role teknisi dan business head unit.
     * User dengan role teknisi dan business head unit.
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateBeritaAcara(CreateBeritaAcara $beritaAcara)
    {
        $damage = $beritaAcara->laporanKerusakan;
        $content = $beritaAcara->content ?? $this->generateBeritaAcaraContent($damage);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.berita_acara', [
            'damage' => $damage,
            'content' => $content,
            'technician_name' => 'Dicky Median' // Could be dynamic if we had technician info
        ])->setOption(['isRemoteEnabled' => true]);

        return $pdf;
    }

    public function generateBeritaAcaraContent($damage): string
    {
        $date = \Carbon\Carbon::now()->translatedFormat('l \t\a\n\g\g\a\l d F Y');
        $checkDate = $damage->created_at->translatedFormat('d F Y');
        $title = $damage->title;
        $description = $damage->description; // Use description or breakdown items if available
        $reporter = $damage->reportedBy->name ?? 'Tim Teknik';

        // Generate damage items list
        $itemsList = '';
        if ($damage->damageItems->count() > 0) {
            $itemsList = '<ol>';
            foreach ($damage->damageItems as $item) {
                $itemsList .= "<li>{$item->name} (Qty: {$item->quantity} {$item->unit}). {$item->description}</li>";
            }
            $itemsList .= '</ol>';
        }

        // Basic template based on the image text structure
        return "
            <p>Pada hari ini {$date} telah dilakukan pengecekan {$title} oleh {$reporter}. Pada pengecekan tersebut telah ditemukan beberapa indikasi kendala sebagai berikut:</p>
            {$itemsList}
            <p>{$description}</p>
            <p>Demikian berita acara ini dibuat untuk dapat dipergunakan seperlunya. Atas perhatian dan kerjasamanya kami ucapkan terimakasih.</p>
        ";
    }
}
