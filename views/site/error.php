<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$code = isset($exception->statusCode) ? $exception->statusCode : 500;
$titles = [
    400 => 'Неверный запрос',
    403 => 'Нет доступа',
    404 => 'Такой страницы нет',
    500 => 'Ошибка сервера',
];
$title = isset($titles[$code]) ? $titles[$code] : 'Что-то пошло не так';
$this->title = $code . ' — Полка';
?>
<div class="container">
    <section class="section section--first">
        <h1><?= (int)$code ?></h1>
        <h2><?= Html::encode($title) ?></h2>
        <p><a class="btn btn--primary" href="<?= \yii\helpers\Url::to(['site/index']) ?>">На главную</a></p>
    </section>
</div>