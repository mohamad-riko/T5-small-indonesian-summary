<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RingkasanController extends Controller
{
    public function ringkasanForm()
    {
        return view('ringkasan.form');
    }

    public function prosesRingkasan(Request $request)
    {
        $request->validate([
            'teks' => 'required|string',
        ]);

        $teksAwal = $request->input('teks');
        $jumlahKataAwal = str_word_count($teksAwal);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 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',
            'Content-Type' => 'application/json',
        ])->post('https://api-inference.huggingface.co/models/panggi/t5-small-indonesian-summarization-cased', [
            'inputs' => $teksAwal,
        ]);

        $result = $response->json();

        $jumlahKataRingkasan = 0;
        if (isset($result[0]['summary_text'])) {
            $jumlahKataRingkasan = str_word_count($result[0]['summary_text']);
        }

        return view('ringkasan.hasil', [
            'result' => $result,
            'jumlahKataAwal' => $jumlahKataAwal,
            'jumlahKataRingkasan' => $jumlahKataRingkasan,
            'teksAwal' => $teksAwal, // Menambahkan teks awal ke variabel yang dikirim ke tampilan
        ]);
    }
}
