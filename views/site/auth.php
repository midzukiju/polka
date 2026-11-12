<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $loginModel app\models\LoginForm */
/* @var $signupModel app\models\SignupForm */
/* @var $tab string */

$this->title = 'Вход и регистрация';
$isRegister = $tab === 'register';

$textField = function ($model, $attr, $id, $label, $type, $autocomplete, $placeholder = null) {
    $error = $model->getFirstError($attr);
    $input = Html::input($type, Html::getInputName($model, $attr), $model->$attr, [
        'class' => 'input',
        'id' => $id,
        'autocomplete' => $autocomplete,
        'placeholder' => $placeholder,
        'aria-invalid' => $error ? 'true' : null,
    ]);
    return '<div class="field' . ($error ? ' has-error' : '') . '">'
        . Html::label($label, $id)
        . $input
        . '<p class="field__error" data-error' . ($error ? '' : ' hidden') . '>' . Html::encode($error) . '</p>'
        . '</div>';
};

$passwordField = function ($model, $attr, $id, $label, $autocomplete, $describedBy = null) {
    $error = $model->getFirstError($attr);
    $input = Html::input('password', Html::getInputName($model, $attr), '', [
        'class' => 'input',
        'id' => $id,
        'autocomplete' => $autocomplete,
        'aria-describedby' => $describedBy,
        'aria-invalid' => $error ? 'true' : null,
    ]);
    $toggle = Html::button('Показать', [
        'class' => 'input-wrap__btn',
        'data-toggle-password' => true,
        'aria-controls' => $id,
        'aria-label' => 'Показать пароль',
    ]);
    return '<div class="field' . ($error ? ' has-error' : '') . '">'
        . Html::label($label, $id)
        . '<div class="input-wrap">' . $input . $toggle . '</div>'
        . '<p class="field__error" data-error' . ($error ? '' : ' hidden') . '>' . Html::encode($error) . '</p>'
        . '</div>';
};

$agreeError = $signupModel->getFirstError('agree');
?>
<section class="auth" aria-labelledby="auth-title">

    <div class="auth__aside">
        <img class="auth__photo" src="<?= Yii::getAlias('@web/image/hero.jpg') ?>" width="736" height="816" alt="Раскрытые книги, разложенные на ткани с цветочным узором">
        <div class="auth__aside-text">
            <p class="pill">Моя полка</p>
            <p class="auth__quote">Книги, к которым хочется возвращаться</p>
            <p>Оценки, заметки и избранное всегда под рукой.</p>
        </div>
    </div>

    <div class="auth__card box">
        <h1 id="auth-title">Добро пожаловать</h1>
        <p class="auth__lead">Войдите или создайте аккаунт, чтобы вести свою полку.</p>

        <div class="auth-tabs" role="tablist" aria-label="Вход или регистрация">
            <button class="auth-tabs__tab" type="button" role="tab" id="tab-login" aria-selected="<?= $isRegister ? 'false' : 'true' ?>" aria-controls="panel-login" tabindex="<?= $isRegister ? '-1' : '0' ?>" data-tab="login">Вход</button>
            <button class="auth-tabs__tab" type="button" role="tab" id="tab-register" aria-selected="<?= $isRegister ? 'true' : 'false' ?>" aria-controls="panel-register" tabindex="<?= $isRegister ? '0' : '-1' ?>" data-tab="register">Регистрация</button>
        </div>

        <div role="tabpanel" id="panel-login" aria-labelledby="tab-login"<?= $isRegister ? ' hidden' : '' ?>>
            <?= Html::beginForm(['site/login'], 'post', ['data-auth-form' => 'login', 'novalidate' => true]) ?>
                <?= $textField($loginModel, 'mail', 'login-email', 'Email', 'email', 'email', 'anna@mail.ru') ?>
                <?= $passwordField($loginModel, 'password', 'login-password', 'Пароль', 'current-password') ?>
                <div class="auth-row">
                    <label class="check">
                        <?= Html::activeCheckbox($loginModel, 'rememberMe', ['label' => null, 'id' => 'login-remember']) ?>
                        <span>Запомнить меня</span>
                    </label>
                    <a class="link-btn" href="#">Забыли пароль?</a>
                </div>
                <button class="btn btn--primary btn--block" type="submit">Войти</button>
            <?= Html::endForm() ?>
            <p class="auth__switch">Нет аккаунта? <button class="link-btn" type="button" data-switch-tab="register">Зарегистрироваться</button></p>
        </div>

        <div role="tabpanel" id="panel-register" aria-labelledby="tab-register"<?= $isRegister ? '' : ' hidden' ?>>
            <?= Html::beginForm(['site/signup'], 'post', ['data-auth-form' => 'register', 'novalidate' => true]) ?>
                <?= $textField($signupModel, 'name', 'reg-name', 'Имя', 'text', 'given-name', 'Анна') ?>
                <?= $textField($signupModel, 'last_name', 'reg-lastname', 'Фамилия', 'text', 'family-name', 'Ковалёва') ?>
                <?= $textField($signupModel, 'mail', 'reg-email', 'Email', 'email', 'email', 'anna@mail.ru') ?>
                <?= $passwordField($signupModel, 'password', 'reg-password', 'Пароль', 'new-password', 'reg-password-hint') ?>
                <p class="field__hint auth-hint" id="reg-password-hint">Не короче 8 символов, с буквой и цифрой</p>
                <?= $passwordField($signupModel, 'password2', 'reg-password2', 'Повторите пароль', 'new-password') ?>
                <div class="field<?= $agreeError ? ' has-error' : '' ?>">
                    <label class="check">
                        <?= Html::activeCheckbox($signupModel, 'agree', ['label' => null, 'id' => 'reg-agree']) ?>
                        <span>Я согласна на обработку персональных данных</span>
                    </label>
                    <p class="field__error" data-error<?= $agreeError ? '' : ' hidden' ?>><?= Html::encode($agreeError) ?></p>
                </div>
                <button class="btn btn--primary btn--block" type="submit">Создать аккаунт</button>
            <?= Html::endForm() ?>
            <p class="auth__switch">Уже есть аккаунт? <button class="link-btn" type="button" data-switch-tab="login">Войти</button></p>
        </div>
    </div>

</section>
