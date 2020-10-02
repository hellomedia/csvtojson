<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use OzdemirBurak\JsonCsv\File\Csv;

class DefaultController extends AbstractController
{
    /**
     * see https://github.com/ozdemirburak/json-csv
     *
     * @Route("/convert/{filename}", name="convert")
     */
    public function convert($filename)
    {
        // CSV to JSON
        if (is_file(\dirname(__DIR__).'/../public/csv/'.$filename.'.csv')) {
            $csv = new Csv(\dirname(__DIR__).'/../public/csv/'.$filename.'.csv');
            $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $csv->setConversionKey('join', 'none');
            // To convert CSV to JSON string
            //$jsonString = $csv->convert();
            // To convert CSV to JSON and save
            $csv->convertAndSave(\dirname(__DIR__). '/../public/json/'.$filename.'.json');
            // To convert CSV to JSON and force download on browser
            //$csv->convertAndDownload();
            $success = true;
        }


        return $this->render('default/index.html.twig', [
            'filename' => $filename,
            'success' => $success ?? false,
        ]);
    }
}
