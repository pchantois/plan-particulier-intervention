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
            'ppi'  => $this->ppi($operations,'global'),
            'ppi2'  => $this->ppi($operations,'parCategorie'),
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
		$configs = array(
			'site' => [
                'theme' => 'dimension',
			],
		);
        return $this->render('admin/operation/show.html.twig', [
            'operation' => $operation,
            'ppi'  => $this->ppi([$operation],'parCategorie'),
			'configs' => $configs,
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

    protected function ppi(Array $operations, String $category)
    {
        $libelleAnnee = array();
        $ppi = array();

        // construction du tableau des PPI
        foreach($operations as $operation)
        {
            $libelle = $operation->getId() .'####'. $operation->getLibelle();
            $annee = $operation->getAnnee();
            $compte = ($operation->getType() ? 'depense' : 'recette' );

            switch(strtolower($category))
            {
                case 'parcategorie':
                    if (! isset($ppi[$compte][$annee]))
                    {
                        $ppi['depense'][$annee] = $ppi['recette'][$annee] = 0;
                    }
                    $ppi[$compte][$annee] += $operation->getMontant();
        
                    $libelleAnnee[] = $annee;
                    break;
                default:
                    if (! isset($ppi[$libelle][$annee][$compte]))
                    {
                        $ppi[$libelle][$annee]['depense'] = $ppi[$libelle][$annee]['recette'] = 0;
                    }
                    $ppi[$libelle][$annee][$compte] += $operation->getMontant();
        
                    $libelleAnnee[] = $annee;
            }
        }
        
        $libelleAnnee = array_unique($libelleAnnee);

        foreach($ppi as $key => $value)
        {
            foreach($libelleAnnee as $item)
            {
                switch(strtolower($category))
                {
                    case 'parcategory':
                        if (! isset($ppi[$key][$item]))
                        {
                            $ppi[$key][$item] = 0;
                        }
                        break;
                    default:
                        if (! isset($ppi[$key][$item]))
                        {
                            $ppi[$key][$item]['depense'] = 0;
                            $ppi[$key][$item]['recette'] = 0;
                        }
                }
            }
            ksort($ppi[$key]);
        }
/*
		$configs = array(
			'site' => [
				'theme' => 'dimension',
			],
        );*/

        return $ppi;
        /*return $this->render('admin/operation/ppi.html.twig', [
            'items' => $ppi,
			//'configs' => $configs,
        ]);*/
    }
}
