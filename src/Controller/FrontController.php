<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="app_front")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

     /**
     * @Route("/video-list", name="videoList")
     */
    public function videoList(): Response
    {
        return $this->render('front/videolist.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

     /**
     * @Route("/video-details", name="videoDetails")
     */
    public function videoDetails(): Response
    {
        return $this->render('front/video_details.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


     /**
     * @Route("/search-results", name="search_results",methods={"POST"})
     */
    public function searchResults(): Response
    {
        return $this->render('front/search_results.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing(): Response
    {
        return $this->render('front/pricing.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

      /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    {
        return $this->render('front/register.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('front/login.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
