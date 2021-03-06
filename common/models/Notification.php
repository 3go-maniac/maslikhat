<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advert".
 *
 * @property int $id
 * @property string $short_desc_kz
 * @property string $short_desc_ru
 * @property string $description_kz
 * @property string $description_ru
 * @property string $image
 * @property int $created_at
 */
class Notification extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description_kz', 'description_ru', 'short_desc_kz', 'short_desc_ru'], 'required'],
            [['created_at'], 'integer'],
            [['description_kz', 'description_ru'], 'string'],
            [['short_desc_kz', 'short_desc_ru', 'image'], 'string', 'max' => 255],
            [['tmpImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['tmpImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on' => self::SCENARIO_CREATE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_desc_kz' => 'Короткое описание на каз',
            'short_desc_ru' => 'Короткое описание на рус',
            'description_kz' => 'Описание на казахском',
            'description_ru' => 'Описание на русском',
            'image' => 'Сурет',
            'tmpImage' => 'Сурет',
            'created_at' => 'Created At',
        ];
    }
}
