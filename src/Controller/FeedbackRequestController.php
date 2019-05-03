<?php

namespace App\Controller;

use App\Entity\FeedBackRequest;
use App\Form\FeedbackRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackRequestController extends AbstractController
{
    /**
     * @Route("/feedback/request", name="feedback_request")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        //создали новый объект из сущности
        $feedbackRequest = new FeedBackRequest();
        //
        $form = $this->createForm(FeedbackRequestType::class, $feedbackRequest);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($feedbackRequest);
            $entityManager->flush(); //sliv

            return $this->redirectToRoute('feedback_request_success');

        }

        return $this->render('feedback_request/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/feedback/success", name="feedback_request_success")
     */
    public function success()
    {
        return $this->render('feedback_request/success.html.twig');
    }
}
