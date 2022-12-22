<?php

namespace App\Controller;

use App\Entity\Files;
use App\Repository\FilesRepository;
use App\Service\CryptingFileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class FileDownloadController extends AbstractController
{
    #[Route('/{id}', name: 'app_file_download', methods: ['GET'])]
    public function downloadAction(Files $files, CryptingFileService $cryptingFileService): Response
    {
        $name = $files->getName();
        $storedPath = $files->getPath();
        $content = file_get_contents($storedPath);
        $label = explode("/", $storedPath);
        $tmpDownload = 'download/'.$label[1];
        $key = $this->getParameter('files_secret');
        $cryptingFileService->decryptFile($storedPath, $tmpDownload,$key);
        // dd($name, $storedPath, $content, $label, $tmpDownload);
        $response = new Response();
        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $name = str_replace(" ", "_", $name);
        $downloadName = $name.".";
        $extension = explode(".", $storedPath);
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$downloadName. $extension[1]);
        $openedFile = fopen($tmpDownload, "r");
        $response->setContent(fread($openedFile, filesize($tmpDownload)));
        unlink($tmpDownload);
        return $response;
    }
}
