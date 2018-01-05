<?php



use yii\helpers\Html;
// use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\db\Query;
use yii\db\Command;
// use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $searchModel app\models\LapduSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Pengaduan (LAPDU)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lapdu-index">

    <h4><?php //= Html::encode($this->title) ?></h4>
    <?php  echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php //= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_lapdu"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_lapdu"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/lapdu/create"><i class="glyphicon glyphicon-plus"> </i> Laporan Pengaduan</a>
              <a class="btn btn-primary btn-sm pull-right" id="cetak_lapdu"><i class="glyphicon glyphicon-print">  </i> Cetak</a>
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
    width:auto; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
</style>
<div class="box box-primary">
<div class="col-sm-12" style="margin-bottom: 20px; margin-top: 20px;">
     <!-- <fieldset class="group-border">
        <legend class="group-border">Daftar laporan Pengaduandsfsdf</legend> -->
  <div class="panel panel-primary">
     <div class="panel-heading">Daftar Lapdu</div>
      <div class="panel-body" >
            <div id="w1" class="grid-view">
            <?php Pjax::begin(['id' => 'lapdu-grid', 'timeout' => false,'formSelector' => '#searchFormLapdu','enablePushState' => false]) ?>
              <?= GridView::widget([
                  'dataProvider'=> $dataProvider,
                  // 'filterModel' => $searchModel,
                   'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                  // 'layout' => "{items}\n{pager}",
                  'columns' => [
                      ['header'=>'No',
                      'headerOptions'=>['style'=>'text-align:center;'],
                      'contentOptions'=>['style'=>'text-align:center;'],
                      'class' => 'yii\grid\SerialColumn'],
                      
                      
                      ['label'=>'No Register',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'attribute'=>'no_register',
                      ],

                      ['label'=>'Perihal',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'attribute'=>'perihal_lapdu',
                      ],

                      ['label'=>'Pelapor',
                          'format'=>'raw',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['class'=>'panggilan'],
                              'value' => function ($data) {
                                $pecah=explode('#', $data['pelapor']);
                                $result_pelapor='';
                                $no_pelapor=1;
                                for ($i=0; $i < count($pecah); $i++) { 
                                  if(count($pecah)<=1){
                                    $result_pelapor .=$pecah[$i];
                                  }else{
                                    $result_pelapor .=$no_pelapor.'. '.$pecah[$i].'<br>';
                                  }
                                  $no_pelapor++;
                                }
                                  return $result_pelapor; 
                          },
                      ], 

                      ['label'=>'Sumber Laporan',
                          'format'=>'raw',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['class'=>'panggilan'],
                              'value' => function ($data) {
                                $pecah1=explode('#', $data['id_sumber_laporan']);
                                $result_sumber='';
                                $no_sumber=1;
                                for ($i=0; $i < count($pecah1); $i++) { 
                                  if(count($pecah1)<=1){
                                    $result_sumber .=$pecah1[$i];
                                  }else{
                                    $result_sumber .=$no_sumber.'. '.$pecah1[$i].'<br>';
                                  }
                                  $no_sumber++;
                                }
                                  return $result_sumber; 
                          },
                      ],

                      ['label'=>'Terlapor',
                          'format'=>'raw',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['class'=>'panggilan'],
                              'value' => function ($data) {
                                $pecah2=explode('#', $data['terlapor']);
                                $result_terlapor='';
                                $no_terlapor=1;
                                for ($i=0; $i < count($pecah2); $i++) { 
                                  if(count($pecah2)<=1){
                                    $result_terlapor .=$pecah2[$i];
                                  }else{
                                    $result_terlapor .=$no_terlapor.'. '.$pecah2[$i].'<br>';
                                  }
                                  $no_terlapor++;
                                }
                                  return $result_terlapor; 
                          },
                      ],

                      ['label'=>'Satker',
                          'format'=>'raw',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['class'=>'panggilan'],
                              'value' => function ($data) {
                                $pecah3=explode('#', $data['satker_terlapor']);
                                $result_satker='';
                                $no_satker=1;
                                for ($i=0; $i < count($pecah3); $i++) { 
                                  if(count($pecah3)<=1){
                                    $result_satker .=$pecah3[$i];
                                  }else{
                                    $result_satker .=$no_satker.'. '.$pecah3[$i].'<br>';
                                  }
                                  $no_satker++;
                                }
                                  return $result_satker; 
                          },
                      ],

                      ['label'=>'Satus',
                          'format'=>'raw',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['class'=>'panggilan'],
                              'value' => function ($data) {
                                $pecah4=explode('#', $data['status']);
                                $result_status='';
                                $no_status=1;
                                for ($i=0; $i < count($pecah4); $i++) { 
                                  if(count($pecah4)<=1){
                                    $result_status .=$pecah4[$i];
                                  }else{
                                    $result_status .=$no_status.'. '.$pecah4[$i].'<br>';
                                  }
                                  $no_status++;
                                }
                                  return $result_status; 
                          },
                      ],

                       ['class' => 'yii\grid\CheckboxColumn',
                           'headerOptions'=>['style'=>'text-align:center'],
                           'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                     'checkboxOptions' => function ($data) {
                                      $result=json_encode($data);
                                    return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result,'disposisi'=>$data['tgl_disposisi']];

                                      },
                              ],

                   

                        
                   ],   

              ]); ?>
             <?php Pjax::end(); ?>
          </div>

      </div>
  </div>
