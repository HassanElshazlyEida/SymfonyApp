<?php 
namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract {

    public function getCategoryList(array $categories_array): string{


        $this->categoryList .="<ul>";
        foreach ($categories_array as $value){

            $catName = $value['name'];
            $url = $this->urlgenerator->generate('videoList',['categoryName'=>$catName,'category'=>$value['id']]);
            $this->categoryList.= '<li>' .'<a href="'. $url. '">'.
            $catName. '</a>'.'</li>';

            if(!empty($value['children'])){
                $this->getCategoryList($value['children']);
            }
        }
       

        $this->categoryList .="</ul>";
        return $this->categoryList;
    }

    public function getChilIds(int $parent):array {
        
        static $ids = [];
        foreach ($this->categories as $val)
        {
            if($val['parent_id'] == $parent)
            {
                $ids [] = $val['id'].',';
                $this->getChilIds($val['id']);
            }
        }
        return $ids;
    }
}