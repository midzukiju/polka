<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerCssFile('@web/css/admin.css', ['depends' => [AppAsset::class]]);

$current = Yii::$app->controller->id;
$items = [
    'book' => 'Книги',
    'genre' => 'Жанры',
    'user' => 'Пользователи',
];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> — Админ-панель</title>
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<div class="admin">
    <aside class="admin__side">
        <div class="admin__top">
            <a class="admin__logo" href="<?= Url::to(['/site/index']) ?>">Полка</a>
            <p class="admin__label">Админ-панель</p>
        </div>

        <nav class="admin__nav" aria-label="Разделы админ-панели">
            <ul>
                <?php foreach ($items as $id => $label): ?>
                    <li>
                        <?= Html::a(
                            Html::encode($label),
                            ["/$id/index"],
                            ['class' => $current === $id ? 'is-active' : null]
                        ) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="admin__foot">
            <a href="<?= Url::to(['/site/index']) ?>">На сайт</a>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <button type="submit">Выйти</button>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </aside>

    <main class="admin__main">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
            'homeLink' => false,
        ]) ?>
        <?= $content ?>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
