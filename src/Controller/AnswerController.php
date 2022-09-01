<?php

namespace App\Controller;

use App\Entity\Qcm;
use App\Entity\Questions;
use App\Entity\Resultat;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'qcmAnswer_index')]
    public function indexAction(ManagerRegistry $doctrine): Response
    {
        $qcmRepository = $doctrine->getManager()->getRepository(Qcm::class);
        $listqcm = $qcmRepository->findBy([], ['titre' => 'ASC']);
        return $this->render('answer/index.html.twig', ['listqcm' => $listqcm]);
    }
    #[Route("/renseigner/{id}", name: "qcmAnswerrenseigner_index")]
    public function renseignerAction(Request $request, int $id, ManagerRegistry $doctrine)
    {
        $qcmRepository = $doctrine->getManager()->getRepository(Questions::class)->findBy(['qcm' => $id]);
        $titre = $doctrine->getManager()->getRepository(Qcm::class)->find($id);
        $qcm = $qcmRepository;

        foreach ($qcm as $question) {
            $props = $question->getPropositions();
            shuffle($props);
            $question->setPropositions($props);
        }
        if ($request->isMethod('POST')) {
            $nbReponsesOK = 0;
            $proposition = $request->get('proposition');
            foreach ($qcm as $value) {
                if ($value->getReponse() == $proposition[$value->getId()]) {
                    $nbReponsesOK = $nbReponsesOK + 1;
                }
            }
            $resultat =  new Resultat();
            $resultat->setUser($request->request->get('user'));
            $resultat->setNbQuestions(count($qcm));
            $resultat->setNbReponsesOK($nbReponsesOK);
            $resultat->setQcm($titre);
            $em = $doctrine->getManager();
            $em->persist($resultat);
            $em->flush();
            $this->addFlash('success', 'Merci d\'avoir renseigné ce qcm !');
            return $this->redirectToRoute('qcmResults_index');
        }
        return $this->render('answer/renseigner.html.twig', ['qcm' => $qcm, 'titre' => $titre]);
    }
}
//