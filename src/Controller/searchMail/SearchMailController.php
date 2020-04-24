<?php

namespace App\Controller\searchMail;

use App\Service\searchMail\SearchMailGoogle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SearchMailController extends AbstractController
{
    /**
     * @Route("/search/mail", name="searchMail")
     */
    public function index(SearchMailGoogle $searchMailGoogle)
    {
        // Todo : form with keyword
        // Todo use SearchInGoogleWithKeyword Service

        $mailGoogle = $searchMailGoogle->SearchInGoogle();
        dd($mailGoogle);

        return $this->render('searchMail/index.html.twig', [
            'controller_name' => 'SearchMailController',
        ]);
    }
}



