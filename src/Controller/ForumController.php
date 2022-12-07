<?php

namespace App\Controller;

use App\Entity\ForumMessages;
use App\Entity\Forums;
use App\Repository\CategoriesRepository;
use App\Repository\ForumMessagesRepository;
use App\Repository\ForumsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum', methods:'GET')]
    public function home(CategoriesRepository $categoriesRepository,ForumsRepository $forumsRepository,ForumMessagesRepository $forumMessagesRepository): Response
    {
        $subCategories = $categoriesRepository -> findBySubCategories();
        $forums = $forumsRepository->findByForum();
        $messages = $forumMessagesRepository->findByForumMessages();
        return $this->render('forum/home.html.twig', [
            'controller_name' => 'ForumController',
            'categories' => $categoriesRepository->findBy(['parent' => Null], ['id' => 'asc']),
            'subCat' => $subCategories,
            'forums' => $forums,
            'messages' => $messages
        ]);
    }
}
