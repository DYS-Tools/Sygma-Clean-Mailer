<?php
// src/Service/FileUploader.php

namespace App\Service\searchMail;

use Symfony\Component\HttpClient\HttpClient;

class SearchMailGoogle
{
    public function SearchInGoogleLink($keyword1) {
        //Search With keyword
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.google.com/search?q='.$keyword1.'&num=1000');

        // get Content
        $Googlecontent = $response->getContent();

        // Clean content
        $Googlecontent = str_replace([">","<","\"","'","-","="], " ",  $Googlecontent);

        // search https with regex
        preg_match_all("#(https?://)([\w\d.:\#@%/;$~_?\+-=]*)#",$Googlecontent, $listLinkInGoogleKeyword);

        // tab Links
        dump($listLinkInGoogleKeyword[0]); // 0 = https , 1 = "https", 2 = www

        // foreach tab for search mail in links
        foreach ($listLinkInGoogleKeyword[0] as $listLinkInGoogleKeyword) {
            // Todo :  Check Status code in links
            $statusCode = $response->getStatusCode();
            dump($statusCode);
            dump($listLinkInGoogleKeyword);

            if ( $statusCode === 200 ) {
                // search mail with GetMailInGoogle
                $response = $client->request('GET', $listLinkInGoogleKeyword);
                $content = $response->getContent();
                $mail = $this->GetMailInGoogle($content);
            }
            else {}
        }

    }

    private function GetMailInGoogle($content) {

        // Clean content
        $content = str_replace([">","<",":","/","\"","'","-","="], " ",  $content);
        // Search mail with regex
        // Todo : if mail exist
        preg_match_all("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#",$content, $ContentMail);
        dump($ContentMail) ;
    }
}