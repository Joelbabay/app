<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]);
    }

    #[Route('/conference/{id}', name: 'show_conference')]
    public function show(ConferenceRepository $conferenceRepository, $id, CommentRepository $commentRepository, Request $request)
    {
        $conference = $conferenceRepository->find($id);

        $offset = max(0, $request->query->get('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        dump(count($paginator));

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}
