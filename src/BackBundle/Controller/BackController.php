<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Article;
use BackBundle\Entity\Evennement;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BackController extends Controller
{
    public function indexAction()
    {   
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('BackBundle:Back:index.html.twig');
    }

}
