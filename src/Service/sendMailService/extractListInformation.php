<?php
/**
 * Created by PhpStorm.
 * User: sacha
 * Date: 14/04/2020
 * Time: 22:33
 */

namespace App\Service\sendMailService;


use App\Entity\Email;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

class extractListInformation
{

    private $entityManager;

    private $csvEncoder;

    public function __construct(EntityManagerInterface $entityManager, DecoderInterface $csvEncoder)
    {
        $this->entityManager = $entityManager;
        $this->csvEncoder = $csvEncoder;
    }

    public function extractNumberOfMailInDocument($file){

        preg_match_all('#\s+[a-z0-9_-]{2,}@[a-z.]{5,}\s+#', $file, $email);
        return count($email);
    }

    public function CsvIsCommat($file){
        // CSV is separated with comma or space ?
    }

    public function ExtractDataInDocument($filename, $list){
        $file = '../Data/'.$filename;
        $file = fopen($file, 'r');
        $data = stream_get_contents($file, -1, 0);
        $data = str_replace(',', ' ', $data);
        preg_match_all('#\s+[A-Za-z0-9_-]{2,}@[a-z.]{5,}\s+#', $data, $result);
        $i = 0 ;

        foreach ($result[0] as $adresse){
            if(!$this->entityManager->getRepository(Email::class)->findBy(['adresse'=>$adresse])){
                $email = new Email();
                $email->setAdresse(trim(strtolower($adresse)));
                $email->setList($list);
                $this->entityManager->persist($email);
                $i++;
                $this->entityManager->flush();
            }
        }
        return $i;
    }

    public function DataCSVEncode($filename, $list){

        // Here transform Data for Output


        // encoding contents in CSV format
        //$serializer->encode($data, 'csv');

    }



    public function convertToArray($filename, $delimiter = ',', $enclosure = '"')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {

                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }



}