<?php

namespace ScriptBundle\Controller;

use ScriptBundle\Entity\Line;
use ScriptBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/script", name="script_rout")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $line = new Line();
        $form = $this->createForm(TaskType::class, $line);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Line $lineSubmit */
            $lineSubmit = $form->getData();

            $logicService = $this->get('script_bundle.logic_service');
            $uniqId = $logicService->logicBeforeSendToApi($lineSubmit);

            $lineSubmit->setApiResult($uniqId);

            $em = $this->getDoctrine()->getManager();

            $em->persist($lineSubmit);
            $em->flush();

            return $this->redirectToRoute('script_rout');
        }

        return $this->render('ScriptBundle:Default:index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
