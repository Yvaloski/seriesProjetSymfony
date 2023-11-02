<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(EntityManagerInterface $entityManager): Response
    {
        //TODO: Récuperation de la liste des séries en bdd


        return $this->render('serie/index.html.twig');
    }

    /**
     * @Route("/new", name="serie_new")
     */
    public function new():Response
    {
        return $this->render('serie/new.html.twig');
    }

    /**
     * @Route("/{id}", name="serie_show", requirements={"id"="\d+"})
     */
    public function show(int $id):Response
    {
        //TODO: Récupérer la serie correspondante a $id
        return $this->render('serie/show.html.twig',[
            'id'=>$id

        ]);
    }




}
