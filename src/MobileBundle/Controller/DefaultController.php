<?php

namespace MobileBundle\Controller;

use BackBundle\Entity\Article;
use BackBundle\Entity\ArticlesCommentaires;
use BackBundle\Entity\Evennement;
use FrontBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{


    public function loginAction (Request $request) {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->findOneBy(['email' =>$request->get('email')]);
        if($user){
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();
            if($encoder->isPasswordValid($user->getPassword(),$request->get('password'), $salt)){
                $normalizer = new ObjectNormalizer();
                // $normalizer->setIgnoredAttributes(array("notifiableNotifications"));
                $normalizer->setIgnoredAttributes(array("commentaires"));
                $serializer = new Serializer(array($normalizer), array($encoder));
                $formatted=$serializer->normalize($user);
                return new JsonResponse($formatted);
            }
        }
        return new JsonResponse($user );
    }

    public function getAllArticlesAction(){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Article::class)->findAll();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        // $normalizer->setIgnoredAttributes(array("notifiableNotifications"));
        $normalizer->setIgnoredAttributes(array("commentaires"));
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function getAllArticleByNameAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Article::class)->findByName($request->get("name"));
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        // $normalizer->setIgnoredAttributes(array("notifiableNotifications"));
        $normalizer->setIgnoredAttributes(array("commentaires"));
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }


    public function AddEventAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $p = new Evennement();
        $p->setImage($request->get("image"));
        $p->setStartDate(new \DateTime($request->get("startDate")));
        $p->setDescription($request->get("desc"));
        $p->setTitre($request->get("titre"));
        $p->setStatus(1);
        $p->setDueDate(new \DateTime($request->get("dueDate")));
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function EditEventAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Evennement")->find($id);
        $p->setImage($request->get("image"));
        $p->setStartDate($request->get("startDate"));
        $p->setDescription($request->get("desc"));
        $p->setTitre($request->get("titre"));
        $p->setDueDate($request->get("dueDate"));
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }
    public function ParticipeEventAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Evennement")->find($id);
        $p->setParticipants($p->getParticipants()+1);
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function DeleteEventAction($id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Evennement")->find($id);
        $em->remove($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }


    public function getAllEventsAction(){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Evennement::class)->findAll();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        // $normalizer->setIgnoredAttributes(array("notifiableNotifications"));
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function getAllEventBynameAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository(Evennement::class)->findbyName($request->get("name"))->getScalarResult();;
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }



    public function AddArticleAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $p = new Article();
        $p->setImage($request->get("image"));
        $p->setText($request->get("text"));
        $p->setTitre($request->get("titre"));
        $p->setCreatedDate(new \DateTime());
        $p->setLastModification(new \DateTime());
        $p->setLikes(0);
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function EditArticleAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Article")->find($id);
        $p->setImage($request->get("image"));
        $p->setText($request->get("text"));
        $p->setTitre($request->get("titre"));
        $p->setLastModification(new \DateTime());
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function LikeArticleAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Article")->find($id);
        $p->setLikes($p->getLikes()+1);
        $em->persist($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }
    public function DeleteArticleAction($id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:Article")->find($id);
        $em->remove($p);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }

    public function getCommentsByArticleAction($id){
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository("BackBundle:ArticlesCommentaires")->findBy(array("article"=>$id));
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array("commentaires"));
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($p);
        return new JsonResponse($data);
    }
    public function addCommentAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $comment = new ArticlesCommentaires();
        $user = $em->getRepository("FrontBundle:User")->find($request->get('user'));
        $article = $em->getRepository("BackBundle:Article")->find($request->get("article"));
        $comment->setArticle($article);
        $comment->setUtilisateur($user);
        $comment->setCommentaire($request->get("comment"));
        $em->persist($comment);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($comment);
        return new JsonResponse($data);
    }
    public function editCommentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository("BackBundle:ArticlesCommentaires")->find($id);
        $comment->setCommentaire($request->get("comment"));
        $em->persist($comment);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($comment);
        return new JsonResponse($data);
    }
    public function deleteCommentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository("BackBundle:ArticlesCommentaires")->find($id);
        $em->remove($comment);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize($comment);
        return new JsonResponse($data);
    }
}
