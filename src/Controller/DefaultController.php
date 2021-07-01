<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Task;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $taskTable = $entityManager->getRepository(Task::class)->findAll();
        $ongoingTasks = [];
        $finishedTasks = [];

        foreach ($taskTable as $task) {
            if ($task->getDone() == 0) {
                $ongoingTasks[] = $task;
            } else {
                $finishedTasks[] = $task;
            }
        }

        return $this->render('home.html.twig', [
            'ongoing_tasks' => $ongoingTasks,
            'finished_tasks' => $finishedTasks,
        ]);
    }
}