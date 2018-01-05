<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use app\models\MsSifatSurat;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT14 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class ="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 't14-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
                        ]
        );
        ?>
        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

    <div class="col-md-12 hide">
        <div class="form-group">
            <label class="control-label col-sm-2">Wilayah Kerja</label>
            <div class="col-sm-3" >
                <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
        </div>
    </div>




    <?php

    //CMS_PIDUM04_57 #default kepada Yth mengarah pada id penyidik SPDP 06 junni 2016
    if($model->kepada ==''){
        $connection = \Yii::$app->db;
    
            $id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
            $value1 = "Kepala ".$instansiPenyidik['nama'];
    }else{
        $value1 = $model->kepada;
    }

    ?>
    
    <div class="col-md-12">
          <div class="form-group">
          <label class="control-label col-sm-2" >Nomor</label>
            <div class="col-sm-3">
                 <?= $form->field($model, 'no_surat_t14')->textInput()  ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Kepada Yth.</label>
            <div class="col-sm-4" style="width:40%;"><?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $value1]) ?></div>
            
        </div>
    </div>
     <div class="col-md-12">
        <div class="form-group">            
        <label class="control-label col-sm-2" >Sifat</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'sifat')->dropDownList(
                    ArrayHelper::map(MsSifatSurat::find()->all(), 'id', 'nama'), ['options' =>  ['1'=>['Selected'=>true]]]) ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Di</label>
            <div class="col-sm-3"><?= $form->field($model, 'di_kepada') ?></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Lampiran</label>
            <div class="col-sm-3">
            <?php if($model->isNewRecord){
            ?>
                <?= $form->field($model, 'lampiran')->textInput(['value' => '-'])  ?>
            <?php } else { ?>
            <?= $form->field($model, 'lampiran')  ?>
        <?php   } ?>
            </div>
            
    </div>
</div>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2" >Nomor SP</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'no_pengadilan')->textInput()  ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2" >Tanggal SP</label>
            <div class="col-sm-3">
                <?php
                             echo $form->field($model, 'tgl_pengadilan')->widget(DateControl::classname(), [
                             'type'=>DateControl::FORMAT_DATE,
                             'ajaxConversion'=>false,
                             'options' => [
                             'pluginOptions' => [
                             'autoclose' => true
                                                    ]
                                                ]
                                            ]);

                                        ?>
            </div>
        </div>
    </div>
</div>


        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
            <label for="tersangka" class="control-label col-md-2">Jaksa</label>
                <div class="col-sm-4">
            <?php
                        echo $form->field($model, 'nip_jaksa')->dropDownList(
                                ArrayHelper::map($modeljaksi, 'nip', 'nama'), // Flat array ('id'=>'label')
                                ['prompt' => 'Pilih Jaksa', 'class' => 'cmb_jaksa']    // options
                        );
                        ?>
                </div>
            <?= $form->field($model, 'nama')->hiddenInput() ?>
            <?= $form->field($model, 'id_tersangka')->hiddenInput() ?>
                <label for="tersangka" class="control-label col-md-2">Terdakwa</label>
                <div class="col-sm-4">
                <?php
                        echo $form->field($model, 'no_reg_tahanan_jaksa')->dropDownList(
                                ArrayHelper::map($modelTerdakwa, 'no_reg_tahanan', 'nama'), // Flat array ('id'=>'label')
                                ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']    // options
                        );
                        ?>
                </div>
                <div id="data-terdakwa" class="col-md-12">
                    <?php
                    if (!empty($model->no_reg_tahanan_jaksa))
                        echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
                    ?>
                </div>

            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <span class="pull-right"><a class="btn btn-warning" id="btn_tambah_pertanyaan">Tambah</a></span>
                <h3 class="box-title">
                    Ciri-ciri
                </h3>
            </div>
            <table id="table_pertanyaan" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="40%">Ciri</th>
                        <th width="57%">Isi</th>
                        <th width="3%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tbody_pertanyaan">
                    <?php
                    if (!empty($ciri2->ciri)) {
                        for ($i=0; $i < count($ciri2->ciri); $i++) { 
                                ?>
                                <tr id="trtanyajawab">
                                    <td><input type="text" class="form-control" name="ciri[]" value="<?php echo $ciri2->ciri[$i]; ?>" > </td>
                                    <td><input type="text" class="form-control" name="isi[]" value="<?php echo $ciri2->isi[$i]; ?>" > </td>
                                    <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                                </tr>
                                <?php
                        }
                    }else{
                    ?>
                        <tr id="trtanyajawab">
                            <td><input type="text" class="form-control" name="ciri[]" value="" > </td>
                            <td><input type="text" class="form-control" name="isi[]" value="" > </td>
                            <td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>


 <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T14, 'id_table' => $model->no_surat_t14]) ?>
     
        <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) { ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t14/cetak?id_t14=' . $model->no_surat_t14]) ?>">Cetak</a>
        <?php } ?>
    </div>
      </div>
    <div id="hiddenId"></div>

    <?php ActiveForm::end(); ?>



    <?php
    $script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
                )
            });

            $('#btn_tambah_pertanyaan').click(function () {
            $('#tbody_pertanyaan').append(
                    '<tr>' +
                    '<td><input type="text" class="form-control" name="ciri[]" > </td>' +
                    '<td><input type="text" class="form-control" name="isi[]" > </td>' +
                    '<td><a class="btn btn-warning" id="btn_hapus_pertanyaan">Hapus</a></td>' +
                    '</tr>'
                    );

        });

        $(document).on('click', 'a#btn_hapus_pertanyaan', function () {
            $(this).parent().parent().remove();
            return false;
        });

            $('.cmb_terdakwa').change(function(){
                var id_tersangka = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '/pidum/pdm-t12/terdakwa',
                    data: 'no_reg_tahanan='+id_tersangka,
                    success:function(data){
                        console.log(data);
                        $('#data-terdakwa').html(
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                                '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                                '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                                '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                                '<div class="col-sm-4">'+data.alamat+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Agama</label>'+
                                '<div class="col-sm-4">'+data.agama+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Pekerjaan</label>'+
                                '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Pendidikan</label>'+
                                '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">No Regsiter Perkara</label>'+
                                '<div class="col-sm-4">'+data.no_register_perkara+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">No Regsiter Tahanan</label>'+
                                '<div class="col-sm-4">'+data.no_reg_tahanan+'</div>'+
                            '</div>'
                        );
                        
                        $('#pdmt14-nama').val(data.nama);
                        $('#pdmt14-id_tersangka').val(data.no_urut_tersangka);
                        
                        
                    }
                });
            });
JS;
    $this->registerJs($script);
    ?>      


</div>
</section>
