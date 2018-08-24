<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // $posts = [
        //     [
        //         "title" => "Hello",
        //         "image" => "",
        //         "description" => "Ah e tal",
        //         "author" => "some User",
        //         "date" => "hoje"
        //     ],
        //     [
        //         "title" => "Second Post",
        //         "image" => "",
        //         "description" => "Coisas e cenas",
        //         "author" => "Other User",
        //         "date" => "hoje"
        //     ],
        // ];

        $posts = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home',
            'posts' => $posts
        ]);
    }
}
