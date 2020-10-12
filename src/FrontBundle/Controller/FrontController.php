<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\ArticlesCommentaires;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $articles = $em->getRepository('BackBundle:Article')->findAll();
		$evennements = $em->getRepository('BackBundle:Evennement')->findAll();
        return $this->render('FrontBundle:Front:index.html.twig',array(
            'evennements' => $evennements,
            'articles' => $articles

        ));   
    }



    public function articleAction($id){
     	$em = $this->getDoctrine()->getEntityManager();
		$articles = $em->getRepository('BackBundle:Article')->findAll();
        return $this->render('FrontBundle:Front:article.html.twig',array(
        	'articles' => $articles
        ));   
    }

    public function articleAddLikeAction(Request $request,$id){
    	$em = $this->getDoctrine()->getEntityManager();
		$article = $em->getRepository('BackBundle:Article')->find($id);
		$likes = $article->getLikes();
		$likes++;
        $article->setLikes($likes);
		$em->persist($article);
        $em->flush(); 
        return $this->redirect($this->generateUrl('front_article',array('id'=>$id))); 
    }

    public function articleAddCommentAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('BackBundle:Article')->find($id);
        $commentaire = new ArticlesCommentaires();
        $commentaire->setCommentaire($request->request->get('commentaire'));
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $commentaire->setUtilisateur($usr);
        $commentaire->setArticle($article);
        $em->persist($commentaire);
        $em->flush();

        return $this->redirect($this->generateUrl('front_article',array('id'=>$id))); 
    }



    public function deleteCommentAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $commentaire = $em->getRepository('BackBundle:ArticlesCommentaires')->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirect($this->generateUrl('front_article',array('id'=>$id))); 
    }


   
}
