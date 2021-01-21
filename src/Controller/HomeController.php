<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function home(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('geekgarage@test.fr')
                ->subject('Contact depuis le site Geek Garage')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'center'=>$contact->get('center')->getData(),
                    'nom' => $contact->get('nom')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'sujet' => $contact->get('sujet')->getData(),
                    'message' => $contact->get('message')->getData(),
                ])
                ;
            $mailer->send($email);

            $this->addFlash('message', 'Votre Mail à bien été pris en compte');
            return $this->redirectToRoute('app_home');
                }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/map/mapinfo", name="app_map")
     */
    public function map(AgencyRepository $agencyRepository, EntityManagerInterface $em): Response
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $agencies = $agencyRepository->findAll();

        $datas = [];

        foreach ($agencies as $key =>$agency){
            $datas[$key]['id'] = $agency->getId();
            $datas[$key]['city'] = $agency->getCity();
            $datas[$key]['lat'] = $agency->getLat();
            $datas[$key]['lon'] = $agency->getLon();
            $datas[$key]['number'] = $agency->getNumber();
            $datas[$key]['mail'] = $agency->getMail();
            $datas[$key]['address'] = $agency->getAddress();
            $datas[$key]['comment'] = $agency->getComment();
        }

        return new JsonResponse (['agences' => $datas]);
    }
}