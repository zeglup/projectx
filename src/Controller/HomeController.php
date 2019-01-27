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
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class HomeController extends AbstractController
{
    public function index(Request $request, KernelInterface $kernel)
    {
        // Generate some graph with command @todo: fix broken path
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'app:dump_graph',
            'workflow' => 'blog_publishing',
        ]);
        $output = new NullOutput();

        try{
            $application->run($input, $output);
            $posts = $this->getDoctrine()->getRepository(BlogPost::class)->findAll();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->render('home/index.html.twig', [
            'posts' =>  $posts
        ]);
    }
}