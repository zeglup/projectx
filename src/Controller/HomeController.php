<?php
/**
 * Created by PhpStorm.
 * User: Glup
 * Date: 20/12/2018
 * Time: 16:19
 */

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function index(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();
        return $this->render('home/workflow.html.twig', [
            'posts' =>  $posts
        ]);
    }
}