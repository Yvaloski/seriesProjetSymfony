<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/season")
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("/new", name="season_new")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $season = new Season();
        $seasonForm =$this->createForm(SeasonType::class, $season);
        $seasonForm->handleRequest($request);

        if ($seasonForm->isSubmitted() && $seasonForm->isValid()){
            $manager->persist($season);
            $manager->flush();

            return $this->redirectToRoute('serie_show', [
                'id'=>$season->getSerie()->getId()
            ]);

        }


        return $this->render('season/new.html.twig', [
            'seasonForm' => $seasonForm->createView()
        ]);
    }
}
