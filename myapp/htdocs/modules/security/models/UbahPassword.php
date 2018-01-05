<?php

namespace app\modules\security\models;
use Yii;
use yii\data\SqlDataProvider;

class UbahPassword extends \yii\db\ActiveRecord{
    public $parent_name;

    public static function tableName(){
        return 'mdm_user';
    }

    public function rules(){
        return [
            [['id_asalsurat'], 'required'],
            [['id_asalsurat'], 'string', 'max' => 32],
            [['nama'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['id_asalsurat'], 'unique']
        ];
    }

    public function attributeLabels(){
        return [
            'id_asalsurat' => 'Id Asalsurat',
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }

    public function simpanData($post){
		$connection 	= $this->db;
		$old = htmlspecialchars($post['oldpass'], ENT_QUOTES);
		$new = htmlspecialchars($post['newpass'], ENT_QUOTES);
		$enc = Yii::$app->getSecurity()->generatePasswordHash($new);
		$transaction = $connection->beginTransaction();
		try {
			$sql1 = "update mdm_user set password_hash = '".$enc."' where id = '".Yii::$app->user->identity->id."'";
			$connection->createCommand($sql1)->execute();
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }

    public function cekPassword($post){
		$connection  = $this->db;
		$old = htmlspecialchars($post['q1'], ENT_QUOTES);
		$sql = "select password_hash from public.mdm_user where id = '".Yii::$app->user->identity->id."'";
		$row = $connection->createCommand($sql)->queryScalar();
		return Yii::$app->getSecurity()->validatePassword($old, $row);
	}

    public function resetPass($id){
		$connection  = $this->db;
		$idr = htmlspecialchars($id, ENT_QUOTES);
		$sql = "select username from public.mdm_user where id = '".$idr."'";
		$nmp = $connection->createCommand($sql)->queryScalar();
		$new = Yii::$app->getSecurity()->generatePasswordHash('kejaksaan');
		$kue = "update mdm_user set password_hash = '".$new."' where id = '".$idr."'";
		$res = $connection->createCommand($kue)->execute();
		return array('user'=>$nmp, 'hasil'=>$res);
	}

}
