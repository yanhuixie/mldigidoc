<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]); ?>
    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('frontend', 'About'), 'url' => ['/page/view', 'slug'=>'about']],
            ['label' => '多语种文献', 'url' => ['/mantra/index']],
            ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
            //['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
            ['label' => Yii::t('frontend', 'Signup'), 'url' => ['/user/sign-in/signup'], 'visible'=>Yii::$app->user->isGuest],
            ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
            [
                'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                'visible'=>!Yii::$app->user->isGuest,
                'items'=>[
                    [
                        'label' => Yii::t('frontend', 'Settings'),
                        'url' => ['/user/default/index']
                    ],
                    [
                        'label' => Yii::t('frontend', 'Backend'),
                        'url' => Yii::getAlias('@backendUrl'),
                        'visible'=>Yii::$app->user->can('manager')
                    ],
                    [
                        'label' => Yii::t('frontend', 'Logout'),
                        'url' => ['/user/sign-in/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ],
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function ($code) {
                    return [
                        'label' => Yii::$app->params['availableLocales'][$code],
                        'url' => ['/site/set-locale', 'locale'=>$code],
                        'active' => Yii::$app->language === $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ]
        ]
    ]); ?>
    <?php NavBar::end(); ?>

    <?php echo $content ?>

</div>

<footer class="footer" >
<div class="container" style="text-shadow: 0 0 2px #b7b7b7;">
    <?php 
    $cpright = Yii::$app->keyStorage->get('frontend.copyright',  'LQSIC');
    $pwdby   = Yii::$app->keyStorage->get('frontend.poweredby',  'LQSIC');
    $icpreg  = Yii::$app->keyStorage->get('frontend.icp-reg-no', '');
    $gapreg  = Yii::$app->keyStorage->get('frontend.ga-reg-no',  '');  $garegNo = preg_replace('/\D/s', '', $gapreg);
    $conQQ   = Yii::$app->keyStorage->get('frontend.contact.qq', '');  $conQQNo = preg_replace('/ /s',  '', $conQQ);
    $conTEL  = Yii::$app->keyStorage->get('frontend.contact.tel','');
    ?>
    <span class="pull-left">
      <i class="fa fa-copyright" aria-hidden="true"></i> <?=$cpright .' '. date('Y') ?>. <!-- Powered by <?=$pwdby?>. --> 
      <?php if($conQQ || $conTEL){ ?>
          <span class="">联系我们&nbsp;
          <?php if($conTEL){ ?><i class="fa fa-phone-square" aria-hidden="true"></i> <?=$conTEL?> &nbsp; <?php }?>
          <?php if($conQQ){  ?><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$conQQNo?>&site=qq&menu=yes" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i> <?=$conQQ?></a> <?php }?>
      <?php }?>
      </span>
    </span>
   <span class="pull-right" style="font-size:.85em;">
       <a target="_blank" href="http://www.miitbeian.gov.cn/"> <?=$icpreg ?></a><?=$icpreg ? ' | ' : ''?>
       <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?=$garegNo?>"><?=$gapreg?></a>
   </span>
</div>
</footer>
<?php $this->endContent() ?>