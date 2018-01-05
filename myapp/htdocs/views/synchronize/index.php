<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPidana */
/* @var $form yii\widgets\ActiveForm */
// $this->title = Yii::t('rbac-admin', 'Roles');
// $this->params['breadcrumbs'][] = $this->title;
?>


<section class="content" style="padding: 0px;margin-top: -3%">
    <div class="content-wrapper-1">
 <?php  $form = ActiveForm::begin([
                    'id' => 'synchronize-insert-setting-form',
                    'action' => '/synchronize/insert-setting',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]); 
    ?>
    <div class="box box-primary" style="border-color: #03b062;padding: 15px 15px 70px 15px;">
        <div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-2"><input class="simple" id='send_method' type="radio" name='send_method' value='1'checked='checked'> Jam</label>
                    <div class="col-md-4">
                       <?php 
                       $get_time = Yii::$app->db->createCommand(" select * from public.sync_schedule order by sync_id Desc limit 1")->queryAll();
                         $query = Yii::$app->db->createCommand(" select * from public.sync_schedule order by sync_id Desc limit 1")->queryScalar();
                            if($query>0)
                                {
                                  $time         = $get_time[0]['time_of_sync'];
                                  $timezones    = $get_time[0]['time_zones'];
                                }
                                else
                                {
                                    $time = '16:00:00';
                                    $timezones    = 1;
                                }
                            echo TimePicker::widget([
                                'name'  => 'time_of_sync',
                                'value' =>  $time,
                                'pluginOptions' => [
                                    'showSeconds' => true,
                                    'showMeridian' => false,
                                    'minuteStep' => 1,
                                    'secondStep' => 5,
                                ]
                            ]);
                         ?>
                    </div>
                    <div class="col-md-4">
                    <select class="form-control" name='timezones'>
                        <option value=""> -- Pilih Time Zone -- </option>
                        <option <?php if($timezones==1) {echo 'selected="selected"';} ?> value="1"> WIB </option>
                        <option <?php if($timezones==2){echo 'selected="selected"';} ?> value="2"> WITA </option>
                        <option <?php if($timezones==3){echo 'selected="selected"';} ?> value="3"> WIT </option>
                    </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="padding-top: 10px">
            <div class="col-md-10">
                <div class="form-group">
                   <label class=" col-md-2"><input class='simple' id='send_method2' type="radio" name='send_method' value='2'> Sekarang</label>
                   <label class="control-label col-md-2"><input class='freeze simple' id='pidum_checkbox' type="checkbox" name='pidum_checkbox' value='1'> Pidum </label>
                   <label class="control-label col-md-2"><input class='freeze simple' id='datun_checkbox' type="checkbox" name='datun_checkbox' value='2'> Datun </label>
                   <label class="control-label col-md-2"><input  class='freeze simple' id='was_checkbox' type="checkbox" name='was_checkbox' value='3'> Was </label>  
                   <div class="col-md-2">
                   <button   id="proses" type='button' class="btn btn-primary proses freeze"> Proses </button>
                   </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton('Simpan' , ['class' => 'btn btn-success','name'=>'actionButton','value'=>'Export']) ?>
        <!-- <input type="file" id="FileUpload" onchange="selectFolder(event)" webkitdirectory mozdirectory msdirectory odirectory directory multiple />
 -->
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</section>

