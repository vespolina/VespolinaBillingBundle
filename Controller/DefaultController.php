<?php

namespace Vespolina\BillingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VespolinaBillingBundle:Default:index.html.twig', array('name' => $name));
    }
}
