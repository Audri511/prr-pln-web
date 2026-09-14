<?php
use Illuminate\Support\Facades\Route;
Route::get('/test-db', function() {
    $id = 'BGN-33014-db';
    $dataInduk = \App\Models\DataIndukMdb::where('idpel', $id)->first();
    $prr = \App\Models\AsetPrr::where('id_bangunan', $id)->first();
    return response()->json([
        'dataInduk' => $dataInduk ? true : false,
        'prr' => $prr ? true : false
    ]);
});
