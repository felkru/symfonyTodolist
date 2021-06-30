<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Task;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        $number = random_int(0, 100);
        $userTasks = ["clean room", "finish free code camp", "be kind"];

        return $this->render('home.html.twig', [
            'random_number' => $number,
            'tasks' => $userTasks,
        ]);
    }
}