<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $new_pass;
    public $sms_token;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a phone.
     *
     * @param string $phone
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($phone, $config = [])
    {

        $this->_user = User::findByPhone($phone);
        if (!$this->_user) {
            throw new InvalidParamException('Пользователь не найден.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sms_token', 'integer'],
            [['new_pass', 'sms_token'], 'required'],
            ['new_pass', 'string', 'min' => 6],
        ];
    }

    /**
     * @return bool
     */
    public function checkSmsToken()
    {
        if (!$this->_user->sms_reset_token = $this->sms_token)
            return true;
        else
            return false;
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);
        $user->removeSmsResetToken();

        return $user->save(false);
    }
}
