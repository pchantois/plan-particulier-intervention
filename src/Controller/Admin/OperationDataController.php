<?php

namespace App\Controller\Admin;

use App\Entity\Admin\OperationData;
use App\Form\Admin\OperationDataType;
use App\Repository\Admin\OperationDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/operation/data")
 */
class OperationDataController extends AbstractController
{
    /**
     * @Route("/", name="admin_operation_data_index", methods={"GET"})
     */
    public function index(OperationDataRepository $operationDataRepository): Response
    {
        return $this->render('admin/operation_data/index.html.twig', [
            'operation_datas' => $operationDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_operation_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operationDatum = new OperationData();
        $form = $this->createForm(OperationDataType::class, $operationDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operationDatum);
            $entityManager->flush();

            return $this->redirectToRoute('admin_operation_data_index');
        }

        return $this->render('admin/operation_data/new.html.twig', [
            'operation_datum' => $operationDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_data_show", methods={"GET"})
     */
    public function show(OperationData $operationDatum): Response
    {
        return $this->render('admin/operation_data/show.html.twig', [
            'operation_datum' => $operationDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_operation_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OperationData $operationDatum): Response
    {
        $form = $this->createForm(OperationDataType::class, $operationDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_operation_data_index', [
                'id' => $operationDatum->getId(),
            ]);
        }

        return $this->render('admin/operation_data/edit.html.twig', [
            'operation_datum' => $operationDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_operation_data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OperationData $operationDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operationDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operationDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_operation_data_index');
    }
}
