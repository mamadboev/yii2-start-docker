<?php


namespace app\modules\api\forms;


use yii\base\Model;

class BaseForm extends Model
{
    public function load($data, $formName = null)
    {
        $formName = $formName ?? '';
        return parent::load($data, $formName);
    }

}