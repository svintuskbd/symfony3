<?php

namespace TestBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Form\CommentType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage_blog")
     *
     */
    public function indexAction()
    {
        $articleRepos = $this->getDoctrine()->getRepository('AppBundle:Post');
        $result = $articleRepos->getArticleSortRang();
//        $result = $articleRepos->customFindAll();

        if ($result instanceof NoResultException) {
            $this->addFlash('error', $result->getMessage());
        } elseif ($result instanceof NonUniqueResultException){
            $this->addFlash('error', $result->getMessage());
        }

        return $this->render('TestBundle:Default:index.html.twig', [
            'articles' => $result,
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
