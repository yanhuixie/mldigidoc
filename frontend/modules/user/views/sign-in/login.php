<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php echo $form->field($model, 'identity') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                        'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                    ]) ?>
                    <?php if (Yii::$app->getModule('user')->shouldBeActivated) : ?>
                        <br>
                        <?php echo Yii::t('frontend', 'Resend your activation email <a href="{link}">here</a>', [
                            'link'=>yii\helpers\Url::to(['sign-in/resend-email'])
                        ]) ?>
                    <?php endif; ?>

                </div>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <!--
                <div class="form-group">
                    <?php //echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
                </div>
                <h2><?php echo Yii::t('frontend', 'Log in with')  ?>:</h2>
                <div class="form-group">
                    <?php $authAuthChoice = yii\authclient\widgets\AuthChoice::begin([
                                    'baseAuthUrl' => ['site/auth']
                                ]); ?>
                        <ul class="list-unstyle list-inline">
                            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                                <li><?= $authAuthChoice->clientLink($client) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php yii\authclient\widgets\AuthChoice::end(); ?>
                </div>
                -->
                
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
