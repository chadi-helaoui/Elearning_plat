<?php

namespace App\Controller;

use App\Entity\Langage;
use App\Form\LangageType;
use App\Repository\LangageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/langage')]
class LangageController extends AbstractController
{
    #[Route('/', name: 'app_langage_index', methods: ['GET'])]
    public function index(LangageRepository $langageRepository): Response
    {
        return $this->render('langage/index.html.twig', [
            'langages' => $langageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_langage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LangageRepository $langageRepository): Response
    {
        $langage = new Langage();
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langageRepository->add($langage, true);

            return $this->redirectToRoute('app_langage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('langage/new.html.twig', [
            'langage' => $langage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_langage_show', methods: ['GET'])]
    public function show(Langage $langage): Response
    {
        return $this->render('langage/show.html.twig', [
            'langage' => $langage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_langage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Langage $langage, LangageRepository $langageRepository): Response
    {
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langageRepository->add($langage, true);

            return $this->redirectToRoute('app_langage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('langage/edit.html.twig', [
            'langage' => $langage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_langage_delete', methods: ['POST'])]
    public function delete(Request $request, Langage $langage, LangageRepository $langageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$langage->getId(), $request->request->get('_token'))) {
            $langageRepository->remove($langage, true);
        }

        return $this->redirectToRoute('app_langage_index', [], Response::HTTP_SEE_OTHER);
    }
}
