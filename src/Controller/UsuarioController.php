<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\Usuario;
use App\Form\RegisterType;

class UsuarioController extends AbstractController
{
    
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new Usuario();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setRole('ROLE_USER');
            
            
            $user->setCreatedAt(new \DateTime('now'));

            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('usuario/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    public function login(AuthenticationUtils $aut){
        
        $error = $aut->getLastAuthenticationError();

        $lastUsername = $aut->getLastUsername();

        return $this->render('usuario/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }
}
