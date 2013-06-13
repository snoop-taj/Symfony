<?php

namespace Abdul\Bundle\CrudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Abdul\Bundle\CrudBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->getMethod() == 'POST')
        {
            $fname = $request->get('firstname');
            $lname = $request->get('lastname');
            
            $em = $this->getDoctrine()->getEntityManager();
            $repo = $em->getRepository('AbdulCrudBundle:User');
        
            $myname = $repo->findOneBy(array('fName'=>$fname, 
                                         'lName'=>$lname));
        
        if($myname){
            return $this->render('AbdulCrudBundle:Default:user.html.twig', array('name'=>$myname-> getFName(),
                                                                                 'lname'=>$myname-> getLName()));
        }
         else{
            return $this->render('AbdulCrudBundle:Default:user.html.twig', array('name'=>'User ','lname'=>'not created can not retrieve entry'));
        }
        }
        return $this->render('AbdulCrudBundle:Default:user.html.twig');
    }
    public function insertAction(Request $request)
    {
       
            $fname = $request->get('firstname');
            $lname = $request->get('lastname');
            $address1 = $request->get('addressline1');
            $address2 = $request->get('addressline2');
            $city = $request->get('mycity');
            $postcode = $request->get('mypostcode');
            $phone1 = $request->get('myphone1');
            $phone2 = $request->get('myphone2');
            
            $entity = new User();
            $entity->setFName($fname);
            $entity->setLName($lname);
            $entity->setAddressLine1($address1);
            $entity->setAddressLine2($address2);
            $entity->setCity($city);
            $entity->setPostCode($postcode);
            $entity->setTelephoneHome($phone1);
            $entity->setTelephoneMobile($phone2);
            $em = $this->getDoctrine()->getEntityManager();
             if($request->getMethod() == 'POST')
        {
            $em->persist($entity);
            
            return $this->render('AbdulCrudBundle:Default:insert.html.twig', array('name'=>$entity-> getFName()));
        
            
        }
        $em->flush();
      
        return $this->render('AbdulCrudBundle:Default:insert.html.twig');     
    }
    
    public function deleteAction(Request $request)
    {
        
            $fname = $request->get('firstname');
            $lname = $request->get('lastname');
            
            $em = $this->getDoctrine()->getEntityManager();
            $repo = $em->getRepository('AbdulCrudBundle:User')->findOneBy(array('fName'=>$fname, 
                                                                                'lName'=>$lname));
            if($request->getMethod() == 'POST')
        {
            $em->remove($repo);
            
             if($repo->getFName()){
            return $this->render('AbdulCrudBundle:Default:delete.html.twig', array('name'=>$fname,
                                                                                 'lname'=>$lname));
        }
         else{
            return $this->render('AbdulCrudBundle:Default:delete.html.twig', array('name'=>'User ','lname'=>'not created can not delete entry'));
        }
        
        }
        $em->flush();
        return $this->render('AbdulCrudBundle:Default:delete.html.twig');
    }
    
    public function updateAction(Request $request)
    {
       
            $fname = $request->get('firstname');
            $lname = $request->get('lastname');
            
            $em = $this->getDoctrine()->getEntityManager();
            $repo = $em->getRepository('AbdulCrudBundle:User')->findOneBy(array('fName'=>$fname, 
                                                                                'lName'=>$lname));
             if($request->getMethod() == 'POST')
        {
            $em->persist($repo->getId());
            
             if($repo->getFName()){
            return $this->render('AbdulCrudBundle:Default:update.html.twig', array('name'=>$fname,
                                                                                 'lname'=>$lname));
        }
         else{
            return $this->render('AbdulCrudBundle:Default:update.html.twig', array('name'=>'User ','lname'=>'not created can not update entry'));
        }
        
        }
        $em->flush();
        
        return $this->render('AbdulCrudBundle:Default:update.html.twig');
    }
}
