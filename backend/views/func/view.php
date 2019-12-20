<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Func */
?>
<div class="func-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at',
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->userProfile->fullname
            ],
        ],
    ]) ?>

</div>
