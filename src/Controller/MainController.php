<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function main(): Response
    {
        $todoList = new todoList();
        $todoList->addToList(new todo("Clean", false));
        return $this->render('main/main.html.twig', [
            'todoList' => $todoList,
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

class todoList{
    public $todos = array();
    function addToList($todo){
        array_push($this->todos, $todo);
    }
}
