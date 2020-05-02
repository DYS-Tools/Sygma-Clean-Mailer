<?php

namespace App\Controller;

use App\Entity\Email;
use App\Entity\ListMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/deleteOneList/{id}", name="DeleteOnelist", requirements={"id"="\d+"})
     */
    public function deleteOneList(EntityManagerInterface $entityManager, $id)
    {

        /* Delete one list */
        $ListRepository = $this->getDoctrine()->getRepository(ListMail::class);
        $list = $ListRepository->findOneBy(['id' => $id]);

        $mailRepository = $this->getDoctrine()->getRepository(Email::class);
        $mail = $mailRepository->findBy(['list' => $list]);
        foreach ($mail as $adresse) {
            $entityManager->remove($adresse);
        }
        $entityManager->remove($list);

        $entityManager->flush();
        $this->addFlash('info','This list is deleted');

        return $this->redirectToRoute('lists');
    }

    /**
     * @Route("/ExportOneList/{id}", name="ExportOnelist", requirements={"id"="\d+"})
     */
    public function ExportOneList(EntityManagerInterface $entityManager, $id)
    {

        $ListRepository = $this->getDoctrine()->getRepository(ListMail::class);
        $list = $ListRepository->findOneBy(['id' => $id]);

        $file = '../Data/'.$list->getPath();
        $fichier = fopen($file,'r+');
        $chaine = '';
        while(!feof($fichier)) {
            $chaine .= fgets($fichier);
        }
        $lignes = explode("\n", $chaine);
        $chaine = '';
        $i = 0;
        foreach($lignes as $ligne) {
            $chaine .= $ligne."\n";
            if ($i >=1) {
                $mail = explode(',',$ligne);
                if($mail[0]) {
                    $mail = trim(strtolower($mail[0]));
                    $mailRepository = $this->getDoctrine()->getRepository(Email::class);
                    // Ajouter la recherche sur la liste en cours
                    $mailObject = $mailRepository->findBy(['adresse' => $mail]);

                    if($mailObject != null){}
                    else{
                        $fichier = fopen($file,'r+');
                        file_put_contents($file, str_replace($ligne, "", file_get_contents($file)));

                        file_put_contents($file, str_replace("\n\n", "\n", file_get_contents($file)));
                    }
                }
            }
            $i++;
        }

        $downloadfile = '../Data/'.$list->getPath();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=".basename($downloadfile).";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($downloadfile));
        readfile("$downloadfile");

        $this->addFlash('success','CSV Exported');
        dd();
        //return $this->redirectToRoute('lists');
    }
}
