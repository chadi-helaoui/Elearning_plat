<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResultsController extends AbstractController
{
    #[Route('/results', name: 'qcmResults_index')]
    public function indexAction(ManagerRegistry $doctrine): Response
    {
        $qcmRepository = $doctrine->getManager()->getRepository(Qcm::class);
        /*$allQcm = $qcmRepository->findAll();*/
        $allQcm = $qcmRepository->findBy([], ['titre' => 'ASC']);

        return $this->render('results/index.html.twig', ['allQcm' => $allQcm]);
    }
    #[Route('/viewResult/{qcmId}', name: 'viewResult')]
    public function viewResultAction($qcmId, ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();
        $qcm = $advert = $manager->getRepository(Qcm::class)->find($qcmId);

        if (null === $qcm) {
            throw new NotFoundHttpException("Ce QCM n'existe pas.");
        }

        $results = $doctrine->getManager()->getRepository(Resultat::class)->findBy(['qcm' => $qcm], ['nbReponsesOK' => 'DESC']);

        $stats = $this->getStats($results);


        return $this->render('Results/viewResult.html.twig', ['qcm' => $qcm, 'allResults' => $results, 'stats' => $stats]);
    }
    public function getStats($results)
    {

        if (null != $results) {
            $meilleurResultat = 0;
            $userMeilleurResultat = "";
            $moyenneResultats = 0;
            $nombreUsers = 0;
            $sommeResultat = 0;
            $nbQuestions = $results[0]->getNbQuestions();

            foreach ($results as $resultat) {

                if ($resultat->getNbReponsesOK() > $meilleurResultat) {
                    $meilleurResultat = $resultat->getNbReponsesOK();
                    $userMeilleurResultat = $resultat->getUser();
                }

                $sommeResultat += $resultat->getNbReponsesOK();
                $nombreUsers++;
            }
            $moyenneResultats = (($sommeResultat / $nombreUsers) * 100) / $nbQuestions;
            $meilleurResultat = ($meilleurResultat * 100) / $nbQuestions;

            $stats = [
                'meilleurResultat' => $meilleurResultat,
                'userMeilleurResultat' => $userMeilleurResultat,
                'moyenneResultats' => $moyenneResultats,
                'nombreUsers' => $nombreUsers,
                'nbQuestions' => $nbQuestions
            ];
        } else {
            $stats = false;
        }
        return $stats;
    }
}
//