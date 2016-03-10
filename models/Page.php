<?php

namespace app\models;

use Yii;
use app\models\base\BaseActiveRecord;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $page_title
 * @property string $description
 * @property string $keywords
 * @property integer $no_index
 * @property string $text
 * @property integer $status
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends BaseActiveRecord {

    const VIEW_IN = 1;
    const VIEW_LP = 0;



    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['alias', 'title', 'status'], 'required'],
            [['no_index', 'status', 'type', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['alias', 'title', 'page_title', 'description', 'keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'alias' => 'Алиас',
            'page_title' => 'Заголовок',
            'title' => 'SEO заголовок',
            'description' => 'SEO описание',
            'keywords' => 'SEO ключи',
            'no_index' => 'Индексация',
            'text' => 'Текст',
            'status' => 'Статус',
            'type' => 'Тип',
            'created_at' => 'Создано',
            'updated_at' => 'Редактированно',
        ];
    }


    /**
     * @inheritdoc
     * @return queries\PageQuery the active query used by this AR class.
     */
    public static function find() {
        return new queries\PageQuery(get_called_class());
    }


    /**
     * Получаем тип страницы
     */
    public function getTypeTitle() {
        $typeArray = self::getTypeArray();
        return !empty($typeArray[$this->type]) ? $typeArray[$this->type] : 'Не известно';
    }


    /**
     * Список типов страницы
     */
    public static function getTypeArray() {
        return array(
            self::VIEW_IN => "Обычный вид",
            self::VIEW_LP => "В виде Landing Page",
        );
    }

}
