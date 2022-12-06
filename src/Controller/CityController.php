<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/City")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/", name="City_index", methods={"GET"})
     */
    public function index(CityRepository $CityRepository): Response
    {
        return $this->render('City/index.html.twig', [
            'Cities' => $CityRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="City_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $City = new City();
        $form = $this->createForm(CityType::class, $City);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($City);
            $entityManager->flush();

            return $this->redirectToRoute('City_index');
        }

        return $this->render('City/new.html.twig', [
            'City' => $City,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="City_show", methods={"GET"})
     */
    public function show(City $City): Response
    {
        return $this->render('City/show.html.twig', [
            'City' => $City
        ]);
    }

    /**
     * @Route("/{id}/edit", name="City_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $City): Response
    {
        $form = $this->createForm(CityType::class, $City);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('City_index');
        }

        return $this->render('City/edit.html.twig', [
            'City' => $City,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="City_delete", methods={"DELETE"})
     */
    public function delete(Request $request, City $City): Response
    {
        if ($this->isCsrfTokenValid('delete'.$City->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($City);
            $entityManager->flush();
        }

        return $this->redirectToRoute('City_index');
    }
    
    /**
     * @Route("/find/{name}", name="find_City_by_name")
     * @param $name
     * @param CityRepository $CityRepository
     * @return Response
     */
    public function findAllByName($name, CityRepository $CityRepository): Response
    {
        return $this->render('City/index.html.twig', [
            'Cities' => $CityRepository->findByName($name)
        ]);
    }
}
