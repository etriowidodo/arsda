<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmTemplateTembusan;
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;

?>

<?php
$form = ActiveForm::begin(
    [
        'id' => 'T11-form',
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
    ]);
?>
<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
    <div class="row" style="height: 45px">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor Surat T-11</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'no_surat_t11') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        
        
        

        <div class="col-md-12 hide">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal S.P Penahanan</label>
                    <div class="col-md-8">
                    <?= $form->field($model, 'tgl_sp_penahanan')->widget(DateControl::className(),[
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]); ?> 
                </div>
            </div>
            </div>
        </div> 

        <div class="col-md-12 hide">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor S.P Penahanan</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'no_sp_penahanan') ?>
                </div>
            </div>
            </div>
        </div>
    
    <div class="row hide" style="height: 45px" >
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Dokter Pemeriksa</label>
                    <div class="col-md-8">  
                         <?// $form->field($model, 'dokter') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat Pemeriksaan</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'tempat_periksa') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row hide" style="height: 45px">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat Pemeriksaan</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'tempat_periksa') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat RS</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'tempat_rs') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row hide" style="height: 45px">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Pemeriksaan</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'tgl_pemeriksaan')->widget(DateControl::className(),[
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Dasar</label>
                    <div class="col-md-8">  
                         <?// $form->field($model, 'dasar')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            </div>
        </div>-->
</div>

