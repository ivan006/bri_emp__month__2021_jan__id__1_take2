<?php
namespace App\Controller;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EntryController
{
  /**
  * @Route("/entries", methods="GET")
  */
  public function index(EntryRepository $entryRepository)
  {
    $entries = $entryRepository->transformAll();

    // return new Response(
    //     $entries,
    //      Response::HTTP_OK
    // );
    return new JsonResponse($entries, 200, $headers = []);
  }

  /**
  * @Route("/entries", methods="POST")
  */
  public function create(Request $request, EntryRepository $entryRepository, EntityManagerInterface $em)
  {
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
    return $entryRepository->transform($entry);
  }
}
