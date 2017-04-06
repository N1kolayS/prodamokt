<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 *
 * @property Town $town
 * @property Type $type
 * @property User $user
 * @property BoardProperty[] $boardProperties
 * @property Property[] $properties
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
            [['property'], 'safe'],
            [['town_id'], 'exist', 'skipOnError' => true, 'targetClass' => Town::className(), 'targetAttribute' => ['town_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['images' ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg',  'maxFiles' => 4],
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
     * @return \yii\db\ActiveQuery
     */
    public function getBoardProperties()
    {
        return $this->hasMany(BoardProperty::className(), ['board_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['id' => 'property_id'])->viaTable('{{%board_property}}', ['board_id' => 'id']);
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

    public static function deleteTmpDir()
    {
        $tmp_user_dir = Yii::getAlias('@frontend/web/uploadimg/').Yii::$app->user->id.'-tmp/';
        if (is_dir($tmp_user_dir))
        {
            $files = array_diff(scandir($tmp_user_dir), array('.','..'));
            foreach ($files as $file) {
                unlink("$tmp_user_dir/$file");
            }
            rmdir($tmp_user_dir);
        }
        return true;
    }

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

    public function getPrice()
    {
        if (!empty($this->type->cost_name))
        {
            $cost = 'Не указано';
            if (!empty($this->cost))
                $cost = Yii::$app->formatter->asCurrency($this->cost);

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
            return true;
        }

        return false;
    }

    /**
     * Установка атрибутов для свойств
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave ($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

            if ((!$insert)and($this->property)) // Check update record and Property exist
            {
                // Удаляем все значения свойств
                BoardProperty::deleteAll(['board_id' => $this->id]);
            }

            if ($this->property)
            {
                // Save
                foreach ($this->property as $key=>$prop)
                {
                    $model_prop = new BoardProperty();
                    $model_prop->board_id = $this->id;
                    $model_prop->property_id = $key;
                    $model_prop->value = strip_tags($prop);
                    $model_prop->save();
                }
            }

    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            BoardProperty::deleteAll(['board_id' => $this->id]);
            $this->removeImages();
            return true;
        }
        return false;
    }


    public function pubVk()
    {
        return true;
    }
}
