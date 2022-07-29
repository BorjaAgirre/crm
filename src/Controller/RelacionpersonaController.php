<?php

namespace App\Controller;

use App\Entity\Relacionpersona;
use App\Form\RelacionpersonaType;
use App\Repository\RelacionpersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/relacionpersona')]
class RelacionpersonaController extends AbstractController
{
    #[Route('/', name: 'app_relacionpersona_index', methods: ['GET'])]
    public function index(RelacionpersonaRepository $relacionpersonaRepository): Response
    {
        return $this->render('relacionpersona/index.html.twig', [
            'relacionpersonas' => $relacionpersonaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_relacionpersona_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelacionpersonaRepository $relacionpersonaRepository): Response
    {
        $relacionpersona = new Relacionpersona();
        $form = $this->createForm(RelacionpersonaType::class, $relacionpersona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relacionpersonaRepository->add($relacionpersona, true);

            return $this->redirectToRoute('app_relacionpersona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relacionpersona/new.html.twig', [
            'relacionpersona' => $relacionpersona,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relacionpersona_show', methods: ['GET'])]
    public function show(Relacionpersona $relacionpersona): Response
    {
        return $this->render('relacionpersona/show.html.twig', [
            'relacionpersona' => $relacionpersona,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_relacionpersona_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Relacionpersona $relacionpersona, RelacionpersonaRepository $relacionpersonaRepository): Response
    {
        $form = $this->createForm(RelacionpersonaType::class, $relacionpersona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relacionpersonaRepository->add($relacionpersona, true);

            return $this->redirectToRoute('app_relacionpersona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('relacionpersona/edit.html.twig', [
            'relacionpersona' => $relacionpersona,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relacionpersona_delete', methods: ['POST'])]
    public function delete(Request $request, Relacionpersona $relacionpersona, RelacionpersonaRepository $relacionpersonaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relacionpersona->getId(), $request->request->get('_token'))) {
            $relacionpersonaRepository->remove($relacionpersona, true);
        }

        return $this->redirectToRoute('app_relacionpersona_index', [], Response::HTTP_SEE_OTHER);
    }
}
