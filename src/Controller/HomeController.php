<?php

namespace App\Controller;

use App\Entity\Smartphone;
use App\Form\SmartphoneTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $smartphones = $entityManager->getRepository(Smartphone::class)->findAll();
        return $this->render('home/index.html.twig', [
            'smartphones' => $smartphones,
        ]);
    }

    #[Route('/create', name: 'app_smartphone_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $smartphone = new Smartphone();
        $form = $this->createForm(SmartphoneTypeForm::class, $smartphone);

        //We handelen de request af (deze kijkt of het formulier verstuurd is)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //We bereiden de database statement voor om het boek aan te passen
            $entityManager->persist($smartphone);

            //We zorgen dat de update statemenet in de database gedraaid wordt.
            $entityManager->flush();

            //Uiteraard zetten we een flash-message
            $this->addFlash('success', 'Boek is aangepast');

            //We maken een redirect naar de route om het aangepaste boek te tonen
            return $this->redirectToRoute('app_home');
        }

        //Als het formulier niet verstuurd is of ongeldig is tonen we de update pagina
        return $this->render('smartphone/insert.html.twig', [
            'form' => $form,
        ]);
    }



    #[Route('/smartphone/edit/{id}', name: 'app_smartphone_update')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Smartphone $smartphone): Response
    {
        //De regel Book $book in de edit functie hierboven zorgt ervoor dat het juiste boek welke meegestuurd wordt
        //in de variabele gezet wordt van $book

        //Onderstaande code haalt het formulier op (BookType) en vult deze data met die van de entity App\Entity\Book.
        $form = $this->createForm(SmartphoneTypeForm::class, $smartphone);

        //We handelen de request af (deze kijkt of het formulier verstuurd is)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //We bereiden de database statement voor om het boek aan te passen
            $entityManager->persist($smartphone);
            $entityManager->flush();
            $this->addFlash('success', 'Boek is aangepast');
            return $this->redirectToRoute('app_home', ['book' => $smartphone->getId()]);
        }
        return $this->render('smartphone/update.html.twig', [
            'form' => $form,
        ]);

    }


    #[Route('/smartphone/delete/{id}', name: 'app_smartphone_delete')]
      public function delete(Smartphone $smartphone, Request $request, EntityManagerInterface $entityManager): Response{
        $entityManager->remove($smartphone);
        $entityManager->flush();
        $this->addFlash('success', 'phone is gewist');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/smartphone/show/{id}', name: 'app_smartphone_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response{
        return $this->render('smartphone/show.html.twig', [
            'smartphone' => $entityManager->getRepository(Smartphone::class)->find($id),
        ]);
    }

}
