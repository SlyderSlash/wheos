<?php

namespace App\Controller;

use App\Entity\Files;
use App\Form\FilesType;
use App\Repository\FilesRepository;
use App\Service\CryptingFileService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Crypto\SMimeEncrypter; // Système de cryptage pour les fichiers ?

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/file/upload')]
class FileUploadController extends AbstractController
{
    #[Route('/', name: 'app_file_upload_index', methods: ['GET'])]
    public function index(FilesRepository $filesRepository): Response
    {
        return $this->render('file_upload/index.html.twig', [
            'files' => $filesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_file_upload_new', methods: ['GET', 'POST'])]

    public function new(Request $request, FilesRepository $filesRepository, CryptingFileService $cryptingFileService): Response 
    {
        $file = new Files();
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('file')->getData();

            // On GENERE un NOUVEAU NOM au FICHIER
            $fileName = md5(uniqid()) . '.' . $files->guessExtension();
            $file->setPath('./uploads/' . $fileName);
            $key = $this->getParameter('files_secret');
            
            // On COPIE le FICHIER dans le DOSSIER UPLOADS
            $files->move(
                $this->getParameter('files_directory'),
                $fileName
            );
            $cryptingFileService = $cryptingFileService->encryptFile('./uploads/'.$fileName, $file->getPath(), $key);

            $filesRepository->add($file, true);
            
            return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_upload/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_upload_show', methods: ['GET'])]
    public function show(Files $file): Response
    {
        return $this->render('file_upload/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{id}', name: 'app_file_download', methods: ['GET'])]
    public function downloadAction($filename)
    {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/downloads/";
        $content = file_get_contents($path.$filename);
    
        $response = new Response();
    
        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);
    
        $response->setContent($content);
        return $response;
    }

    #[Route('/{id}/edit', name: 'app_file_upload_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Files $file, FilesRepository $filesRepository, CryptingFileService $cryptingFileService): Response
    {
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('file')->getData();
            $oldFile = $file->getPath();
            $newFile = md5(uniqid()) . '.' . $files->guessExtension();
            $file->setPath('./uploads/' . $newFile);
            $key = $this->getParameter('files_secret');
            // On COPIE le FICHIER dans le DOSSIER UPLOADS
            $files->move(
                $this->getParameter('files_directory'),
                $newFile
            );
            $cryptingFileService = $cryptingFileService->encryptFile('./uploads/'.$newFile, $file->getPath(), $key);
            
            $filesRepository->add($file, true);
            unlink($oldFile);

            return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_upload/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_upload_delete', methods: ['POST'])]
    public function delete(Request $request, Files $file, FilesRepository $filesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $file->getId(), $request->request->get('_token'))) {
            $filesRepository->remove($file, true);
            unlink($file->getPath());
        }

        return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
    }
}
