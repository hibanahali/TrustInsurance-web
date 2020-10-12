<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\Article;
use BackBundle\Entity\Evennement;
use BackBundle\Entity\ArticlesCommentaires;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleController extends Controller
{
    public function articlesAction()
    {   
    	$em = $this->getDoctrine()->getEntityManager();
		$articles = $em->getRepository('BackBundle:Article')->findAll();
        return $this->render('BackBundle:Back:articles.html.twig',array(
        	'articles' => $articles
        ));
    }

   
    public function AddarticleAction(Request $request)
    {   

        $em = $this->getDoctrine()->getEntityManager();
        $article = new Article();
        $form = $this->createFormBuilder($article)
        ->add('titre',TextType::class,array('attr'=>array('class'=>'form-control','id' =>'text-input'),'label'=> false))
        ->add('text',TextAreaType::class,array('attr'=>array('class'=>'form-control','id' =>'textarea-input'),'label'=> false))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title =  $form['titre']->getData();
            $text =  $form['text']->getData();
            $image = $request->request->get('base64');  
            $article->setTitre($title);
            $article->setText($text);
            $article->setImage($image);
            $article->setLikes(0);
            $article->setCreatedDate(new \DateTime('now'));
            $article->setlastModification(new \DateTime('now'));
            $em->persist($article);
            $em->flush(); 
            return $this->redirect($this->generateUrl('back_articles'));        
        }
        return $this->render('BackBundle:Back:add_article.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function EditarticleAction(Request $request,$id){
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('BackBundle:Article')->find($id);
        $form = $this->createFormBuilder($article)
        ->add('titre',TextType::class,array('attr'=>array('class'=>'form-control','id' =>'text-input'),'label'=> false))
        ->add('text',TextAreaType::class,array('attr'=>array('class'=>'form-control','id' =>'textarea-input'),'label'=> false))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title =  $form['titre']->getData();
            $text =  $form['text']->getData();
            $image = $request->request->get('base64');  
            $article->setTitre($title);
            $article->setText($text);
            if($image){$article->setImage($image);}
            $article->setlastModification(new \DateTime('now'));
            $em->persist($article);
            $em->flush(); 
            return $this->redirect($this->generateUrl('back_articles'));        
        }
        return $this->render('BackBundle:Back:edit_article.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function DeletearticleAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('BackBundle:Article')->find($id);
        $em->remove($article);
        $em->flush();
        
        return $this->redirect($this->generateUrl('back_articles'));        
    }

    public function articleCommentsAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('BackBundle:Article')->find($id);
        $commentaires = $article->getCommentaires();
        return $this->render('BackBundle:Back:article_comments.html.twig',array(
            'commentaires' => $commentaires
        ));
        //return $this->render('BackBundle:Back:article_comments.html.twig');
    }

    public function articleDeleteCommentAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('BackBundle:Article')->find($id);
        $commentaire = $em->getRepository('BackBundle:ArticlesCommentaires')->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirect($this->generateUrl('back_articles'));        

    }

    public function RechercheArticleAction(Request $request)
    {
        $search =$request->query->get('article');
        $en = $this->getDoctrine()->getManager();
        $article=$en->getRepository("BackBundle:Article")->findMulti($search);
        return $this->render('@Back\Back\rechercherArticle.html.twig',array(
            'articles' => $article
        ));
    }
}