<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin')]
class PageController extends AbstractController
{
    const TMPL_INDEX = "backend/pages/index.html.twig";
    const TMPL_DASHBOARD = "backend/pages/index.html.twig";
    const TMPL_COGES = "backend/pages/index.html.twig";

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(self::TMPL_INDEX);
    }
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

    #[Route('/coges', name: 'app_coges', methods: ['GET'])]
    public function coges(): Response
    {
        return $this->render(self::TMPL_COGES);
    }

    #[Route('/daps_coges', name: 'app_daps_coges', methods: ['GET'])]
    public function dapsCoges(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

    #[Route('/iepp', name: 'app_iepp', methods: ['GET'])]
    public function iepp(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/etablissements', name: 'app_etablissements', methods: ['GET'])]
    public function etablissements(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/creation_pacc', name: 'app_creation_pacc', methods: ['GET'])]
    public function creationPacc(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/execution_pacc', name: 'app_execution_pacc', methods: ['GET'])]
    public function executionPacc(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/paiement_fournisseurs', name: 'app_paiement_fournisseurs', methods: ['GET'])]
    public function paiementFournisseurs(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/mandats', name: 'app_mandats', methods: ['GET'])]
    public function mandats(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/membres', name: 'app_membres', methods: ['GET'])]
    public function membres(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/liste_coges', name: 'app_liste_coges', methods: ['GET'])]
    public function listeCoges(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/affectations_ecoles', name: 'app_affectations_ecoles', methods: ['GET'])]
    public function affectationsEcoles(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/fournisseurs', name: 'app_fournisseurs', methods: ['GET'])]
    public function fournisseurs(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }
    #[Route('/utilisateurs', name: 'app_utilisateurs', methods: ['GET'])]
    public function utilisateurs(): Response
    {
        return $this->render(self::TMPL_DASHBOARD);
    }

}
