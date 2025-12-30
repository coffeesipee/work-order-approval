<?php

namespace App\Class;

use App\Models\Damage;

class CreateBeritaAcara
{
    public function __construct(
        public readonly Damage $laporanKerusakan,
        public readonly bool $isCustom = false,
        public readonly ?string $content = null
    ) {
    }
}
