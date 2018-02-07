<?php

namespace TestBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Form\CommentType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     *
     */
    public function indexAction()
    {
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        $articles = $articleRepos->getArticleSortRang();
//        $articles = $articleRepos->searchArticle('ea');

        return $this->render('TestBundle:Default:index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article_show")
     * @param Request $request
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function singleAction(Request $request, $slug)
    {
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        /** @var Post $article */
        $article = $articleRepos->findOneBy(['slug' => $slug]);
        $comments = $article->getComments();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $article) {
            /** @var Comment $commentSubmit */
            $commentSubmit = $form->getData();
            $commentSubmit->setPost($article);
            $article->setRang($article->getRang()+1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentSubmit);
            $em->flush();

            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }


        return $this->render('TestBundle:Default:article_single.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
            'comments' => $comments,
        ]);
    }
}
