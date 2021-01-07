<?php

use frontend\mails;

/* @var $this yii\web\View */
/* @var $user frontend\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/email-confirm', 'token' => $user->verification_token]);
?>
<p>Здравствуйте!</p>
<p>Вы зарегистрировались на сайте <?=Yii::$app->name?></p>
<p>Для подтверждения аккаунта, пожалуйста перейдите по <a href="<?= $confirmLink ?>">ссылке</a></p>

<p>Если Вы не регистрировались на сайте, то, пожалуйста, проигнорируйте это письмо.</p>

<p>С уважением, Межрегиональный центр
    развития профессионального
    медицинского образования</p>


