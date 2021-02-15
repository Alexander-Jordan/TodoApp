<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\Type\TodoFormType;
use App\Repository\TodoRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(TodoRepository $todoRepository, Request $request): Response
    {
        $newTodo = new Todo();

        $todoForm = $this->createForm(TodoFormType::class, $newTodo);

        $todoForm->handleRequest($request);
        if ($todoForm->isSubmitted() && $todoForm->isValid())
        {
            $this->saveToDB($newTodo);
            return $this->redirectToRoute('task_success');
        }

        $todos_db = $todoRepository->findAll();
        $todos = [];

        foreach($todos_db as $todo)
        {
            $t = new todoObj($todo->getId(), $todo->getTitle(), $todo->getCompleted());
            array_unshift($todos, $t);
        }
        return $this->render('main/list.html.twig', [
            'todoForm' => $todoForm->createView(),
            'todos' => $todos,
        ]);
    }

    function saveToDB(Todo $todo)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($todo);
        $entityManager->flush();
    }

    public function getTodo(int $id)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
    }

    public function getTodos()
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
        return $todos;
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
