<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Category;
use App\Utils\CategoryTreeFrontPage;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FrontController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;

    }
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
     * @Route("/video-list/category/{categoryName},{category}/{page}", name="videoList", defaults={"page": 1})
     *
     */
    public function videoList(Category $category,CategoryTreeFrontPage $categories,$page): Response
    {

        $subCategories=$categories->buildTree($category->getId());
        $videos=$this->em->getRepository(Video::class)->findAllPaginated($page);
        return $this->render('front/videolist.html.twig', [
            'controller_name' => 'FrontController',
            "category"=>$category,
            'videos'=>$videos,
            'subCategories'=> $categories->getCategoryList($subCategories)
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
    
      /**
     * @Route("/payment", name="payment")
     */
    public function payment(): Response
    {
        return $this->render('front/payment.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    public function mainCategoires(): Response
    {   
        $categories = $this->em->getRepository(Category::class)
        ->findBy (['parent'=>null], ['name'=>'ASC']);
        return $this->render('front/_main_categories.html.twig',[
            'categories'=> $categories
        ]);
    }

    
}
