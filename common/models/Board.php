<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "{{%board}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $town_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $finished_at
 * @property string $name
 * @property string $body
 * @property string $cost
 * @property integer $views
 * @property integer $looks
 * @property integer $enable
 * @property integer $marked
 * @property integer $started_at
 * @property string $value1
 * @property string $value2
 * @property string $value3
 * @property string $value4
 * @property string $value5
 * @property string $value6
 * @property string $value7
 * @property string $value8
 * @property string $slug
 *
 * @property Town $town
 * @property Type $type
 * @property User $user
 *
 * @property array $property
 * @property string $images
 */

class Board extends \yii\db\ActiveRecord
{
    public $property;

    public $images;

    const STATUS_ENABLE  = 1;
    const STATUS_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];

    }

    public function beforeValidate() {
        // Чистим от тегов входные данные
        $this->name = strip_tags($this->name);
        $this->body = strip_tags($this->body);
        $this->cost = intval(str_replace(' ', null, $this->cost));


        return parent::beforeValidate();
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%board}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'type_id', 'town_id',  'name', 'body'], 'required'],
            [['user_id', 'type_id', 'town_id', 'created_at', 'updated_at', 'finished_at', 'started_at', 'views', 'looks', 'enable', 'marked'], 'integer'],
            [['body'], 'string'],
            [['cost'], 'decimalNumber'],
            [['name'], 'string', 'max' => 100],
            [['value1', 'value2' ,'value3', 'value4', 'value5', 'value6', 'value7', 'value8'], 'string', 'max' => 255],
            [['property'], 'safe'],
            [['town_id'], 'exist', 'skipOnError' => true, 'targetClass' => Town::className(), 'targetAttribute' => ['town_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

        ];
    }

    public function decimalNumber($attribute)
    {
        if (!preg_match('/^[\d\s]*$/', $this->$attribute)) {
            $this->addError($attribute, 'Только цифры');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'type_id' => 'Тип',
            'town_id' => 'Город',
            'user' => 'Пользователь',
            'type' => 'Тип',
            'town' => 'Город',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'finished_at' => 'Срок до',
            'started_at' => 'Старт',
            'name' => 'Заголовок',
            'body' => 'Текст',
            'cost' => 'Стоимость',
            'views' => 'Просмотры',
            'looks' => 'Запросов',
            'enable' => 'Включено',
            'marked' => 'Marked',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTown()
    {
        return $this->hasOne(Town::className(), ['id' => 'town_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * Check exist image
     * @return bool
     */
    public function existImages()
    {
        if ($this->getImages()[0]->urlAlias != 'placeHolder')
        {
            return true;
        }
        return false;
    }

    public function correctImages()
    {
        // Изображения существуют, но главного нет
        if ($this->existImages()&&($this->getImage()->urlAlias == 'placeHolder' ))
        {
            $this->setMainImage($this->getImages()[0]); // Установить главную из списка
        }
    }

    /**
     * Check Active board
     * @return bool
     */
    public function isActive()
    {
        if (($this->finished_at >= time())&&$this->enable&&$this->started_at <= time())
        {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public static function createTmpDir()
    {
        $tmp_user_dir = Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/';
        if (!is_dir($tmp_user_dir))
        {
             mkdir($tmp_user_dir);
        }

        return $tmp_user_dir;
    }

    /**
     * @return bool
     */
    public static function deleteTmpDir()
    {
        FileHelper::removeDirectory(Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/');
        /*
        $tmp_user_dir = Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/';
        if (is_dir($tmp_user_dir))
        {
            $files = array_diff(scandir($tmp_user_dir), array('.','..'));
            foreach ($files as $file) {
                unlink("$tmp_user_dir/$file");
            }
            rmdir($tmp_user_dir);
        }
        */
        return true;
    }

    /**
     * @return array|bool
     */
    public static function scanDirImages()
    {
        $tmp_user_dir = Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/';
        if (is_dir($tmp_user_dir))
        {
            $files = array_diff(scandir($tmp_user_dir), array('.','..'));
            return ['path' => $tmp_user_dir, 'url'=> '/uploadimg/'.Yii::$app->user->id.'-tmp/', 'files' => $files] ;
        }
        else
        {
            return false;
        }
    }

    /**
     * Check start board
     * @return bool
     */
    public function isStarted()
    {
        if ($this->started_at <= time())
        {
            return true;
        }
        return false;
    }

    /**
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function getPrice()
    {
        if (!empty($this->type->cost_name))
        {

            if ((empty($this->cost))or(intval($this->cost)==0))
            {
                $cost = 'Не указано';
            }
            else
            {
                $cost = Yii::$app->formatter->asCurrency($this->cost);
            }

            return ['name' => $this->type->cost_name, 'cost' => $cost];
        }

        return false;
    }

    /**
     * Check Finished
     * @return bool
     */
    public function isFinished()
    {
        if ($this->finished_at <= time())
        {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function Prolong()
    {
        $this->started_at = time();
        $this->finished_at = $this->started_at + Yii::$app->params['board.lifetime'];
        return true;
    }

    /**
     * Обновление просмотров
     */
    public function updateView()
    {
        self::updateCounters(['views'=>1]);
    }


    /**
     * @param $i
     * @param $value
     */
    private function setValue($i, $value)
    {
        switch ($i) {
            case 1:
                $this->value1 = $value;
                break;
            case 2:
                $this->value2 = $value;
                break;
            case 3:
                $this->value3 = $value;
                break;
            case 4:
                $this->value4 = $value;
                break;
            case 5:
                $this->value5 = $value;
                break;
            case 6:
                $this->value6 = $value;
                break;
            case 7:
                $this->value7 = $value;
                break;
            case 8:
                $this->value8 = $value;
                break;
        }
    }

    /**
     * @param $i
     * @return string
     */
    public function getValue($i)
    {
        switch ($i) {
            case 1:
                return $this->value1;
                break;
            case 2:
                return $this->value2;
                break;
            case 3:
                return $this->value3;
                break;
            case 4:
                return $this->value4;
                break;
            case 5:
                return $this->value5;
                break;
            case 6:
                return $this->value6;
                break;
            case 7:
                return $this->value7;
                break;
            case 8:
                return $this->value8;
                break;
        }
    }



    /**
     * Превращение цены в INT
     * @todo Сделать по нормальному
     * Установка времени старта и финиша
     * Привязка пользователя
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {

            if ($this->cost)
                $this->cost = intval(str_replace(' ', '', $this->cost));

            if ($this->isNewRecord) {
                $this->user_id = Yii::$app->user->id;
                $this->finished_at = $this->created_at + Yii::$app->params['board.lifetime'];
                $this->started_at  = $this->created_at + Yii::$app->params['board.delay'];
            }


            if ($this->property)
            {

                foreach ($this->property as $key=>$prop)
                {
                    $this->setValue($key,  strip_tags($prop));

                }
            }

            return true;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {

            $this->removeImages();
            return true;
        }
        return false;
    }

}
