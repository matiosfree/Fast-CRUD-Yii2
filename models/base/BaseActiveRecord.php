<?php
/**
 * Created by PhpStorm.
 * User: Matios
 * Date: 15.01.2016
 * Time: 10:48
 *
 * @property string $status
 */

namespace app\models\base;

use \yii\caching\DbDependency;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class BaseActiveRecord extends ActiveRecord {

    protected $_properties; //Аттрибуты моделей (обычно наследников)

    const STATUS_WAIT = 0;
    const STATUS_PUBLISHED = 1;

    const NO_INDEX_FALSE = 0;
    const NO_INDEX_TRUE = 1;

    const TRUE = 1;
    const FALSE = 0;


    public function behaviors() {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }


    public function search($params) {

        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        return $dataProvider;
    }

    public static function getStatusArray() {
        return [
            self::STATUS_PUBLISHED => 'Опубликовано',
            self::STATUS_WAIT => 'В ожидании',
        ];
    }

    public function getStatusTitle() {
        $statuses = self::getStatusArray();
        return !empty($statuses[$this->status]) ? $statuses[$this->status] : '-';
    }


    /**
     * Получаем тип NoIndex
     */
    public function getNoIndexTitle() {
        $noIndexArray = self::getNoIndexArray();
        return !empty($noIndexArray[$this->no_index]) ? $noIndexArray[$this->no_index] : 'Не известно';
    }


    /**
     * Список типов NoIndex
     */
    public static function getNoIndexArray() {
        return array(
            self::NO_INDEX_FALSE => "Индексировать",
            self::NO_INDEX_TRUE => "Не индексировать",
        );
    }


    /**
     * Список bool'ов
     */
    public static function getBoolArray() {
        return array(
            self::TRUE => "Да",
            self::FALSE => "Нет",
        );
    }


    /**
     * Проверка свойства модели
     *
     * @param $property
     * @return bool
     */
    public function propertyExists($property) {

        if (!isset($this->_properties)) {
            $this->_properties = $this->getAttributes();
        }

        return array_key_exists($property, $this->_properties);
    }


    /**
     * Проверка свойств модели
     *
     * @param $properties
     * @return bool
     */
    public function propertiesExists(array $properties) {
        $result = true;

        foreach ($properties as $property) {
            $result = $this->propertyExists($property) && $result;
        }

        return $result;
    }


    /**
     * Условие кеширования запроса
     *
     * @return DbDependency
     */
    public static function getSqlDbDependency() {
        return new DbDependency([
            'sql' => 'SELECT MAX(updated_at) FROM ' . self::tableName(),
        ]);
    }
}