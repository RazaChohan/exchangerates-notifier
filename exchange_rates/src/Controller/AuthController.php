<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Auth controller.
 * @Route("/api", name="api_")
 *
 */
class AuthController extends FOSRestController
{
    /***
     * @Rest\Post('/register')
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return array
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();
        return ['message' => "User $user->getUsername()successfully created"];
    }
}