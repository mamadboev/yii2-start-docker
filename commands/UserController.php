<?php


namespace app\commands;

use Yii;
use app\modules\api\models\User;
use yii\console\Controller;
use yii\base\Exception;
use yii\console\ExitCode;

class UserController extends Controller
{
    /**
     * @param string $username
     * @param string $password
     * @return int
     * @throws Exception
     */
    public function actionCreate(string $username, string $password): int
    {

        if(User::findOne(['username'=>$username])!== null )
        {
            echo "user {$username} already exists\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $model = new User();
        $model->username = $username;
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
        $model->auth_token =  Yii::$app->security->generateRandomString();

        if($model->save() === false)
        {
            echo "error: ".array_values($model->firstErrors)[0] ?? "unknown error\n";
            return ExitCode::UNSPECIFIED_ERROR;

        }
        echo "user {$username} created\n";

        return ExitCode::OK;
    }


}