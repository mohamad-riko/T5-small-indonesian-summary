<?php

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RingkasanController;
use App\Http\Controllers\DokumenRingkasanController;
use App\Http\Controllers\ImageToTextController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UrlController;

use Mpdf\Mpdf;


Route::get('/', [HomeController::class, 'home']);


Route::get('/form-url', [UrlController::class, 'showForm'])->name('show.url.form');
Route::post('/process-url', [UrlController::class, 'processUrl'])->name('process.url');

Route::get('/summarization', [TextSummarizationController::class, 'showForm']);
Route::post('/summarize', [TextSummarizationController::class, 'summarize'])->name('summarize');


Route::get('/ringkasan', [RingkasanController::class, 'ringkasanForm'])->name('ringkasan.form');
Route::post('/ringkasan', [RingkasanController::class, 'prosesRingkasan'])->name('ringkasan.proses');

Route::get('/dokumen-ringkasan', [DokumenRingkasanController::class, 'ringkasanForm'])->name('dokumen.ringkasan.form');
Route::post('/dokumen-ringkasan', [DokumenRingkasanController::class, 'ringkasanDokumen'])->name('dokumen.ringkasan.proses');
// Route::get('/hasil-ringkasan', [DokumenRingkasanController::class, 'tampilkanHasilRingkasan'])->name('ringkasan.hasil');

Route::get('/hasil-ringkasan-dokumen', [DokumenRingkasanController::class, 'tampilkanHasilRingkasan'])->name('ringkasan.hasil_dokumen');


Route::get('/upload-form', [ImageToTextController::class, 'showUploadForm'])->name('upload.form');
Route::post('/process-image', [ImageToTextController::class, 'processImage'])->name('process.image');
Route::get('/result', function () {
    return view('result');
})->name('result');

Route::post('/download-text', function (Request $request) {
    $text = $request->text;
    $filename = 'hasil_konversi_teks.txt';

    // Buat response dengan header
    $response = \Illuminate\Support\Facades\Response::make($text);
    $response->header('Content-Type', 'text/plain');
    $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    return $response;
})->name('download.text');


Route::post('/download-pdf', function (Request $request) {
    $text = $request->text;
    $filename = 'hasil_konversi_teks.pdf';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($text);
    $pdfContent = $mpdf->Output('', 'S');

    $response = \Illuminate\Support\Facades\Response::make($pdfContent);
    $response->header('Content-Type', 'application/pdf');
    $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    return $response;
})->name('download.pdf');

Route::post('/download-docx', function (Request $request) {
    $text = $request->text;
    $filename = 'hasil_konversi_teks.docx';

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $section->addText($text);
    $docxWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    ob_start();
    $docxWriter->save('php://output');
    $docxContent = ob_get_clean();

    $response = \Illuminate\Support\Facades\Response::make($docxContent);
    $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $response->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

    return $response;
})->name('download.docx');

