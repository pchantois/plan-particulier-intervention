<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Operation;
use App\Form\Admin\OperationType;
use App\Repository\Admin\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/", name="admin_operation_index", methods={"GET"})
     */
    public function index(OperationRepository $operationRepository): Response
    {
        $operations = $operationRepository->findAll();

		$configs = array(
			'site' => [
                'theme' => 'dimension',
			],
		);

        return $this->render('admin/operation/index.html.twig', [
            'operations' => $operations,
			'configs' => $configs,
        ]);
    }

    /**
     * @Route("/new", name="admin_operation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_operation_index');
        }

        return $this->render('admin/operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_show", methods={"GET"})
     */
    public function show(Operation $operation): Response
    {
        return $this->render('admin/operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_operation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_operation_index', [
                'id' => $operation->getId(),
            ]);
        }

        return $this->render('admin/operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Operation $operation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_operation_index');
    }

    protected function ppi(OperationRepository $operationRepository)
    {
        $operations = $operationRepository->findAll();
        $libelleAnnee = array();

        // construction du tableau des PPI
        foreach($operations as $operation)
        {
            $ppi = array();
            $libelle = $operation->getLibelle();
            $annee = $operation->getAnnee();
            $compte = ($operation->getType() ? 'depense' : 'recette' );

            if (!isset($ppi[$libelle][$annee][$compte]))
            {
                $ppi[$libelle][$annee]['depense'] = 0;
                $ppi[$libelle][$annee]['recette'] = 0;
            }
            $ppi[$libelle][$annee][$compte] += $operation->getMontant();

            $libelleAnnee[] = $annee;
        }
        
        $libelleAnnee2 = array_sort(array_unique($libelleAnnee));

        foreach($ppi as $key => $value)
        {
            foreach($libelleAnnee2 as $item)
            {
                if (! isset($value[$item]))
                {
                    $ppi[$key][$item]['depense'] = 0;
                    $ppi[$key][$item]['recette'] = 0;
                }
            }
        }
/*
		$configs = array(
			'site' => [
				'theme' => 'dimension',
			],
        );*/

        return $this->render('admin/operation/ppi.html.twig', [
            'items' => $ppi,
			//'configs' => $configs,
        ]);
    }
}
