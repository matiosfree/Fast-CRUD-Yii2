<?php
namespace app\actions;

use yii\base\Action;
use yii\helpers\ArrayHelper;


/**
 * Class IndexAction
 */
class IndexAction extends Action {

    /**
     * @var string Класс
     */
    public $modelClass;

    /**
     * @var string Название вьюшки
     */
    public $view = 'index';

    /**
     * @var string Сценарий
     */
    public $scenario = 'search';

    /**
     * @var array Дополнительные данные для вьюшки
     */
    public $additionalData = array();


    public function run() {
        /**
         * @var \app\models\base\BaseActiveRecord|string $searchModel
         */
        $searchModel = new $this->modelClass;

        $scenarios = $searchModel->scenarios();
        if (isset($scenarios[$this->scenario])) {
            $searchModel->setScenario('search');
        }

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->render(
            $this->view,
            ArrayHelper::merge($this->additionalData, ['dataProvider' => $dataProvider, 'searchModel' => $searchModel])
        );
    }
}