<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $phone;
    public $verifyCode;

    public function beforeValidate() {
        $this->phone = str_replace('-', null, $this->phone);
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['phone', 'required'],
            ['phone', 'is10NumbersOnly'],
            ['phone', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Пользователь с данным номером телефона не найден.'
            ],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'verifyCode' => 'Введите код с картинки',
        ];
    }

    /**
     * @param $attribute
     */
    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен состоять из 10 цифр');
        }
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendSms()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'phone' => $this->phone,
        ]);

        if (!$user) {
            return false;
        }

        $user->generateSmsResetToken();

        if (!$user->save()) {
            return false;
        }

        return $user->SendResetSms();
    }
}
