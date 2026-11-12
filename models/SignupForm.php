<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $name;
    public $last_name;
    public $mail;
    public $password;
    public $password2;
    public $agree;

    public function rules()
    {
        return [
            [['name', 'last_name', 'mail', 'password', 'password2'], 'required'],
            [['name', 'last_name', 'mail'], 'string', 'max' => 255],
            ['name', 'string', 'min' => 2],
            ['mail', 'email'],
            ['mail', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'mail', 'message' => 'Эта почта уже зарегистрирована'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Za-zА-Яа-яЁё])(?=.*\d).+$/u', 'message' => 'Минимум 8 символов, буква и цифра'],
            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['agree', 'compare', 'compareValue' => 1, 'operator' => '==', 'message' => 'Нужно ваше согласие', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'mail' => 'Email',
            'password' => 'Пароль',
            'password2' => 'Повторите пароль',
            'agree' => 'Согласие на обработку данных',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->name = $this->name;
        $user->last_name = $this->last_name;
        $user->mail = $this->mail;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->role_id = 1;

        return $user->save() ? $user : null;
    }
}
