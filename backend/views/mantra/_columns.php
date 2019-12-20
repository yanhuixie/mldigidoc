<?php

use common\models\Func;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\JsExpression;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cd',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'entity_name_han',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'entity_name_tb',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'text_han',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'text_tb',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'func_id',
        'filterType' => GridView::FILTER_SELECT2,
	    'filterInputOptions' => ['placeholder' => '标签'],
		'filterWidgetOptions' => [
			'model' => $searchModel,
			'attribute' => 'func_id',
			'initValueText' => Func::getName($searchModel->func_id) ,
			'pluginOptions'=>[
				'allowClear' => true,
				'ajax' => [
					'url' => Url::to(['/func/autocomplete']),
					'dataType' => 'json',
					'data' => new JsExpression('function(params) { return {q:params.term}; }')
				],
				'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
				'templateResult' => new JsExpression('function(city) { return city.text; }'),
				'templateSelection' => new JsExpression('function (city) { return city.text; }'),
			]
		],
        'value' => function($model){
            return $model->funcsText;
        }
    ],
    [
		'class'=>'\kartik\grid\DataColumn',
		'attribute'=>'sutra_id',
		'filterType' => GridView::FILTER_SELECT2,
	    'filterInputOptions' => ['placeholder' => '出处名'],
		'filterWidgetOptions' => [
			'model' => $searchModel,
			'attribute' => 'sutra_id',
			'initValueText' => $searchModel->sutra ? $searchModel->sutra->entity_name_tc : '',
			'pluginOptions'=>[
				'allowClear' => true,
				'ajax' => [
					'url' => Url::to(['/sutra/autocomplete']),
					'dataType' => 'json',
					'data' => new JsExpression('function(params) { return {q:params.term}; }')
				],
				'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
				'templateResult' => new JsExpression('function(city) { return city.text; }'),
				'templateSelection' => new JsExpression('function (city) { return city.text; }'),
			]
		],
		'value'=>function ($model){
			return $model->sutra->entity_name_tc;
		}
	],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'context',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'cbeta_index',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'created_at',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_by',
        'value' => function($model){
            return $model->createdBy->userProfile->fullname;
        },
        'filter' => false
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   