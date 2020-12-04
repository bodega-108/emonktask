<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use App\Entity\Usuario;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

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
            'controller_name' => 'TaskController',
            'tareas' => $tasks,
            'usuarios' => $users
        ]);
    }

    public function detail(Task $task){

        if(!$task){
            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig', [
            'task' => $task
        ]);
    }

    public function createTask(Request $request, UserInterface $user){

        $tarea = new Task();

        $form = $this->createForm(TaskType::class, $tarea);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            $tarea->setCreatedAt(new \DateTime('now'));
            
           $tarea->setUser($user);

           $em = $this->getDoctrine()->getManager();
           $em->persist($tarea);
           $em->flush();

           return $this->redirect(
               $this->generateUrl('task_detail',['id' => $tarea->getId()])
           );
        }

        return $this->render('task/crear.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    public function miTask(UserInterface $user){
       
        $tasks = $user->getTasks();

        return $this->render('task/miTask.html.twig',[
            'mitarea' => $tasks
        ]);
    }

    public function edit(Request $request, Task $task, UserInterface $user){

        if($user || $user->getId() != $task->getUser()->getId()) {
                $message = "Lo sentimos, pero no puede Editar esta tarea";
                $sin_permisos = true;
        }

        
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            $tarea->setCreatedAt(new \DateTime('now'));
            
           $tarea->setUser($user);

           $em = $this->getDoctrine()->getManager();
           $em->persist($tarea);
           $em->flush();

           return $this->redirect(
               $this->generateUrl('task_detail',['id' => $tarea->getId()])
           );
        } 

        return $this->render('task/crear.html.twig',[
            'edit' => true,
            'form' => $form->createView(),
            'mensaje' => $message,
            'permiso' => $sin_permisos
        ]);
    }
}
