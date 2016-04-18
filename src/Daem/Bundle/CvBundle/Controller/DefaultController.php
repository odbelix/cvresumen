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



class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('DaemCvBundle:Default:frontend.html.twig');
    }
    /**
     * @Route("/access")
     */
    public function accessAction(Request $request)
    {
          /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
          $session = $request->getSession();

          if (class_exists('\Symfony\Component\Security\Core\Security')) {
              $authErrorKey = Security::AUTHENTICATION_ERROR;
              $lastUsernameKey = Security::LAST_USERNAME;
          } else {
              // BC for SF < 2.6
              $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
              $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
          }

          // get the error if any (works with forward and redirect -- see below)
          if ($request->attributes->has($authErrorKey)) {
              $error = $request->attributes->get($authErrorKey);
          } elseif (null !== $session && $session->has($authErrorKey)) {
              $error = $session->get($authErrorKey);
              $session->remove($authErrorKey);
          } else {
              $error = null;
          }

          if (!$error instanceof AuthenticationException) {
              $error = null; // The value does not come from the security component.
          }

          // last username entered by the user
          $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

          if ($this->has('security.csrf.token_manager')) {
              $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
          } else {
              // BC for SF < 2.4
              $csrfToken = $this->has('form.csrf_provider')
                  ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                  : null;
          }


          return $this->render('DaemCvBundle:Default:access.html.twig',array(
              'last_username' => $lastUsername,
              'error' => $error,
              'csrf_token' => $csrfToken,
          ));

    }

    /**
     * @Route("/panel/index")
     */
    public function panelAction()
    {

      return $this->render('DaemCvBundle:Backend:panel.html.twig');
    }

    /**
     * @Route("/access/registration")
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        //$form = $this->createForm(RegistrationFormPostulant::class, $user);

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('daem_cv_default_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('DaemCvBundle:Default:registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/access/registration/confirmed")
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('Este usuario no tiene acceso a esta seccion');
        }

        return $this->render('DaemCvBundle:Default:registration_confirmed.html.twig', array(
            'user' => $user,
            'targetUrl' => $url = $this->generateUrl('daem_cv_default_access'),
        ));
    }


}
