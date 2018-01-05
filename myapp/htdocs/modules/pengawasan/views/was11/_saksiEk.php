<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
// use kartik\widgets\DatePicker;
use app\modules\pengawasan\models\SumberLaporan;
use kartik\datecontrol\DateControl;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\bootstrap\Modal;
// use app\models\MsJkl;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<!--<style>
#pelapor-kewarganegaraan_pelapor {
 background-color: #FFF;
  cursor: text;
}
</style>-->
<div class="modalContent">
    <?php
    $form = ActiveForm::begin([
                'id' => 'modalterlapor',
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


<div class="col-md-12"  style="margin-top:10px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                   <th width="4%" style="text-align:center;">No</th>
                      <th style="text-align:center;">Nama Saksi</th>
                      <th style="text-align:center;">Alamat</th>
                      <th style="text-align:center;">Lokasi</th>
                      <th width="2%" rowspan="2" style="text-align:center;"><input class="" type="checkbox" name="hapus_all_pl" id="hapus_all_tr"></th>
                </tr>
            </thead>
            <tbody class="bd_saksi_ek">
                <?php
                $no_ek=1;
                    foreach ($modelSaksiEk as $key_value) {
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no_ek;?></td>
                    <td><?php echo $key_value['nama_saksi_eksternal'];?></td>
                    <td><?php echo $key_value['alamat_saksi_eksternal'];?></td>
                    <td><?php echo $key_value['nama_kota_saksi_eksternal'];?></td>
                    <td>
<a  id="pilih_saksi_ek" data-dismiss="modal" tanggal_lahir="<?php echo $key_value['tanggal_lahir_saksi_eksternal'];?>" tempat_saksi_ek="<?php echo $key_value['tempat_lahir_saksi_eksternal'];?>" pekerjaan_saksi_ek="<?php echo $key_value['pekerjaan_saksi_eksternal'];?>"  lokasi_saksi_ek="<?php echo $key_value['lokasi_saksi_eksternal'];?>"  pendidikan_saksi_ek="<?php echo $key_value['pendidikan'];?>" negara_saksi_ek="<?php echo $key_value['id_negara_saksi_eksternal'];?>" agama="<?php echo $key_value['id_agama_saksi_eksternal'];?>" id_saksi_ek="<?php echo $key_value['id_saksi_eksternal'];?>" nama_saksi_ek="<?php echo $key_value['nama_saksi_eksternal'];?>" alamat="<?php echo $key_value['alamat_saksi_eksternal'];?>" kota="<?php echo $key_value['nama_kota_saksi_eksternal'];?>" class="btn btn-primary pilih_saksi_ek">Pilih</a>
                </td>
                </tr>

                <?php
                $no_ek++;
                    }
                ?>
            </body>
        </table>
    </div>

    


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="margin-top:10px;">
        <!-- <button class="btn btn-primary" type="button" id="btn-tambah-terlapor">Simpan</button>
        <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button> -->
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // $(".pilih_saksi_in").click(function(){
        //     var nip=$(this).attr('nip');
        //     var nama_saksi_in=$(this).attr('nama_saksi_in');
        //     var pangkat=$(this).attr('pangkat');
        //     var jabatan=$(this).attr('jabatan');
        //     var golongan=$(this).attr('golongan');
        //     var x= $(".bd_saksi_in_tmp").find('#'+nip).val();
        //     // alert(x);
        //     if(x==nip){
        //         alert('Nik saksi ini sudah ada');
        //         return false;
        //     }else{
        //     $(".bd_saksi_in_tmp").append("<tr class='saksi_in' id=\"tr_"+nip+"\">"+
        //         "<td>"+
        //         "<input value=\""+nip+"\" type=\"hidden\" class=\"form-control\" id=\"nip\" name=\"nip[]\"  readonly>"+
        //         "<input value=\""+nama_saksi_in+"\" type=\"hidden\" class=\"form-control\" id=\"nama_saksi_in[]\" name=\"nama_saksi_in[]\" readonly>"+
        //         "<input value=\""+jabatan+"\" type=\"hidden\" class=\"form-control\" id=\"jabatan\" name=\"jabatan[]\"  readonly>"+
        //         "<input value=\""+pangkat+"\" type=\"hidden\" class=\"form-control\" id=\"pangkat\" name=\"pangkat[]\"  readonly>"+
        //         "<input value=\""+golongan+"\" type=\"hidden\" class=\"form-control\" id=\"golongan\" name=\"golongan[]\"  readonly>"+
        //         "</td>"+
        //         "<td>"+nip+"</td>"+
        //         "<td>"+nama_saksi_in+"</td>"+
        //         "<td>"+jabatan+"</td>"+
        //         "<td>"+pangkat+"</td>"+
        //         "<td><input  class='hapus_tr_saksi_in' value=\""+nip+"\" type='checkbox' name='hapus_tr_saksi_in' id=\""+nip+"\">"+
        //         "</td>"+
        //         "</tr>");
        //          i = 0;
        //     $('.bd_saksi_in_tmp').find('.saksi_in').each(function () {
        //         i++;
        //         $(this).addClass('saksi_in'+i);
        //         // $(this).find('.cekbok').val(i);
        //     }); 
        // }
        // });

        $(".pilih_saksi_ek").click(function(){
            var id_saksi_ek=$(this).attr('id_saksi_ek');
            var nama_saksi_ek=$(this).attr('nama_saksi_ek');
            var alamat=$(this).attr('alamat');
            var kota=$(this).attr('kota');
            var tanggal_lahir=$(this).attr('tanggal_lahir');
            var tempat_lahir=$(this).attr('tempat_saksi_ek');
            var pekerjaan=$(this).attr('pekerjaan_saksi_ek');
            var lokasi=$(this).attr('lokasi_saksi_ek');
            var agama=$(this).attr('agama');
            var pendidikan=$(this).attr('pendidikan_saksi_ek');
            var negara=$(this).attr('negara_saksi_ek');
            // alert('sds');
            $(".bd_saksi_ek_tmp").append("<tr class='saksi_ek' id=\"tr_ek"+id_saksi_ek+"\">"+
                "<td>"+
                "<input type='hidden' name='nama_saksi_ek[]' value='"+nama_saksi_ek+"'>"+
                "<input type='hidden' name='alamat_saksi_ek[]' value='"+alamat+"'>"+
                "<input type='hidden' name='kota_saksi_ek[]' value='"+kota+"'>"+
                "<input type='hidden' name='tanggal_lahir_saksi_ek[]' value='"+tanggal_lahir+"'>"+
                "<input type='hidden' name='tempat_saksi_ek[]' value='"+tempat_lahir+"'>"+
                "<input type='hidden' name='pekerjaan_saksi_ek[]' value='"+pekerjaan+"'>"+
                "<input type='hidden' name='lokasi_saksi_ek[]' value='"+lokasi+"'>"+
                "<input type='hidden' name='agama_saksi_ek[]' value='"+agama+"'>"+
                "<input type='hidden' name='pendidikan_saksi_ek[]' value='"+pendidikan+"'>"+
                "<input type='hidden' name='negara_saksi_ek[]' value='"+negara+"'>"+
                "</td>"+
                "<td>"+nama_saksi_ek+"</td>"+
                "<td>"+alamat+"</td>"+
                "<td>"+kota+"</td>"+
                "<td><input class='hapus_tr_saksi_ek' value="+id_saksi_ek+" type='checkbox' name='hapus_tr_saksi_ek' id='hapus_saksi_tr_ek'></td>"+
                "</tr>");
            i = 0;
            $('.bd_saksi_ek_tmp').find('.saksi_ek').each(function () {
                i++;
                $(this).addClass('saksi_ek'+i);
                // $(this).find('.cekbok').val(i);
            }); 

        });
    });
</script>