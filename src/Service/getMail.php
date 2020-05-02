<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;

class getMail
{
    private $containerBag;

    public function __construct(ContainerBagInterface $containerBag)
    {
        $this->containerBag = $containerBag;
    }

    private function getMails()
    {
        $response = $this->request('GET', 'assets/list1.csv');
        dd($response);
        return $response->toArray();
    }
}