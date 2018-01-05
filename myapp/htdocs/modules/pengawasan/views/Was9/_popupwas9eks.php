<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;

?>
<div class="modalContent">
 <?php $form = ActiveForm::begin([
        'id' => 'was9eks-popup-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options' =>[
            'enctype' => 'multipart/form-data',
            'onkeypress'=>" if(event.keyCode == 13){return false;}",
            'actions' => ($model->isNewRecord?Url::toRoute('was9/create'):Url::toRoute('was9/update')),
        ]
    ]); ?>

<div class="panel box box-primary" style="padding: 15px 0px;">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Nama</label>
                <div class="col-md-7 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'nama_saksi_eksternal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Tempat Lahir</label>
                <div class="col-md-7 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'tempat_lahir_saksi_eksternal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal Lahir</label>
                <div class="col-md-8 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'tanggal_lahir_saksi_eksternal',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startDate' => 0,
                            // 'endDate' => 0,
                        ]
                    ]
                ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Warganegara</label>
                <div class="col-md-7 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'id_negara_saksi_eksternal')->dropDownList(
                      ArrayHelper::map(MsWarganegara::find()->all(), 'id', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Negara']
                       );  
                     ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Agama</label>
                <div class="col-md-7 kejaksaan">
                      <?
                   echo $form->field($modelSaksiEksternal, 'id_agama_saksi_eksternal')->dropDownList(
                      ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Agama']
                       );  

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Pendidikan</label>
                <div class="col-md-7 kejaksaan">
                    <?//= $form->field($modelSaksiEksternal, 'pendidikan')->textInput(['maxlength' => true]) ?>
                      <?
                   echo $form->field($modelSaksiEksternal, 'pendidikan')->dropDownList(
                      ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Pendidikan']
                       );  

                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-1">Alamat</label>
                <div class="col-md-11 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'alamat_saksi_eksternal')->textArea(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Kota</label>
                <div class="col-md-7 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'nama_kota_saksi_eksternal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-5">Pekerjaan</label>
                <div class="col-md-7 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'pekerjaan_saksi_eksternal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>






</div>

       <?php ActiveForm::end(); ?>
       <button class="btn btn-primary" type="button" id="tambah_saksi">Simpan</button>
       <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button>
<?php 
                        
    // $searchModel = new app\modules\pengawasan\models\VRiwayatJabatan();
    // $dataProvider = $searchModel->searchPegawaiWas(Yii::$app->request->queryParams);


?>
       <?
       // = GridView::widget([
       //      'id'=>'was9saksiinternal-grid',
       //      'dataProvider'=> $dataProvider,
       //      'filterModel' => $searchModel,
       //      'layout' => "{items}\n{pager}",
       //      'columns' => [
       //          ['class' => 'yii\grid\SerialColumn'],
                
       //          'peg_nik',
       //          'peg_nip_baru',
       //          'peg_nama',
                            
       //         'gol_pangkat',
             
       //          'jabatan',
       //           [
       //              'class' => 'yii\grid\ActionColumn',
       //              'template' => '{pilih}',
       //              'buttons' => [
       //                  'pilih' => function ($url, $model,$key) use ($param){
       //                      return Html::button('Pilih', ['class' => 'btn btn-primary','onclick'=>'$("#tbody_was9_saksiinternal").append("<tr><td><input type=\"text\" name=\"peg_nama_saksiint[]\" value=\"'.$model['peg_nama'].'\" readonly=\"readonly\"></td><td><input type=\"text\" readonly=\"readonly\" name=\"peg_nip_saksiint[]\" value=\"'.$model['peg_nip_baru'].'\"></td><td><input type=\"text\" readonly=\"readonly\" name=\"peg_golpangkat_saksiint[]\" value=\"'.$model->gol_pangkat.'\"></td><td><input type=\"text\" readonly=\"readonly\" name=\"peg_jabatan_saksiint[]\" value=\"'.$model['jabatan'].'\"></td><td><input type=\"hidden\" name=\"peg_nik_saksiint[]\" readonly=\"readonly\" value=\"'.$model['peg_nik'].'\"><input type=\"hidden\" name=\"peg_id_saksiint[]\" readonly=\"readonly\" value=\"'.$model['id'].'\"><button type=\"button\"  class=\"removebutton btn btn-primary\">Hapus</button></td></tr>");$("#was9_saksiinternal").modal("hide")']);
       //                  },
       //              ]
       //          ],
               
       //      ],
       //      'export' => false,
       //      'pjax' => true,
       //      'responsive'=>true,
       //      'hover'=>true,
       //      'panel' => [
       //          'type' => GridView::TYPE_PRIMARY,
       //          'heading' => '<i class="glyphicon glyphicon-book"></i>',
       //      ],

       //      'pjaxSettings'=>[
       //          'options'=>[
       //              'enablePushState'=>false,
       //          ],
       //          'neverTimeout'=>true,
       //        //  'beforeGrid'=>['columns'=>'peg_nip'],
       //      ]

       //  ]); ?>    

</div>






