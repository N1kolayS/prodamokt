<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 21.03.17
 * Time: 23:32
 */


namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Sms Activate form
 */
class SmsActivateForm extends Model
{
    public $sms_code;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sms_code', 'integer'],
            ['sms_code', 'required'],
        ];
    }

    public function getUser()
    {
        return $this->user;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sms_code' => 'Код из смс',
        ];
    }

    /**
     * Activate User
     *
     * @return bool
     */
    public function Activate()
    {
        if (!$this->validate()) {
            return null;
        }


        if ($this->user->validateSmsCode($this->sms_code))
        {
            $this->user->Activate();
            return true;
        }
        $this->addError('sms_code', 'Код не совпадает, попробуйте еще раз');
        return null;

    }
}
