<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $model app\models\ProfileForm */
/* @var $stats array */
/* @var $recent app\models\UserBook[] */
/* @var $favorites app\models\UserBook[] */

$this->title = 'Личный кабинет — Полка';

$initials = mb_strtoupper(mb_substr($user->name, 0, 1) . mb_substr($user->last_name, 0, 1));
$fullName = $user->name . ' ' . $user->last_name;
$goal = max(1, (int)$model->year_goal);
$read = $stats['read'];
$percent = min(100, (int)round($read / $goal * 100));
$star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg>';

$cls = function ($attr) use ($model) {
    return $model->hasErrors($attr) ? 'field has-error' : 'field';
};
$err = function ($attr) use ($model) {
    $msg = $model->getFirstError($attr);
    return '<p class="field__error" data-error' . ($msg ? '' : ' hidden') . '>' . Html::encode($msg) . '</p>';
};
?>
<div class="container">

    <nav class="breadcrumbs breadcrumbs--desktop" aria-label="Хлебные крошки">
        <ol>
            <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
            <li aria-current="page">Личный кабинет</li>
        </ol>
    </nav>

    <h1 class="page-title page-title--mobile-hidden visually-hidden">Личный кабинет</h1>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <p class="flash flash--<?= Html::encode($type) ?>" role="status"><?= Html::encode($message) ?></p>
    <?php endforeach; ?>

    <div class="profile-layout">

        <aside class="box profile-aside" aria-label="Меню кабинета">
            <div class="profile-user">
                <span class="avatar" aria-hidden="true"><?= Html::encode($initials) ?></span>
                <div>
                    <p><strong><?= Html::encode($fullName) ?></strong></p>
                    <p class="small muted"><?= Html::encode($user->mail) ?></p>
                </div>
            </div>
            <nav aria-label="Разделы кабинета">
                <ul class="profile-menu">
                    <li><a href="<?= Url::to(['site/profile']) ?>" aria-current="page">Профиль</a></li>
                    <li><a href="<?= Url::to(['site/mybooks']) ?>">Мои книги <span class="menu-count"><?= $stats['total'] ?></span></a></li>
                    <li><a href="<?= Url::to(['site/favorites']) ?>">Избранное <span class="menu-count"><?= $stats['favorites'] ?></span></a></li>
                    <li>
                        <?= Html::beginForm(['site/logout'], 'post', ['class' => 'inline-form']) ?>
                        <button class="profile-menu__logout" type="submit">Выйти</button>
                        <?= Html::endForm() ?>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="profile-main">

            <section class="profile-hero" aria-labelledby="profile-title">
                <span class="avatar" aria-hidden="true"><?= Html::encode($initials) ?></span>
                <div>
                    <h2 id="profile-title"><?= Html::encode($fullName) ?></h2>
                    <p class="small muted">С нами с <?= Yii::$app->formatter->asDate($user->created_at, 'php:d.m.Y') ?></p>
                    <ul class="profile-stats">
                        <li><b><?= $stats['total'] ?></b><span>книг</span></li>
                        <li><b><?= $stats['read'] ?></b><span>прочитано</span></li>
                        <li><b><?= $stats['notes'] ?></b><span>заметок</span></li>
                        <li><b><?= $stats['favorites'] ?></b><span>избранное</span></li>
                    </ul>
                </div>
                <button class="btn btn--secondary" type="button" data-focus-target="#profile-name">Редактировать</button>
            </section>

            <?= Html::beginForm(['site/profile'], 'post', [
                'class' => 'box',
                'data-profile-form' => '',
                'data-read-count' => $read,
                'novalidate' => 'novalidate',
                'aria-labelledby' => 'personal-title',
            ]) ?>
            <div class="box__head"><h2 id="personal-title">Личные данные</h2></div>

            <div class="form-row">
                <div class="<?= $cls('name') ?>">
                    <label for="profile-name">Имя</label>
                    <?= Html::activeTextInput($model, 'name', ['id' => 'profile-name', 'class' => 'input', 'autocomplete' => 'given-name', 'maxlength' => 255]) ?>
                    <?= $err('name') ?>
                </div>
                <div class="<?= $cls('last_name') ?>">
                    <label for="profile-last-name">Фамилия</label>
                    <?= Html::activeTextInput($model, 'last_name', ['id' => 'profile-last-name', 'class' => 'input', 'autocomplete' => 'family-name', 'maxlength' => 255]) ?>
                    <?= $err('last_name') ?>
                </div>
            </div>

            <div class="<?= $cls('mail') ?>">
                <label for="profile-email">Email</label>
                <?= Html::activeInput('email', $model, 'mail', ['id' => 'profile-email', 'class' => 'input', 'autocomplete' => 'email', 'maxlength' => 255]) ?>
                <?= $err('mail') ?>
            </div>

            <div class="<?= $cls('year_goal') ?>">
                <label for="profile-goal">Цель на год (книг)</label>
                <?= Html::activeInput('number', $model, 'year_goal', ['id' => 'profile-goal', 'class' => 'input', 'min' => 1, 'max' => 999, 'inputmode' => 'numeric', 'aria-describedby' => 'goal-text']) ?>
                <?= $err('year_goal') ?>
                <div class="progress" role="progressbar" aria-label="Прогресс цели на год" aria-valuemin="0" aria-valuenow="<?= min($read, $goal) ?>" aria-valuemax="<?= $goal ?>" data-goal-meter>
                    <span class="progress__bar" data-goal-bar style="width: <?= $percent ?>%"></span>
                </div>
                <p class="field__hint" id="goal-text" data-goal-text>Прочитано <?= $read ?> из <?= $goal ?><?= $goal > $read ? ' · осталось ' . ($goal - $read) : ' · цель достигнута' ?></p>
            </div>

            <div class="form-actions">
                <button class="btn btn--primary" type="submit">Сохранить изменения</button>
                <a class="btn btn--ghost" href="<?= Url::to(['site/index']) ?>">Отмена</a>
            </div>
            <?= Html::endForm() ?>

            <section class="box" aria-labelledby="recent-title">
                <div class="box__head">
                    <h2 id="recent-title">Последние прочитанные</h2>
                    <a class="link-btn" href="<?= Url::to(['site/mybooks', 'status' => 'read']) ?>">Все книги</a>
                </div>
                <?php if ($recent): ?>
                    <ul>
                        <?php foreach ($recent as $ub): ?>
                            <?php
                            $b = $ub->book;
                            $rating = (int)$ub->rating;
                            $url = Url::to(['site/book', 'id' => $b->id]);
                            ?>
                            <li class="read-item">
                                <span class="read-item__cover" aria-hidden="true"><span class="cover--<?= ($b->id % 8) + 1 ?>"></span></span>
                                <div class="read-item__text">
                                    <a class="read-item__title" href="<?= $url ?>"><?= Html::encode($b->name) ?></a>
                                    <p class="small muted"><?= Html::encode($b->author) ?></p>
                                    <span class="stars" role="img" aria-label="<?= $rating ? 'Оценка ' . $rating . ' из 5' : 'Оценки пока нет' ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span<?= $i <= $rating ? ' class="is-on"' : '' ?>><?= $star ?></span>
                                        <?php endfor; ?>
                                    </span>
                                </div>
                                <a class="btn btn--secondary btn--sm" href="<?= $url ?>">Открыть</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="empty-text">Прочитанных книг пока нет.</p>
                <?php endif; ?>
            </section>

            <section class="box" aria-labelledby="favorites-title">
                <div class="box__head">
                    <h2 id="favorites-title">Избранное</h2>
                    <a class="link-btn" href="<?= Url::to(['site/favorites']) ?>">Смотреть всё</a>
                </div>
                <?php if ($favorites): ?>
                    <ul class="book-grid book-grid--three">
                        <?php foreach ($favorites as $ub): ?>
                            <li><?= $this->render('_book_card', ['model' => $ub]) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="empty-text">В избранном пока пусто.</p>
                <?php endif; ?>
            </section>

        </div>
    </div>
</div>
