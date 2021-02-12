<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        $todoTest = new todo("Clean", false);
        return $this->render('main/main.html.twig', [
            'todoTest' => $todoTest,
        ]);
    }
}

class todo{
    public $title;
    public $isDone;
    function __construct($title, $isDone)
    {
        $this->title = $title;
        $this->isDone = $isDone;
    }
}
