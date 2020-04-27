<?php

namespace App\Controller\searchMail;

use App\Form\searchMail\KeywordSearchType;
use App\Service\searchMail\SearchMailGoogle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchMailController extends AbstractController
{
    /**
     * @Route("/search/mail", name="searchMail")
     */
    public function index(SearchMailGoogle $searchMailGoogle, Request $request)
    {
        // Todo : form with keyword
        // Todo use SearchInGoogleWithKeyword Service

        $form = $this->createForm(KeywordSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Todo : if checkbox form is valid
            $keyword1 = $form['keyword']->getData();
            $mailGoogle = $searchMailGoogle->SearchInGoogleLink($keyword1);

        }

        //$mailGoogle = $searchMailGoogle->SearchInGoogleLink();
        //dd($mailGoogle);

        return $this->render('searchMail/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}



