<?php 
namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract {

    public function getCategoryList(array $categories_array): string{


        $this->categoryList .="<ul>";
        foreach ($categories_array as $value){

            $catName = $value['name'];
            $url = $this->urlgenerator->generate('videoList',['category'=>$catName,'id'=>$value['id']]);
            $this->categoryList.= '<li>' .'<a href="'. $url. '">'.
            $catName. '</a>'.'</li>';

            if(!empty($value['children'])){
                $this->getCategoryList($value['children']);
            }
        }
       

        $this->categoryList .="</ul>";
        return $this->categoryList;
    }
}