<?php
namespace app\actions;

use yii\base\Action;
use yii\helpers\ArrayHelper;


/**
 * Class CreateAction
 */
class CreateAction extends Action {

    /**
     * @var string Название вьюшки
     */
    public $view = 'create';

    /**
     * @var string Класс
     */
    public $modelClass;

    /**
     * @var string сценарий
     */
    public $modelScenario = 'default';

    /**
     * @var string|array URL для редиректа после успешного обновления данных
     */
    public $returnUrl = 'update';

    /**
     * @var boolean Флаг, означающий редирект на URL, содержащий ID созданой записи
     */
    public $urlWithId = true;

    /**
     * @var array Дополнительные данные для вьюшки
     */
    public $additionalData = array();

    /**
     * @var string Сообщение при успешном сохранении модели
     */
    public $successMessage = 'Данные успешно сохранены';

    /**
     * @var string Сообщение при неудачном сохранении модели
     */
    public $errorMessage = 'Во время сохранения данных возникла неизвестная ошибка';

    /**
     * @var null Каллбэк
     */
    public $callback;


    public function run() {
        /**
         * @var \app\models\base\BaseActiveRecord $model
         */
        $model = new $this->modelClass;
        $model->setScenario($this->modelScenario);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                if (is_callable($this->callback)) {
                    return call_user_func($this->callback, $model, $this);
                } else {
                    \Yii::$app->session->setFlash('success', $this->successMessage);
                    if ($this->urlWithId) {
                        return $this->controller->redirect([$this->returnUrl, 'id' => $model->id]);
                    } else {
                        return $this->controller->redirect([$this->returnUrl]);
                    }
                }
            } else {
                \Yii::$app->session->setFlash('error', $this->errorMessage);
                return $this->controller->refresh();
            }
        }

        return $this->controller->render($this->view, ArrayHelper::merge(
            $this->additionalData,
            ['model' => $model]
        ));
    }
}