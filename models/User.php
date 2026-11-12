<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $mail
 * @property string $password
 * @property string|null $auth_key
 * @property int $role_id
 * @property int|null $year_goal
 * @property string $created_at
 *
 * @property Book[] $books
 * @property Note[] $notes
 * @property Role $role
 * @property UserBook[] $userBooks
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'last_name', 'mail', 'password'], 'required'],
            [['role_id'], 'integer'],
            [['year_goal'], 'integer', 'min' => 1, 'max' => 999],
            [['created_at'], 'safe'],
            [['name', 'last_name', 'mail', 'password'], 'string', 'max' => 255],
            [['mail'], 'email'],
            [['mail'], 'unique'],
            [['auth_key'], 'string', 'max' => 32],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'mail' => 'Почта',
            'password' => 'Пароль',
            'auth_key' => 'Ключ входа',
            'role_id' => 'Роль',
            'year_goal' => 'Цель на год (книг)',
            'created_at' => 'Дата регистрации',
        ];
    }

    // ==========================================
    // МЕТОДЫ ИНТЕРФЕЙСА IdentityInterface
    // (Обязательны для авторизации в Yii2)
    // ==========================================

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key !== null && $this->auth_key === $authKey;
    }

    public static function findByMail($mail)
    {
        return static::findOne(['mail' => $mail]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function isAdmin()
    {
        return (int)$this->role_id === 2;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        // Генерация auth_key при создании
        if ($insert && !$this->auth_key) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        // Хэширование пароля
        if ($this->isAttributeChanged('password') && strpos($this->password, '$2y$') !== 0) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        
        return true;
    }

    // ==========================================
    // СВЯЗИ (RELATIONS)
    // ==========================================

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('user_book', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Notes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * Gets query for [[UserBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBooks()
    {
        return $this->hasMany(UserBook::className(), ['user_id' => 'id']);
    }
}