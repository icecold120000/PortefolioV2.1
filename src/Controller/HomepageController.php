<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ProjectRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET","POST"})
     * @throws Exception
     */
    public function index(ProjectRepository $projetsRepo,Request $request,
                          EntityManagerInterface $entityManager): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash(
                'SuccessContact',
                'Votre message a été envoyé'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage/index.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
            'projets' => $projetsRepo->findHomepageProjets(new DateTime('now',new DateTimezone('Europe/Paris'))),

        ]);

    }
}
