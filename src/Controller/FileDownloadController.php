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
        $downloadName = explode("/", $path);
        // dd($name, $path, $content, $downloadName[1]);
        $contentPath = 'download/'.$downloadName[1];
        $key = $this->getParameter('files_secret');
        $cryptingFileService->decryptFile($path, $contentPath,$key);
        $response = new Response();
        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        // dd($response);
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$downloadName[1]);
        $response->setContent(fread($contentPath, "r"));
        //dd($response);
        return $response;
    }
}
