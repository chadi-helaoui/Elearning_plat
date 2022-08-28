<?php

namespace App\Controller;

use App\Entity\Framework;
use App\Form\FrameworkType;
use App\Repository\FrameworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/framework')]
class FrameworkController extends AbstractController
{
    #[Route('/', name: 'app_framework_index', methods: ['GET'])]
    public function index(FrameworkRepository $frameworkRepository): Response
    {
        return $this->render('framework/index.html.twig', [
            'frameworks' => $frameworkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_framework_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FrameworkRepository $frameworkRepository): Response
    {
        $framework = new Framework();
        $form = $this->createForm(FrameworkType::class, $framework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $frameworkRepository->add($framework, true);

            return $this->redirectToRoute('app_framework_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('framework/new.html.twig', [
            'framework' => $framework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_framework_show', methods: ['GET'])]
    public function show(Framework $framework): Response
    {
        return $this->render('framework/show.html.twig', [
            'framework' => $framework,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_framework_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Framework $framework, FrameworkRepository $frameworkRepository): Response
    {
        $form = $this->createForm(FrameworkType::class, $framework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $frameworkRepository->add($framework, true);

            return $this->redirectToRoute('app_framework_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('framework/edit.html.twig', [
            'framework' => $framework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_framework_delete', methods: ['POST'])]
    public function delete(Request $request, Framework $framework, FrameworkRepository $frameworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$framework->getId(), $request->request->get('_token'))) {
            $frameworkRepository->remove($framework, true);
        }

        return $this->redirectToRoute('app_framework_index', [], Response::HTTP_SEE_OTHER);
    }
}
