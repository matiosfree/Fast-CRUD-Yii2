<?php

namespace app\actions;

use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;


/**
 * Class ViewAction
 */
class ViewAction extends Action {

    /**
     * @var string Класс
     */
    public $modelClass;

    /**
     * @var string Название вьюшки
     */
    public $view = 'view';

    /**
     * @var array Дополнительные данные для вьюшки
     */
    public $additionalData = array();

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function run($id) {
        /**
         * @var \app\models\base\BaseActiveRecord|string $modelClass
         */
        $modelClass = $this->modelClass;

        /**
         * @var \app\models\base\BaseActiveRecord|null $model
         */
        $model = $modelClass::findOne((int) $id);

        if (empty($model)) {
            throw new NotFoundHttpException('Такая страница не существует');
        }

        return $this->controller->render($this->view, ArrayHelper::merge(
            $this->additionalData,
            ['model' => $model]
        ));
    }
}