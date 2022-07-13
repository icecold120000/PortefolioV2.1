<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/projet")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="projet_index", methods={"GET"})
     */
    public function index(ProjectRepository $projetRepository,
                          PaginatorInterface $paginator, Request $request): Response
    {

        $projets = $projetRepository->findAll();
        $projets = $paginator->paginate(
            $projets,
            $request->query->getInt('page',1),
            10
        );

        return $this->render('project/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/new", name="projet_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger,
                        EntityManagerInterface $entityManager): Response
    {
        $projet = new Project();
        $form = $this->createForm(ProjectType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vigProjetFile = $form->get('vig')->getData();

            if ($vigProjetFile) {
                $originalFilename = pathinfo($vigProjetFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameVig = $safeFilename.'.'.$vigProjetFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $vigProjetFile->move(
                        $this->getParameter('vigProjetFile_directory'),
                        $newFilenameVig
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre vignette");
                }
                $projet->setVignetteProjet($newFilenameVig);
            }

            /** @var UploadedFile $documentationFile */
            $documentationFile = $form->get('doc')->getData();

            if ($documentationFile) {
                $originalFilename = pathinfo($documentationFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameDoc = $safeFilename.'.'.$documentationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $documentationFile->move(
                        $this->getParameter('docProjetFile_directory'),
                        $newFilenameDoc
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre image");
                }
                $projet->setDocumentation($newFilenameDoc);
            }

            /** @var UploadedFile $cahierDesChargesFile */
            $cahierDesChargesFile = $form->get('cdc')->getData();

            if ($cahierDesChargesFile) {
                $originalFilename = pathinfo($cahierDesChargesFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameCdc = $safeFilename.'.'.$cahierDesChargesFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $cahierDesChargesFile->move(
                        $this->getParameter('cdcProjetFile_directory'),
                        $newFilenameCdc
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre image");
                }
                $projet->setCahierdescharges($newFilenameCdc);
            }
            $projet->setArchiveProjet(false);

            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_new');
        }

        return $this->render('project/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_show", methods={"GET"})
     */
    public function show(Project $projet): Response
    {
        return $this->render('project/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $projet, SluggerInterface $slugger,
                         EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vigProjetFile = $form->get('vig')->getData();

            if ($vigProjetFile) {
                $originalFilename = pathinfo($vigProjetFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameVig = $safeFilename.'.'.$vigProjetFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $vigProjetFile->move(
                        $this->getParameter('vigProjetFile_directory'),
                        $newFilenameVig
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre vignette");
                }
                $projet->setVignetteProjet($newFilenameVig);
            }

            /** @var UploadedFile $documentationFile */
            $documentationFile = $form->get('doc')->getData();

            if ($documentationFile) {
                $originalFilename = pathinfo($documentationFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameImg = $safeFilename.'.'.$documentationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $documentationFile->move(
                        $this->getParameter('docFile_directory'),
                        $newFilenameImg
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre image");
                }
                $projet->setDocumentation($newFilenameImg);
            }

            /** @var UploadedFile $cahierDesChargesFile */
            $cahierDesChargesFile = $form->get('cdc')->getData();

            if ($cahierDesChargesFile) {
                $originalFilename = pathinfo($cahierDesChargesFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameImg = $safeFilename.'.'.$cahierDesChargesFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $cahierDesChargesFile->move(
                        $this->getParameter('cdcFile_directory'),
                        $newFilenameImg
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransférer votre image");
                }
                $projet->setCahierdescharges($newFilenameImg);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('project/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {

            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index');
    }
}
