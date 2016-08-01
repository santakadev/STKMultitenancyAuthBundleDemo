<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/jwt-login", name="jwt_login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jwtLoginAction(Request $request)
    {
        $tenant = $request->get('tenant');
        $username = $request->get('username');
        $password = $request->get('username');

        $token = $this->get('lexik_jwt_authentication.jwt_encoder')
            ->encode([
                'tenant' => $tenant,
                'username' => $username
            ]);

        return new JsonResponse(['token' => $token]);
    }
}