<!-- </fieldset> -->
    </div>
  </div>
</div>
<style type="text/css">


 /*   tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}*/
#tbl1 th{
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
$("#hapus_lapdu").addClass("disabled");
$("#cetak_lapdu").addClass("disabled");
    /*permintaan pa putut*/
   
         $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
       $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
    function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_lapdu, #cetak_lapdu, #hapus_lapdu').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_lapdu').removeClass('disabled');
               $('#ubah_lapdu, #cetak_lapdu').addClass('disabled');
            } else{
               $('#ubah_lapdu, #cetak_lapdu, #hapus_lapdu').addClass('disabled');
            }
    }
}

$(document).ready(function(){

  //   $('#tbl1').dataTable(
  //       {
  //           "autoWidth":false
  //       });
  // var dataTable = $('#tbl1').dataTable();
  //   $("#lapdusearch-cari").keyup(function() {
  //       dataTable.fnFilter(this.value);
  //   });

$('.table-bordered tr').hover(function() {
      $(this).addClass('hover');
    }, function() {
      $(this).removeClass('hover');
    });

    $('#cetak_lapdu').click(function(){
        var x   =$(".selection_one:checked").length;
        // var link=$(".selection_one:checked").val();
        var link=JSON.parse($(".selection_one:checked").attr('json'));
        /*alert(x);
        exit();*/
        if(x>=2 || x<=0){
            var warna='black';
            bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk dicetak",
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
            
        location.href='/pengawasan/lapdu/cetakdoc?id='+link.no_register;
         }

    });
    
    $('#ubah_lapdu').click(function(){
      var data=JSON.parse($(".selection_one:checked").attr('json'));
        

        var x   =$(".selection_one:checked").length;
        var link=$(".selection_one:checked").val();
        // //var id_wilayah =$("#checkbox:checked").attr('id_wilayah');
        var id_tingkat =data.id_tingkat;
        var id_kejati  =data.id_kejati;  
        var id_kejari  =data.id_kejari; 
        var id_cabjari =data.id_cabjari; 
        var no_register =data.no_register;
        var disposisi  =JSON.parse($(".selection_one:checked").attr('json'));

     
         if(disposisi.tgl_disposisi!=null){
            var warna='black';
            bootbox.dialog({
                message: "Status akhir Laporan Pengaduan sudah melewati LAPDU atau sudah masuk disposisi inspektur, data tidak dapat diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
      //notify(warna);
         // return false
         }else{
          location.href='/pengawasan/lapdu/update?no_register='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari
         }
      
         
         
  //}
    });

        
    $('#hapus_lapdu').click(function(){
    var x         =$(".selection_one:checked").length;
    //var status    = $(".checkbox-row:checked").attr('nilai');
    var disposisi  =$(".selection_one:checked").attr('disposisi');
    //if(status !='inspektur')
    if(disposisi !='')
    {
    bootbox.dialog({
                message: "Status akhir Laporan Pengaduan sudah melewati LAPDU atau sudah masuk disposisi inspektur, data tidak dapat dihapus",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
    }
    else
    {
    
       
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-primary",
                                callback: function(){   
                                var checkValues = $('.selection_one:checked').map(function()
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
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        
      
    }
            });

$('tr').dblclick(function(){
  var id = $(this).find('.checkbox-row').val();
  //var status = $(this).find(".checkbox-row").attr('nilai');
 // var disposisi =  $(this).find(".checkbox-row").attr('disposisi');
  var id_tingkat =$(this).find(".selection_one").attr('id_tingkat');
  var id_kejati  =$(this).find(".selection_one").attr('id_kejati');  
  var id_kejari  =$(this).find(".selection_one").attr('id_kejari'); 
  var id_cabjari =$(this).find(".selection_one").attr('id_cabjari'); 
  var no_register =$(this).find(".selection_one").attr('no_register'); 
  // var status     =$(this).find(".selection_one").attr('nilai');
  var disposisi  =$(this).find(".selection_one").attr('disposisi');
  /* alert(disposisi);*/
    if(disposisi!='')
    {
    bootbox.dialog({
                message: "Status akhir Laporan Pengaduan sudah melewati LAPDU atau sudah masuk disposisi inspektur, data tidak dapat diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
    }
    else
    {
         location.href='/pengawasan/lapdu/update?no_register='+no_register+'&id_tingkat='+id_tingkat+'&id_kejati='+id_kejati+'&id_kejari='+id_kejari+'&id_cabjari='+id_cabjari;  
    }
});
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


