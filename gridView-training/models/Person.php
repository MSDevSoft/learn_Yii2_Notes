<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $client_company_id
 * @property string|null $person_name
 *
 * @property ClientCompany $clientCompany
 * @property User $user
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'client_company_id'], 'integer'],
            [['person_name'], 'string', 'max' => 255],
            [['client_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCompany::className(), 'targetAttribute' => ['client_company_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'client_company_id' => 'Client Company ID',
            'person_name' => 'Person Name',
        ];
    }

    /**
     * Gets query for [[ClientCompany]].
     *
     * @return \yii\db\ActiveQuery|ClientCompanyQuery
     */
    public function getClientCompany()
    {
        return $this->hasOne(ClientCompany::className(), ['id' => 'client_company_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }
}
