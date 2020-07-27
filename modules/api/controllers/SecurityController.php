<?php


namespace app\modules\api\controllers;


use app\modules\api\forms\SecurityForm;
use Yii;
use yii\filters\VerbFilter;

class SecurityController extends BaseController
{
    public  function behaviors()
    {
        $parent = parent::behaviors();
        $parent['verb'] =[
        'class'=>VerbFilter::class,
            'actions'=>[
                'login'=>['POST'],
                'reset-password' => ['POST']
            ]
    ];
        return $parent;
    }

    public function actionLogin(): array
    {
        $model = new SecurityForm();
        $model->scenario =  SecurityForm::SCENARIO_LOGIN;

        try {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->output([
                    'auth_token' => $model->auth_token,

                ]);

            }
        } catch (Yii\base\Exception $e) {
        }

        $error_message = array_values($model->firstErrors)[0] ?? "load error";
        return $this->output([], false, $error_message,401);

    }

    public function actionResetPassword(): array
    {
        return ['reset'];
    }


}