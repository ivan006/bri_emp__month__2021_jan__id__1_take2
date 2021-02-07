<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class EntryController extends AbstractController
{
  // /**
  // * @Route("/entries", methods="GET")
  // */
  // public function index(EntryRepository $entryRepository)
  // {
  //   $entries = $entryRepository->transformAll();
  //
  //   // return new Response(
  //   //     $entries,
  //   //      Response::HTTP_OK
  //   // );
  //   return new JsonResponse($entries, 200, $headers = []);
  // }

  // /**
  // * @Route("/entries", methods="GET")
  // */

  /**
  * @Route("/entries")
  */
  // public function index(EntryRepository $entryRepository)
  public function new(Request $request): Response
  {

    $task = new Entry();

    $form = $this->createFormBuilder($task)
    ->add('name', TextType::class)
    ->add('email', TextType::class)
    ->add('message', TextType::class)
    ->add('save', SubmitType::class, ['label' => 'Create'])
    ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $entry = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($entry);
      $entityManager->flush();

      // return $this->redirectToRoute('entries');
      return $this->redirect('entry_success');
    }

    return $this->render('Entry/new.html.twig', [
      'form' => $form->createView(),
    ]);



  }

  /**
  * @Route("/entry_success")
  */
  public function entry_success(EntryRepository $entryRepository)
  {

    return $this->render('Entry/entry_success.html.twig', []);

  }

}
