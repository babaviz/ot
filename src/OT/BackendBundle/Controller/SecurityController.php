<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;


class SecurityController extends Controller
{
    public function getRole()
    {
        //get the role of current user
        $user=$this->get('security.context')->getToken()->getUser();

        if (is_object($user)){
            $role=$user->getRoles()[0];
        }
        else{
            $role='VISITOR';
        }

        return $role;
    }

    public function getUserId()
    {
        //get the id of current user
        $user=$this->get('security.context')->getToken()->getUser();

        return $user->getId();
    }
    
    public function loginAction(Request $request)
    {

        $role=$this->getRole();

        if ($role!='VISITOR')
            return $this->render('OTBackendBundle:Security:entrance.html.twig',['role'=>$role]);

    	$session = $request->getSession();
        
        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR); 
        }else{
            $error = ''; }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);
        return $this->render(
            	'OTBackendBundle:Security:login.html.twig',
	            array(
	                // last username entered by the user
	                'last_username' => $lastUsername,
	                'error'         => $error,
	            )
			); 
    }

    public function entranceAction()
    {
        $role=$this->getRole();

        //throw $this->createNotFoundException($this->getUserId());

        return $this->render('OTBackendBundle:Security:entrance.html.twig',['role'=>$role]);
        

    }

}
