<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecettesType;
use App\Helper\DataTableHelper;
use App\Repository\ActiviteRepository;
use App\Repository\PaccRepository;
use App\Repository\RecetteRepository;
use App\Repository\SourceRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/recette')]
class RecettesController extends AbstractController
{
    #[Route('/', name: 'app_recette_index', methods: ['GET'])]
    public function index(RecetteRepository $recettesRepository): Response
    {
        return $this->render('recettes/index.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }

    #[Route('/datatable', name: 'app_recette_dt', methods: ['GET', 'POST'])]
    public function datatable(Request $request, Connection $connection)
    {
        date_default_timezone_set("Africa/Abidjan");
        $params = $request->query->all();
        $paramDB = $connection->getParams();
        $table = 'recette';
        $primaryKey = 'id';
        $columns = [
            [
                'db' => 'source_id',
                'dt' => 'source_id',
                'formatter' => function($d, $row) use($connection) {
                    $libelle = $connection->fetchOne("select `libelle_source` from `source` where `id` = $d");
                    return "<span>$libelle</span>";
                }
            ],
            [
                'db' => 'montant_recette',
                'dt' => 'montant_recette',
            ],
            [
                'db' => 'id',
                'dt' => '',
                'formatter' => function($d, $row){
                    $content = sprintf("<div class='d-flex justify-content-end'><span class='btn btn-warning shadow btn-xs sharp me-1 dt-edit-recette' data-id='%s' data-source-id='%s' data-montant='%s'><i class='fa fa-pencil'></i></span><span class='btn btn-danger shadow btn-xs sharp dt-delete-recette' data-id='%s' ><i class='fa fa-trash'></i></span></div>", $d, $row['source_id'], $row['montant_recette'], $d);
                    return $content;
                }
            ],
        ];

        $sql_details = [
            'user' => $paramDB['user'],
            'pass' => $paramDB['password'],
            'db'   => $paramDB['dbname'],
            'host' => $paramDB['host']
        ];

        $whereResult = null;
        if(!empty($params['source_filter'])) {
            $whereResult .= " source_id = ". $params['source_filter'] . " AND";
        }
        if(!empty($params['pacc_filter'])) {
            $whereResult .= " pacc_id = ". $params['pacc_filter'] . " AND";
        }
        if(!empty($params['libelle_filter'])) {
            $whereResult .= " libelle = '". $params['region_filter'] . "' AND";
        }

        if($whereResult) $whereResult = substr_replace($whereResult,'',-strlen(' AND'));

        $response = DataTableHelper::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult);
        return new JsonResponse($response);
    }

    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Connection $connection, RecetteRepository $recetteRepository): Response
    {
        if($request->isXmlHttpRequest()){
            $recette = $recetteRepository->findOneBy(['pacc' => $request->get('pacc'), 'source' => $request->get('source')]);

            if($recette) return $this->json(['duplicate' => 1, 'source' => $request->get('source')]);

            $connection->insert('recette', [
                'montant_recette' => $request->get('montant_recette'),
                'source_id' => $request->get('source'),
                'pacc_id' => $request->get('pacc'),
            ]);

            $recettes = $recetteRepository->findBy(['pacc' => $request->get('pacc')]);
            $total_recettes = 0;
            foreach($recettes as $recette){
                $total_recettes += $recette->getMontantRecette();
            }
            return $this->json(['total_recettes' => $total_recettes, 'duplicate' => 0]);
        }else{
            $recette = new Recette();
            $form = $this->createForm(RecettesType::class, $recette);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $recetteRepository->add($recette, true);

                return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('recettes/new.html.twig', [
                'recette' => $recette,
                'form' => $form,
            ]);
        }

    }

    #[Route('/{id}', name: 'app_recette_show', methods: ['GET'])]
    public function show(Recette $recette): Response
    {
        return $this->render('recettes/show.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recette $recette, RecetteRepository $recetteRepository): Response
    {
        $form = $this->createForm(RecettesType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recetteRepository->add($recette, true);
            return $this->json(['success' => 1]);
        }
        return $this->render('/backend/recettes/edit.html.twig', [
            'recette' => $recette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_recette_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Recette $recette, RecetteRepository $recetteRepository): Response
    {
        if($request->isXmlHttpRequest()){
            $recetteRepository->remove($recette, true);
            return $this->json(['result' => 'success']);
        }else {
            if ($this->isCsrfTokenValid('delete' . $recette->getId(), $request->request->get('_token'))) {
                $recetteRepository->remove($recette, true);
            }
            return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/update/ajax', name: 'app_recette_update_ajax', methods: ['GET', 'POST'])]
    public function updateAjax(Request $request, Connection $connection, RecetteRepository $recetteRepository): Response
    {
        $recette = $recetteRepository->findOneBy(['pacc' => $request->get('pacc'), 'source' => $request->get('source')]);
        if($recette) return $this->json(['duplicate' => true, 'source' => $request->get('source')]);

        $connection->update('recette', [
            'montant_recette' => $request->get('montant_recette'),
            'source_id' => $request->get('source'),
            'pacc_id' => $request->get('pacc'),
        ], ['id' => $request->get('id')]);

        $recettes = $recetteRepository->findBy(['pacc' => $request->get('pacc')]);
        $total_recettes = 0;
        foreach($recettes as $recette){
            $total_recettes += $recette->getMontantRecette();
        }
        return $this->json(['total_recettes' => $total_recettes, 'duplicate' => false]);
    }


}
