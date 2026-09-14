<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function data()
    {
        if (!Auth::check()) return response()->json([]);

        $bookmarks = Bookmark::where('petugas_id', Auth::id())->get();
        // map it to match the JS structure: { id, prr, idpel, alamat }
        $mapped = $bookmarks->map(function($b) {
            return [
                'id' => $b->idpel, // In frontend, task.id is actually the idpel
                'idpel' => $b->idpel,
                'prr' => $b->prr,
                'alamat' => $b->alamat
            ];
        });

        return response()->json($mapped);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|string'
        ]);

        $idpel = $request->id;
        $petugasId = Auth::id();

        $bookmark = Bookmark::where('petugas_id', $petugasId)->where('idpel', $idpel)->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Bookmark::create([
                'petugas_id' => $petugasId,
                'idpel' => $idpel,
                'prr' => filter_var($request->prr, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'alamat' => $request->alamat ?? ''
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
