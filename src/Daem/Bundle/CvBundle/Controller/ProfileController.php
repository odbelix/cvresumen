<?php

namespace Daem\Bundle\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


/*REGISTRATIO*/
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

use Daem\Bundle\CvBundle\Form\RegistrationFormPostulant;



class ProfileController extends Controller
{
    /**
     * @Route("/profile/show")
     */
     public function showAction()
     {
         $user = $this->getUser();
         if (!is_object($user) || !$user instanceof UserInterface) {
             throw new AccessDeniedException('This user does not have access to this section.');
         }
         $menu = 'offers';
         return $this->render('DaemCvBundle:Profile:show.html.twig', array(
             'user' => $user,
             'menu' => $menu
         ));
     }


}
