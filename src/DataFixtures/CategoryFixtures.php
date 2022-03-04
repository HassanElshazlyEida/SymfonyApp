<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadMainCategories($manager);
    }
    private function loadMainCategories ($manager){

        foreach ($this->getMainCategoriesData() as [$name,$parent_id] ){

            $category = new Category();
            $parent=$manager->getRepository(Category::class)->find($parent_id);
            $category->setName($name);
            $category->setParent($parent);

            $manager->persist($category);
             
            $manager->flush();
        }
   }
    private function getMainCategoriesData(){
        return [
            ['Electronics',-1], ['Toys',1], ['Books',2], ['Movies',3],
            ['Test1',-1], ['Test2',5], ['Test3',6], ['Test4',7],
            ['Test5',-1], ['Test6',9], ['Test7',10], ['Test8',11]
        ];
    }
   
}
