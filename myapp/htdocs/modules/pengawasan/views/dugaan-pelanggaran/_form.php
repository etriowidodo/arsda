<style>
#m_pelapor 
{
    margin-top: 70px !important;
} 
</style>
<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\grid\GridView;
use app\modules\pengawasan\models\Wilayah;
use app\modules\pengawasan\models\Inspektur;
use app\modules\pengawasan\models\SumberPengaduan;
use app\modules\pengawasan\models\Dokumen;
use app\modules\pengawasan\models\SumberPelapor;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\models\MsAgama;
use app\models\MsPendidikan;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->registerJs("
    $(document)  
  .on('show.bs.modal', '.modal', function(event) {
    $(this).appendTo($('body'));
  })
  .on('shown.bs.modal', '.modal.in', function(event) {
    setModalsAndBackdropsOrder();
  })
  .on('hidden.bs.modal', '.modal', function(event) {
    setModalsAndBackdropsOrder();
  });
 $.fn.modal.Constructor.DEFAULTS.backdrop = 'static';
function setModalsAndBackdropsOrder() {  
  var modalZIndex = 1040;
  $('.modal.in').each(function(index) {
    var modal = $(this);
    modalZIndex++;
    modal.css('zIndex', modalZIndex);
    modal.css('overflow', 'scroll');
    modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
 
});
  $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
   
} ", \yii\web\View::POS_END);
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php
    $form = ActiveForm::begin([
                'id' => 'dugaan-pelanggaran-form',
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





    <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3" style="margin-top:9px;">Kejaksaan</label>
                    <div class="col-md-9 kejaksaan">
                        <div class="input-group margin" style="margin: 10px 0px;">

                            <input id="inst_satkerkd" value="<?php echo $model->inst_satkerkd; ?>" class="form-control" type="hidden" maxlength="10" name="DugaanPelanggaran[inst_satkerkd]">
                            <input id="inst_nama" value="<?php echo KpInstSatker::find()->where(['inst_satkerkd' => $model->inst_satkerkd])->one()->inst_nama; ?>" class="form-control" type="text" maxlength="10" name="inst_nama">

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_kejaksaan" style="border:none;">Pilih</button>
                            </span>
                        </div>
                    </div>



                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Wilayah</label>
                    <div class="col-md-9 kejaksaan">
                        <div class="input-group margin" style="margin: 10px 0px;">

                            <input id="inst_satkerkd_laporan" value="<?php echo $model->inst_satkerkd; ?>" class="form-control" type="hidden" maxlength="10" name="DugaanPelanggaran[wilayah_laporan]">
                            <input id="inst_nama_laporan" value="<?php echo KpInstSatker::find()->where(['inst_satkerkd' => $model->inst_satkerkd])->one()->inst_nama; ?>" class="form-control" type="text" maxlength="10" name="wilayah_laporan">

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_kejaksaan_laporan" style="border:none;">Pilih</button>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		
		
			
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Inspektur</label>
                    <div class="col-md-9 kejaksaan">
                        <?=
                        $form->field($model, 'inspektur')->dropDownList(
                                ArrayHelper::map(Inspektur::find()->orderBy('nama_inspektur')->all(), 'id_inspektur', 'nama_inspektur'), ['prompt' => 'Pilih Inspektur',
                            'id' => 'cbInspektur',
                            'disabled' => 'disabled',
                                ]
                        )
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
      
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Kelompok Wilayah</label>
                    <div class="col-md-9 kejaksaan">
                        <?=
                        $form->field($model, 'wilayah')->dropDownList(
                                ArrayHelper::map(Wilayah::find()->orderBy('nm_wilayah')->all(), 'id_wilayah', 'nm_wilayah'), ['prompt' => 'Pilih Wilayah',
                            'id' => 'cbWilayah',
                            'disabled' => 'disabled',
                                ]
                        )
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

		
		<div class="col-md-12" id='div-wilayah-keterangan' style="display:none;">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-9 kejaksaan">
                        <?= $form->field($model, 'wilayah_keterangan')->textarea(['rows' => 2, 'id'=>'wilayah_keterangan', 'readonly'=>'readonly']) ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		
		
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Sumber</label>
                    <div class="col-md-9 kejaksaan">
                        <?=
                        $form->field($model, 'sumber_dugaan')->dropDownList(
                                ArrayHelper::map(SumberPengaduan::find()->all(), 'id_sumber_pengaduan', 'nm_sumber_pengaduan'), ['prompt' => 'Pilih Sumber']
                        )
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		
		
		<div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal Dugaan</label>
                    <div class="col-md-5 kejaksaan">
                        <?= $form->field($model, 'tgl_dugaan')->widget(DateControl::className(),[
							'type'=>DateControl::FORMAT_DATE,
							'ajaxConversion'=>false,
							'displayFormat' => 'dd-MM-yyyy',
							'options' => [
								
								'pluginOptions' => [
									
									'autoclose' => true,
									
								]
							],
							
							]); ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		

        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">No Surat</label>
                    <div class="col-md-3 kejaksaan">
                        <?= $form->field($model, 'no_register')->textInput(['maxlength' => true,]) ?>
                    </div>
                    <div class="col-md-6" style="padding: 0px 15px 0px 0px;">
					<label class="control-label col-md-4">Tanggal Surat</label>
					<div class="col-md-8 kejaksaan">
                        <span class="pull-right">
                            <?= $form->field($model, 'tgl_surat')->widget(DateControl::className(),[
							'type'=>DateControl::FORMAT_DATE,
							'ajaxConversion'=>false,
							'displayFormat' => 'dd-MM-yyyy',
							'options' => [
								
								'pluginOptions' => [
									
									'autoclose' => true,
									
								]
							],
							
							]); ?>
                        </span>
						</div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
            </div>

        </div>

        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Perihal</label>
                    <div class="col-md-9 kejaksaan">
                        <?= $form->field($model, 'perihal')->textarea(['rows' => 4]) ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>


        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Ringkasan</label>
                    <div class="col-md-9 kejaksaan">
                        <?= $form->field($model, 'ringkasan')->textarea(['rows' => 4]) ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Sumber Pelapor</label>
                    <div class="col-md-9 kejaksaan">
                        <?=
                        $form->field($model, 'sumber_pelapor')->dropDownList(
                                ArrayHelper::map(SumberPelapor::find()->all(), 'id_sumber_pelapor', 'nm_sumber_pelapor'), ['prompt' => 'Pilih Sumber Pelapor']
                        )
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		
		<div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Oknum</label>
                    <div class="col-md-9 kejaksaan">
                        <?= $form->field($model, 'oknum')->checkbox(['label'=>'','id'=>'checkbox_oknum']) ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
		
		
		<div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan</label>
                    <div class="col-md-9 kejaksaan">
                        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true,'id'=>'txt_jabatan', 'readonly'=>'readonly']) ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

		
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Upload File</label>
                    <div class="col-md-9 kejaksaan">
                        <?=
                        FileInput::widget([
                            'name' => 'upload_file',
                            'options' => [
                                'multiple' => false,
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
    <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <span class="pull-left"><a class="btn btn-primary" data-toggle="modal" id="btn_pelapor"><i class="glyphicon glyphicon-user"></i>Tambah Identitas Pelapor</a></span>
            <!--<h3 class="box-title" style="margin-top: 5px;">
                <strong>Identitas Pelapor</strong>
            </h3>-->
        </div>
        <div class="box-header with-border">

            <table id="table_pelapor" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="15%">NIK</th>
                        <th width="35%">Nama</th>
                        <th>Pendidikan</th>
                        <th>Agama</th>
						<th width="8%">&nbsp;</th>
                        <th width="8%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tbody_pelapor">

                    <?php
                    if (!$model->isNewRecord) {
                        foreach ($pelapor as $data) {

                            echo "<tr data-nik='".$data->nik."' id='trpelapor".$data->nik."'>";
                            echo "<td>" . $data->nik . "<input type='hidden' name='nik[]' id='nik_pelapor' value='" . $data->nik . "' /><input type='hidden' name='keterangan[]' value='".$data->keterangan."' /></td>";
                            echo "<td>" . $data->nama . "<input type='hidden' name='nama[]' value='" . $data->nama . "' /><input type='hidden' name='alamat[]' value='" . $data->alamat . "' /></td>";
                            echo "<td>" . MsPendidikan::findOne($data->pendidikan)->nama . "<input type='hidden' name='pendidikan[]' value='" . $data->pendidikan . "' /></td>";
                            echo "<td>" . MsAgama::findOne($data->agama)->nama . "<input type='hidden' name='agama[]' value='" . $data->agama . "' /><input type='hidden' name='pekerjaan[]' value='" . $data->pekerjaan . "' /></td>";
							echo "<td><a class='btn btn-primary' id='btn_ubah_pelapor' eketerangan='".$data->keterangan."' enik='".$data->nik."' enama='".$data->nama."' ejkl='".$data->kelamin."' etempat_lahir='".$data->tempat_lahir."' etgl_lahir='".$data->tgl_lahir."' ealamat='".$data->alamat."' ependidikan='".$data->pendidikan."' eagama='".$data->agama."' epekerjaan='".$data->pekerjaan."'>Ubah</a></td>";
                            echo "<td><input type='hidden' name='tempat_lahir[]' value='" . $pelapor->tempat_lahir . "'><input type='hidden' name='tgl_lahir[]' value='" . $pelapor->tgl_lahir . "'><a class='btn btn-primary' id='btn_hapus_pelapor'>Hapus</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>





    <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <span class="pull-left"><a class="btn btn-primary" data-toggle="modal" data-target="#m_terlapor"><i class="glyphicon glyphicon-user"></i> Tambah Identitas Terlapor</a></span>
            <!--<h3 class="box-title" style="margin-top: 5px;">
                <strong>Identitas Terlapor</strong>
            </h3>-->
        </div>
        <div class="box-header with-border">
        <table id="table_jpu" class="table table-bordered">
            <thead>
                <tr>
                    <th width="50%">Nama</th>
                    <th>Jabatan</th>
                    <th width="8%">&nbsp;</th>
                </tr>
            </thead>
            <tbody id="tbody_terlapor">

                <?php
                if (!$model->isNewRecord) {
                    foreach ($terlapor as $data) {
                        $query = new Query;
                        $query->select('*')
                                ->from('was.v_riwayat_jabatan')
                                ->where("id= :id", [':id' => $data->id_h_jabatan]);

                        $pegawai = $query->one();

                        echo '<tr id="trterlapor' . $pegawai['peg_nip_baru'] . '">';
                        echo '<td><input type="text" class="form-control" name="namaTerlapor[]" value="' . $pegawai['peg_nama'] . '">';
						echo '<input type="hidden" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
						echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                        echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
						echo '</td>';
						/*
                        echo '<td><input type="text" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
                        echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                        echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
                        echo '</td>';
						*/
                        echo '<td><input type="text" class="form-control" name="jabatanTerlapor[]" readonly="true" value="' . $pegawai['jabatan'] . '"> </td>';
                        echo '<td><a class="btn btn-primary" id="btn_delete_terlapor">Hapus</a></td>';
                        '</tr>';
                    }
                }
                ?>

            </tbody>
        </table>
        </div>
    </div>



  <!--  <div class="form-group">
        <label class="control-label col-md-2">Status Pengaduan</label>
        <div class="col-md-3 kejaksaan">
            <?php
         //   $form->field($model, 'status')->dropDownList(
             //       ArrayHelper::map(Dokumen::find()->all(), 'id_dokumen', 'kd_dokumen'), ['prompt' => 'Pilih Status Pengaduan']
          //  )
            ?>
        </div>

    </div>!-->	


    <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <span class="pull-left"><a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="glyphicon glyphicon-user"></i> Tambah Tembusan</a></span>
            <!--<h3 class="box-title" style="margin-top: 5px;">
                <strong>Tembusan</strong>
            </h3>-->
        </div>
        <div class="box-header with-border">
        <table id="table_tembusan" class="table table-bordered">
            <thead>
                <tr>
                    <th>Tembusan</th>
                    <th width="8%"></th>
                </tr>
            </thead>
            <tbody id="tbody_tembusan-dugaan_pelanggaran">
                <?php
                if (!$model->isNewRecord) {
					$i = 1;
                    foreach ($tembusan as $data) {
                        $queryTembusan = new Query;
                        $queryTembusan->select('*')
                                ->from('was.v_pejabat_tembusan')
                                ->where("id_pejabat_tembusan= :id", [':id' => $data->id_pejabat_tembusan]);


                        $pejabatTembusan = $queryTembusan->one();
						?>	
				
						<tr id="tembusan<?= $data->id_pejabat_tembusan ?>">
						<td><input type="text" name="jabatan[]" class="form-control" readonly="true" value="<?= $pejabatTembusan['jabatan']; ?>">
						<input type="hidden" class="form-control" name="id_jabatan[]" readonly="true" value="<?= $data->id_pejabat_tembusan; ?>">
						</td>
						<td><button class="removebutton btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>
						</tr>
				<?php
					$i++;	
                    }
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>




        <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php //echo Html::Button('Kembali', ['class' => 'tombolbatalindex btn btn-primary']); ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</section>

<?php
Modal::begin([
    'id' => 'm_kejaksaan',
    'header' => 'Data Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);
?> 
<?=
$this->render('_modalKejaksaan', [
    'model' => $model,
    'searchSatker' => $searchSatker,
    'dataProviderSatker' => $dataProviderSatker,
])
?>
<?php
Modal::end();
?>  


<?php
Modal::begin([
    'id' => 'm_pelapor',
    'header' => 'Form Pelapor',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_modalPelapor', [
    'model' => $model,
])
?>

<?php
Modal::end();
?>



<?php
Modal::begin([
    'id' => 'm_terlapor',
    'header' => 'Data Pegawai',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_modalTerlapor', [
    'model' => $model,
    'searchPegawai' => $searchPegawai,
    'dataProviderPegawai' => $dataProviderPegawai,
])
?>

<?php
Modal::end();
?>  




<?php
    Modal::begin([
		'id' => 'tembusan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Tembusan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_tembusan', ['param'=> 'dugaan_pelanggaran'] );
Modal::end();?>



<?php
Modal::begin([
    'id' => 'm_kejaksaan_laporan',
    'header' => 'Data Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);
?> 
<?=
$this->render('_modalKejaksaan_laporan', [
    'model' => $model,
    'searchSatker' => $searchSatker,
    'dataProviderSatker' => $dataProviderSatker,
])
?>
<?php
Modal::end();
?>  

<script type="text/javascript">
	
	function test(){
	alert("test");
	}
	function removeRow(id)
    {
		$("#tembusan-"+id).remove();
    }
        
	function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
		$("#delete_tembusan").val(nilai);
		$("#"+id).remove();
    }
	
    window.onload = function () {
	
		$(document).on('click', 'input#checkbox_oknum', function () {
		if ($(this).is(':not(:checked)')){
		$("#txt_jabatan").attr("readonly", true);
		}
		else{
		$("#txt_jabatan").attr("readonly", false);
		}
		});
		
		
		
		$(document).on('click', 'a#btn_hapus_pelapor', function () {
            //$(this).parent().parent().remove();
            //return false;
			var nik_pelapor = $(this).closest('tr').find('#nik_pelapor').val();
					
		
			bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){	
								$("#trpelapor"+nik_pelapor).remove();								
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        });

        $(document).on('click', 'a#btn_delete_terlapor', function () {
		var nip_terlapor = $(this).closest('tr').find('#nip_terlapor').val();
		
			
		
			bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){	
								$("#trterlapor"+nip_terlapor).remove();								
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
			
            
        });

		
		$("#cbWilayah").change(function(){
		var idWilayah = $(this).val();
		$.ajax({
										type:'POST',
										url:'/pengawasan/dugaan-pelanggaran/getwilayah',
										data:'id='+idWilayah,
										success:function(data){
										$('#div-wilayah-keterangan').show();
										$('#wilayah_keterangan').text(data);
										}
										});
		});
		
        $("#btn_pelapor").click(function () {
			$("#m_pelapor").modal('show');
            $("#dugaan-pelanggaran-modalpelapor")[0].reset();
			$("#nik").attr("readonly", false);
        });

        $("#btn-tambah-pelapor").click(function () {

			
            var nik = $("#nik").val();
            var nama = $("#nama").val();
            var jkl = $("#jkl").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var alamat = $("#alamat").val();

            var pendidikan = $("#pendidikan").val();
            var pendidikanText = $("#pendidikan option:selected").text();

            var agama = $("#agama").val();
            var agamaText = $("#agama option:selected").text();
            var pekerjaan = $("#pekerjaan").val();
			var keterangan = $("#keterangan").val();
			
			if(nik==''){
			bootbox.dialog({
						title: "Peringatan",
                        message: "NIK Tidak Boleh Kosong",
                        buttons:{
                            tidak : {
                                label: "Tutup",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
			}
			
			else{
			$('#'+nik).remove();

            var html = "<tr data-nik='"+nik+"' id='trpelapor"+nik+"'>";
            html += "<td>" + nik + "<input type='hidden' id='nik_pelapor' name='nik[]' value='" + nik + "' /><input type='hidden' name='keterangan[]' value='" + keterangan + "' /></td>";
            html += "<td>" + nama + "<input type='hidden' name='nama[]' value='" + nama + "' /><input type='hidden' name='alamat[]' value='" + alamat + "' /></td>";
            html += "<td>" + pendidikanText + "<input type='hidden' name='pendidikan[]' value='" + pendidikan + "' /></td>";
            html += "<td>" + agamaText + "<input type='hidden' name='agama[]' value='" + agama + "' /><input type='hidden' name='jkl[]' value='" + jkl + "' /><input type='hidden' name='pekerjaan[]' value='" + pekerjaan + "' /></td>";
            html += "<td><a class='btn btn-primary' id='btn_ubah_pelapor' eketerangan='"+keterangan+"' enik='"+nik+"' enama='"+nama+"' ejkl='"+jkl+"' etempat_lahir='"+tempat_lahir+"' etgl_lahir='"+tgl_lahir+"' ealamat='"+alamat+"' ependidikan='"+pendidikan+"'  eagama='"+agama+"' epekerjaan='"+pekerjaan+"'>Ubah</a></td>";
			html += "<td><input type='hidden' name='tempat_lahir[]' value='" + tempat_lahir + "'><input type='hidden' name='tgl_lahir[]' value='" + tgl_lahir + "'>";
			html += "<a class='btn btn-primary' id='btn_hapus_pelapor'>Hapus</a></td>";
            html += "</tr>";

            $("#tbody_pelapor").append(html);
            $("#m_pelapor").modal('hide');
			}
        });
		
		
		$(document).on('click', 'a#btn_ubah_pelapor', function () {
            var nik = $(this).attr('enik');
            var nama = $(this).attr('enama');
			var jkl = $(this).attr('ejkl');
            var tempat_lahir = $(this).attr('etempat_lahir');
            var tgl_lahir = $(this).attr('etgl_lahir');
            var alamat = $(this).attr('ealamat');
            var pendidikan = $(this).attr('ependidikan');
            var pendidikanText = $(this).attr('ependidikanText');
            var agama = $(this).attr('eagama');
            var agamaText = $(this).attr('eagamaText');
            var pekerjaan = $(this).attr('epekerjaan');
			var keterangan = $(this).attr('eketerangan');
			
			$("#nik").val("");
            $("#nama").val("");
            $("#tempat_lahir").val("");
            $("#tgl_lahir").val("");
            $("#alamat").val("");
            $("#pekerjaan").val("");
			$("#keterangan").val("");
			
			$("#nik").attr("readonly", "readonly");
			
			$("#nik").val(nik);
            $("#nama").val(nama);
			$('#jkl').val(jkl);
            $("#tempat_lahir").val(tempat_lahir);
            $("#tgl_lahir").val(tgl_lahir);
            $("#alamat").val(alamat);
			$('#pendidikan').val(pendidikan);
			$('#agama').val(agama);
            $("#pekerjaan").val(pekerjaan);
			$("#keterangan").val(keterangan);
			
			
			$("#m_pelapor").modal('show');
			
        });
		
    };
</script>