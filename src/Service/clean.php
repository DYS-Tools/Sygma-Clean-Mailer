<?php
/**
 * Created by PhpStorm.
 * User: sacha
 * Date: 14/04/2020
 * Time: 21:32
 */

namespace App\Service;


use App\Entity\Email;
use App\Entity\ListMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;

class clean
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function CleanMailingList($list, $severalMode){

        ini_set('max_execution_time', 0);

        $emails = $this->entityManager->getRepository(Email::class)->findBy(['list' => $list]);
        $i = 0;
        foreach ($emails as $email){
            if($this->GeneralCheck($email) == false || $this->DnsCheck($email) == false || $this->LogicCheck($email) == false){
                $this->entityManager->remove($email);
                $i++;
                $this->entityManager->flush();
            }

            if($severalMode == true){
                var_dump('true several mode');
            }
        }
        $list->setContact($list->getContact() - $i);
        $this->entityManager->persist($list);
        $this->entityManager->flush();

        return  $i;
    }

    function GeneralCheck($email) {
        $email = $email->getAdresse();

        if ($email == "") {
            $err = "L'email est vide";
            return false;
        }

        if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
            $err = "Le format de l'email n'est pas valide";
            //dd('email(s) pas valide sur la regex');
            return false;
        }

        list($nom, $dom) = explode("@", $email); // separate id and domain

        if (gethostbyname($dom) == $dom) {
            $err = "Ce nom de domaine n'existe pas";
            return false;
        }

        // filter var
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
            $err = "la fonction filter_var ne permet pas de valider l'email";
            return false;
        }
        return true;
    }

    public function DnsCheck($email){
        $email = $email->getAdresse();
        // TYPE possible : A, MX, NS, SOA, PTR, CNAME, AAAA, A6, SRV, NAPTR, TXT ou ANY.
        if (!checkdnsrr($email) == false){
            return false;
        }

        list($nom, $dom) = explode("@", $email);

        if (gethostbyname($dom) == $dom) {
            $err = "Ce nom de domaine n'existe pas";
            return false;
        }

        if(substr_count($dom, '.') > 1){
            return false;
        }

        if(substr_count($dom, '.') > 1) {
            $client = HttpClient::create();
            if ($client->request('GET', 'http://www.' . $dom)->getStatusCode() == 0) {
                return false;
            }
        }
        return true;
    }

    function verif_alphaNum($str){
        preg_match("/([^A-Za-z0-9\s])/",$str,$result);
        if(!empty($result)){
            return false;
        }
        return true;
    }

    public function LogicCheck($email){
        $email = $email->getAdresse();
        list($nom, $dom) = explode("@", $email);

        if(strlen($nom) <= 3 || strlen($nom) > 17){
            return false;
        }

        if($dom == 'example.com'){
            return false;
        }
        if($nom[0] == $nom[1] && $nom[0] == $nom[2]){
            return false;
        }
        return true;
    }
}