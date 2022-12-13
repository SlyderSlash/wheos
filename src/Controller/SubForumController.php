<?php

namespace App\Controller;
use App\Entity\Categories;
use App\Entity\ForumMessages;
use App\Entity\Forums;
use App\Repository\CategoriesRepository;
use App\Repository\ForumMessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isEmpty;

#[Route('/forum', name: 'forum_')]
class SubForumController extends AbstractController
{
    #[Route('/{id}', name: 'subforum')]
    public function index(Categories $category,
                            Request $request,
                            EntityManagerInterface $objectManager,
                            CategoriesRepository $categoriesRepository,
                            int $id, 
                            ForumMessagesRepository $forumMessagesRepository): Response
    {
        
        $sujet = new Forums();
        $contenu = new ForumMessages();

       $categoryform = $this->createFormBuilder($sujet)
                            ->add('title')
                            ->getForm();
 
        $categoryform->handleRequest($request);

         if ($categoryform->isSubmitted() && $categoryform->isValid() && $request->request->count() > 0){
            if( isEmpty( $request->request->get('message'))){

                $sujet->setCreatedAt(new \DateTime())
                        ->setCategory($category)
                        ->setUser($this->getUser());

                $objectManager->persist($sujet); 

                $contenu->setCreatedAt(new \DateTime())
                        ->setContent($request->request->get('message'))
                        ->setUser($this->getUser())
                        ->setForum($sujet) 
                        ;

                $objectManager->persist($contenu);
                $objectManager->flush();

                return $this->redirectToRoute('forum_subforum',['id' => $id]);                
            }
        }


        $subCategories = $categoriesRepository->findBySubCategories();
        $lastMessages = $forumMessagesRepository->findByLastMessages($category->getId());
        $allforums = $forumMessagesRepository->findAllForumMessages();

        return $this->render('forum/subForum.html.twig',[
            'category' => $category,
            'subCategories' => $subCategories,
            'allforums' => $allforums,
            'lastMessages' => $lastMessages,
            'categoryform' =>  $categoryform->createView()
        ]);
    }

    #[Route('/{id}/{sujet}', name: 'sujet')]
    public function showDiscussion(ForumMessagesRepository $forumMessagesRepository, 
                                    ForumMessages $sujets, 
                                    Forums $forum,
                                    int $sujet, int $id,
                                    Categories $category,
                                    Request $request,
                                    EntityManagerInterface $objectManager): Response
    {
    
        $allforums = $forumMessagesRepository->findByForums($sujet);

        $reponse = new ForumMessages();

        $messageform = $this->createFormBuilder($reponse)
                            ->add('content')
                            ->getForm();

        $messageform->handleRequest($request);

        if ($messageform->isSubmitted() && $messageform->isValid() && $request->request->count() > 0){
                   /*   $reponse->setCreatedAt(new \DateTime())
                        ->setForum($sujet)
                        ->setUser($this->getUser());

                $objectManager->persist($reponse); 
                $objectManager->flush();

                return $this->redirectToRoute('forum_sujet',['id' => $id, 'sujet' => $sujet]);  */              
        }


        return $this->render('forum/discussion.html.twig',[
            'discussions' => $allforums,
            'form' => $messageform->createView()
        ]);
    }
}
