<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\JsExpression;

return [
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cd',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'entity_name_han',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'entity_name_tb',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'entity_name_sans',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'funcs',
        'value' => function($model){
            return $model->funcsText;
        }
    ],
    [
		'class'=>'\kartik\grid\DataColumn',
		'attribute'=>'sutra_id',
		'value'=>function ($model){
			return $model->sutra->entity_name_tc;
		}
	],

    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'cbeta_index',
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=> '{view}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key, ]);
        },
        'viewOptions'=>['target'=>'_blank'],
    ],

];   