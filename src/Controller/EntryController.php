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
      // $form->getData() holds the submitted values
      // but, the original `$entry` variable has also been updated
      $entry = $form->getData();

      // ... perform some action, such as saving the entry to the database
      // for example, if Entry is a Doctrine entity, save it!
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($entry);
      $entityManager->flush();

      // $entry->setName($request->get('name'));
      // $entry->setEmail($request->get('email'));
      // $entry->setMessage($request->get('message'));
      // $em->persist($entry);
      // $em->flush();

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

  // /**
  // * @Route("/entries", methods="POST")
  // */
  public function create(Request $request, EntryRepository $entryRepository, EntityManagerInterface $em)
  {
    $request = $this->transformJsonBody($request);
      // $request = json_decode($request->getContent(), true);
    return new JsonResponse($request->getContent(), 200, $headers = []);
    return $request;

    $request = $this->transformJsonBody($request);

    if (! $request) {
      // return $this->respondValidationError('Please provide a valid request!');
      return 'Please provide a valid request!!';
    }

    // // validate the title
    // if (! $request->get('title')) {
    //   return $this->respondValidationError('Please provide a title!');
    // }
    if (! $request->get('name')) {
      return 'Please provide a name!';
    }
    if (! $request->get('email')) {
      return 'Please provide a email!';
    }
    if (! $request->get('message')) {
      return 'Please provide a message!';
    }

    // persist the new entry
    $entry = new Entry;
    // $entry->setTitle($request->get('title'));
    // $entry->setCount(0);
    $entry->setName($request->get('name'));
    $entry->setEmail($request->get('email'));
    $entry->setMessage($request->get('message'));
    $em->persist($entry);
    $em->flush();

    // return $this->respondCreated($entryRepository->transform($entry));
    // return $entryRepository->transform($entry);
    return $this->redirectToRoute('entries');


  }

  protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
  {
    $data = json_decode($request->getContent(), true);

    if ($data === null) {
      return $request;
    }

    $request->request->replace($data);

    return $request;
  }
}
