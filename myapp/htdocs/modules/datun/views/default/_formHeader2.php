<?php

use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\db\Query;

use kartik\builder\Form;
use app\models\MsSifatSurat;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
\dosamigos\ckeditor\CKEditorAsset::register($this);
?>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

    <div class="col-md-12 hide">
        <div class="form-group">
            <label class="control-label col-sm-2">Wilayah Kerja</label>
            <div class="col-sm-3">
                <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor</label>
            <div class="col-sm-3">
		
		<input type="text" id="pdmp19-no_surat" class="form-control" name="PdmP19[no_surat]" value="<?php echo $model->no_surat; ?>">
               
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Dikeluarkan</label>
            <div class="col-sm-3">
                <?php
                    if($model->isNewRecord){
                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                    }else{
                       echo $form->field($model, 'dikeluarkan');
                    } 
                ?>
            </div>
            <div class="col-sm-2">
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal dikeluarkan',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    <?php
        $connection = \Yii::$app->db;

        $route = substr(Yii::$app->request->url, 0, strrpos( Yii::$app->request->url, '/'));
        $query = $connection->createCommand("select default_kepada from pidum.pdm_sys_menu a inner join public.menu b on a.id_menu = b.id
                                                where b.route like '%$route/%'");

        $txtKepada = $query->queryOne();


        if($model['kepada'] == null){
            $value = $txtKepada['default_kepada'];
        }

        if(stripos($route, 'p21') !== FALSE){
            $id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_penyidik WHERE id_penyidik = '$spdp[id_penyidik]'")->queryOne();
            $value = "Kepala " . $instansiPenyidik['nama'];   
        }
    ?>
    <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-2" >Sifat</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'sifat')->dropDownList(
                    ArrayHelper::map(MsSifatSurat::find()->all(), 'id', 'nama'), 
                    ['prompt' => 'Pilih Sifat']) ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Kepada Yth.</label>
            <div class="col-sm-5"><?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $value]) ?></div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Lampiran</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'lampiran') ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Di</label>
            <div class="col-sm-3"><?= $form->field($model, 'di_kepada') ?></div>
        </div>
    </div>
</div>
