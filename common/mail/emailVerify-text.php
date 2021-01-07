<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Здравствуйте, <?= $user->email ?>,

Пожалуйста, перейдите по ссылке для подтверждения Вашего e-mail:

<?= $verifyLink ?>
