<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\modules\pengawasan\models;

use Yii;
class WasRecord extends \yii\db\ActiveRecord{

public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {


            
            //var_dump( $this->scenario );
            /*echo $this->getScenario();
            var_dump($this->scenario);exit();
            if(!($this->scenario == 'delete')) {
            //if($this->notbatchcreate == 'yes') {
                // преобразовать album -> album_id
                
            }else{
                $this->flag ='3';
            }
*/
            if($this->isNewRecord)
			{
				$this->created_time=date('Y-m-d H:i:s');
				$this->created_by=\Yii::$app->user->identity->id;
				$this->updated_by=\Yii::$app->user->identity->id;
				$this->updated_time = date('Y-m-d H:i:s');
                                $this->created_ip = \Yii::$app->getRequest()->getUserIP();
                                // $this->flag = '1';
                               
			}
			else{
				$this->updated_by=\Yii::$app->user->identity->id;
				$this->updated_time=date('Y-m-d H:i:s');
                                $this->updated_ip = \Yii::$app->getRequest()->getUserIP();
                        }
		

            return true;
        }
        else
            return false;
    } 
}