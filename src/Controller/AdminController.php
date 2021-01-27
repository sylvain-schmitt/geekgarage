<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Form\AgencyType;
use App\Repository\AgencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(AgencyRepository $agencyRepository): Response
    {
        $agencies = $agencyRepository->findAll();
        return $this->render('admin/index.html.twig', compact(('agencies'))
        );
    }
    /**
     * @Route("/admin/map_create", name="app_map_create")
     */
    public function mapCreate(Request $request, EntityManagerInterface $em): Response
    {
        $agency = new Agency;
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData()->getAddress();
            $search_url = "https://nominatim.openstreetmap.org/search?q=.$address.&format=json";
            $httpOptions = [
                "http" => [
                    "method" => "GET",
                    "header" => "User-Agent: Nominatim-Test"
                ]
            ];
            $streamContext = stream_context_create($httpOptions);
            $json = file_get_contents($search_url, false, $streamContext);
            
            $decoded = json_decode($json, true);
            $lat = floatval($decoded[0]["lat"]);
            $lon = floatval($decoded[0]["lon"]);
            $agency->setLat($lat);
            $agency->setLon($lon);
            $em->persist($agency);
            $em->flush();
            
            
            $this->addFlash('success', 'Agence ajouter avec succès !');
            
            return $this->redirectToRoute('app_admin');
        }
        
    
        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/map_edit/{id<[0-9]+>}", name="app_map_edit")
     */
    public function mapEdit(Agency $agency, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData()->getAddress();
            $city = $form->getData()->getCity();
            $search_url = "https://nominatim.openstreetmap.org/search?q=$address $city&format=json";
            $httpOptions = [
                "http" => [
                    "method" => "GET",
                    "header" => "User-Agent: Nominatim-Test"
                ]
            ];
            $streamContext = stream_context_create($httpOptions);
            $json = file_get_contents($search_url, false, $streamContext);
            
            $decoded = json_decode($json, true);
            $lat = floatval($decoded[0]["lat"]);
            $lon = floatval($decoded[0]["lon"]);
            $agency->setLat($lat);
            $agency->setLon($lon);
            $em->flush();

            $this->addFlash('success', 'Agence modifier avec succès !');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/map_delete/{id<[0-9]+>}", name="app_map_delete", methods={"DELETE"})
     */
    public function mapDelete(Request $request, Agency $agency, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('agency_deletion_' . $agency->getId(), $request->request->get('csrf_token'))) {
            $em->remove($agency);
            $em->flush();

            $this->addFlash('info', 'Centre supprimer avec succès !');
        }
        return $this->redirectToRoute('app_admin');
    }
}

