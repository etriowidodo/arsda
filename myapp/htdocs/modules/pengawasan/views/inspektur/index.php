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

    <h4><?php ?></h4>
    <?php//  echo $this->render('_search', ['model' => $searchModel]); ?>
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
                <th style="vertical-align: middle; text-align:center;">No</th>
                <th style="vertical-align: middle; text-align:center;">Register</th>
                <th style="vertical-align: middle; text-align:center;">Perihal</th>
                <th style="vertical-align: middle; text-align:center;">Pelapor</th>
                <th style="vertical-align: middle; text-align:center;">Sumber Laporan</th>
                <th style="vertical-align: middle; text-align:center;">Terlapor</th>
                <th style="vertical-align: middle; text-align:center;">Satuan Kerja Terlapor</th>
                <!-- <th>Status Akhir</th> -->
                <th style="vertical-align: middle; text-align:center;">Irmud (Status Akhir)</th>
                <th style="vertical-align: middle; text-align:center;">Pilih</th>
            </tr>
        </thead>
        <tbody>
          <?php 
          $no=1;
          foreach ($query as $key){
          ?>
            <tr>
                <td style="text-align:center;"><?= $no ?></td>
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
                <td><?php
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
                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_satker=1;
                      foreach ($satker as $key_satker) {
                        if(count($satker)<=1){
                            echo $key_satker['sumber_laporan'].'<br>';
                        }else{
                            echo $no_satker.'. '.$key_satker['sumber_laporan'].'<br>';
                        }
                         $no_satker++;
                      }
                    ?>
                </td>
                <td><?php
                //  $sql= " SELECT a.nama_terlapor_awal FROM was.terlapor_awal a WHERE a.no_register='".$key['no_register']."' and a.id_inspektur='".$_SESSION['inspektur']."' order by id_terlapor_awal";
                $sql= " SELECT a.nama_terlapor_awal FROM was.terlapor_awal a WHERE a.no_register='".$key['no_register']."' and  a.id_inspektur='".$_SESSION['inspektur']."' order by no_urut";
                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                        $no_satker=1;
                      foreach ($satker as $key_satker) {
                        if(count($satker)<=1){
                            echo $key_satker['nama_terlapor_awal'].'<br>';
                        }else{
                            echo $no_satker.'. '.$key_satker['nama_terlapor_awal'].'<br>';
                        }
                         $no_satker++;
                      }
                    ?>
                </td>
                <td><?php
                  $sql= " SELECT a.satker_terlapor_awal FROM was.terlapor_awal a WHERE a.no_register='".$key['no_register']."' and a.id_inspektur='".$_SESSION['inspektur']."' order by no_urut";
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
                <!-- baru -->
                <td><?php

                  $sql= " SELECT a.no_urut FROM was.terlapor_awal a WHERE a.no_register='".$key['no_register']."' and a.id_inspektur='".$_SESSION['inspektur']."' order by no_urut";
                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                      $no_sstatus=1;
                      foreach ($satker as $key_satker) {
                       
                      $sql_test= " SELECT string_agg(c.akronim ||'('||a.status||') ',',') as akronim FROM was.was_disposisi_inspektur a  inner join was.irmud c on a.id_irmud=c.id_irmud and a.id_inspektur=c.id_inspektur where a.no_register='".$key['no_register']."' and a.urut_terlapor='".$key_satker['no_urut']."' ";
                      $result_test = Yii::$app->db->createCommand($sql_test)->queryAll();
                      foreach ($result_test as $key_test) {
                        if(count($satker)<=1){
                            echo $key_test['akronim'].$key_test['status'].'<br>';
                        }else{
                            echo ($key_test['akronim']==''?'':$no_sstatus.'. '.$key_test['akronim'].'<br>');
                        }
                         $no_sstatus++;
                      }

                      }
                 

                  ?>
                </td>

                </td>
                <td style="text-align:center;">
                    <input class="checkbox-row aksinya" type="checkbox" name="ck" value="<?= $key['no_register']?>" id_tingkat="<?= $key['id_tingkat']?>" id_kejati="<?= $key['id_kejati']?>" id_kejari="<?= $key['id_kejari']?>" id_cabjari="<?= $key['id_cabjari']?>">
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
/*.paging_simple_numbers a.paginate_button {
    background-color: #FFFFCC !important;
    background:  #FFFFCC;
}
.paging_simple_numbers a.paginate_active {
    background-color: #FFFFCC !important;
}*/

</style>
<script type="text/javascript">


///////////Kondisi Tombol Checklist////////////
window.onload=function(){
$("#ubah_lapdu").addClass("disabled");
    /*permintaan pa putut*/
        
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
       // var link=$(".checkbox-row:checked").val();
        // var no_register=$(".checkbox-row:checked").val();
        // var id_wilayah=$(".checkbox-row:checked").attr('idwilayah');
        // var id_bidang=$(".checkbox-row:checked").attr('idbidang');
        // var id_unit=$(".checkbox-row:checked").attr('idunit');  
        var no_register=$('.checkbox-row:checked').val();
        var id_tingkat=$('.checkbox-row:checked').attr('id_tingkat');
        var id_kejati=$('.checkbox-row:checked').attr('id_kejati');
        var id_kejari=$('.checkbox-row:checked').attr('id_kejari');  
        var id_cabjari=$('.checkbox-row:checked').attr('id_cabjari');  
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
            
        // location.href='/pengawasan/inspektur/update?id='+no_register+'&id_wilayah='+id_wilayah+'&id_bidang='+id_bidang+'&id_unit='+id_unit;
        location.href='/pengawasan/inspektur/update?id='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;   
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
// //  var id = $(this).find('.checkbox-row').val();
//   var no_register=$(this).find('.checkbox-row').val();
//   var id_tingkat=$(this).find('.checkbox-row').attr('id_tingkat');
//   var id_kejati=$(this).find('.checkbox-row').attr('id_kejati');
//   var id_kejari=$(this).find('.checkbox-row').attr('id_kejari');  
//   var id_cabjari=$(this).find('.checkbox-row').attr('id_cabjari');  
//   // alert(id);
//          location.href='/pengawasan/inspektur/update?id='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;   
//   //do something with id
// });
});

 $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var no_register = $(this).closest('tr').find('.checkbox-row').val();
          var id_tingkat=$(this).find('.checkbox-row').attr('id_tingkat');
          var id_kejati=$(this).find('.checkbox-row').attr('id_kejati');
          var id_kejari=$(this).find('.checkbox-row').attr('id_kejari');
          var id_cabjari=$(this).find('.checkbox-row').attr('id_cabjari');
        location.href='/pengawasan/inspektur/update?id='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;   
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


