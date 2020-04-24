<?php
// src/Service/FileUploader.php

namespace App\Service\searchMail;

use Symfony\Component\HttpClient\HttpClient;

class SearchMailGoogle
{
    private $keyword = 'photography';

    // Todo : get keyword with arguments
    public function SearchInGoogle() {

        $client = HttpClient::create();
        //$response = $client->request('GET', 'https://www.google.com/search?q=photography');
        $response = $client->request('GET', 'http://yohanndurand.fr');

        $content = $response->getContent();
        //$content ="li  span class= ion email yohanndurand76@gmail.com  ";
        $this->GetMailInGoogle($content);
    }

    public function GetMailInGoogle($content) {

        //dump($content);

        // Clean content  > < / : " for space
        $content = str_replace([">","<",":","/","\"","'","-","="], " ",  $content);

        dump($content);

        // regex search mail with space
        $mail = preg_match_all("#^\s[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}\s$#",$content, $out);
        dd($out);
    }
}