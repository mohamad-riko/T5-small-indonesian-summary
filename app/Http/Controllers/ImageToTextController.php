<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Http;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ImageToTextController extends Controller
{
    public function showUploadForm()
    {
        return view('upload_form');
    }

    public function processImage(Request $request)
    {
        // Validasi request untuk memastikan file yang diunggah adalah gambar
        $request->validate([
            'image' => 'required|image',
        ]);

        // Simpan gambar yang diunggah ke storage local 
        $imagePath = $request->file('image')->store('images');

        // Jalankan Tesseract OCR untuk mendapatkan teks dari gambar
        $text = (new TesseractOCR(storage_path('app/' . $imagePath)))
            ->executable('C:\Program Files\Tesseract-OCR\tesseract.exe')
            ->run();

        // Proses ringkasan teks
        $summarizedText = $this->summarizeText($text);

        // Tampilkan hasil teks di halaman result.blade.php
        return view('result', compact('text', 'summarizedText'));
    }

    private function summarizeText($text)
    {
        // Mengirim teks ke API Hugging Face untuk proses ringkasan menggunakan model tertentu
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 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',
            'Content-Type' => 'application/json',
        ])->post('https://api-inference.huggingface.co/models/panggi/t5-small-indonesian-summarization-cased', [
            'inputs' => $text,
        ]);

        $result = $response->json();

        // Ambil hasil ringkasan teks
        $summarizedText = isset($result[0]['summary_text']) ? $result[0]['summary_text'] : '';

        return $summarizedText;
    }
    public function downloadPdf(Request $request)
    {
        $text = $request->text;
        $filename = 'hasil_konversi_teks.pdf';

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($text);
        $pdfContent = $mpdf->Output('', 'S');

        $response = \Illuminate\Support\Facades\Response::make($pdfContent);
        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    public function downloadDocx(Request $request)
    {
        $text = $request->text;
        $filename = 'hasil_konversi_teks.docx';

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText($text);
        $docxWriter = IOFactory::createWriter($phpWord, 'Word2007');
        ob_start();
        $docxWriter->save('php://output');
        $docxContent = ob_get_clean();

        $response = \Illuminate\Support\Facades\Response::make($docxContent);
        $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
