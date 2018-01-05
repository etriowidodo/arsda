<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
// use kartik\grid\DataColumn;
// use yii\helpers\Url;
// use yii\web\View;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LapduSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Pengaduan (LAPDU)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lapdu-index">


    <h4><?php//print_r ($_SESSION); ?></h4>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php 
    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    if($var[1]=='1'){
        $cek_irmud="b.irmud_pegasum_kepbang=TRUE";
        }else if($var[1]=='2'){
        $cek_irmud="b.irmud_pidum_datun=TRUE";
        }else if($var[1]=='3'){
        $cek_irmud="b.irmud_intel_pidsus=TRUE";
        }
     ?>

    <p>
        <?//= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-toolbar">
              <!-- <a class="btn btn-primary btn-sm pull-right" id="hapus_lapdu"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp; -->
              <a class="btn btn-primary btn-sm pull-right" id="ubah_lapdu"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
              <!-- <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/lapdu/create"><i class="glyphicon glyphicon-plus"> Laporan Pengaduan</i></a> -->
            </div>
    </p>
    <style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
</style>
     <fieldset class="group-border">
        <legend class="group-border">Daftar laporan Pengaduan</legend>
   
    <table class="table table-striped table-bordered table-hover" id="tbl1">
        <thead>
            <tr>
                <th style=" vertical-align: middle ;text-align:center;">No</th>
                <th style=" vertical-align: middle ;text-align:center;">Register</th>
                <th style=" vertical-align: middle ;text-align:center;">Perihal</th>
                <th style=" vertical-align: middle ;text-align:center;">Pelapor</th>
                <th style=" vertical-align: middle ;text-align:center;">Sumber Laporan</th>
                <th style=" vertical-align: middle ;text-align:center;">Terlapor</th>
                <th style=" vertical-align: middle ;text-align:center;">Satuan Kerja Terlapor</th>
                <th style=" vertical-align: middle ;width:20%; text-align:center;">Pemeriksa (Status Akhir)</th>
                <th style=" vertical-align: middle ;width:3%; text-align:center;">Pilih</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $no=1;
            foreach ($query as $key) {
          ?>
          <tr>
            <td style="text-align:center;"><?= $no?></td>
            <td><?= $key['no_register']?></td>
            <td><?= $key['perihal_lapdu']?></td>
            <td><?php
                  $sql= " SELECT
                        x.nama_pelapor
                   FROM was.pelapor x
                     -- JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
                  WHERE x.no_register::text = '".$key['no_register']."'
                  ORDER BY x.no_urut";
                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_satker=1;
                      foreach ($satker as $key_satker) {
                        if(count($satker)<=1){
                            echo $key_satker['nama_pelapor'].'<br>';
                        }else{
                            echo $no_satker.'. '.$key_satker['nama_pelapor'].'<br>';
                        }
                         $no_satker++;
                      }
                    ?>
            </td>
            <td>
              <?php
                  $sql= " SELECT
                        CASE
                            WHEN x.id_sumber_laporan::text = '11'::text THEN ('LSM '::text || x.sumber_lainnya::text)::character varying
                            WHEN x.id_sumber_laporan::text = '13'::text THEN (x.sumber_lainnya::text)::character varying
                            ELSE y.akronim
                        END AS sumber_laporan
                   FROM was.pelapor x
                     JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
                  WHERE x.no_register::text = '".$key['no_register']."'
                  ORDER BY x.no_urut";
                      $sumber = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_sumber=1;
                      foreach ($sumber as $key_sumber) {
                        if(count($sumber)<=1){
                            echo $key_sumber['sumber_laporan'].'<br>';
                        }else{
                            echo $no_sumber.'. '.$key_sumber['sumber_laporan'].'<br>';
                        }
                         $no_sumber++;
                      }
                    ?>
            </td>
            <td><?php
                //  $sql= " SELECT a.nama_terlapor_awal FROM was.terlapor_awal a WHERE a.no_register='".$key['no_register']."' and a.id_inspektur='".$_SESSION['inspektur']."' order by id_terlapor_awal";
                $sql= " SELECT DISTINCT a.nama_terlapor_awal,a.no_urut FROM was.terlapor_awal a left JOIN was.was_disposisi_inspektur b on a.id_inspektur=b.id_inspektur WHERE a.no_register='".$key['no_register']."' and  a.id_inspektur='".$var[0]."' and b.id_irmud='".$var[1]."' order by a.no_urut";
                      $terlapor = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_terlapor=1;
                      foreach ($terlapor as $key_terlapor) {
                        if(count($terlapor)<=1){
                            echo $key_terlapor['nama_terlapor_awal'].'<br>';
                        }else{
                            echo $no_terlapor.'. '.$key_terlapor['nama_terlapor_awal'].'<br>';
                        }
                         $no_terlapor++;
                      }
                    ?>
            </td>
            <td><?php
                $sql= " SELECT DISTINCT a.satker_terlapor_awal,a.no_urut FROM was.terlapor_awal a left JOIN was.was_disposisi_inspektur b on a.id_inspektur=b.id_inspektur WHERE a.no_register='".$key['no_register']."' and  a.id_inspektur='".$var[0]."' and b.id_irmud='".$var[1]."' order by a.no_urut";
                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_satker=1;
                      foreach ($satker as $key_satker) {
                        if(count($satker)<=1){
                            echo $key_satker['satker_terlapor_awal'].'<br>';
                        }else{
                            echo $no_satker.'. '.$key_satker['satker_terlapor_awal'].'<br>';
                        }
                         $no_satker++;
                      }
                    ?>
             </td>

            <td>
              <?php
              $sqlterlapor= " SELECT DISTINCT a.nama_terlapor_awal,a.no_urut FROM was.terlapor_awal a left JOIN was.was_disposisi_inspektur b on a.id_inspektur=b.id_inspektur WHERE a.no_register='".$key['no_register']."' and  a.id_inspektur='".$var[0]."' and b.id_irmud='".$var[1]."' order by a.no_urut";
                      $terlapor = Yii::$app->db->createCommand($sqlterlapor)->queryAll();
                        // $no_pemeriksa=1;
                      foreach ($terlapor as $key_terlapor) {

                      $sqlpemeriksa= "select string_agg(b.akronim_pemeriksa ||'('||a.status||')',', ') as akronim_pemeriksa FROM was.was_disposisi_irmud a inner join was.tm_pemeriksa b on a.id_pemeriksa::text=b.id_pemeriksa WHERE a.no_register='".$key['no_register']."' and  a.id_inspektur='".$var[0]."' and a.id_irmud='".$var[1]."' and a.urut_terlapor='".$key_terlapor['no_urut']."'";
                      $pemeriksa = Yii::$app->db->createCommand($sqlpemeriksa)->queryAll();
                      foreach ($pemeriksa as $key_pemeriksa) {
                        // if(count($pemeriksa)<=1){
                            echo $key_pemeriksa['akronim_pemeriksa'];
                        // }else{
                        //     echo $no_pemeriksa.'. '.$key_pemeriksa['id_pemeriksa'];
                        // }
                      }
                      echo "<br>";
                         // $no_pemeriksa++;
                        
                      }

                
                    ?>
            </td>
             
            
            <td style="width:3%; text-align:center;">
                <input class="checkbox-row aksinya" type="checkbox" name="ck" value="<?= $key['no_register']?>" idTingkat="<?= $key['id_tingkat']?>" idKejati="<?= $key['id_kejati']?>" idKejari="<?= $key['id_kejari']?>" idCabjari="<?= $key['id_cabjari']?>">
            </td>
          </tr>
          <?php
          $no++;
            }
          ?>
         </tbody>
    </table>
