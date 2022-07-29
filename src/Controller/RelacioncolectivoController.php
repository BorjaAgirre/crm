<?php

namespace App\Controller;

use App\Entity\Relacioncolectivo;
use App\Form\RelacioncolectivoType;
use App\Repository\RelacioncolectivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/relacioncolectivo')]
class RelacioncolectivoController extends AbstractController
{
    #[Route('/', name: 'app_relacioncolectivo_index', methods: ['GET'])]
    public function index(RelacioncolectivoRepository $relacioncolectivoRepository): Response
    {
        return $this->render('relacioncolectivo/index.html.twig', [
            'relacioncolectivos' => $relacioncolectivoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_relacioncolectivo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelacioncolectivoRepository $relacioncolectivoRepository): Response
    {
        $relacioncolectivo = new Relacioncolectivo();
        $form = $this->createForm(RelacioncolectivoType::class, $relacioncolectivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relacioncolectivoRepository->add($relacioncolectivo, true);

            return $this->redirectToRoute('app_relacioncolectivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relacioncolectivo/new.html.twig', [
            'relacioncolectivo' => $relacioncolectivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relacioncolectivo_show', methods: ['GET'])]
    public function show(Relacioncolectivo $relacioncolectivo): Response
    {
        return $this->render('relacioncolectivo/show.html.twig', [
            'relacioncolectivo' => $relacioncolectivo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_relacioncolectivo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Relacioncolectivo $relacioncolectivo, RelacioncolectivoRepository $relacioncolectivoRepository): Response
    {
        $form = $this->createForm(RelacioncolectivoType::class, $relacioncolectivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relacioncolectivoRepository->add($relacioncolectivo, true);

            return $this->redirectToRoute('app_relacioncolectivo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relacioncolectivo/edit.html.twig', [
            'relacioncolectivo' => $relacioncolectivo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relacioncolectivo_delete', methods: ['POST'])]
    public function delete(Request $request, Relacioncolectivo $relacioncolectivo, RelacioncolectivoRepository $relacioncolectivoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relacioncolectivo->getId(), $request->request->get('_token'))) {
            $relacioncolectivoRepository->remove($relacioncolectivo, true);
        }

        return $this->redirectToRoute('app_relacioncolectivo_index', [], Response::HTTP_SEE_OTHER);
    }
}
