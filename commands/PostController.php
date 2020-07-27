<?php


namespace app\commands;


use app\modules\api\models\Post;
use app\modules\api\models\User;
use Faker\Factory;
use yii\console\Controller;
use yii\console\ExitCode;

class PostController extends Controller
{
    public function actionCreate(int $user_id, int $count): int
    {
        if(($user = User::findOne(['id'=>$user_id]) ) === null)
        {
            echo "{$user_id} not found\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }


        $faker = Factory::create('ru_RU');

        for($x = 0; $x < $count; $x++)
        {
            $post = new Post();
            $post->user_id = $user_id;
            $post->title = $faker->realText(20);
            $post->text  = $faker->realText(200);
            $post->date = date('Y-m-d H:i:s');

            if($post->save() === false)
            {
                echo "error: ".array_values($post->firstErrors)[0] ?? "unknown error\n";
                return ExitCode::UNSPECIFIED_ERROR;
            }

            echo "post '{$post->title}' created\n";

        }


        return ExitCode::OK;

    }

}