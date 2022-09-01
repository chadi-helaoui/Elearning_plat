<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'qcm_homepage')]
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    #[Route('/reponse', name: 'qcm_reponsepage')]
    public function reponseAction()
    {
        return $this->render('default/index.html.twig');
    }
}
//