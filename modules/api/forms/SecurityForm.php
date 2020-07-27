<?php


namespace app\modules\api\forms;


use app\modules\api\models\User;
use Yii;

class SecurityForm extends BaseForm
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $auth_token = null;

    public const SCENARIO_LOGIN = 'login';
    public const SCENARIO_RESET_PASSWORD = 'reset password';

    public function  rules(): array
    {
        return [
            [['username','password'], 'required', 'on'=>self::SCENARIO_LOGIN],
            [['username'], 'required', 'on'=>self::SCENARIO_RESET_PASSWORD],
        ];
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(),[
            self::SCENARIO_LOGIN => ['username','password'],
            self::SCENARIO_RESET_PASSWORD => ['username']
            ]);
    }

    /**
     * @return bool
     * @throws Yii\base\Exception
     */
    public function login(): bool
    {
        if($this->validate() === false)
        {
            return false;
        }
        $user = User::findOne(['username'=> $this->username]);

        if($user === null)
        {
            $this->addError('username', 'user not found');
            return false;
        }

        if(Yii::$app->security->validatePassword($this->password, $user->password_hash))
        {
            $user->generateAuthToken();

            if($user->save(false) === false)
            {
                $this->addError('username', 'error, try later');
                return false;
            }

            $this->auth_token =  $user->auth_token;
            return  true;
        }

        $this->addError('username', 'username or password incorrect');
        return  false;
    }

    public function resetPassword(): bool
    {
        return true;
    }



}