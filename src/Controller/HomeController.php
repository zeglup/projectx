<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\Type\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class HomeController extends AbstractController
{
    public function media(Request $request)
    {
        $form = $this->createForm(BlogPostType::class, new BlogPost());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

        }
        return $this->render('home/media.html.twig', [
            'form' => $form->createView()
        ]);
    }


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

    public function toReview(Request $request)
    {

    }

    public function publishBlogPost(Request $request, $id)
    {
        $post = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->find($id)
        ;

        try {

            $workflow = $this->get('workflow.blog_publishing');


            if ($workflow->can($post, 'publish')) {
                $workflow->apply($post, 'published');
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Approved');

        } catch (\LogicException $e) {

            $this->addFlash('danger', sprintf('No, that did not work: %s', $e->getMessage()));

        }

        return $this->redirectToRoute('index');
    }

    public function omg()
    {
        throw new \Exception('L\'application s\'est vautrée comme une loutre bourrée à la bière sur une pelure de concombre pas fraiche.');
    }
}