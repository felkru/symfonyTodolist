<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/create-task", name="create-task")
     */
    public function createTask(Request $request): Response
    {
        $description = $request->request->get('description');

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $task = new Task();
        $task->setName($description);
        $task->setDone(false);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($task);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('index', $request->query->all());
    }

    /**
     * @Route("/change-tasks", name="change-tasks")
     */
    public function changeTasks(Request $request): Response
    {
        $tasks = $request->request->get('tasks');

        $entityManager = $this->getDoctrine()->getManager();

        $taskTable = $entityManager->getRepository(Task::class)->findAll();

        foreach ($taskTable as $task) {
            if (in_array($task->getId(), $tasks)) {
                $task->setDone(true); 
            } else {
                $task->setDone(false);
            }
            $entityManager->persist($task);
            $entityManager->flush();
        }

        // foreach ($tasks as &$id) {
        //     $task = $entityManager->getRepository(Task::class)->find($id);
        //     $task->setDone(true);
        //     $entityManager->persist($task);
        //     $entityManager->flush(); 
        // }

        return $this->redirectToRoute('index', $request->query->all());
    }
}
