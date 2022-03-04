<?php
namespace App\Utils\AbstractClasses;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract {

    public $categoryList;
    public function __construct(EntityManagerInterface $em,UrlGeneratorInterface $urlgenerator)
    {
        $this->em=$em;
        $this->urlgenerator=$urlgenerator;
    }

    abstract public function getCategoryList(array $categories_array);

    private function getCategories() :?array {
        // return  $this->em->getRepository(Category::class)->find(); as object
        $sql="
            SELECT * FROM categories
        ";
        $stmt = $this->em->getConnection()->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
       
    }
    public function buildTree(int $parent_id=null): ?array
    {
        foreach ($this->getCategories() as $category){

            if($category['parent_id']== $parent_id){

                $children=$this->buildTree($category['id']);

                if($children){
                    $category['children']=$children;
                }
                $subCategory[] = $category;
           }
        }
        return $subCategory ?? [];
    }
}