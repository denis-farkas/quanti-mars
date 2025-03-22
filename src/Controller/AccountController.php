<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pack;
use App\Entity\UserAbonnement;
use App\Entity\UserPack;
use App\Form\BuyPackType;
use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('The user is not an instance of User. Actual type: ' . get_class($user));
        }

        $userId = $user->getId();

        $userPack = $entityManager->getRepository(UserPack::class)->findOneByCredit([
            'userId' => $userId
        ]);
        $currentPack = $userPack ? $userPack->getPack() : null;

        $userAbonnement = $entityManager->getRepository(UserAbonnement::class)->findOneById($userId);

        $currentAbonnement = $userAbonnement ? $userAbonnement->getAbonnement() : null;
        return $this->render('account/index.html.twig', ['userPack' => $userPack,'currentPack' => $currentPack, 'userAbonnement'=> $userAbonnement, 'currentAbonnement' => $currentAbonnement]);
    }

     #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {

        $user= $this->getUser();
        $form = $this->createForm(PasswordUserType::class, $user, ['passwordHasher' => $passwordHasher]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');
            return $this->redirectToRoute('app_account');
        }
        return $this->render('account/password.html.twig', ['modifyPwdForm' => $form->createView()]);
    }
   
    

}