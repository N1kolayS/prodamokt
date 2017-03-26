<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $phone;
    public $password;

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
            ['username', 'trim'],
            ['username', 'required'],

            ['username', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'trim'],
            ['phone', 'required'],

            ['phone', 'is10NumbersOnly'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот номер телефона уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен состоять из 10 цифр');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Ваше имя',
            'phone' => 'Ваш телефон',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateSmsCode();
        // Send Sms
        $user->SendSms();
        
        return $user->save() ? $user : null;
    }
}
