<?php

namespace Daem\Bundle\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MonitorController extends Controller
{
    /**
     * @Route("/monitor/index")
     */
    public function indexMonitorAction()
    {
        return $this->render('DaemCvBundle:Backend:monitor.html.twig');
    }


}
