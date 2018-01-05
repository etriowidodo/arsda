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
use kartik\growl\Growl;

?>

<script>
var url1='<?php echo  Url::toRoute('was9/create'); ?>';
</script>
  <?php
$script= <<<JS
        
$('#tgl_inter_waktu').change(function(){
       
   var d = new Date($('#tgl_inter_waktu').val());
  
   
var weekday = new Array(7);
weekday[0]=  "Minggu";
weekday[1] = "Senin";
weekday[2] = "Selasa";
weekday[3] = "Rabu";
weekday[4] = "Kamis";
weekday[5] = "Jumat";
weekday[6] = "Sabtu";

var n = weekday[d.getDay()];  
    $('#was9-hari').val(n);
     });  
        
    function removeRow(id)
    {
     
      $("#"+id).remove();
        

    }
        
        function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
     $("#delete_tembusan").val(nilai);
      $("#"+id).remove();
        

    }
     
        
     
JS;
$this->registerJs($script,View::POS_BEGIN);

?>    


<div>
 <?php 
 $form = ActiveForm::begin([
        'id' => 'was9int-popup-form',
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
          //  'actions' => Url::toRoute('was9/create'),
        ]
    ]); ?>
 <?php
 // print_r($LoadSaksiInternal);
 // print_r($LoadSaksiEksternal);
 ?>
<div class="col-md-12" style="padding: 15px 0px;">
 
 <table class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Pangkat</th>
      <th>NIP/NRP</th>
      <th>Jabatan</th>
      <th>Golongan</th>
      <th>Pilih</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($LoadSaksiInternal as $key_value) {
    ?>
    <tr>
      <td><?= $key_value['nama_saksi_internal']?></td>
      <td><?= $key_value['pangkat_saksi_internal']?></td>
      <td><?= $key_value['nip']?></td>
      <td><?= $key_value['jabatan_saksi_internal']?></td>
      <td><?= $key_value['golongan_saksi_internal']?></td>
      <td> <a class="btn btn-primary" id="pilih_saksi_in" namasaksiIN="<?= $key_value['nama_saksi_internal']?>" pangkatsaksiIN="<?= $key_value['pangkat_saksi_internal']?>" nipIN="<?= $key_value['nip']?>" golongansaksiIN="<?= $key_value['golongan_saksi_internal']?>" jabatansaksiIN="<?= $key_value['jabatan_saksi_internal']?>">Pilih</a></td>

    </tr>
    <?php
  }
    ?>
  </tbody>
</table>

</div>


<div class="col-md-12" style="padding: 15px 0px;">
<table class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>Nama</th>
      <!-- <th>Tempat lahir</th> -->
      <!-- <th>Kewarganegaraan</th> -->
      <th>Alamat</th>
      <!-- <th>Agama</th> -->
      <th>Pekerjaan</th>
      <th>Pilih</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($LoadSaksiEksternal as $key) {
    ?>
    <tr>
      <td><?= $key['nama_saksi_eksternal']?></td>
      <td><?= $key['alamat_saksi_eksternal']?></td>
      <td><?= $key['pekerjaan_saksi_eksternal']?></td>
      <td>
        <a class="btn btn-primary" id="pilih_saksi_ek" namaSaksiEk="<?= $key['nama_saksi_eksternal']?>" tempatlahirSaksi="<?= $key['tempat_lahir_saksi_eksternal']?>" idnegara="<?= $key['id_negara_saksi_eksternal']?>" alamat="<?= $key['alamat_saksi_eksternal']?>" idagama="<?= $key['id_agama_saksi_eksternal']?>" idpekerjaan="<?= $key['pekerjaan_saksi_eksternal']?>" kota="<?= $key['nama_kota_saksi_eksternal']?>"
          tanggallahirSaksi="<?= $key['tanggal_lahir_saksi_eksternal']?>" pendidikan="<?= $key['pendidikan']?>">Pilih</a>
      </td>
    </tr>
    <?php
  }
    ?>
  </tbody>
</table>
</div>

  <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
  window.onload = function () {
    $(document).on('click','#pilih_saksi_in',function(){
     var nama_saksi=$(this).attr('namasaksiIN');
     var pangkat=$(this).attr('pangkatsaksiIN');
     var nip=$(this).attr('nipIN');
     var golongan=$(this).attr('golongansaksiIN');
     var jabatan=$(this).attr('jabatansaksiIN');
     $("#was9-nip").val(nip);
     $("#was9-nama_pegawai_terlapor").val(nama_saksi);
     $("#was9-pangkat_pegawai_terlapor").val(pangkat);
     $("#was9-golongan_pegawai_terlapor").val(golongan);
     $("#was9-jabatan_pegawai_terlapor").val(jabatan);
     $("#jenis_saksi1").attr('checked','checked');
     // alert(nama_saksi);
     $("#m_daftar_saksi").modal('hide');
     });

    $(document).on('click','#pilih_saksi_ek',function(){
     var nama_saksi_ek=$(this).attr('namaSaksiEk');
     var tempatlahirSaksi=$(this).attr('tempatlahirSaksi');
     var tanggallahirSaksi=$(this).attr('tanggallahirSaksi');
     var idnegara=$(this).attr('idnegara');
     var alamat=$(this).attr('alamat');
     var idagama=$(this).attr('idagama');
     var idpekerjaan=$(this).attr('idpekerjaan');
     var kota=$(this).attr('kota');
     var pendidikan=$(this).attr('pendidikan');
     $("#was9-nama_pegawai_terlapor").val(nama_saksi_ek);
     $("#nama_saksi_eksternal").val(nama_saksi_ek);
     $("#tempat_lahir_saksi_eksternal").val(tempatlahirSaksi);
     $("#tanggal_lahir_saksi_eksternal").val(tanggallahirSaksi);
     $("#wn_saksi_eksternal").val(idnegara);
     $("#alamat_saksi_eksternal").val(alamat);
     $("#agama_saksi_eksternal").val(idagama);
     $("#pekerjaan_saksi_eksternal").val(idpekerjaan);
     $("#pendidikan_saksi_eksternal").val(pendidikan);
     $("#kota_saksi_eksternal").val(kota);
     $("#jenis_saksi2").attr('checked','checked');
     // alert(nama_saksi_ek);
     $("#m_daftar_saksi").modal('hide');
     });



  }
</script>





