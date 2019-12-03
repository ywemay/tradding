<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }
        if ($request->headers->get('accept') == 'application/json') {
            return $this->json_login();
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/api/user/dologin", name="api_json_login")
     */
    public function json_login() { //IriConverterInterface $iriConverter) {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".'
            ], 400);
        }

        //return $this->json($this->getUser());

        return new Response(null, 204, [
            'Location' => 'api/users/' . $this->getUser()->getId()
        ]);
    }

    /**
     * @Route("/api/user/info", name="api_user_info")
     */
    public function userInfo(SerializerInterface $serializer){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data['data'] = array();

        $user = $this->getUser();
        if ($user) {
            $data['data'] = array(
                'uid' => $user->getId(),
                'roles' => $user->getTrimmedRoles(),
                'name' => $user->getUsername(),
            );
        }
        $data['data'] += array(
            'uid' => 0,
            'roles' => [],
            'avatar' => '',
            'name' => 'Anonymous',
            'introduction' => ''
        );
        return $this->json($data);
    }

    /**
     * @Route("/api/user/(\d+)", name="app_user_id")
     */
    public function user($id) {
        $user = $this->find('User', $id);
        return $this->json([
            'data' => (array) $user,
            'cool' => 'All cooll!',
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     * @Route("/api/user/logout", name="api_user_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
    * api route redirects
    * @return Response
    */
    public function api()
    {
        return new Response(sprintf("Logged in as %s", $this->getUser()->getUsername()));
    }
}
