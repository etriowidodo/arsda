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

$this->title = 'Daftar Lapdu';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php// print_r($_SESSION); ?>
<div class="lapdu-index">

    <h4><?php ?></h4>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php 
    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    // echo $var[0];
    // echo $var[1];
    // if($var[1]=='1'){
    //     $cek_irmud="b.irmud_pegasum_kepbang=TRUE";
    //     }else if($var[1]=='2'){
    //     $cek_irmud="b.irmud_pidum_datun=TRUE";
    //     }else if($var[1]=='3'){
    //     $cek_irmud="b.irmud_intel_pidsus=TRUE";
    //     }

    //     if($var[2]%2=='1'){
    //     $field_status="a.status_pemeriksa1";
    //     $cek_riksa="b.pemeriksa_1";
    //     }else if($var[2]%2=='0'){
    //     $field_status="a.status_pemeriksa2";
    //     $cek_riksa="b.pemeriksa_2";
    //     }
     ?>

    <p>
        <?//= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-toolbar">
              <!-- <a class="btn btn-primary btn-sm pull-right" id="hapus_lapdu"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp; -->
              <a class="btn btn-primary btn-sm pull-right" id="ubah_irmud"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
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
     <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-bordered table-hover','style'=>'table-layout:fixed; word-wrap:break-word;'],
         // 'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',

                'header'=>'No',
                'headerOptions'=>['style'=>'width: 4%;text-align:center;'],
                'contentOptions'=>['style'=>'width: 4%;text-align:center;'],
                 ],
                ['label' => 'No Register',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                return $data['no_register']; 
                          },
                      ],
                ['label' => 'Perihal',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                return $data['perihal_lapdu']; 
                          },
                      ],
                ['label' => 'Pelapor',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                //return $data['perihal_lapdu']; 
                                $sql= " SELECT
                                        x.nama_pelapor
                                   FROM was.pelapor x
                                     -- JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
                                  WHERE x.no_register::text = '".$data['no_register']."'
                                  ORDER BY x.no_urut";
                                      $satker = Yii::$app->db->createCommand($sql)->queryAll();
                                        $no_satker=1;
                                        $HasilPelapor="";
                                      foreach ($satker as $key_satker) {
                                        if(count($satker)<=1){
                                            $HasilPelapor .= $key_satker['nama_pelapor'].'<br>';
                                        }else{
                                            $HasilPelapor .= $no_satker.'. '.$key_satker['nama_pelapor'].'<br>';
                                        }
                                         $no_satker++;
                                      }
                            return $HasilPelapor; 
                          },
                      ],
                ['label' => 'Sumber Laporan',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                //return $data['perihal_lapdu']; 
                                $sql= " SELECT
                                    CASE
                                        WHEN x.id_sumber_laporan::text = '11'::text THEN ('LSM '::text || x.sumber_lainnya::text)::character varying
                                        WHEN x.id_sumber_laporan::text = '13'::text THEN ('Sumber lainnya '::text || x.sumber_lainnya::text)::character varying
                                        ELSE y.akronim
                                    END AS sumber_laporan
                               FROM was.pelapor x
                                 JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
                               WHERE x.no_register::text = '".$data['no_register']."'
                               ORDER BY x.no_urut";
                                $sumber = Yii::$app->db->createCommand($sql)->queryAll();
                                $no_sumber=1;
                                $HasilSumber="";
                              foreach ($sumber as $key_sumber) {
                                if(count($sumber)<=1){
                                    $HasilSumber .= $key_sumber['sumber_laporan'].'<br>';
                                }else{
                                    $HasilSumber .= $no_sumber.'. '.$key_sumber['sumber_laporan'].'<br>';
                                }
                                 $no_sumber++;
                              }
                            return $HasilSumber; 
                          },
                      ],
                ['label' => 'Terlapor Awal',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                               $sql= " SELECT DISTINCT 
                                        A .nama_terlapor_awal,
                                        A .no_urut
                                FROM
                                    was.terlapor_awal A
                                    LEFT JOIN was.was_disposisi_irmud B ON A .no_register = b.no_register and A.id_tingkat=b.id_tingkat and A.id_kejati=b.id_kejati and A.id_kejari=b.id_kejari and A.id_cabjari=b.id_cabjari WHERE a.no_register='".$data['no_register']."' and  a.id_inspektur='".$var[0]."' and b.id_irmud=".$var[1]." order by a.no_urut";
                                  $terlapor = Yii::$app->db->createCommand($sql)->queryAll();
                                    $no_terlapor=1;
                                    $HasilTerlapor="";
                                  foreach ($terlapor as $key_terlapor) {
                                    if(count($terlapor)<=1){
                                        $HasilTerlapor .= $key_terlapor['nama_terlapor_awal'].'<br>';
                                    }else{
                                        $HasilTerlapor .= $no_terlapor.'. '.$key_terlapor['nama_terlapor_awal'].'<br>';
                                    }
                                     $no_terlapor++;
                                  } 
                            return $HasilTerlapor;
                          },
                      ],
                ['header' => 'Satuan Kerja <br>Terlapor',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                               $sql= " SELECT DISTINCT 
                                        A .satker_terlapor_awal,
                                        A .no_urut
                                FROM
                                    was.terlapor_awal A
                                    LEFT JOIN was.was_disposisi_irmud B ON A .no_register = b.no_register and A.id_tingkat=b.id_tingkat and A.id_kejati=b.id_kejati and A.id_kejari=b.id_kejari and A.id_cabjari=b.id_cabjari WHERE a.no_register='".$data['no_register']."' and  a.id_inspektur='".$var[0]."' and b.id_irmud=".$var[1]." order by a.no_urut";
                                  $terlapor = Yii::$app->db->createCommand($sql)->queryAll();
                                    $no_terlapor=1;
                                    $HasilSatker="";
                                  foreach ($terlapor as $key_terlapor) {
                                    if(count($terlapor)<=1){
                                        $HasilSatker .= $key_terlapor['satker_terlapor_awal'].'<br>';
                                    }else{
                                        $HasilSatker .= $no_terlapor.'. '.$key_terlapor['satker_terlapor_awal'].'<br>';
                                    }
                                     $no_terlapor++;
                                  } 
                            return $HasilSatker;
                          },
                      ],
                      ['header' => 'Status <br> Akhir',
                            'format'=>'raw',
                            'headerOptions'=>['style'=>'width: 14%;'],
                            'value' => function ($data) {
                                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                               $sql= "select * from was.v_status_dokumen where no_register='".$data['no_register']."' and  tanggal=(select max(tanggal) from was.v_status_dokumen where no_register='".$data['no_register']."') order by tanggal";
                                  $terlapor = Yii::$app->db->createCommand($sql)->queryAll();
                                    $no_terlapor=1;
                                    $HasilStatus="";
                                  foreach ($terlapor as $key_terlapor) {
                                    if(count($terlapor)<=1){
                                        $HasilStatus .= $key_terlapor['status'].'<br>';
                                    }else{
                                        $HasilStatus .= $no_terlapor.'. '.$key_terlapor['status'].'<br>';
                                    }
                                     $no_terlapor++;
                                  } 
                            return ($HasilStatus==''?'LAPDU':$HasilStatus);
                          },
                      ],
      
                ['class' => 'yii\grid\CheckboxColumn',
                       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
                    // you may configure additional properties here
                       'headerOptions'=>['style'=>'width: 4%;text-align:center;'],
                       'contentOptions'=>['style'=>'width: 4%;text-align:center;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['no_register'],'class'=>'checkbox-row','nilai' =>$data['status']];
            
                        },


                ],
                // manual checkbox
            // [
            // 'label' =>'',
            // 'format' => 'raw',
            // 'value' => function($data)
            // {
            //     return Html::checkbox('chk1', false, ["class" => "chk1",'value' => $data['no_register']]);
            // },
            // ],


            /*manual button*/
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{Tampil}{Edit}{Hapus}',
            //     'buttons' => [
            //         'Tampil' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/view?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-eye-open']);
                        
            //         },
            //         'Edit' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/update?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-pencil']);
                        
            //         },
            //         'Hapus' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/delete?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-trash']);
                        
            //         },
            //     ],
            // ],
            ],
         
    ]); 
     ?>

     
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td
{
  
  text-align:center;
}
.dataTables_filter,.dataTables_length {
   display: none;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  var dataTable = $('#tbl1').dataTable();
    $("#was1search-cari").keyup(function() {
        dataTable.fnFilter(this.value);
    });

// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });



//     $("#ubah_irmud").addClass("disabled");
//     $("#hapus_lapdu").addClass("disabled");
//     /*permintaan pa putut*/
//     $(".checkbox-row").click(function(){
//             var x=$(".checkbox-row:checked").length;
//             if(x>0){
//          $("#ubah_irmud").removeClass("disabled");
//          $("#hapus_lapdu").removeClass("disabled");

                
//         }else{
//           $("#ubah_irmud").addClass("disabled");
//           $("#hapus_lapdu").addClass("disabled");      
//             }
//     // alert(x);
//     });

   
    $("#ubah_irmud").addClass("disabled");
    $("#hapus_lapdu").addClass("disabled");
   
    /*permintaan pa putut*/
   $(document).on('change','.select-on-check-all',function() {
        var c = this.checked ? true : false;
        if(c==true){
          $('.checkbox-row').closest('tr').addClass('danger');
        }else{
          $('.checkbox-row').closest('tr').removeClass('danger');
        }
        // $('.checkbox-row').prop('checked',c);
        var x=$('.checkbox-row:checked').length;
        ConditionOfButton(x);
    });
        
    $(document).on('change','.checkbox-row',function() {
        var c = this.checked ? '#f00' : '#09f';
        if(c=='#f00'){
        $(this).closest('tr').addClass('danger');
        }else{
        $(this).closest('tr').removeClass('danger');
      }

        var x =$('.checkbox-row:checked').length;
        ConditionOfButton(x);
    });

  function ConditionOfButton(n){
        if(n == 1){
           $('#ubah_irmud, #hapus_lapdu').removeClass('disabled');
        } else if(n > 1){
           $('#hapus_lapdu').removeClass('disabled');
           $('#ubah_irmud').addClass('disabled');
        } else{
           $('#ubah_irmud, #hapus_lapdu').addClass('disabled');
        }
    }

    $('#ubah_irmud').click(function(){

        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var id_wilayah=$(".checkbox-row:checked").attr('idwilayah');
        var id_bidang=$(".checkbox-row:checked").attr('idbidang');
        var id_unit=$(".checkbox-row:checked").attr('idunit');
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
            
        location.href='/pengawasan/riksa/index1?id='+link+'&id_wilayah='+id_wilayah+'&id_bidang='+id_bidang+'&id_unit='+id_unit;
         }
    });


