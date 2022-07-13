<?php

namespace App\Controller;

use App\Entity\ImageProject;
use App\Form\ImageProjectType;
use App\Repository\ImageProjectRepository;
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
 * @Route("/image/projet")
 */
class ImageProjectController extends AbstractController
{
    /**
     * @Route("/", name="imgProjet_index", methods={"GET"})
     */
    public function index(ImageProjectRepository $imageProjetRepository,
                          Request $request, PaginatorInterface $paginator): Response
    {

        $imgProjets = $imageProjetRepository->findAll();
        $imgProjets = $paginator->paginate(
            $imgProjets,
            $request->query->getInt('page',1),
            10
        );

        return $this->render('imgProject/index.html.twig', [
            'imgsProjet' => $imgProjets,
        ]);
    }

    /**
     * @Route("/new", name="imgProjet_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger,
                        EntityManagerInterface$entityManager): Response
    {
        $imageProjet = new ImageProject();
        $form = $this->createForm(ImageProjectType::class, $imageProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imgProjetFile */
            $imgProjetFile = $form->get('image')->getData();

            if ($imgProjetFile) {
                $originalFilename = pathinfo($imgProjetFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameImg = $safeFilename.'.'.$imgProjetFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imgProjetFile->move(
                        $this->getParameter('imgProjetFile_directory'),
                        $newFilenameImg
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransferer votre image");
                }
                $imageProjet->setLienProjet($newFilenameImg);
            }

            $entityManager->persist($imageProjet);
            $entityManager->flush();

            return $this->redirectToRoute('imgProject_index');
        }

        return $this->render('imgProject/new.html.twig', [
            'imgProjet' => $imageProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="imgProjet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ImageProject $imageProjet, SluggerInterface $slugger,
                         EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageProjectType::class, $imageProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imgProjetFile */
            $imgProjetFile = $form->get('image')->getData();

            if ($imgProjetFile) {
                $originalFilename = pathinfo($imgProjetFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameImg = $safeFilename.'.'.$imgProjetFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imgProjetFile->move(
                        $this->getParameter('imgProjetFile_directory'),
                        $newFilenameImg
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu. Veuillez retransferer votre image");
                }
                $imageProjet->setLienProjet($newFilenameImg);
            }

            $entityManager->flush();

            return $this->redirectToRoute('imgProject_index');
        }

        return $this->render('imgProject/edit.html.twig', [
            'imgProjet' => $imageProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="imgProjet_delete_view", methods={"GET"})
     */
    public function deleteView(ImageProject $imgProjet): Response
    {
        return $this->render('imgProject/delete_view.html.twig', [
            'imgProjet' => $imgProjet,
        ]);
    }

    /**
     * @Route("/{id}", name="imgProjet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ImageProject $imageProjet,
                           EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageProjet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($imageProjet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('imgProject_index');
    }
}
