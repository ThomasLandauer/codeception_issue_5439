<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user")
     */
    public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $user = $userRepository->find(1);
        // If you create a new user instead, the bug does not appear (i.e. the new user "foobar" is not created):
        // $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid())
        {
            $em->persist($user);
            $em->flush();
        }
        return $this->render('user.html.twig', array('form'=>$form->createView()));
    }
}
