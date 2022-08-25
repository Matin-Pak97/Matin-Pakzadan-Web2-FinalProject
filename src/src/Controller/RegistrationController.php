<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->get('role')->getData();
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles([$role]);

            // do anything else you need here, like send an email
            if(in_array("ROLE_HOST", $user->getRoles())) {
                $contract = new Contract();
                $contract->setOwneredBy($user);
                $contract->setNumberOfPropery(10);

                $entityManager->persist($contract);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_property_index');
            } else {
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_property_index');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
