<?php

namespace App\Controller;

use App\Entity\Qcm;
use App\Entity\Questions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateController extends AbstractController
{
    #[Route('/create', name: 'qcmCreate_index')]

    public function indexAction(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('create/index.html.twig');
        } else if ($request->isMethod('POST')) {
            $titre = $request->request->get('titre');
            $nbQuestions = $request->request->get('nbQuestions');
            $questions = [];

            for ($i = 1; $i <= $nbQuestions; $i++) {
                $question = $request->request->get('question_' . $i);
                $reponse = $request->request->get('reponse_' . $i);
                $prop1 = $request->request->get('prop1_' . $i);
                $prop2 = $request->request->get('prop2_' . $i);
                $prop3 = $request->request->get('prop3_' . $i);

                $questions[] = [
                    'question' => $question,
                    'reponse' => $reponse,
                    'propositions' => [$prop1, $prop2, $prop3, $reponse]
                ];
            }

            $em = $doctrine->getManager();

            $qcm = new Qcm();
            $qcm->setTitre($titre);

            for ($i = 1; $i <= $nbQuestions; $i++) {
                $question = new Questions();
                $question->setQuestion($questions[$i - 1]['question']);
                $question->setReponse($questions[$i - 1]['reponse']);
                $question->setPropositions($questions[$i - 1]['propositions']);
                $question->setQcm($qcm);
                $qcm->getQuestions()->add($question);
            }

            try {
                $em->persist($qcm);
                $em->flush();
                $success = true;
            } catch (Exception $e) {
                $success = false;
                $message = $e->getMessage();
            }

            if ($success) {
                return $this->render('create/createResults.html.twig', [
                    'success' => true
                ]);
            } else {
                return $this->render('create/createResults.html.twig', [
                    'message' => $message,
                    'success' => false
                ]);
            }
        }
    }
}
