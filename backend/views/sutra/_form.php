<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sutra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sutra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entity_name_tc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entity_name_sc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vol_amount')->textInput() ?>

    <?= $form->field($model, 'vol_amount_actual')->textInput() ?>

    <?= $form->field($model, 'pageno_begin')->textInput() ?>

    <?= $form->field($model, 'pageno_end')->textInput() ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
