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
        $todoList = new todoList("Test");
        #$todoList->addToList(new todo("Clean", false));
        $lists = array($todoList);
        array_push($lists, new todoList("Test 2"), new todoList("Test 3"));
        return $this->render('main/main.html.twig', [
            'lists' => $lists,
        ]);
    }

    #[Route('/list/{list?}', name: 'list')]
    public function list($list): Response
    {
        $todoList = new todoList("Test");
        #$todoList->addToList(new todo("Clean", false));
        return $this->render('main/list.html.twig', [
            'list' => $list,
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
    public $name;
    public $todos = array();
    function __construct($name)
    {
        $this->name = $name;
    }
    function addToList($todo){
        array_push($this->todos, $todo);
    }
}
