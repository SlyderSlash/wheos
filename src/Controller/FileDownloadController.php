<?php

namespace App\Controller;

use App\Entity\Files;
use App\Repository\FilesRepository;
use App\Service\CryptingFileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FileDownloadController extends AbstractController
{
    // [BUG] can't get a way to download file from the TWIG page (templates/file_upload/show.html.twig)
    #[Route('/{id}', name: 'app_file_download', methods: ['GET'])]
    public function downloadAction(Request $request, Files $files, FilesRepository $filesRepository, CryptingFileService $cryptingFileService): Response
    {
        $file = $files->getPath();
        dd($request, $filesRepository, $files, $file);
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/downloads/";
        $content = file_get_contents($path.$filename);

        $response = new Response();
    
        //set headers
        $response->header->set('uploads/459e8b3ea40fcc27d5c5c32a627e8648.txt');
        // $response->headers->set('Content-Type', 'mime/type');
        // $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);
    
        $response->setContent($content);
        return $response;
    }
}
