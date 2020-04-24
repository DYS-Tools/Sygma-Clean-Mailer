<?php
// src/Service/FileUploader.php

namespace App\Service\searchMail;

use Symfony\Component\HttpClient\HttpClient;

class SearchMailGoogle
{
    private $keyword = 'photography';

    // Todo : Function Search in Google with Keyword
    // for each keyword, use function SearchInGoogle


    public function SearchInGoogle() {

        $client = HttpClient::create();
        //$response = $client->request('GET', 'https://www.google.com/search?q=photography');
        $response = $client->request('GET', 'http://yohanndurand.fr');
        $content = $response->getContent();

        $mail = $this->GetMailInGoogle($content);
        return $mail;
    }

    private function GetMailInGoogle($content) {

        // Clean content
        $content = str_replace([">","<",":","/","\"","'","-","="], " ",  $content);
        // Search mail with regex
        preg_match_all("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#",$content, $ContentMail);
        dump($ContentMail) ;
    }
}