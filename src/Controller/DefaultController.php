<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Hello world!',
            'path' => 'src/Controller/DefaultController.php',
            'date' => strftime('%F %T'),
        ]);
    }
}
