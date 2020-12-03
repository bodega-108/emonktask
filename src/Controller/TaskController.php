<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\Usuario;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {
        // Prueba de Entidades y relaciones
        $em = $this->getDoctrine()->getManager();
        
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();
        /*
        foreach($tasks as $task){
            echo $task->getUser()->getEmail().': '.$task->getTitle().'<br>';
        }
        */
        $user_repo = $this->getDoctrine()->getRepository(Usuario::class);
        $users = $user_repo->findAll();

       /* foreach($users as $user){
            echo "<h1>{$user->getName()} {$user->getSurname()}</h1>";
            
            foreach($user->getTasks() as $task){
                echo $task->getTitle().'<br>';
            }
        }
       */ 
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController'
        ]);
    }
}
