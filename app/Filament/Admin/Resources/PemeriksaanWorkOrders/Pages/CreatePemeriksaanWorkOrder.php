<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\PemeriksaanWorkOrderResource;
use App\Models\Damage;
use App\Models\DamageItem;
use App\Models\DamageProof;
use App\Models\Unit;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreatePemeriksaanWorkOrder extends CreateRecord
{
    protected static string $resource = PemeriksaanWorkOrderResource::class;
    protected static ?string $title = "Buat";

    private function generateTicketNumber(Unit $unit): string
    {
        $damageFromUnit = Damage::where('unit_id', $unit->id)->count();
        $unitNumber = $unit->code;
        $currentYear = Carbon::now()->format('Y');

        return $damageFromUnit + 1 . '/' . $unitNumber . '/' . $currentYear;
    }

    public function formatUniversalCode($input)
    {
        // ^         : Start of string
        // ([a-zA-Z]+): Group 1 - Matches any alphabetic word (e.g., SPBU, AGEN, TOKO)
        // \s+       : Matches one or more spaces
        // ([\d.]+)  : Group 2 - Matches the numbers and dots following it
        return preg_replace('/^([a-zA-Z]+)\s+([\d.]+)/', '$1-$2', $input);
    }


    public function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();
        $user = auth()->user();
        $unit = Unit::find($data['unit_id']);

        try {
            $damage = new Damage();
            $damage->title = $data['title'];
            $damage->unit_id = $data['unit_id'];
            $damage->region_id = $data['region_id'];
            $damage->reported_by = $user->id;
            $damage->description = $data['description'];
            $damage->ticket_number = $this->generateTicketNumber($unit);
            $damage->save();

            foreach ($data['damageItems'] as $damageItem) {
                DamageItem::create([
                    'name' => $damageItem['name'],
                    'quantity' => $damageItem['quantity'],
                    'unit' => $damageItem['unit'],
                    'description' => $damageItem['description'],
                    'damage_id' => $damage->id,
                ]);
            }

            foreach ($data['proofs'] as $proof) {
                DamageProof::create([
                    'image' => $proof,
                    'damage_id' => $damage->id,
                ]);
            }

            DB::commit();

            return $damage;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
