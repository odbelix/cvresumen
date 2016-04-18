<?php

namespace Daem\Bundle\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TeacherController extends Controller
{
    /**
     * @Route("/teacher/index")
     */
    public function indexAction()
    {

        return $this->render('DaemCvBundle:Backend:teacher.html.twig',array('user' =>
      $this->get('security.context')->getToken()->getUser() ));
    }


}
