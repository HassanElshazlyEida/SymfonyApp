<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Utils\CategoryTreeAdminList;
use App\Utils\CategoryTreeAdminOptionList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(CategoryTreeAdminList $categories,Request $request): Response
    {
        $categories->getCategoryList($categories->buildTree());
       
        $category=new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($this->saveCategory($category,$form,$request)){
            $this->addFlash("created","Category has been created successfully");   
            return $this->redirectToRoute('categories');    
        }
        return $this->render('admin/categories.html.twig', [
            "categories" => $categories->categoryList,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/edit-category/{category}", name="editCategory")
     */
    public function editCategory(Category $category,Request $request): Response
    {
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($this->saveCategory($category,$form,$request)){
            $this->addFlash("updated","Category has been updated successfully");   
            return $this->redirectToRoute('categories');    
        }
        return $this->render('admin/edit_category.html.twig',[
            'category'=>$category,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/delete-category/{category}", name="deleteCategory")
     */
    public function deleteCategory(Category $category): Response
    {
        $this->em->remove($category);
        $this->em->flush();
        $this->addFlash("deleted","Category has been deleted successfully");   
        return $this->redirectToRoute('categories');
    }



    /**
     * @Route("/videos", name="videos")
     */
    public function videos(): Response
    {
        return $this->render('admin/videos.html.twig');
    }

    /**
     * @Route("/upload-video", name="uploadVideo")
     */
    public function uploadVideo(): Response
    {
        return $this->render('admin/upload_video.html.twig');
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }

    public function getAllCategories(CategoryTreeAdminOptionList $categories,$editedCategory=null)
    {
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/_all_categories.html.twig',[
            'categories'=>$categories->categoryList,
            'editedCategory'=>$editedCategory
        ]);
    }

    private function saveCategory($category,$form,$request){
        if($form->isSubmitted() && $form->isValid()){
        
            $repo=$this->em->getRepository(Category::class);
            $category->setName($request->request->get('category')['name']);
          
            $parent=$repo->find($request->request->get('category')['parent']);
            $category->setParent($parent);
    
            $this->em->persist($category);
            $this->em->flush();

          
            return true;
        }
        return false;

    
    }
}
