<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $name;
    public $last_name;
    public $mail;
    public $year_goal;

    public function __construct(User $user, $config = [])
    {
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->mail = $user->mail;
        $this->year_goal = $user->year_goal ?: 12;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'last_name', 'mail', 'year_goal'], 'required'],
            [['name', 'last_name', 'mail'], 'trim'],
            [['name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            ['mail', 'string', 'max' => 255],
            ['mail', 'email'],
            [
                'mail', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'mail',
                'filter' => ['<>', 'id', Yii::$app->user->id],
                'message' => 'Эта почта уже занята',
            ],
            ['year_goal', 'integer', 'min' => 1, 'max' => 999, 'tooSmall' => 'Цель — число не меньше 1', 'tooBig' => 'Цель не больше 999'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'mail' => 'Email',
            'year_goal' => 'Цель на год (книг)',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne(Yii::$app->user->id);
        $user->name = $this->name;
        $user->last_name = $this->last_name;
        $user->mail = $this->mail;
        $user->year_goal = (int)$this->year_goal;

        return $user->save(false);
    }
}
