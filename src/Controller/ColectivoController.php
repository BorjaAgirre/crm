<?php

namespace App\Controller;

use App\Entity\Colectivo;
use App\Form\ColectivoType;
use App\Repository\ColectivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/colectivo')]
class ColectivoController extends AbstractController
{
    #[Route('/', name: 'app_colectivo_index', methods: ['GET'])]
    public function index(ColectivoRepository $colectivoRepository): Response
    {
        return $this->render('colectivo/index.html.twig', [
            'colectivos' => $colectivoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_colectivo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ColectivoRepository $colectivoRepository): Response
    {
        $colectivo = new Colectivo();
        $form = $this->createForm(ColectivoType::class, $colectivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colectivoRepository->add($colectivo, true);

            return $this->redirectToRoute('app_colectivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colectivo/new.html.twig', [
            'colectivo' => $colectivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colectivo_show', methods: ['GET'])]
    public function show(Colectivo $colectivo): Response
    {
        return $this->render('colectivo/show.html.twig', [
            'colectivo' => $colectivo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_colectivo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Colectivo $colectivo, ColectivoRepository $colectivoRepository): Response
    {
        $form = $this->createForm(ColectivoType::class, $colectivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colectivoRepository->add($colectivo, true);

            return $this->redirectToRoute('app_colectivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colectivo/edit.html.twig', [
            'colectivo' => $colectivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colectivo_delete', methods: ['POST'])]
    public function delete(Request $request, Colectivo $colectivo, ColectivoRepository $colectivoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$colectivo->getId(), $request->request->get('_token'))) {
            $colectivoRepository->remove($colectivo, true);
        }

        return $this->redirectToRoute('app_colectivo_index', [], Response::HTTP_SEE_OTHER);
    }
}
