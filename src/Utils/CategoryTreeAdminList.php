<?php
namespace App\Utils;

use App\Utils\AbstractClasses\CategoryTreeAbstract;
class CategoryTreeAdminList extends CategoryTreeAbstract {

 
   public function getCategoryList(array $categories_array): string{


      $this->categoryList .="<ul>";
      foreach ($categories_array as $value){
         $url_edit = $this->urlgenerator->generate('editCategory',['category'=>$value['id']]);
         $url_delete = $this->urlgenerator->generate('deleteCategory',['category'=>$value['id']]);
         $this->categoryList.=
         '<li>'. $value['name'].
               '  <a onclick="return confirm("Are you sure?");" href="'. $url_edit. '">Edit'. '</a>'.'<a href="'. $url_delete. '"> Delete'. '</a>'
         .'</li>';
          if(!empty($value['children'])){
              $this->getCategoryList($value['children']);
          }
      }
     

      $this->categoryList .="</ul>";
      return $this->categoryList;
  }
   
}