/*
        
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
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
            
        location.href='/pengawasan/riksa/index1?id='+link;*/
        

        
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
//   var id_wilayah=$(this).find('.checkbox-row').attr('idwilayah');
//   var id_bidang=$(this).find('.checkbox-row').attr('idbidang');
//   var id_unit=$(this).find('.checkbox-row').attr('idunit');
//   // alert(id);
//   location.href='/pengawasan/riksa/index1?id='+id+'&id_wilayah='+id_wilayah+'&id_bidang='+id_bidang+'&id_unit='+id_unit; 
//   /*var id = $(this).find('.checkbox-row').val();*/
//   // alert(id);
//        /*  location.href='/pengawasan/riksa/index1?id='+id;   */
//   //do something with id
// });
});

 $(document).on("dblclick", "tr", function(e) {
          var id = $(this).find('.checkbox-row').val();
          var id_wilayah=$(this).find('.checkbox-row').attr('idwilayah');
          var id_bidang=$(this).find('.checkbox-row').attr('idbidang');
          var id_unit=$(this).find('.checkbox-row').attr('idunit');
          // alert(id);
          location.href='/pengawasan/riksa/index1?id='+id+'&id_wilayah='+id_wilayah+'&id_bidang='+id_bidang+'&id_unit='+id_unit; 
         
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
window.onload=function(){
    $(document).on('click','.table-bordered tr', function() {
      // $('.table-bordered tr').not(this).removeClass('click-row')
    //  $(this).toggleClass('click-row');
      // $(this).find('.checkbox-row').attr('checked','checked');
      // $(this).find('.checkbox-row').prop('checked',false);
      
      // var x=$(this).find('.checkbox-row:checked').attr('checked');
      // if(x!=''){
      //   $(this).toggleClass('click-row');
      //   // $(this).find('.checkbox-row').attr('checked','checked');
      // }else {
      //   // $(this).removeClass('click-row');
      //   $(this).find('.checkbox-row').attr('checked',false);
      // }
      // var z=$(this).attr('class');
      // if(z=='odd hover' || z=='even hover'){
      //  $(this).find('.checkbox-row').prop('checked',false);
      //   $("#ubah_irmud").addClass("disabled");
      //   $("#hapus_lapdu").addClass("disabled");
      // }else{
      //   $(this).find('.checkbox-row').prop('checked',true);
      //   $("#ubah_irmud").removeClass("disabled");
      //   $("#hapus_lapdu").removeClass("disabled");
      // }
      // alert(z);
});
}
</script>


