<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\AgencyRepository;
use App\Service\MailerServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function home(Request $request, MailerServiceInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mailer->send($contact->getEmail(), 'geekgarage@test.fr', 'Contact depuis le site Geek Garage',
                'emails/contact.html.twig',
                'emails/contact.txt.twig', [
                    'center' => $contact->getCenter(),
                    'nom' => $contact->getName(),
                    'mail' => $contact->getEmail(),
                    'phone' => $contact->getPhone(),
                    'message' => $contact->getMessage(),
                ]);
            $this->addFlash('success', 'Votre Mail à bien été pris en compte');
            return $this->redirect(
                $this->generateUrl('app_home') . '#contact');
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

        foreach ($agencies as $key => $agency) {
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