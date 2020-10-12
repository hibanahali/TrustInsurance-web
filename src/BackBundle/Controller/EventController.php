<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Article;
use BackBundle\Entity\Evennement;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventController extends Controller
{
        

    public function eventsAction()
    {   
        $em = $this->getDoctrine()->getEntityManager();
        $evennements = $em->getRepository('BackBundle:Evennement')->findAll();
        return $this->render('BackBundle:Back:evennements.html.twig',array(
            'evennements' => $evennements
        ));
    }

     public function AddeventAction(Request $request)
    {   

        $em = $this->getDoctrine()->getEntityManager();
        $evennement = new Evennement();
        $form = $this->createFormBuilder($evennement)
        ->add('titre',TextType::class,array('attr'=>array('class'=>'form-control','id' =>'text-input'),'label'=> false))
        ->add('description',TextAreaType::class,array('attr'=>array('class'=>'form-control','id' =>'textarea-input'),'label'=> false))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title =  $form['titre']->getData();
            $description =  $form['description']->getData();
            $image = $request->request->get('base64');  
            $evennement->setTitre($title);
            $evennement->setDescription($description);
            $evennement->setImage($image);
            $evennement->setStartDate(new \DateTime('now'));
            $evennement->setlastModification(new \DateTime('now'));
            $evennement->setDueDate(new \DateTime('now'));
            $evennement->setStatus(0);
            $evennement->setParticipants(0);
            $em->persist($evennement);
            $em->flush(); 
            return $this->redirect($this->generateUrl('back_events'));        
        }
        return $this->render('BackBundle:Back:add_event.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function EditeventAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $evennement = $em->getRepository('BackBundle:Evennement')->find($id);
        $form = $this->createFormBuilder($evennement)
        ->add('titre',TextType::class,array('attr'=>array('class'=>'form-control','id' =>'text-input'),'label'=> false))
        ->add('description',TextAreaType::class,array('attr'=>array('class'=>'form-control','id' =>'textarea-input'),'label'=> false))
        ->add('status',ChoiceType::class,array('choices'=>array('En cours' =>0,'Terminé'=>1,'Annulé'=>2),'attr'=>array('class'=>'form-control')))

        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title =  $form['titre']->getData();
            $description =  $form['description']->getData();
            $image = $request->request->get('base64');  
            $evennement->setTitre($title);
            $evennement->setDescription($description);
            if($image){$evennement->setImage($image);}
            $evennement->setCreatedDate(new \DateTime('now'));
            $evennement->setlastModification(new \DateTime('now'));
            $evennement->setDueDate(new \DateTime('now'));
            $evennement->setStatus($form['status']->getData());
            $em->persist($evennement);
            $em->flush(); 
            return $this->redirect($this->generateUrl('back_events'));        
        }
        return $this->render('BackBundle:Back:edit_event.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function DeleteventAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $evennement = $em->getRepository('BackBundle:Evennement')->find($id);
        $em->remove($evennement);
        $em->flush();
        
        return $this->redirect($this->generateUrl('back_events'));        
    }

    public function AddParticipantAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $evennement = $em->getRepository('BackBundle:Evennement')->find($id);
        $participants = $evennement->getParticipants();
        $participants = $participants + 1;
        $evennement->setParticipants($participants);
        $em->persist($evennement);
        $em->flush();
        return $this->redirect($this->generateUrl('front_homepage'));        
    }
}