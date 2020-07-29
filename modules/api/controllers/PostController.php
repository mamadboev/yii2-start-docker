<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\PostResource;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

class PostController extends AuthController
{
    public $serializer = [
        'class'=>'yii\rest\Serializer',
];
    public function behaviors()
    {
        $parent = parent::behaviors();

        $parent['verb']=[
            'class'=>VerbFilter::class,
            'actions'=> [
                'index'=> ['GET'],

            ]
        ];
       // $parent['access']['only'] = ['index'];
        $parent['access']['except'] = ['public'];
        return $parent;
    }

    public function actionIndex(int $perPage = 20 ): ActiveDataProvider
    {
        $this->serializer['collectionEnvelope']='posts';

        if ($perPage > 20 || $perPage < 0)
        {
            $perPage = 20;
        }
        return new ActiveDataProvider([

            'query'=>PostResource::find()->joinWith(['user']),
            'pagination'=>[
                'pagesize'=> $perPage,
            ]
        ]);
    }
    public function actionPublic(): array
    {
        return [
          'ok'
        ];
    }


}