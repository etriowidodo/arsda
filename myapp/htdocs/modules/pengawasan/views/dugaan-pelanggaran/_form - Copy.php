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
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Surat</label>
                    <div class="col-sm-8 kejaksaan">
                            <input id="inst_satkerkd" value="<?php echo $model->inst_satkerkd; ?>" class="form-control" type="hidden" maxlength="10" name="DugaanPelanggaran[inst_satkerkd]">
                            <input id="inst_nama" value="<?php echo KpInstSatker::find()->where(['inst_satkerkd' => $model->inst_satkerkd])->one()->inst_nama; ?>" class="form-control" type="text" maxlength="10" name="inst_nama">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label col-sm-6">Tanggal Surat</label>
                    <div class="col-sm-6 kejaksaan">
                       <?=
                            $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [

                                    'pluginOptions' => [

                                        'autoclose' => true,
                                    ]
                                ],
                            ]);

                            ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label col-sm-5">Media Pelaporan</label>
                    <div class="col-sm-7 kejaksaan">
                        <?=
                        $form->field($model, 'sumber_dugaan')->dropDownList(
                                ArrayHelper::map(SumberPengaduan::find()->all(), 'id_sumber_pengaduan', 'nm_sumber_pengaduan'), ['prompt' => 'Pilih Sumber'],['width'=>'40%']
                        )
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Register</label>
                    <div class="col-sm-8 kejaksaan">
                            <input id="inst_satkerkd" value="<?php echo $model->inst_satkerkd; ?>" class="form-control" type="hidden" maxlength="10" name="DugaanPelanggaran[inst_satkerkd]">
                            <input id="inst_nama" value="<?php echo KpInstSatker::find()->where(['inst_satkerkd' => $model->inst_satkerkd])->one()->inst_nama; ?>" class="form-control" type="text" maxlength="10" name="inst_nama">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6">Tanggal Surat Terima</label>
                    <div class="col-sm-6 kejaksaan">
                       <?=
                            $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [

                                    'pluginOptions' => [

                                        'autoclose' => true,
                                    ]
                                ],
                            ]);

                            ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <br></br>
        </div >
    </div>

<!-- begin Pelapor -->
    <div class="box box-primary">

        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-sm-6">
                Daftar Pelapor
            </div>
            <div class="btn-toolbar">
              <button class="btn btn-primary btn-sm pull-right">Hapus</button>
              <!-- <button class="btn btn-primary btn-sm pull-right" id="btn_ubah_pelapor"><i class="glyphicon glyphicon-user">Ubah </i></button> -->
              <a class="btn btn-primary btn-sm pull-right" id="btn_ubah_pelapor"><i class="glyphicon glyphicon-user"> Ubah </i></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" id="btn_pelapor"><i class="glyphicon glyphicon-user"> Tambah Pelapor </i></a>
            </div>

        </div>
        <div class="box-header with-border">
           <!--  <div class="box-header with-border" style="border-color: #c7c7c7;">
                   
            </div> -->

            <table id="table_pelapor" class="table table-bordered">
                <thead>
                    <tr>
                        <!-- <th width="15%">No</th> -->
                        <th width="35%">Sumber Laporan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No telp</th>
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

<!-- begin Terlapor -->
 <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-sm-6">
                Daftar Terlapor
            </div>
            <div class="btn-toolbar">
              <button class="btn btn-primary btn-sm pull-right">Hapus</button>
              <button class="btn btn-primary btn-sm pull-right" id="ubah_terlapor">Ubah</button>
              <span class="pull-right"><a class="btn btn-primary btn-sm" data-toggle="modal" href="#myModalTerlapor"><i class="glyphicon glyphicon-user"> Tambah Terlapor </i></a></span>
            </div>

        </div>

        <div class="box-header with-border">
           <!--  <div class="box-header with-border" style="border-color: #c7c7c7;">
                   
            </div> -->
        <table id="table_jpu" class="table table-bordered">
            <thead>
                <tr>
                    <th width="20%" rowspan="2">Nama Terlapor</th>
                    <th rowspan="2">Jabatan</th>
                    <th rowspan="2">Satuan Kerja</th>
                    <th colspan="2">Pelanggaran</th>
                    <th width="8%" rowspan="2">&nbsp;</th>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <th>Waktu</th>
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

        <!-- baegin perihal -->
        <div class="box box-primary">
        <div class="col-md-12">
            <div class="col-sm-6">
                    <label class="control-label col-md-4">Perihal</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?= $form->field($model, 'wilayah_keterangan')->textarea(['rows' => 2, 'id'=>'wilayah_keterangan']) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <label class="control-label col-md-4">Ringkasan/Isi Laporan</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?= $form->field($model, 'wilayah_keterangan')->textarea(['rows' => 2, 'id'=>'wilayah_keterangan']) ?>
                    </div>
                </div>
            </div>
        </div>

         <div class="col-md-12" style="padding: 15px 0px;">
            <div class="col-sm-6">
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
            </div>
        </div>


 <div class="col-md-12">
    <div class="form-group">
    <div class="box-footer">
       <h2>Stacked Bootstrap Modal Example.</h2>
 <a data-toggle="modal" href="#myModal" class="btn btn-primary">Launch modal</a>
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?php //echo Html::Button('Kembali', ['class' => 'tombolbatalindex btn btn-primary']); ?>

        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
        <input action="action" type="button" value="Cetak" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
    </div>
