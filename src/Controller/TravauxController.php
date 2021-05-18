<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\ORM\EntityManagerInterface;

use App\Repository\TravauxRepository;
use App\Repository\LikeRepository;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use App\Form\FileUploadType;
use App\Form\FileUploadType2;

use App\Entity\Travaux;
use App\Entity\Like;
use App\Entity\Category;

/**
* @Route("/travaux")
*/
class TravauxController extends AbstractController
{
    /**
     * @Route("/", name="app_travaux")
     */
    public function index(TravauxRepository $repo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->findAll();
      
        
        if ($request->isMethod('POST')) {
        
          $travaux = $repo->rechercher($request->request->get('rechercher'));
        }
        
        else {
          $travaux = $repo->findBy(array(), array('score' => 'desc'));
          $travaux_top = $repo->findBy([],['score'=>'desc'],3);

        }

        return $this->render('travaux/index.html.twig', [
            'travaux' => $travaux,
            'category' => $category,
        ]);
    }

     /**
     * @Route("/podium", name="app_top")
     */
    public function podium(TravauxRepository $repo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->findAll();
      
        
        if ($request->isMethod('POST')) {
        
          $travaux = $repo->rechercher($request->request->get('rechercher'));
        }
        
        else {
          $travaux_top = $repo->findBy([],['score'=>'desc'],3);
        }

        return $this->render('travaux/app_top.html.twig', [
            'travaux' => $travaux_top,
            'category' => $category,
        ]);
    }

   /**
     * @Route("/travaux_unique/{travaux}", name="travaux_unique")
     * @param Travaux $travaux
     *
     * @return Response
     */
    public function postunique(EntityManagerInterface $entityManager, Travaux $travaux)
    {
        $repository = $this->getDoctrine()->getRepository(Travaux::class);

        $travaux_unique = $repository->findOneBy(
            ['id' => $travaux],
        );
        return $this->render('travaux/unique_travaux.html.twig', [
            'travaux' => $travaux_unique,
            'id_user' => $travaux
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="app_edit_travail")
     * @param Travaux $travaux    
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, Travaux $travaux, $id): Response
    {

      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository(Category::class)->findAll();

      $form = $this->createForm(FileUploadType2::class, $travaux);
      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) 
      {
            $travaux = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($travaux);
            $em->flush();
       
            $this->addFlash('success', 'Travail bien modifié !');
            return $this->redirectToRoute('app_travaux', [
              'id' => $travaux->getId(),
              'category' => $category

              
          ]);      }
      return $this->render('travaux/edit_travaux.html.twig', [
        'form' => $form->createView(),
        
      ]);
    }

    
    /**
     * @Route("/{id}/delete", name="app_delete_travail")
     * @param Travaux $travaux    
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, Travaux $travaux, $id): Response
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository(Travaux::class)->findOneBy(array('id' => $id));

      if ($entity != null){
          $em->remove($entity);
          $em->flush();
      }

      $this->addFlash('success', 'Enquête supprimé !');

      return $this->redirectToRoute('app_travaux');

    }


    

    /**
     * @Route("/new", name="app_upload")
     */
    public function excelCommunesAction(Request $request, FileUploader $file_uploader)
    {
      $form = $this->createForm(FileUploadType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) 
      {
        $file = $form['upload_file']->getData();
        if ($file) 
        {
          $file_name = $file_uploader->upload($file);
          if (null !== $file_name) // for example
          {
            $directory = $file_uploader->getTargetDirectory();
            $full_path = $directory.'/'.$file_name;
            // Do what you want with the full path file...
            // Why not read the content or parse it !!!
            $uploads = new Travaux();
            $uploads->setTitre($form["Titre"]->getData());
            $uploads->setDescription($form["Description"]->getData()); // OK 
            $uploads->setTravail($file_name);
            $uploads->setLien1($form["Lien_1"]->getData());
            $uploads->setLien2($form["Lien_2"]->getData());
            $uploads->setUser($this->getUser());
            $uploads->setDate(date('d-m-Y'));
            $uploads->setCategorie($form["categorie"]->getData());
            $uploads->setScore(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($uploads);
            $em->flush();
    
          }
          else
          {
            return $this->redirectToRoute('app_travaux');

          }
        }
        $this->addFlash('success', 'Enquête ajouté !');

        return $this->redirectToRoute('app_travaux');
      }
      return $this->render('travaux/upload_travaux.twig', [
        'form' => $form->createView(),
      ]);
    }

    /**
     * Permet de liker ou unliker un travail
     * 
     * @Route("/{id}/like", name="app_like")
     * 
     * @param Travaux $travaux
     * @param EntityManagerInterface $manager
     * @param LikeRepository $likeRepo
     * @return Response 
     */
     public function like(Travaux $travaux, EntityManagerInterface $manager, LikeRepository $likeRepo): Response
     
     {

        $user = $this->getUser();


        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if ($travaux->isLikedByUser($user)) {
          $travaux->setScore($travaux->getScore() - 1);
          $like = $likeRepo->findOneBy([
            'Travaux' => $travaux,
            'User' => $user
          ]);

          $manager->remove($like);
          $manager->flush();

          return $this->json([
            'code' => 200,
            'message' => "Like bien supprimé",
            'likes' => $likeRepo->count(['Travaux' => $travaux])
          ], 200);

        }

        $like = new Like(); 
        $travaux->setScore($travaux->getScore() + 1);
        $like->setTravaux($travaux)
             ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
          'code' => 200,
          'message' => "Like bien ajouté",
          'likes' => $likeRepo->count(['Travaux' => $travaux])
        ], 200);
   
        return $this->json(['code' => 200, 'message' => 'OK'], 200);
     }

     
}
