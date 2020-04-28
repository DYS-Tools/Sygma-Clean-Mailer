<?php
// src/Service/FileUploader.php

namespace App\Service\searchMail;

use Symfony\Component\HttpClient\HttpClient;

class SearchMailGoogle
{
    public function SearchInGoogleLink($keyword1) {
        ini_set('max_execution_time', 500); //in seconds

        //Search With keyword
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.google.com/search?q='.$keyword1.'&num=1000');

        // get Content Google Search
        $GoogleContent = $response->getContent();

        // Clean content Google Search
        $GoogleContent = str_replace([">","<","\"","'","=",".jpg",".gouv.fr"], " ",  $GoogleContent); // replace specifical caractere and jpg
        // Todo : generate ssl certificat wamp
        $GoogleContent = str_replace(["https"], "http",  $GoogleContent);

        // search https with regex in Google Search
        preg_match_all("#(https?://)([\w\d.:\#@%/;$~_?\+-=]*)#",$GoogleContent, $listLinkInGoogleKeyword);

        // tab Links
        dump($listLinkInGoogleKeyword[0]); // 0 = https , 1 = "https", 2 = www

        // foreach tab for search mail in links
        foreach ($listLinkInGoogleKeyword[0] as $listLinkInGoogleKeyword) {
            $response = $client->request('GET', $listLinkInGoogleKeyword);
            dump($response);
            $statusCode = $response->getStatusCode();

            dump($statusCode);
            dump($listLinkInGoogleKeyword);

            if ( $statusCode === 200) {
                $content = $response->getContent();
                $mail = $this->GetMailInLinkContent($content);
                dump($mail) ;
            }
            else {
                dump('no valid http response');
            }
        }
    }

    private function GetMailInLinkContent($content) {
        // Clean content
        $content = str_replace([">","<",":","/","\"","'","-","="], " ",  $content); // replace specifical caractere
        // Todo :Clean mail ( @exemple, @prestashop ,double, your@email.com with str_replace

        // Search mail with regex
        preg_match_all("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#",$content, $ContentMail);
        dump($ContentMail) ;
    }
}