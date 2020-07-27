<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Post;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

class PostController extends BaseController
{
    public function behaviors()
    {
        $parent = parent::behaviors();

        $parent['verb']=[
            'class'=>VerbFilter::class,
            'actions'=> [
                'index'=> ['GET'],

            ]
        ];
        return $parent;
    }

    public function actionIndex()
    {
        return new ActiveDataProvider([

            'query'=>Post::find()
        ]);
    }


}