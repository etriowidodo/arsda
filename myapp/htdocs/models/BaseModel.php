<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models;

use Yii;
use app\models\MsSifatSurat;
use yii\db\Query;

class BaseModel extends \yii\db\ActiveRecord{

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {

            if($this->isNewRecord)
			{
				$this->created_time=date('Y-m-d H:i:s');
				$this->created_by=\Yii::$app->user->identity->peg_nip;
				//$this->updated_by=\Yii::$app->user->identity->peg_nip;
				$this->updated_time = date('Y-m-d H:i:s');
                $this->created_ip = \Yii::$app->getRequest()->getUserIP();
                               
			}
			else{
				$this->updated_by=\Yii::$app->user->identity->peg_nip;
				$this->updated_time=date('Y-m-d H:i:s');
                                $this->updated_ip = \Yii::$app->getRequest()->getUserIP();
                        }
		

            return true;
        }
        else
            return false;
    } 

    public function getSifatSurat()
    {
        return $this->hasOne(MsSifatSurat::className(), ['id' => 'sifat']);
    }
}