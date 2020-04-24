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
        $response = $client->request('GET', 'https://www.google.com/search?q=photography');

        $statusCode = $response->getStatusCode();

        dd($statusCode);
        // return $statusCode
    }
}