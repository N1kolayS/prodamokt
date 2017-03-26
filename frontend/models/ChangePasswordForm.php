<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 26.03.17
 * Time: 11:06
 */

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Change Password form
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $new_password;

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
            [['new_password', 'password'],  'required'],
            [['new_password', 'password'],  'string', 'max' => 50, 'min'=>6],
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
            'new_password' => 'Новый пароль',
            'password' => 'Старый пароль',
        ];
    }

    /**
     * Activate User
     *
     * @return bool
     */
    public function Change()
    {
        if (!$this->validate()) {
            return null;
        }


        if ($this->user->validatePassword($this->password))
        {
            $this->user->setPassword($this->new_password);
            $this->user->save();
            return true;
        }
        $this->addError('password', 'Старый пароль не верный');
        return null;

    }
}