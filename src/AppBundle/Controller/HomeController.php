<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
/**
 * Description of HomeController
 *
 * @author David
 * 
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('home/index.html.twig');
    }
 
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        
        if($error !== null)
        {
            $this->addFlash('error', $error->getMessage());
        }
        
        return $this->render('home/login.html.twig', [
            'page_title'=> 'Iniciar sessió',
            'last_username' => $lastUsername,
            //'errors' => $error
        ]);
    }
 
    /**
     * @Route("/register", name="register")
     */
    public function registerAction()
    {
        
    }
 
    
}
