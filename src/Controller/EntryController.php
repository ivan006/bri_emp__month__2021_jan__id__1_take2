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
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



class EntryController extends AbstractController
{

  /**
  * @Route("/entries")
  */
  public function new(Request $request, MailerInterface $mailer): Response
  {

    $entry = new Entry();

    $form = $this->createFormBuilder($entry)
    ->add('name', TextType::class)
    ->add('email', EmailType::class)
    ->add('message', TextType::class)
    ->add('save', SubmitType::class, ['label' => 'Create'])
    ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $entry = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($entry);
      $entityManager->flush();

      $form_name = $form->get('name')->getData();
      $form_email = $form->get('email')->getData();
      $form_message = $form->get('message')->getData();
      // return new JsonResponse($email, 200, $headers = []);

      // $mailer = new MailerInterface();
      $email = (new TemplatedEmail())
      ->from('hello@example.com')
      ->to($form_email)
      ->cc('ivan.copeland2015@gmail.com')
      //->bcc('bcc@example.com')
      //->replyTo('fabien@example.com')
      //->priority(Email::PRIORITY_HIGH)
      ->subject('bri_emp__month__2021_jan__id__1_take2')
      ->text($form_name." - ".$form_email." - ".$form_message)
      ->htmlTemplate('Entry/email.html.twig')
      ->context([
        'form_name' => $form_name,
        'form_email' => $form_email,
        'form_message' => $form_message,
      ]);
      $mailer->send($email);

      // return $this->redirectToRoute('entries');
      return $this->redirect('entry_success');
    }

    return $this->render('Entry/new.html.twig', [
      'form' => $form->createView(),
      'site_key' => "6LdW5U0aAAAAAMu3Dhve3EGq1RwOLjDivitoBDO_",
      'secret_key' => $_ENV['RECAPTURE_SECRET_KEY'],
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
