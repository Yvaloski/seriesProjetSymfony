<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/serie")
 */
class SerieController extends AbstractController
{
    /**
     * @Route("/", name="serie_index")
     */
    public function index(SerieRepository $serieRepository): Response
    {
        // Récuperation de la liste des séries en bdd

        //$series = $serieRepository->findBy([],['popularity'=>'DESC', 'vote' =>'DESC'], 30);
        $series = $serieRepository->findBest();

        return $this->render('serie/index.html.twig', [
            'series' => $series
        ]);
    }

    /**
     * @Route("/new", name="serie_new")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        $serieForm = $this->createForm(SerieType::class,$serie);

       $serieForm->handleRequest($request);
       if ($serieForm->isSubmitted() && $serieForm->isValid()){

           $manager->persist($serie);
           $manager->flush();

           $this->addFlash('succes', 'Votre série a bien été enregistrée !');

           return $this->redirectToRoute('serie_show', [
               'id'=>$serie->getId()
           ]);

       }

        return $this->render('serie/new.html.twig',[
            'serieForm'=>$serieForm->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="serie_show", requirements={"id"="\d+"})
     */
    public function show(SerieRepository $serieRepository, int $id): Response
    {

        //Récupérer la serie correspondante a $id

        $serie = $serieRepository->find($id);

        if ($serie == null) {
            throw $this->createNotFoundException("Cette série n'existe pas ");
        }

        return $this->render('serie/show.html.twig', [
            'serie' => $serie

        ]);
    }


}
