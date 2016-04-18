<?php

namespace Daem\Bundle\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/index")
     */
    public function indexAdminAction()
    {
        return $this->render('DaemCvBundle:Backend:admin.html.twig');
    }


}
