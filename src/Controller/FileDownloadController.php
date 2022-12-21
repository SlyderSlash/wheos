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
        // dd($request, $filesRepository, $files, $file);
        $name = $files->getName();
        $path = $files->getPath();
        $content = file_get_contents($path);
        $contentPath = 'download/'.$name;
        $key = $this->getParameter('files_secret');

        $response = new Response();
        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        // dd($response);
         $response->headers->set('Content-Disposition', 'attachment;filename="'.$path);
        $content = $cryptingFileService->decryptFile($path, $contentPath,$key);
        dd($content);
        $response->setContent($content);
        //dd($response);
        return $response;
    }
}
