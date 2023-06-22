<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController {

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        If ($this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', "Vous éte déja connecter");
            return $this->redirectToRoute('page_accueil');
        }
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/inscreption", name="app_inscreption")
     */
    public function inscreption(ManagerRegistry $doctrine, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response {
        If ($this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', "Vous éte déja inscrit");
            return $this->redirectToRoute('page_accueil');
        }

        $form = $this->createFormBuilder()
                ->add('email', EmailType::class, [
                    'required' => true,
                    'label' => 'email',
                    'attr' => array('placeholder' => 'email'),
                    'constraints' => array(
                        new NotBlank(),
                        new Email(),
                    ),
                        ]
                )
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'required' => true,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ])
                ->add('save', SubmitType::class, [
                    'label' => "inscreption",
                ])
                ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted()) {



            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $user = new \App\Entity\Utilisateur();

                $email = $request->request->get('form')['email'];
                $password = $request->request->get('form')['password']['first'];

                $password = $passwordEncoder->encodePassword($user, $password);
                $user->setEmail($email);
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "votre compte a bien été créé");
                return $this->redirectToRoute('page_accueil');
            }
        }

        return $this->render('security/inscreption.html.twig', ["form" => $form->createView(),]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
