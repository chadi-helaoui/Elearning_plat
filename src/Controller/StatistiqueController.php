<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_statistique')]
    public function statenseignant(EnseignantRepository $ensrepo): Response
    {
        $enseignant = $ensrepo->findAll();

        $enscount = [];
        $etudcount = [];

        foreach ($enseignant as $ens) {
            $enscount[] = count($enscount[], $ens->getId());
        }
        return $this->render('statistique/index.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }

    public function statetudiant(EtudiantRepository $etudrepo): Response
    {
        $etudiant = $etudrepo->findAll();

        $etudcount = [];


        foreach ($etudiant as $ens) {
            $enscount[] = count($etudcount[], $ens->getId());
        }
        return $this->render('statistique/index.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    }
}
