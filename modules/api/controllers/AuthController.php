<?php


namespace app\modules\api\controllers;


use yii\filters\auth\HttpBearerAuth;

class AuthController extends  BaseController
{
 public function behaviors()
 {
     $parent =  parent::behaviors();

     $parent['access'] = [
       'class' => HttpBearerAuth::class,
     ];

     return $parent;
 }
}