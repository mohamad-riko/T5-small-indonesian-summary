<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Http;
use phpQuery;

class UrlController extends Controller
{
    public function showForm()
    {
        return view('url_form');
    }

    public function processUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            // Gunakan Guzzle untuk mengambil konten dari URL
            $client = new GuzzleClient();
            $response = $client->get($request->input('url'));
            $html = (string) $response->getBody();

            // Log halaman HTML untuk debugging
            \Log::info($html);

            // Gunakan phpQuery untuk mem-parsing HTML dan mengambil teks dari semua elemen <p>
            $document = phpQuery::newDocumentHTML($html);
            $text = '';
            foreach ($document->find('p') as $element) {
                $text .= pq($element)->text() . ' ';
            }

            // Log teks untuk debugging
            \Log::info($text);

            // Proses ringkasan teks menggunakan model Hugging Face
            $summarizedText = $this->summarizeText($text);

            return view('result_url', compact('text', 'summarizedText'));
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., failed to fetch content)
            \Log::error('Failed to fetch content from URL: ' . $e->getMessage());
            return redirect()->back()->withErrors(['url' => 'Failed to fetch content from URL.']);
        }
    }

    private function summarizeText($text)
    {
        try {
            // Kirim teks ke API Hugging Face untuk proses ringkasan menggunakan model T5-small Indonesia
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
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan saat memanggil API Hugging Face
            \Log::error('Failed to summarize text: ' . $e->getMessage());
            return '';
        }
    }
}
