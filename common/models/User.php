<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $role
 * @property string $sms_code_activate
 * @property string $sms_reset_token
 *
 * @property Board[] $boards
 *
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_AGENT = 'agent';
    const ROLE_DEFAULT = 'user';

    // Need for change password
    public $new_password;
    public $old_password;

    public function beforeValidate() {
        // Чистим от тегов входные данные
        $this->username = strip_tags($this->username);
        $this->email = strip_tags($this->email);
        $this->phone = str_replace('-', null, $this->phone);

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
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

            [['role'], 'required', 'on' => 'update'],
            [['role', 'sms_code_activate'], 'string', 'max' => 10],
            ['phone', 'is10NumbersOnly'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот Номер телефона уже занят.'],

            [['new_password', 'old_password'],  'string', 'max' => 50, 'min'=>6],
            [['new_password', 'old_password'],  'required', 'on' => 'change'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот E-mail уже занят.'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен состоять из 10 цифр');
        }
    }

    public function displayPhone()
    {
        if ($this->phone)
        {
            // Clean string phone
            $phone = preg_replace('~\D+~','',$this->phone);
            $phone_code = substr($phone, 0, 3);
            $phone_1 = substr($phone, 3, 3);
            $phone_2 = substr($phone, 6 );
            return '8 ('.$phone_code.') '.$phone_1.'-'.$phone_2;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата изменения',
            'username' => 'Имя',
            'info' => 'Инфо',
            'phone' => 'Телефон',
            'role' => 'Права',
            'agent' => 'Агентство',
            'status' => 'Статус пользователя',
            'sms_code_activate' => 'Код активации',
            'sms_reset_token' => 'Код сброса пароля',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['user_id' => 'id']);
    }


    /**
     * Finds user by phone.
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }


    /**
     * Finds user by sms reset token
     * @author Nikolay
     * @param $token
     * @return static
     */
    public static function findBySmsResetToken($token)
    {
        return static::findOne([
           'sms_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @author Nikolay
     */
    public function generateSmsResetToken()
    {
        $this->sms_reset_token = mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9);
    }



    /**
     * @author Nikolay
     *  Remove sms reset token
     */
    public function removeSmsResetToken()
    {
        $this->sms_reset_token = null;
    }

    /**
     * @author Nikolay
     * Generate SMS code
     */
    public function generateSmsCode()
    {
        $this->sms_code_activate = mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9);
    }

    /**
     * @author Nikolay, Usage library Zelenin
     * @throws \Zelenin\SmsRu\Exception\Exception
     */
    public function SendSms()
    {
        if (YII_ENV_PROD)
        {
            $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth(Yii::$app->params['sms.ru.api_id']));
            $sms = new \Zelenin\SmsRu\Entity\Sms('7'.$this->phone, 'Код: '. $this->sms_code_activate);
            $client->smsSend($sms);
        }
        else
        {
            $file = '/home/nikolay/sms.txt';
            file_put_contents($file, $this->sms_code_activate.PHP_EOL);
        }

    }

    /**
     * @author Nikolay, Usage library Zelenin
     * @throws \Zelenin\SmsRu\Exception\Exception
     */
    public function SendResetSms()
    {
        if (YII_ENV_PROD)
        {
            $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth(Yii::$app->params['sms.ru.api_id']));
            $sms = new \Zelenin\SmsRu\Entity\Sms('7'.$this->phone, 'Код сброса: '. $this->sms_reset_token);
            $client->smsSend($sms);
        }
        else
        {
            $file = '/home/nikolay/sms-reset.txt';
            file_put_contents($file, $this->sms_reset_token.PHP_EOL);
        }
        return true;

    }

    /**
     *
     * @author Nikolay
     * @return bool
     */
    public function isActivate()
    {
        if ($this->sms_code_activate==null)
            return true;
        else
            return false;
    }

    /**
     * @param $sms_code
     * @return bool
     */
    public function validateSmsCode($sms_code)
    {
        if ($this->sms_code_activate == $sms_code)
            return true;
        else
            return false;
    }

    public function Activate()
    {
        $this->sms_code_activate = null;
        $this->updateAll(['sms_code_activate'=>$this->sms_code_activate], ['id'=>$this->id]);
    }

    /**
     * @author Nikolay
     * Get All role from RBAC
     * @return array
     */
    public static function getAllRoles()
    {
        $roles = array();
        foreach (Yii::$app->authManager->getRoles() as $role)
        {
            $roles[$role->name] = $role->description;
        }

        return $roles;
    }

    public static function listStatus()
    {
        $data = [
            self::STATUS_ACTIVE => 'Включен',
            self::STATUS_DELETED => 'Отключен'
        ];
        return $data;
    }

    /**
     * Set role in Base
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {


            if ($this->isNewRecord)
            {
                // Роль по умолчанию
                $this->role = User::ROLE_DEFAULT;
            }
            else
            {
                // Номер телефона изменился, генерируем код
                if (!empty($this->getDirtyAttributes(['phone'])))
                {
                    $this->generateSmsCode();
                }

            }
            return true;
        }

        return false;
    }

    /**
     * @author Nikolay
     * Assignment Default role "user"
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave ($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) // Check new record. Analog isNewRecord.
        {
            // Assigned Role for user
            $userRole = Yii::$app->authManager->getRole(User::ROLE_DEFAULT);
            Yii::$app->authManager->assign($userRole, $this->id);
        }
        else
        {
            // Код активации не ноль, значит меняли номер, отправляем смс
            if ($this->sms_code_activate!=null)
            {
                $this->SendSms();
            }
            /**
             * Update Roles
             */
            Yii::$app->authManager->revokeAll($this->id);
            $userRole = Yii::$app->authManager->getRole($this->role);
            Yii::$app->authManager->assign($userRole, $this->id);
        }
    }

}
