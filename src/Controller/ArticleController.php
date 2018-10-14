<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class ArticleController extends AbstractController
{
    /**
     * @var
     */
    private $isDebug;

    /**
     * ArticleController constructor.
     */
    public function __construct(bool $isDebug, Client $slack)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig',[
            'articles' => $articles,
        ]);

    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, Client $slack)
    {

        if($article->getSlug() === 'khaaaaaan'){
            $message = $slack->createMessage()
                ->from('khan')
                ->withIcon(':ghost:')
                ->setText('Ah, Kirk, my old friend...');

            $slack->sendMessage($message);
        }

//        $repository = $em->getRepository(Article::class);
//        /** @var Article $article */
//        $article = $repository->findOneBy(['slug'=> $slug]);
//
//        if(!$article){
//            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
//        }

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];


        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        // TODO - actually heart/unheart the article!

        $logger->info('Article is being hearted!');

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
