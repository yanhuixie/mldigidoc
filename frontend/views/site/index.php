<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>欢迎</h1>

        <p class="lead">这里是 <?=Yii::$app->name ?></p>

        <?php echo common\widgets\DbMenu::widget([
            'key'=>'frontend-index',
            'options'=>[
                'tag'=>'p'
            ]
        ]) ?>

    </div>
</div>
