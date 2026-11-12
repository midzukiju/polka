<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $status
 *
 * @property UserBook[] $userBooks
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['status'], 'required'],
        [['status'], 'string', 'max' => 255],
        [['status'], 'unique'],
    ];
}

public function attributeLabels()
{
    return ['id' => 'ID', 'status' => 'Статус'];
}

    /**
     * Gets query for [[UserBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBooks()
    {
        return $this->hasMany(UserBook::className(), ['status_id' => 'id']);
    }
}
