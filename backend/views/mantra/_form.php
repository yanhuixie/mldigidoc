<?php

use common\models\Sutra;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\Mantra */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="mantra-form">
    <?php $form = ActiveForm::begin(['options'=>[]]); ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'cd')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'cbeta_index')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'entity_name_han')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'entity_name_tb')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'entity_name_sans')->textInput(['maxlength' => true]) ?>
    </div>
</div>

    <?= $form->field($model, 'text_han')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'text_tb')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'text_sans')->textarea(['rows' => 5]) ?>

<div class="row">
    <div class="col-md-6">
        <?php $model->loadFuncs(); echo $form->field($model, 'funcs')->widget(Select2::classname(), [
            // 'data' => $data,//$model->getFuncs(),
            'options' => [
                'placeholder' => '选择或输入...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true,
                'maximumInputLength' => 50,
                'tokenSeparators' => new JsExpression("[ ',' ]"),
                'createTag' => new JsExpression(" function(params) {
                    if (params.term.indexOf('，') > 0 || params.term.indexOf(',') > 0) {
                    var str = params.term;
                    str = str.substr(0, str.length - 1);
                    return {
                        id: str,
                        text: str
                    }
                    } else {
                    return null;
                    }
                }")
            ],
        ])->hint("注意：输入标签文字后再输入逗号[,] 或[，]来建立标签");?>
    </div>
    <div class="col-md-6">
        <?php echo $form->field($model, 'sutra_id')->widget(Select2::classname(), [
                'initValueText' => $model->sutra_id ? $model->sutra->entity_name_tc : '', 
                'options' => [
                    'placeholder' => '查找……'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => Url::to(['/sutra/autocomplete']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(obj) { return obj.text; }'),
                    'templateSelection' => new JsExpression('function (obj) { return obj.text; }'),
                ],
            ]);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'context')->textarea(['rows' => 3]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'voice')->widget(
            Upload::class,
            [
                'url' => ['/file/storage/upload'],
                'maxFileSize' => 5000000, // 5 MiB,
                'acceptFileTypes' => new JsExpression('/(\.|\/)(mp3|ogg)$/i'),
                'multiple' => false,
                'id' => 'file_voice'
            ])
        ?>
    </div>
</div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
