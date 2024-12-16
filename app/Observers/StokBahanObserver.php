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
        
    }
    /**
     * Handle the stokbahan "updated" event.
     */
    public function updated(Stokbahan $stokbahan): void
    {
        $tanggalKadaluarsa = Carbon::parse($stokbahan->tanggal_kadaluarsa);
        $tanggalSekarang = Carbon::now();
        $recepient = Auth::user();

        // Notifikasi kadaluarsa
        if ($tanggalSekarang->diffInDays($tanggalKadaluarsa, false) <= 2 && !$stokbahan->notified_kadaluarsa) {
            Notification::make()
                ->title('Stok Akan Kadaluarsa')
                ->body('Stok ' . $stokbahan->nama_bahan . ' akan kadaluarsa dalam 2 hari.')
                ->color('warning')
                ->sendToDatabase($recepient);
            $stokbahan->notified_kadaluarsa = true;
            $stokbahan->save();
        }

        // Notifikasi jumlah stok kurang dari batas minimum
        if ($stokbahan->jumlah_stok < $stokbahan->minimum_stok && !$stokbahan->notified_stok) {
            Notification::make()
                ->title('Jumlah Stok Kurang dari Batas Minimum')
                ->body('Stok ' . $stokbahan->nama_bahan . ' kurang dari batas minimum stok.')
                ->color('red')
                ->sendToDatabase($recepient);
            $stokbahan->notified_stok = true;
            $stokbahan->save();
        }

        // Reset notified_stok jika jumlah_stok melebihi atau sama dengan minimum_stok
        if ($stokbahan->jumlah_stok >= $stokbahan->minimum_stok && $stokbahan->notified_stok) {
            $stokbahan->notified_stok = false;
            $stokbahan->save();
        }

        // Reset notified_kadaluarsa jika tanggal kadaluarsa sudah lewat
        if ($tanggalSekarang->diffInDays($tanggalKadaluarsa, false) > 2 && $stokbahan->notified_kadaluarsa) {
            $stokbahan->notified_kadaluarsa = false;
            $stokbahan->save();
        }
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

    public function afterSave(stokbahan $stokbahan): void
    {
        
    }
}
