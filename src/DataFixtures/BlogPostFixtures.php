<?php
/**
 * Created by PhpStorm.
 * User: Glup
 * Date: 20/12/2018
 * Time: 16:42
 */

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BlogPostFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $post = new BlogPost();
        $post->setTitle('title1');
        $post->setContent('Some content.');
        $post->setState([ 'draft' => 1 ]);
        $manager->persist($post);

        $post = new BlogPost();
        $post->setTitle('title2');
        $post->setContent('Some content.');
        $post->setState([ 'review' => 1 ]);
        $manager->persist($post);

        $post = new BlogPost();
        $post->setTitle('title3');
        $post->setContent('Some content.');
        $post->setState([ 'waiting' => 1 ]);
        $manager->persist($post);

        $post = new BlogPost();
        $post->setTitle('title4');
        $post->setContent('Some content.');
        $post->setState([ 'rejected' => 1 ]);
        $manager->persist($post);

        $manager->flush();
    }
}