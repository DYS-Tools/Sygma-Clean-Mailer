<?php
// src/Service/FileUploader.php

namespace App\Service\searchMail;

use Symfony\Component\HttpClient\HttpClient;

class SearchMailGoogle
{
    public function SearchInGoogleLink($keyword1) {
        //Search With keyword
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.google.com/search?q='.$keyword1.'');

        // read the code source for search link
        $Googlecontent = $response->getContent();
        dd($Googlecontent);

        /*
        $response = $client->request('GET', 'http://yohanndurand.fr');
        $content = $response->getContent();

        $mail = $this->GetMailInGoogle($content);
        return $mail;
        */
    }

    private function GetMailInGoogle($content) {

        // Clean content
        $content = str_replace([">","<",":","/","\"","'","-","="], " ",  $content);
        // Search mail with regex
        preg_match_all("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#",$content, $ContentMail);
        //dump($ContentMail) ;
    }
}