<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(TodoRepository $todoRepository): Response
    {
        $todos_db = $todoRepository->findAll();
        $todos = [];

        foreach($todos_db as $todo)
        {
            $t = new todoObj($todo->getId(), $todo->getTitle(), $todo->getCompleted());
            array_unshift($todos, $t);
        }
        return $this->render('main/list.html.twig', [
            'todos' => $todos,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function createNewTodo(Request $request)
    {
        $title = trim($request->request->get('title'));
        if(!empty($title))
        {
            $todo = $this->createTodo($title);
            $this->saveToDB($todo);
        }
        return $this->redirectToRoute('list');
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateTodo($id, TodoRepository $todoRepository)
    {
        $todo = $todoRepository->find($id);
        $todo->setCompleted(!$todo->getCompleted());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('list');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteTodo(Todo $id)
    {
        $eventManager = $this->getDoctrine()->getManager();
        $eventManager->remove($id);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('list');
    }

    function createTodo($title) : Todo
    {
        $newTodo = new Todo();
        $newTodo->setTitle($title);
        $newTodo->setCompleted(false);
        return $newTodo;
    }

    function saveToDB(Todo $todo)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($todo);
        $entityManager->flush();
    }
}

class todoObj
{
    function __construct($id, $title, $completed)
    {
        $this->id = $id;
        $this->title = $title;
        $this->completed = $completed;
    }
}