<div class="box box-primary" style="border-color: #f39c12">
    <div style="border-color: #c7c7c7;" class="box-header with-border">
        <h3 class="box-title">
            <strong>Dasar</strong>
        </h3>
    </div>
    <div style="border-color: #c7c7c7;" class="box-header">
        <div class="col-md-6" style="padding: 0px;">
            <h3 class="box-title">
                <a class='btn btn-danger delete hapus hapusSurat'></a>
                &nbsp;
                <a class="btn btn-primary tambah_memperhatikan">+ Dasar</a>
            </h3>
        </div>
    </div>
    <div class="box-header with-border">
        <table id="table_grid_surat" class="table table-bordered table-striped">
            <thead>
                <th></th>
                <th style="width: 97%">Dasar</th>
            </thead>
            <tbody id="tbody_grid_surat">
                <?php if(!$model->isNewRecord){ ?>
                    <?php foreach($dasar1 as $value): ?>
                    <tr>
                        <td style="height: 70px"></td>
                        <td width="20%"><textarea name="txt_nama_surat[]" id=""  type='textarea' class='form-control'><?=$value?></textarea></td>
                    </tr>
                    <?php endforeach; ?>
                <?php }else{ ?>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat[]" id=""  type='textarea' class='form-control'>Surat Perintah Penahanan Kepala .........&#13;&#10;Tanggal ........ Nomor .........</textarea></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat[]" id="" type='textarea' class='form-control'></textarea></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12">
    <div style="border-color: #c7c7c7;" class="box-header with-border">
        <h3 class="box-title">
            <strong>Pertimbangan</strong>
        </h3>
    </div>
    <div style="border-color: #c7c7c7;" class="box-header">
        <div class="col-md-6" style="padding: 0px;">
            <h3 class="box-title">
                <a class='btn btn-danger delete hapus hapusSurat1'></a>
                &nbsp;
                <a class="btn btn-primary tambah_memperhatikan1">+ Pertimbangan</a>
            </h3>
        </div>
    </div>
    <div class="box-header with-border">
        <table id="table_grid_surat1" class="table table-bordered table-striped">
            <thead>
                <th></th>
                <th style="width: 97%">Pertimbangan</th>
            </thead>
            <tbody id="tbody_grid_surat1">
                <?php if(!$model->isNewRecord){ ?>
                <?php foreach($dasar2 as $value): ?>
                    <tr>
                        <td style="height: 70px"></td>
                        <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'><?=$value?></textarea></td>
                    </tr>
                    <?php endforeach; ?>
                <?php }else{ ?>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'>Hasil pemeriksaan kesehatan tersangka/terdakwa yang dibuat oleh dokter ........... (Lembaga) ........... (Kejaksaan) ........... (Puskesmas).</textarea></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat1[]" id="" type='textarea' class='form-control'>Permintaan Penyidik/Penuntut Umum.</textarea></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12">
    <div style="border-color: #c7c7c7;" class="box-header with-border">
        <h3 class="box-title">
            <strong>TERSANGKA</strong>
        </h3>
    </div>
    <div class="row" style="height: 45px">
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-4">Nama</label>
                    <div class="col-sm-8">
                        <?php

                            // print_r($modeltsk);
                         echo $form->field($model, 'id_tersangka')->dropDownList(
                                ArrayHelper::map($modeltsk,'no_urut_tersangka', 'nama'), 
                                ['prompt' => 'Pilih Tahanan']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12">
    <div style="border-color: #c7c7c7;" class="box-header with-border">
        <h3 class="box-title">
            <strong>Untuk</strong>
        </h3>
    </div>
    <div style="border-color: #c7c7c7;" class="box-header">
        <div class="col-md-6" style="padding: 0px;">
            <h3 class="box-title">
                <a class='btn btn-danger delete hapus hapusSurat2'></a>
                &nbsp;
                <a class="btn btn-primary tambah_memperhatikan2">+ Untuk</a>
            </h3>
        </div>
    </div>
    <div class="box-header with-border">
        <table id="table_grid_surat2" class="table table-bordered table-striped">
            <thead>
                <th></th>
                <th style="width: 97%">Untuk</th>
            </thead>
            <tbody id="tbody_grid_surat2">
                <?php if(!$model->isNewRecord){ ?>
                    <?php foreach($dasar3 as $value): ?>
                    <tr>
                        <td style="height: 70px"></td>
                        <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'><?=$value?></textarea></td>
                    </tr>
                    <?php endforeach; ?>
                <?php }else{ ?>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'>Memeriksa kesehatan tahanan  ke Rumah sakit .......... dan/atau spesialis ........... pada tanggal ..........</textarea></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat2[]" id="" type='textarea' class='form-control'>Mengembalikan tahanan tersebut ketempat tahanan segera setelah selesai pemeriksaan.</textarea></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                    <td width="20%"><textarea name="txt_nama_surat2[]" id="" type='textarea' class='form-control'>Membuat Berita Acara Pelaksanaan Surat Perintah ini.</textarea></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
    <div style="border-color: #c7c7c7;" class="box-header with-border">
        <h3 class="box-title">
            <strong>Petugas Jaksa</strong>
        </h3>
    </div>
    <br/>
    <div class="row" style="height: 45px">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <?php
                if ($model->isNewRecord) {?>
                <div class="form-group field-pdmjaksasaksi-nama required">
                    <label class="control-label col-md-4">Petugas Kejaksaan</label>
                    <div class="input-group">
                        <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                        <div class="input-group-btn">
                            <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                        </div>
                    </div>
                </div>
                <?php
                    } else {
                ?>
                    <div class="form-group field-pdmjaksasaksi-nama required">
                        <label class="control-label col-md-4">Petugas Kejaksaan</label>
                            <div class="input-group">
                                <input value ="<?= $modelpeg['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                </div>
                            </div>
                            <?php
                            echo $form->field($modelpeg, 'peg_nip_baru')->hiddenInput();
                            ?>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12">
                            <div class="help-block"></div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    
    </div>
</div>

<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
    <div class="row" style="height: 45px">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Dikeluarkan</label>
                    <div class="col-sm-8">
                        <?php
                            if($model->isNewRecord){
                               echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                            }else{
                               echo $form->field($model, 'dikeluarkan');
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="row" style="height: 45px">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Dikeluarkan</label>
                    <div class="col-md-8">  
                         <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T11, 'id_table' => $model->no_surat_t11]) ?>
    
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord ): ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-t11/cetak?no_surat_t11='.rawurlencode($model->no_surat_t11)]) ?>">Cetak</a>
        <?php endif ?>
        <?php
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', null, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_t11]', null, ['id' => 'pdmjaksasaksi-no_surat_t11']);
            echo Html::hiddenInput('PdmJaksaSaksi[peg_nip_baru]', null, ['id' => 'pdmjaksasaksi-peg_nip_baru']);
            echo Html::hiddenInput('PdmJaksaSaksi[gol_pangkat2]', null, ['id' => 'pdmjaksasaksi-gol_pangkat2']);
        ?>	
 
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pdsold/p16/jpu');
        $('#m_jpu').modal('show');
	});
        
        $( "#pdmt11-id_tersangka" ).change(function() {
            var nama    = $('#pdmt11-id_tersangka').find('option:selected').text();
            var tex1    = 'Memeriksa kesehatan tahanan a.n '+nama+' ke Rumah sakit .......... dan/atau spesialis ........... pada tanggal ..........';
            
                $('textarea[name="txt_nama_surat2[]"]:eq(0)').val(tex1);
                //alert(tex1);
        });
        
        var id=1;
	$('.tambah_memperhatikan').on('click', function() {
		$("#table_grid_surat > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check[]' class='hapusSuratCheck'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        var id=1;
	$('.tambah_memperhatikan1').on('click', function() {
		$("#table_grid_surat1 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat1[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat1').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check1[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        var id=1;
	$('.tambah_memperhatikan2').on('click', function() {
		$("#table_grid_surat2 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat2[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat2').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check2[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});

    
    $('.cmb_terdakwa').change(function(){

        $.ajax({
            type: "POST",
            url: '/pdsold/pdm-ba12/terdakwa',
            data: 'id_tersangka='+$('.cmb_terdakwa').val(),
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
                    '</div>'
                );
                $('.no_reg_tahanan').val(data.no_reg_tahanan);

                var tglawal = new Date(data.ditahan_sejak);
                console.log(tglawal);
                function pad(s) {
                    return (s < 10) ? '0' + s : s;
                }
                var tgl = [pad(tglawal.getDate()), pad(tglawal.getMonth() + 1), tglawal.getFullYear()].join('-');
                var tgl2 = [tglawal.getFullYear(), pad(tglawal.getMonth() + 1), pad(tglawal.getDate())].join('-');
                console.log(tgl);
                console.log(tgl2);
                $("#pdmba12-tgl_penahanan-disp").val(tgl);
                $("#pdmba12-tgl_penahanan").val(tgl2);
            }
        });
    });
JS;
$this->registerJs($script1);
?>


<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Petugas Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>