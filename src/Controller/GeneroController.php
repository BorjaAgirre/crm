<?php

namespace App\Controller;

use App\Entity\Genero;
use App\Form\GeneroType;
use App\Repository\GeneroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genero')]
class GeneroController extends AbstractController
{
    #[Route('/', name: 'app_genero_index', methods: ['GET'])]
    public function index(GeneroRepository $generoRepository): Response
    {
        return $this->render('genero/index.html.twig', [
            'generos' => $generoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_genero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GeneroRepository $generoRepository): Response
    {
        $genero = new Genero();
        $form = $this->createForm(GeneroType::class, $genero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $generoRepository->add($genero, true);

            return $this->redirectToRoute('app_genero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genero/new.html.twig', [
            'genero' => $genero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_genero_show', methods: ['GET'])]
    public function show(Genero $genero): Response
    {
        return $this->render('genero/show.html.twig', [
            'genero' => $genero,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_genero_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Genero $genero, GeneroRepository $generoRepository): Response
    {
        $form = $this->createForm(GeneroType::class, $genero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $generoRepository->add($genero, true);

            return $this->redirectToRoute('app_genero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genero/edit.html.twig', [
            'genero' => $genero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_genero_delete', methods: ['POST'])]
    public function delete(Request $request, Genero $genero, GeneroRepository $generoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genero->getId(), $request->request->get('_token'))) {
            $generoRepository->remove($genero, true);
        }

        return $this->redirectToRoute('app_genero_index', [], Response::HTTP_SEE_OTHER);
    }
}
