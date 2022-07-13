<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(ProjectRepository $projetRepo, ContactRepository $contactsRepo
        , PaginatorInterface $paginator, Request $request): Response
    {

        $projets = $projetRepo->findAll();
        $projets = $paginator->paginate(
            $projets,
            $request->query->getInt('page',1),
            15
        );

        return $this->render('admin/index.html.twig', [
            'projets' => $projets,
            'contacts' => $contactsRepo->findAll(),
        ]);
    }
}
