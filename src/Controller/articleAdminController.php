<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-10-13
 * Time: 오전 5:35
 */

namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class articleAdminController extends AbstractController
{

    /**
     * @Route("/admin/article/new")
     */

    public function new(EntityManagerInterface $em)
    {
        die('todo');

        return new Response(sprintf(
            'Hiya! New article id: #%d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }

}