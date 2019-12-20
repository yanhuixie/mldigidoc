<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sutra */
?>
<div class="sutra-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cd',
            'entity_name_tc',
            'entity_name_sc',
            'vol_amount',
            'vol_amount_actual',
            'pageno_begin',
            'pageno_end',
            'memo',
        ],
    ]) ?>

</div>
