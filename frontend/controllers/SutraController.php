<?php

namespace frontend\controllers;

use Yii;
use common\models\Sutra;
use backend\models\search\SutraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * SutraController implements the CRUD actions for Sutra model.
 */
class SutraController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 
     */
    public function actionAutocomplete($q = null) 
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        
        if (!empty($q)) {
            $sql = <<<EOF
SELECT p.id AS id, p.entity_name_tc AS text 
FROM sutra p 
WHERE (p.entity_name_tc LIKE :fn or p.entity_name_sc LIKE :fn)
LIMIT 20
EOF;
            $data = Yii::$app->db->createCommand($sql, [':fn' => '%' . $q . '%'])->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
    }

    /**
     * Finds the Sutra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sutra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sutra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
