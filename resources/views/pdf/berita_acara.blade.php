<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .header img {
            position: absolute;
            right: 0;
            top: 0;
            height: 40px;
        }

        .company-name {
            font-weight: bold;
            font-size: 14pt;
        }

        .spbu-name {
            font-weight: bold;
            font-size: 12pt;
        }

        .line {
            border-bottom: 3px solid black;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
            font-size: 14pt;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-table td {
            vertical-align: top;
        }

        .meta-label {
            width: 100px;
        }

        .content {
            text-align: justify;
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 50px;
        }

        .date {
            margin-bottom: 20px;
        }

        .signatures {
            width: 100%;
            table-layout: fixed;
        }

        .signature-box {
            text-align: center;
            vertical-align: top;
        }

        .signature-image {
            height: 50px;
        }

        .signature-space {
            height: 60px;
        }

        .name {
            font-weight: bold;
            text-decoration: underline;
        }

        ol {
            margin-top: 0;
            padding-left: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        .proof-grid {
            width: 100%;
            font-size: 0;
            /* Remove spacing between inline-block elements */
        }

        .proof-item {
            display: inline-block;
            width: 48%;
            margin: 1%;
            vertical-align: top;
            text-align: center;
        }

        .proof-image {
            width: 100%;
            height: 250px;
            /* Fixed height for uniformity */
            object-fit: contain;
            /* Ensure image isn't distorted */
            border: 1px solid #ddd;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- Assuming logo is available in public/images/pertamina_retail_logo.png or similar. Using a placeholder or base64 if needed, but for now assuming path specific to dompdf -->
        <!-- Note: dompdf requires absolute paths or base64. For simplicity in this template we'll use text if logo path is unknown, or try a standard path -->
        <div style="text-align: right; margin-bottom: 10px;">
            <!-- <img src="{{ public_path('images/logo.png') }}" alt="Logo"> -->
            <span style="font-weight: bold; color: #DB291C;">PERTAMINA</span> <span
                style="font-weight: bold; color: #00A1DE;">RETAIL</span>
        </div>

        <div class="company-name">PT PERTAMINA RETAIL</div>
        <div class="spbu-name">{{ $damage->unit->name ?? 'Unknown Unit' }}</div>
    </div>

    <div class="line"></div>

    <div class="title">BERITA ACARA</div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Perihal</td>
            <td>: Berita Acara Kerusakan {{ $damage->title }}</td>
        </tr>
        <tr>
            <td class="meta-label">No Surat</td>
            <!-- No Surat format validation/generation logic if exists -->
            <td>:
                {{ str_pad($damage->id, 3, '0', STR_PAD_LEFT) }}/{{ $damage->unit->code ?? 'XXXX' }}/BERITAACARA/{{ date('Y') }}
            </td>
        </tr>
    </table>

    <div class="content">
        {!! $content !!}
    </div>

    <div class="footer">
        <div class="date">{{ $damage->unit->region->city ? $damage->unit->region->city . ', ' : '' }}
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>

        <table class="signatures">
            <tr>
                <td class="signature-box">
                    Diperiksa Oleh,<br>
                    <div class="signature-space">
                        <img src="{{ $damage->reportedBy->handsign_file_url }}" alt="Signature" class="signature-image">
                    </div>
                    <div class="name">{{ $damage->reportedBy->name ?? '...............' }}</div>
                    <!-- Placeholder or passed variable -->
                    <div>{{ $damage->reportedBy->role->name }} {{ $damage->region->name ?? 'VI' }}</div>
                </td>
                <td class="signature-box">
                    Mengetahui,<br>
                    <div class="signature-space">
                        <img src="{{ $damage->approvedBy->handsign_file_url }}" alt="Signature" class="signature-image">
                    </div>
                    <div class="name">{{ $damage->approvedBy->name ?? '...............' }}</div>
                    <div>{{ $damage->approvedBy->role->name }}</div>
                </td>
            </tr>
        </table>
    </div>

    @if($damage->damageProofs->count() > 0)
        <div class="page-break"></div>
        <div class="header">
            <div class="company-name">LAMPIRAN FOTO KERUSAKAN</div>
        </div>
        <div class="line"></div>

        <div class="proof-grid">
            @foreach($damage->damageProofs as $proof)
                <div class="proof-item">
                    <!-- Using public_path assuming storage link is set up, typically filament stores in public disk -->
                    <!-- If image path is full URL or relative to storage/app/public, adjust accordingly.
                                                                                                                                                                         Ideally use public_path('storage/' . $proof->image) for dompdf if linked.
                                                                                                                                                                         Or storage_path('app/public/' . $proof->image). -->
                    <img src="{{ $proof->image_url }}" class="proof-image" alt="Damage Proof">
                </div>
            @endforeach
        </div>
    @endif
</body>

</html>