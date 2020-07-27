<?php


namespace app\modules\api\controllers;


use Yii;
use yii\rest\Controller;

class BaseController extends Controller
{
    public function output($data, bool  $success = true, string $error_message = '', int $error_code = 0 ): array
    {
        if($success ===  false){
            Yii::$app->response->statusCode = $error_code;

            return  [
                'code' => $error_code,
                'message' => $error_message
            ];

        }


        return $data;
    }


}