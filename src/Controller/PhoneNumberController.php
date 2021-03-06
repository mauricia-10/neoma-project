<?php

namespace App\Controller;

use App\Entity\PhoneNumber;
use App\Form\PhoneNumberType;
use App\Repository\PhoneNumberRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/phone/number')]
class PhoneNumberController extends AbstractController
{
    #[Route('/new', name: 'phone_number_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepository): Response
    {
        $phoneNumber = new PhoneNumber();
        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);
        $form->handleRequest($request);
        $contact = $contactRepository->find($request->get("id"));

        if ($form->isSubmitted() && $form->isValid()) {
            $phoneNumber->setContact($contact);
            $entityManager->persist($phoneNumber);
            $entityManager->flush();

            return $this->redirectToRoute('contact_show', ['contact'=> $request->get("id") ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phone_number/new.html.twig', [
            'phone_number' => $phoneNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'phone_number_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PhoneNumber $phoneNumber, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('contact_show', ['contact'=> $phoneNumber->getContact()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phone_number/edit.html.twig', [
            'phone_number' => $phoneNumber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'phone_number_delete', methods: ['POST'])]
    public function delete(Request $request, PhoneNumber $phoneNumber, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phoneNumber->getId(), $request->request->get('_token'))) {
            $entityManager->remove($phoneNumber);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_show', ['contact'=> $phoneNumber->getContact()->getId()], Response::HTTP_SEE_OTHER);
    }
}
