<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'cd',
        [
            'attribute' => 'entity_name_han',
            'format'=>'raw',
            'value' => Html::a($model->entity_name_han, Url::to(['/mantra/view', 'id'=>$model->id])),
        ],
        'entity_name_tb',
        'entity_name_sans',
        [
            'attribute' => 'funcs',
            'value' => $model->funcsText
        ],
        [
            'attribute' => 'sutra_id',
            'value' => $model->sutra->entity_name_tc
        ],
    ],
    'template' => '<tr><th style="width:90px;">{label}</th><td>{value}</td></tr>',
]) ?>