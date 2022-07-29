<?php

namespace App\Controller;

use App\Entity\Tiporelacion;
use App\Form\TiporelacionType;
use App\Repository\TiporelacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tiporelacion')]
class TiporelacionController extends AbstractController
{
    #[Route('/', name: 'app_tiporelacion_index', methods: ['GET'])]
    public function index(TiporelacionRepository $tiporelacionRepository): Response
    {
        return $this->render('tiporelacion/index.html.twig', [
            'tiporelacions' => $tiporelacionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tiporelacion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TiporelacionRepository $tiporelacionRepository): Response
    {
        $tiporelacion = new Tiporelacion();
        $form = $this->createForm(TiporelacionType::class, $tiporelacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tiporelacionRepository->add($tiporelacion, true);

            return $this->redirectToRoute('app_tiporelacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tiporelacion/new.html.twig', [
            'tiporelacion' => $tiporelacion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tiporelacion_show', methods: ['GET'])]
    public function show(Tiporelacion $tiporelacion): Response
    {
        return $this->render('tiporelacion/show.html.twig', [
            'tiporelacion' => $tiporelacion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tiporelacion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tiporelacion $tiporelacion, TiporelacionRepository $tiporelacionRepository): Response
    {
        $form = $this->createForm(TiporelacionType::class, $tiporelacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tiporelacionRepository->add($tiporelacion, true);

            return $this->redirectToRoute('app_tiporelacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tiporelacion/edit.html.twig', [
            'tiporelacion' => $tiporelacion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tiporelacion_delete', methods: ['POST'])]
    public function delete(Request $request, Tiporelacion $tiporelacion, TiporelacionRepository $tiporelacionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tiporelacion->getId(), $request->request->get('_token'))) {
            $tiporelacionRepository->remove($tiporelacion, true);
        }

        return $this->redirectToRoute('app_tiporelacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