</fieldset>
</div>
<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
.grid-view th{
  white-space:unset;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
{
  vertical-align:top;
}
.dataTables_filter,.dataTables_length {
   display: none;
}
</style>
<script type="text/javascript">

window.onload=function(){
$("#ubah_lapdu").addClass("disabled");
    /*permintaan pa putut*/
   
        //  $(document).on('change','.select-on-check-all',function() {
        //     var c = this.checked ? '#f00' : '#09f';
        //     var x=$('.checkbox-row:checked').length;
        //     ConditionOfButton(x);
        // });
        
       $(document).on('change','.checkbox-row',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.checkbox-row:checked').length;
            ConditionOfButton(x);
        });
    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_lapdu').removeClass('disabled');
            } else{
               $('#ubah_lapdu').addClass('disabled');
            }
    }
}

$(document).ready(function(){
    var dataTable = $('#tbl1').dataTable();
    $("#lapdusearch-cari").keyup(function() {
        dataTable.fnFilter(this.value);
    });
    
// $('.table-bordered tr').hover(function() {

//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tr').on('click', function() {
//       // $('.table-bordered tr').not(this).removeClass('click-row')
//       $(this).toggleClass('click-row');
//       // $(this).find('.checkbox-row').attr('checked','checked');
//       // $(this).find('.checkbox-row').prop('checked',false);
      
//       // var x=$(this).find('.checkbox-row:checked').attr('checked');
//       // if(x!=''){
//       //   $(this).toggleClass('click-row');
//       //   // $(this).find('.checkbox-row').attr('checked','checked');
//       // }else {
//       //   // $(this).removeClass('click-row');
//       //   $(this).find('.checkbox-row').attr('checked',false);
//       // }
//       var z=$(this).attr('class');
//       if(z=='odd hover' || z=='even hover'){
//        $(this).find('.checkbox-row').prop('checked',false);
//         $("#ubah_lapdu").addClass("disabled");
//         $("#hapus_lapdu").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#ubah_lapdu").removeClass("disabled");
//         $("#hapus_lapdu").removeClass("disabled");
//       }
//       // alert(z);
// });

//     $("#ubah_lapdu").addClass("disabled");
//     $("#hapus_lapdu").addClass("disabled");
//     /*permintaan pa putut*/
//     $(".checkbox-row").click(function(){
//             var x=$(".checkbox-row:checked").length;
//             if(x>0){
//          $("#ubah_lapdu").removeClass("disabled");
//          $("#hapus_lapdu").removeClass("disabled");

                
//         }else{
//           $("#ubah_lapdu").addClass("disabled");
//           $("#hapus_lapdu").addClass("disabled");      
//             }
//     // alert(x);
//     });

    $('#ubah_lapdu').click(function(){

        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var id_tingkat=$(".checkbox-row:checked").attr('idTingkat');
        var id_kejati=$(".checkbox-row:checked").attr('idKejati');
        var id_kejari=$(".checkbox-row:checked").attr('idKejari');
        var id_cabjari=$(".checkbox-row:checked").attr('idCabjari');
       if(x>=2 || x<=0){
            var warna='black';
            bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			//notify(warna);
         return false
         }else{
            
        location.href='/pengawasan/irmud/update?id='+link+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;
         }
    });

        
    $('#hapus_lapdu').click(function(){
        var x=$(".checkbox-row:checked").length;
         // var link=$(".chk1:checked").val();
        if(x<=0){
   //          var warna='black';
         
			// notifyHapus(warna);
         return false
         }else{
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.checkbox-row:checked').map(function()
                                {
                                    return $(this).val();
                                }).get();
                             //alert(checkValues);

                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/lapdu/delete',
                                    data:'id='+checkValues+'&jml='+x,
                                    success:function(data){
                                        alert(data);
                                    }
                                    });                           
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
        
        }
            });

    // $('tr').dblclick(function(){
    //   var id = $(this).find('.checkbox-row').val();
    //   var id_tingkat=$(this).find('.checkbox-row').attr('idTingkat');
    //   var id_kejati=$(this).find('.checkbox-row').attr('idKejati');
    //   var id_kejari=$(this).find('.checkbox-row').attr('idKejari');
    //   var id_cabjari=$(this).find('.checkbox-row').attr('idCabjari');

    //          location.href='/pengawasan/irmud/update?id='+id+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;
    //   //do something with id
    // });
});

 $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.checkbox-row').val();
          var id_tingkat=$(this).closest('tr').find('.checkbox-row').attr('idtingkat');
          var id_kejati=$(this).closest('tr').find('.checkbox-row').attr('idkejati');
          var id_kejari=$(this).closest('tr').find('.checkbox-row').attr('idkejari');
          var id_cabjari=$(this).closest('tr').find('.checkbox-row').attr('idcabjari');
          location.href='/pengawasan/irmud/update?id='+id+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;
        });
   
          // alert(id);
                 // location.href='/pengawasan/sk-was-4e/update?id='+id;  
          // if(check.id_sk_was_4e==null){
          //   location.href='/pengawasan/sk-was-4e/create?id='+check.nip_terlapor+'&id2='+check.pasal;
          // }else{

          // location.href='/pengawasan/sk-was-4e/update?id='+check.id_sk_was_4e+'&id2='+check.nip_pegawai_terlapor+'&id3='+check.pasal;
          // }

          //do something with id

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
function notifyHapus(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Menghapus data harus memilih salah data,Harap pilih salah satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
</script>


