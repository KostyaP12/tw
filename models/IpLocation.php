<?php

namespace app\models;

use yii\db\ActiveRecord;

class IpLocation extends ActiveRecord {
    public static function tableName()
    {
        return 'ip_locations';
    }

    public function rules()
    {
        return [
            [['ip_address'], 'required'],
            [['ip_address'], 'ip'],
        ];
    }
}