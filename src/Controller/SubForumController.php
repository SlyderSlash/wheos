<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Forums;
use App\Entity\Users;
use App\Repository\CategoriesRepository;
use App\Repository\ForumMessagesRepository;
use App\Repository\ForumsRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forum', name: 'forum_')]
class SubForumController extends AbstractController
{
    #[Route('/{id}', name: 'subforum')]
    public function index(Categories $category,CategoriesRepository $categoriesRepository,
                            ForumsRepository $forumsRepository, 
                            ForumMessagesRepository $forumMessagesRepository): Response
    {
 
        $subCategories = $categoriesRepository->findBySubCategories();
        $forums = $forumsRepository->findByForum();
        $messages = $forumMessagesRepository->findByForumMessages();
        $lastMessages = $forumMessagesRepository->findByLastMessages($category->getId());
        return $this->render('forum/subForum.html.twig', compact('category', 'subCategories', 'forums', 'messages', 'lastMessages'));
    }
}
