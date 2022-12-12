<?php

namespace App\Controller;
use App\Entity\Categories;
use App\Entity\ForumMessages;
use App\Entity\Forums;
use App\Repository\CategoriesRepository;
use App\Repository\ForumMessagesRepository;
use App\Repository\ForumsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Forums as EntityForums;
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
                            ForumsRepository $forumsRepository, 
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

                return $this->redirectToRoute('forum_subforum',['id' => $category->getId()]);                
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
    public function showDiscussion(ForumMessagesRepository $forumMessagesRepository, ForumMessages $sujets, int $sujet, Categories $category): Response
    {
    
        $allforums = $forumMessagesRepository->findByForums($sujet);


        return $this->render('forum/discussion.html.twig',[
            'category' => $category,
            'discussions' => $allforums,
            'messages' => $sujets
        ]);
    }
}
