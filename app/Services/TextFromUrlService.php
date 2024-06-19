<?php

namespace App\Services;

use GoutteFacade\GoutteFacade;

class TextFromUrlService
{
    public function getTextFromUrl($url)
    {
        try {
            $crawler = GoutteFacade::request('GET', $url);
            $text = $crawler->filter('body')->text();
            return $text;
        } catch (\Exception $e) {
            return null;
        }
    }
}
