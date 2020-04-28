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

            //$this->addFlash('Search','cela peut prendre plusieurs minute..');

            if ( $form['Google']->getData() === true  ) {
                //$this->addFlash('Search','Recherche des emails sur Google');
                $keyword1 = $form['keyword']->getData();
                $mailGoogle = $searchMailGoogle->SearchInGoogleLink($keyword1);
            }
            if ( $form['Facebook']->getData() === true  ) {
                dd("Facebook Value");
            }
        }
        return $this->render('searchMail/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}



