<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, EntityManagerInterface $manager,FileUploader $uploader): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        $serieForm = $this->createForm(SerieType::class,$serie);

       $serieForm->handleRequest($request);
       if ($serieForm->isSubmitted() && $serieForm->isValid()){

           /** @var UploadedFile $posterFile */
           $posterFile = $serieForm->get('posterFile')->getData();
           if ($posterFile) {
               $posterFileName= $uploader->upload($posterFile, $this->getParameter('series_posters_directory'));
               $serie->setPoster($posterFileName);
           }
           /** @var UploadedFile $backdropFile */
           $backdropFile = $serieForm->get('backdropFile')->getData();
           if ($backdropFile) {
               $backdropFileName= $uploader->upload($backdropFile, $this->getParameter('series_backdrops_directory'));
               $serie->setBackdrop($backdropFileName);
           }



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

    /**
     * @Route("/delete/{id}",name="serie_delete",requirements={"id"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete( Serie $serie, SerieRepository $serieRepository)
    {
        $serieRepository->remove($serie,true);

        return $this->redirectToRoute('serie_index');

    }

}
