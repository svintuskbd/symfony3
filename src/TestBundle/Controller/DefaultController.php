<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     *
     */
    public function indexAction()
    {
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        $articles = $articleRepos->findAll();

        return $this->render('TestBundle:Default:index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article_show")
     *
     */
    public function singleAction($slug)
    {
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        $article = $articleRepos->findOneBy(['slug' => $slug]);
        dump($article); die;
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        $articles = $articleRepos->findAll();

        return $this->render('TestBundle:Default:index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
