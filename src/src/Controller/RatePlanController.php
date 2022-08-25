<?php

namespace App\Controller;

use App\Entity\RatePlan;
use App\Form\RatePlanType;
use App\Repository\RatePlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rate-plan')]
class RatePlanController extends AbstractController
{
    #[Route('/', name: 'app_rate_plan_index', methods: ['GET'])]
    public function index(RatePlanRepository $ratePlanRepository): Response
    {
        return $this->render('rate_plan/index.html.twig', [
            'rate_plans' => $ratePlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rate_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RatePlanRepository $ratePlanRepository): Response
    {
        $ratePlan = new RatePlan();
        $form = $this->createForm(RatePlanType::class, $ratePlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ratePlanRepository->add($ratePlan, true);

            return $this->redirectToRoute('app_rate_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rate_plan/new.html.twig', [
            'rate_plan' => $ratePlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rate_plan_show', methods: ['GET'])]
    public function show(RatePlan $ratePlan): Response
    {
        return $this->render('rate_plan/show.html.twig', [
            'rate_plan' => $ratePlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rate_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RatePlan $ratePlan, RatePlanRepository $ratePlanRepository): Response
    {
        $form = $this->createForm(RatePlanType::class, $ratePlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ratePlanRepository->add($ratePlan, true);

            return $this->redirectToRoute('app_rate_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rate_plan/edit.html.twig', [
            'rate_plan' => $ratePlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rate_plan_delete', methods: ['POST'])]
    public function delete(Request $request, RatePlan $ratePlan, RatePlanRepository $ratePlanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ratePlan->getId(), $request->request->get('_token'))) {
            $ratePlanRepository->remove($ratePlan, true);
        }

        return $this->redirectToRoute('app_rate_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
