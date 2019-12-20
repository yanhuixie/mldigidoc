<?php

namespace frontend\controllers;

use Yii;
use common\models\Func;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * FuncController implements the CRUD actions for Func model.
 */
class FuncController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

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
SELECT p.id AS id, p.name AS text 
FROM func p 
WHERE (p.name LIKE :fn )
LIMIT 20
EOF;
            $data = Yii::$app->db->createCommand($sql, [':fn' => '%' . $q . '%'])->queryAll();
            $out['results'] = array_values($data);
        }

        return $out;
    }

    /**
     * Finds the Func model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Func the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Func::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
