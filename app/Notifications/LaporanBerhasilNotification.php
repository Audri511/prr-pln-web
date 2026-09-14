<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LaporanBerhasilNotification extends Notification
{
    use Queueable;

    public $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'success',
            'title' => 'Laporan Berhasil!',
            'message' => 'Laporan pemasangan ID ' . $this->laporan->id_pelanggan_baru . ' berhasil tersimpan di sistem.',
            // Added search parameter to direct exactly to the data
            'url' => route('riwayat') . '?tab=pasang_baru&search=' . $this->laporan->id_pelanggan_baru,
        ];
    }
}
