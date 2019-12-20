<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Mantra */

$this->title = $model->entity_name_han;
$this->params['breadcrumbs'][] = ['label' => '文献', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mantra-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'cd',
            'entity_name_han',
            'entity_name_tb',
            'entity_name_sans',
            [
        		'attribute'=>'text_han',
        		'format'=>'ntext',
        	],
            'text_tb:ntext',
            'text_sans:ntext',
            [
                'attribute' => 'funcs',
                'value' => $model->funcsText
            ],
            [
                'attribute' => 'sutra_id',
                'value' => $model->sutra->entity_name_tc
            ],
            [
        		'attribute'=>'context',
        		'format'=>'ntext',
        	],
            'cbeta_index',
            [
        		'attribute'=>'voice',
        		'format'=>'raw',
        		'value'=>$model->voice_path ? sprintf('<audio src="%s%s" controls="controls">浏览器不支持播放</audio>', $model->voice_base_url, $model->voice_path) : '',
        	],
            'created_at',
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->userProfile->fullname
            ],
        ],
        'template' => '<tr><th style="width:120px;">{label}</th><td>{value}</td></tr>',
    ]) ?>

</div>