</div> 
    <?php ActiveForm::end(); ?>
    </div>
</section>

<!-- =======================================================MODAL TAMBAH PELAPOR ========================================================-->
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
<!-- =========================================================END MODAL TAMBAH PELAPOR =====================================================-->

 <!-- ====================================================MODAL TAMBAH TERLAPOR========================================================== -->

 <div class="modal fade" id="myModalTerlapor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Tambah Data Terlapor</h4>

            </div>
<div class="modal-body">
   <div class="box box-primary" style="padding: 15px 0px;">
       <div class="col-md-12">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="Nama">Nama</label>
                         <input id="nama_terlapor" class="form-control" type="text" maxlength="32">
                </div>
            </div>

            <div class="col-sm-4">
                       <div class="form-group">
                     <label for="Nama">Jabatan</label>
                         <input id="jabatan" class="form-control" type="text" maxlength="32">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                     <label for="Nama">Satker</label>
                         <input id="satker" class="form-control" type="text" maxlength="32">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="Nama">Pelanggaran</label>
                    <textarea id="pelanggaran" class="form-control" rows="2"></textarea>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <!-- <div class="col-sm-6"> -->
                <div class="col-sm-2">
                
                <select class="form-control" name="tanggal"id="tanggal"  width="3%">
                    <?php
                    $arrlength = count($tanggal);
                        for ($i=1; $i <=$arrlength ; $i++) { 
                        echo "<option value=".$i.">".$tanggal[$i]."</option>";
                        }
                        
                    ?>
                </select>
                
            </div> 

            <div class="col-sm-2">
               
                <select class="form-control" name="bulan" id="bulan" width="3%">
                    <?php
                    $arrlength = count($bulan);
                        for ($i=1; $i <=$arrlength ; $i++) { 
                        echo "<option value=".$i.">".$bulan[$i]."</option>";
                        }
                        
                    ?>
                </select>

               
            </div> 
            <div class="col-sm-2">
               
                <select class="form-control" name="tahun" id="tahun" width="3%">
                    <?php
                    $arrlength = count($tahun);
                        for ($i=0; $i <$arrlength ; $i++) { 
                        echo "<option value=".$tahun[$i].">".$tahun[$i]."</option>";
                        }
                        
                    ?>
                </select>

                
               
            </div> 
            <div class="col-sm-6">
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah" value="0" rel="Kejagung RI">Kejagung RI</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah" value="1" rel="Kejati">Kejati</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah" value="2" rel="Kejari">Kejari</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah" value="3" rel="Cabjari">Cabjari</label>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>


    <div class="box box-primary" style="padding: 15px 0px;" id="lokasi_pelanggaran">

    </div>
   
</div>

            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
            <button class="btn btn-primary" type="button" id="btn_tambah_Telapor">Simpan</button>

            </div>
        </div>
</div>

<!-- ====================================================END OF MODAL TERLAPOR======================================================== -->

<!-- =========================================================MODAL BIDANG================================================================= -->
<div class="modal fade rotate" id="MyModalPopUp">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Detail Lokasi Pelnggaran</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Content for the dialog / modal goes here.
                <br>
                <br>
                <p>come content</p>
                <br>
                <br>
                <br>    

            </div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>

            </div>
        </div>
    </div>
</div>
<!-- =========================================================END MODAL BIDANG================================================================= -->



