<?php


namespace app\modules\api\resources;


use app\modules\api\models\Post;

class PostResource extends Post
{
 public function fields()
 {
     return [
         'id',
         'title',
         'date',
         'user'=>function()
         {
             return[
                 'id'=>$this->user->id,
                 'name'=>$this->user->username,
             ];
         }
     ];
 }
 public function extraFields()
 {
     return [
         'user'
     ];
 }
}