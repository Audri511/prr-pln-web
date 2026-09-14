<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LaporanBaruManagerNotification extends Notification
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
            'type' => 'info',
            'title' => 'Laporan Pemasangan Baru',
            'message' => 'Teknisi ' . ($this->laporan->petugas->nama_petugas ?? 'Seseorang') . ' mensubmit pemasangan baru (ID: ' . $this->laporan->id_pelanggan_baru . ').',
            // Added search parameter to direct exactly to the data
            'url' => route('laporan.index') . '?search=' . $this->laporan->id_pelanggan_baru,
        ];
    }
}
