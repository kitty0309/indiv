<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/Country")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("/", name="Country_index", methods={"GET"})
     */
    public function index(CountryRepository $CountryRepository): Response
    {
        return $this->render('Country/index.html.twig', [
            'Countries' => $CountryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="Country_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $Country = new Country();
        $form = $this->createForm(CountryType::class, $Country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Country);
            $entityManager->flush();

            return $this->redirectToRoute('Country_index');
        }

        return $this->render('Country/new.html.twig', [
            'Country' => $Country,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/find/{name}", name="find_Country_by_name")
     * @param $name
     * @param CountryRepository $CountryRepository
     * @return Response
     */
    public function findAllByName($name, CountryRepository $CountryRepository): Response
    {
        return $this->render('Country/index.html.twig', [
            'Countries' => $CountryRepository->findByName($name),
        ]);
    }

    /**
     * @Route("/{id}", name="Country_show", methods={"GET"})
     */
    public function show(Country $Country): Response
    {
        return $this->render('Country/show.html.twig', [
            'Country' => $Country,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="Country_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Country $Country): Response
    {
        $form = $this->createForm(CountryType::class, $Country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Country_index');
        }

        return $this->render('Country/edit.html.twig', [
            'Country' => $Country,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Country_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Country $Country): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Country->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Country_index');
    }
}
