<?php

namespace App\Observers;

use App\Models\stokbahan;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StokBahanObserver
{
    /**
     * Handle the stokbahan "created" event.
     */
    public function created(stokbahan $stokbahan): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('Stok Bahan Berhasil Ditambahkan')
            ->body('Stok bahan berhasil ditambahkan.')
            ->sendToDatabase($recepient);
    }

    /**
     * Handle the stokbahan "updated" event.
     */
    public function updated(stokbahan $stokbahan): void
    {
        
    }

    /**
     * Handle the stokbahan "deleted" event.
     */
    public function deleted(stokbahan $stokbahan): void
    {
        //
    }

    /**
     * Handle the stokbahan "restored" event.
     */
    public function restored(stokbahan $stokbahan): void
    {
        //
    }

    /**
     * Handle the stokbahan "force deleted" event.
     */
    public function forceDeleted(stokbahan $stokbahan): void
    {
        //
    }

    public function kadaluarsa (stokbahan $stokbahan): void
    {
        $tanggalKadaluarsa = Carbon::parse($stokbahan->tanggal_kadaluarsa);
        $tanggalSekarang = Carbon::now();

        if ($tanggalSekarang->diffInDays($tanggalKadaluarsa, false) <= 2) {
            Notification::make()
                ->title('Stok Akan Kadaluarsa')
                ->body('Stok ' . $stokbahan->nama_bahan . ' akan kadaluarsa dalam 7 hari.')
                ->sendToDatabase(Auth::user());
        }
    }
}
