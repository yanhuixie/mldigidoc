<?php

use common\helpers\UserAgent;
use common\models\Func;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kartik\select2\Select2; // or kartik\select2\Select2
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use common\models\Sutra;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\MantraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文献';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$dataProvider->pagination->pageSize = 10;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                检索条件 <small>(点击收起/展开)</small>
            </a>
        </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">

<div class="mantra-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($searchModel, 'sutra_id')->widget(Select2::classname(), [
                'initValueText' => Sutra::getName($searchModel->sutra_id), 
                'options' => ['placeholder' => '输入并查找出处...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => Url::to(['/sutra/autocomplete']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]); ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($searchModel, 'func_id')->widget(Select2::classname(), [
                'initValueText' => Func::getName($searchModel->func_id), 
                'options' => ['placeholder' => '输入并查找标签...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => Url::to(['/func/autocomplete']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'entity_name_han')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'entity_name_tb')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'entity_name_sans')->textInput(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'text_han')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'text_tb')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'text_sans')->textInput(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'cd')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'context')->textInput(); ?>
        </div>
        <div class="col-md-4">
        <?php echo $form->field($searchModel, 'cbeta_index')->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

        </div>
    </div>
</div>

<div class="mantra-index">
<?php if(UserAgent::chkMobile()){ $dataProvider->pagination->pageSize = 10; ?>
    <div id="listview_mantra">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'viewParams' => [//传参数给每一个item
            
        ],
        // 'layout' => '{items}<div class="col-md-12 sum-pager">{summary}{pager}</div>',//整个ListView布局
        'itemOptions' => [//针对渲染的单个item
            'tag' => 'div',
            'class' => 'col-md-4'
        ],
        // 'options' => [//针对整个ListView
        //     'tag' => 'div',
        //     'class' => 'col-lg-3'
        // ],
        'pager' => [
            //'options' => ['class' => 'hidden'],//关闭分页（默认开启）
            /* 分页按钮设置 */
            'maxButtonCount' => 5,//最多显示几个分页按钮
            'firstPageLabel' => '首页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '尾页'
        ]
    ]);?>
    </div>
<?php } else { ?>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    '{export}'
                ],
            ], 
            'pager' => [
                'maxButtonCount' => 10,//最多显示几个分页按钮
                'firstPageLabel' => '首页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'lastPageLabel' => '尾页'
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> 检索结果 列表',
                'before'=>'<em>* 可以像Excel那样拖拽调整每列宽度。</em>',
                'after'=>'<div class="clearfix"></div>',
            ],
            'containerOptions'=>[
                'style' => 'overflow-x:visible;'
            ]
        ])?>
    </div>
<?php } ?>
</div>

<?php \common\widgets\JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        // $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    });
</script>
<?php \common\widgets\JsBlock::end() ?>