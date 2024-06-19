<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpWord\IOFactory;
use Spatie\PdfToText\Pdf;

class DokumenRingkasanController extends Controller
{
    public function ringkasanForm()
    {
        return view('ringkasan.dokumen-form');
    }

    public function ringkasanDokumen(Request $request)
    {
        $request->validate([
            'dokumen' => 'required|file|mimes:txt,doc,docx,pdf|max:2048',
        ]);

        // Simpan dokumen di lokal
        $path = $request->file('dokumen')->store('dokumen');

        // Ekstrak teks dari dokumen 
        $text = '';
        $extension = $request->file('dokumen')->extension();
        if ($extension === 'txt') {
            $text = file_get_contents(storage_path('app/' . $path));
        } elseif ($extension === 'pdf') {
            $text = Pdf::getText(storage_path('app/' . $path));
        } elseif (in_array($extension, ['doc', 'docx'])) {
            $phpWord = IOFactory::load(storage_path('app/' . $path));
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $textElement->getText();
                            }
                        }
                    }
                }
            }
        }

        // Pembersihan teks
        $text = $this->cleanText($text);

        // Menghitung jumlah kata dalam dokumen asli
        $jumlahKataAwal = str_word_count($text);

        // Kirim teks ke API Hugging Face -> proses ringkasan dengan model t5-small (model yang sudah dilatih NLP nya)
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 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',
            'Content-Type' => 'application/json',
        ])->post('https://api-inference.huggingface.co/models/panggi/t5-small-indonesian-summarization-cased', [
            'inputs' => $text,
        ]);

        $result = $response->json();

        // Menghitung jumlah kata dalam teks yang diringkas
        $jumlahKataRingkasan = 0;
        if (isset($result[0]['summary_text'])) {
            $jumlahKataRingkasan = str_word_count($result[0]['summary_text']);
        }

        // Tampilkan hasil ringkasan 
        return view('ringkasan.result_dokumen', [
            'result' => $result,
            'jumlahKataAwal' => $jumlahKataAwal,
            'jumlahKataRingkasan' => $jumlahKataRingkasan,
            'teksAwal' => $text,
        ]);
    }

    private function cleanText($text)
    {
        // Contoh pembersihan sederhana: menghapus karakter \r dan \n
        $cleanedText = str_replace(["\r", "\n"], ' ', $text);
        return $cleanedText;
    }
}