<h2>Stacked Bootstrap Modal Example.</h2>
 <a data-toggle="modal" href="#myModal" class="btn btn-primary">Launch modal</a>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modal 1</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Content for the dialog / modal goes here.
                <br>
                <br>
                <br>
                <p>more content</p>
                <br>
                <br>
                <br>    <a data-toggle="modal" href="#myModal2" class="btn btn-primary">Launch modal</a>

            </div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modal 2</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Content for the dialog / modal goes here.
                <br>
                <br>
                <p>come content</p>
                <br>
                <br>
                <br>    <a data-toggle="modal" href="#myModal3" class="btn btn-primary">Launch modal</a>

            </div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modal 3</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Content for the dialog / modal goes here.
                <br>
                <br>
                <br>
                <br>
                <br>    <a data-toggle="modal" href="#myModal4" class="btn btn-primary">Launch modal</a>

            </div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modal 4</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Content for the dialog / modal goes here.</div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>

            </div>
        </div>
    </div>
</div>


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
		
		
		
		$(document).on('click', 'a.btn_hapus_pelapor', function () {
            //$(this).parent().parent().remove();
            //return false;
            // var nik_pelapor = $(this).parents('tr').find('#nik_pelapor').val();
			var nik_pelapor = $(this).attr('rel');

		alert(nik_pelapor);
			bootbox.dialog({
						title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){	
                                // $("#trpelapor"+nik_pelapor).remove();                               
								$("#"+nik_pelapor).remove();								
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
            var sumber = $("#sumber").val();
            var nama = $("#nama").val();
            var jkl = $("#jkl").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var alamat = $("#alamat").val();
            var no_telepon = $("#no_telepon").val();

            var pendidikan = $("#pendidikan").val();
            var pendidikanText = $("#pendidikan option:selected").text();
            var sumberText = $("#sumber option:selected").text();

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
            html += "<td>" + sumberText + "<input type='hidden' id='txt_sumber' name='txt_sumber[]' value='" + sumber + "' /><input type='hidden' name='keterangan[]' value='" + keterangan + "' /></td>";
            // html += "<td>" + nik + "<input type='hidden' id='nik_pelapor' name='nik[]' value='" + nik + "' /><input type='hidden' name='keterangan[]' value='" + keterangan + "' /></td>";
            html += "<td>" + nama + "<input type='hidden' name='nama[]' value='" + nama + "' /></td>";
            html += "<td>" + alamat + "<input type='hidden' name='alamat[]' value='" + alamat + "' /></td>";
            html += "<td>" + no_telepon + "<input type='hidden' name='no_telepon[]' value='" + no_telepon + "' /></td>";
            // html += "<td>" + pendidikanText + "<input type='hidden' name='pendidikan[]' value='" + pendidikan + "' /></td>";
            // html += "<td>" + agamaText + "<input type='hidden' name='agama[]' value='" + agama + "' /><input type='hidden' name='jkl[]' value='" + jkl + "' /><input type='hidden' name='pekerjaan[]' value='" + pekerjaan + "' /></td>";
            // html += "<td><a class='btn btn-primary' id='btn_ubah_pelapor' eketerangan='"+keterangan+"' enik='"+nik+"' enama='"+nama+"' ejkl='"+jkl+"' etempat_lahir='"+tempat_lahir+"' etgl_lahir='"+tgl_lahir+"' ealamat='"+alamat+"' ependidikan='"+pendidikan+"'  eagama='"+agama+"' epekerjaan='"+pekerjaan+"'>Ubah</a></td>";
            html += "<td width='3%'><input class='td' type='checkbox' name='ck_ubah' value='"+nik+"' eketerangan='"+keterangan+"' enik='"+nik+"' enama='"+nama+"' ejkl='"+jkl+"' etempat_lahir='"+tempat_lahir+"' etgl_lahir='"+tgl_lahir+"' ealamat='"+alamat+"' ependidikan='"+pendidikan+"'  eagama='"+agama+"' epekerjaan='"+pekerjaan+"'></td>";
			html += "<td><input type='hidden' name='tempat_lahir[]' value='" + tempat_lahir + "'><input type='hidden' name='tgl_lahir[]' value='" + tgl_lahir + "'>";
			html += "<a class='btn btn-primary btn_hapus_pelapor' id='btn_hapus_pelapor' rel='trpelapor"+nik+"'>Hapus</a></td>";
            html += "</tr>";

            $("#tbody_pelapor").append(html);
            $("#m_pelapor").modal('hide');
			}
        });
		
        function notify(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Merubah data harus memilih satu data,Harap pilih satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
    }
		
		$(document).on('click', 'a#btn_ubah_pelapor', function () {
              var x=$("input[name=ck_ubah]:checked").length;
             if(x>=2 || x<=0){
                var warna='black';
                notify(warna);
             return false
             }
             var nik=$('input[name=ck_ubah]:checked').attr('enik');
             var nama=$('input[name=ck_ubah]:checked').attr('enama');
             var jkl=$('input[name=ck_ubah]:checked').attr('ejkl');
             var tempat_lahir=$('input[name=ck_ubah]:checked').attr('etempat_lahir');
             var tgl_lahir=$('input[name=ck_ubah]:checked').attr('etgl_lahir');
             var alamat=$('input[name=ck_ubah]:checked').attr('ealamat');
             var pendidikan=$('input[name=ck_ubah]:checked').attr('ependidikan');
             var pendidikanText=$('input[name=ck_ubah]:checked').attr('ependidikanText');
             var agama=$('input[name=ck_ubah]:checked').attr('eagama');
             var agamaText=$('input[name=ck_ubah]:checked').attr('eagamaText');
             var pekerjaan=$('input[name=ck_ubah]:checked').attr('epekerjaan');
             var keterangan=$('input[name=ck_ubah]:checked').attr('eketerangan');
             // alert(x);

   //          var nik = $(this).attr('enik');
   //          var nama = $(this).attr('enama');
			// var jkl = $(this).attr('ejkl');
   //          var tempat_lahir = $(this).attr('etempat_lahir');
   //          var tgl_lahir = $(this).attr('etgl_lahir');
   //          var alamat = $(this).attr('ealamat');
   //          var pendidikan = $(this).attr('ependidikan');
   //          var pendidikanText = $(this).attr('ependidikanText');
   //          var agama = $(this).attr('eagama');
   //          var agamaText = $(this).attr('eagamaText');
   //          var pekerjaan = $(this).attr('epekerjaan');
			// var keterangan = $(this).attr('eketerangan');
			
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

    /*ini adalah fungsi untuk menambahkan daftar orang terlapor*/
    function pilihPegawai( nama, jabatan, satker, wilayah, wilayah_text, waktu){
        $('#tbody_terlapor').append(
                    '<tr id="trterlapor'+nama+'">' +
                        '<td>'+nama+'<input type="hidden" class="form-control" name="namaTerlapor[]"value="'+nama+'"></td>' +
                        '<td>'+jabatan+'<input type="hidden" class="form-control" name="jabatanTerlapor[]" id="nip_terlapor" readonly="true" value="'+jabatan+'"></td>'+
                        '<td>'+satker+'<input type="hidden" class="form-control" name="satkerTerlapor[]" id="nip_terlapor" readonly="true" value="'+satker+'"></td>'+
                        '<td>'+wilayah_text+'<input type="hidden" class="form-control" name="wilayahTerlapor[]" id="nip_terlapor" readonly="true" value="'+wilayah+'"></td>'+
                        '<td>'+waktu+'<input type="hidden" class="form-control" name="waktuTerlapor[]" id="nip_terlapor" readonly="true" value="'+waktu+'"></td>'+
                        
                        // '<td><input type="text" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="'+nip+'">'+
                        // '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="'+id+'">'+
                        // '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="'+peg_nik+'">'+
                        // '</td>' +
                        
                        '<td><a class="btn btn-primary" id="btn_delete_terlapor">Hapus</a></td>'+
                    '</tr>'
        );

    $('#myModalTerlapor').modal('hide');
    }


    /*ini adalah jquery untuk mebedakan wilayah pelanggaran*/
    $(document).ready(function(){
    $('.opt_wilayah').click(function(){
        var kode_pelanggaran=$(this).val();
      $.ajax({
            type:'POST',
            url:'/pengawasan/dugaan-pelanggaran/lokasipelanggaran',
            data:'id='+kode_pelanggaran,
            success:function(data){
            $('#lokasi_pelanggaran').html(data);
            }
            });
       });
      
     $('#openBtn').click(function () {
        $('#myModal').modal({
            show: true
        })
    });

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
   


    $('#btn_tambah_Telapor').click(function(){
    var nama_pelapor=$('#nama_terlapor').val();
    var jabatan= $('#jabatan').val();
    var satker= $('#satker').val();
    var opt_wilayah= $('input[name=optradio]:checked').val();
    if(opt_wilayah=='0'){
        var wilayah_text="Kejagung RI";
    }else if(opt_wilayah=='1'){
        var wilayah_text="Kejati";
    }else if(opt_wilayah=='2'){
        var wilayah_text="Kejari";
    }else if(opt_wilayah=='3'){
        var wilayah_text="Cabjari";
    }
    var tanggal=$('#tanggal').val()+'/'+$('#bulan').val()+'/'+$('#tahun').val();
    // alert($('input[name=optradio]:checked').val()); 
       pilihPegawai(nama_pelapor,jabatan,satker,opt_wilayah,wilayah_text,tanggal);
    });
});



</script>