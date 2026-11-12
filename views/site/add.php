<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AddBookForm */
/* @var $genres array */

$this->title = 'Добавить книгу — Полка';

$addError = function ($attr) use ($model) {
    $msg = $model->getFirstError($attr);
    return '<p class="field__error" data-error' . ($msg ? '' : ' hidden') . '>' . Html::encode($msg) . '</p>';
};

$cls = function ($attr) use ($model) {
    return $model->hasErrors($attr) ? 'field has-error' : 'field';
};
$isRead = $model->status === 'read';
?>
<div class="container">

    <nav class="breadcrumbs breadcrumbs--desktop" aria-label="Хлебные крошки">
        <ol>
            <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
            <li><a href="<?= Url::to(['site/mybooks']) ?>">Мои книги</a></li>
            <li aria-current="page">Добавить книгу</li>
        </ol>
    </nav>

    <h1 class="page-title page-title--mobile-hidden visually-hidden">Добавить книгу</h1>

    <div class="add-layout">
        <section class="add-main" aria-labelledby="add-form-title">
            <?= Html::beginForm(['site/add'], 'post', ['class' => 'box add-form', 'data-add-form' => '', 'novalidate' => 'novalidate']) ?>
            <div class="box__head"><h2 id="add-form-title">Информация о книге</h2></div>

            <div class="<?= $cls('title') ?>">
                <label for="book-title">Название *</label>
                <?= Html::activeTextInput($model, 'title', ['id' => 'book-title', 'class' => 'input', 'maxlength' => 120, 'autocomplete' => 'off', 'placeholder' => 'Например, Мастер и Маргарита']) ?>
                <?= $addError('title') ?>
            </div>

            <div class="<?= $cls('author') ?>">
                <label for="book-author">Автор *</label>
                <?= Html::activeTextInput($model, 'author', ['id' => 'book-author', 'class' => 'input', 'maxlength' => 80, 'autocomplete' => 'off', 'placeholder' => 'Например, М. Булгаков']) ?>
                <?= $addError('author') ?>
            </div>

            <div class="form-row">
                <div class="<?= $cls('genre_id') ?>">
                    <label for="book-genre">Полка / жанр *</label>
                    <?= Html::activeDropDownList($model, 'genre_id', $genres, ['id' => 'book-genre', 'class' => 'input input--select', 'prompt' => 'Выберите жанр']) ?>
                    <?= $addError('genre_id') ?>
                </div>
                <div class="<?= $cls('year') ?>">
                    <label for="book-year">Год издания</label>
                    <?= Html::activeInput('number', $model, 'year', ['id' => 'book-year', 'class' => 'input', 'inputmode' => 'numeric', 'min' => 1000, 'max' => 2100, 'placeholder' => '1967']) ?>
                    <?= $addError('year') ?>
                </div>
            </div>

            <div class="form-row">
                <div class="<?= $cls('pages') ?>">
                    <label for="book-pages">Количество страниц</label>
                    <?= Html::activeInput('number', $model, 'pages', ['id' => 'book-pages', 'class' => 'input', 'inputmode' => 'numeric', 'min' => 1, 'max' => 9999, 'placeholder' => '480']) ?>
                    <?= $addError('pages') ?>
                </div>
            </div>

            <fieldset class="fieldset">
                <legend>Статус</legend>
                <div class="choice-list">
                    <label class="choice">
                        <input type="radio" name="AddBookForm[status]" value="want"<?= $isRead ? '' : ' checked' ?>>
                        <span>В планах</span>
                    </label>
                    <label class="choice">
                        <input type="radio" name="AddBookForm[status]" value="read"<?= $isRead ? ' checked' : '' ?>>
                        <span>Прочитано</span>
                    </label>
                </div>
            </fieldset>

            <div class="field" data-rating-field<?= $isRead ? '' : ' hidden' ?>>
                <span class="field__label">Моя оценка</span>
                <div class="choice-list">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label class="choice">
                            <input type="radio" name="AddBookForm[rating]" value="<?= $i ?>"<?= (int)$model->rating === $i ? ' checked' : '' ?>>
                            <span><?= $i ?></span>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="field">
                <label for="book-desc">Описание</label>
                <?= Html::activeTextarea($model, 'description', ['id' => 'book-desc', 'class' => 'textarea', 'maxlength' => 1000, 'placeholder' => 'О чём эта книга…']) ?>
            </div>

            <div class="field">
                <label class="check">
                    <?= Html::activeCheckbox($model, 'favorite', ['label' => null, 'uncheck' => null]) ?>
                    <span>Добавить в избранное</span>
                </label>
            </div>

            <div class="form-actions">
                <button class="btn btn--primary" type="submit">Добавить книгу</button>
                <a class="btn btn--ghost" href="<?= Url::to(['site/mybooks']) ?>">Отмена</a>
            </div>
            <?= Html::endForm() ?>
        </section>

        <aside class="add-preview" aria-hidden="true">
            <div class="box add-preview__box">
                <p class="eyebrow">Так книга будет выглядеть</p>
                <div class="art art--1">
                    <div class="book-cover cover--1" data-preview-cover><span class="book-cover__title" data-preview-title>Название книги</span></div>
                </div>
                <p class="eyebrow" data-preview-genre>Жанр</p>
                <p class="add-preview__title" data-preview-name>Название книги</p>
                <p class="small muted" data-preview-author>Автор</p>
            </div>
        </aside>
    </div>
</div>
