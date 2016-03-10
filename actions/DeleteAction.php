<?php

namespace app\actions;

use yii\base\Action;
use yii\web\NotFoundHttpException;


/**
 * Class DeleteAction
 */
class DeleteAction extends Action {

    /**
     * @var string Класс
     */
    public $modelClass;

    /**
     * @var string|array Вьюха на которую уходит редирект после удаления данные
     */
    public $view = 'index';

    /**
     * @var bool Вернуться на предыдущую страницу
     */
    public $goBack = false;

    /**
     * @var string сценарий
     */
    public $modelScenario = 'default';

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
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

        $model->setScenario($this->modelScenario);

        $model->delete();

        return $this->controller->redirect($this->goBack ? \Yii::$app->request->referrer : [$this->view]);
    }
}