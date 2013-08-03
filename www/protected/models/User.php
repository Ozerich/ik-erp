<?php

class User extends CActiveRecord
{
    public $full_name;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return array(
            array('email, password, name, surname', 'required'),
            array('last_login', 'safe'),
        );
    }

    public function relations()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'last_login' => 'Дата последнего входа',
        );
    }

    public function validatePassword($password)
    {
        return $this->password == $password;
    }

    public function afterFind()
    {
        $this->full_name = $this->name . ' ' . $this->surname;
    }
}