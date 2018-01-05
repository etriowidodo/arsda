<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP24Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar CekLis Berkas';
//$this->title = 'P24';
//$this->params['breadcrumbs'][] = $this->title;
//$this->title = $sysMenu->kd_berkas;
//$this->subtitle = $sysMenu->keterangan;


?>
<div class="content-wrapper-1">
<div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
<div class="pdm-berkas-tahap1-index">


    <div id="divTambah" class="col-md-11">
        <?php // Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-berkas-tahap1/delete/'
        ]);  
    ?>  
<!--    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div> -->
    <?php \kartik\widgets\ActiveForm::end() ?>
    <?php
    $tgl_berkas=date('Y-m-d',strtotime($model->tgl_berkas));
    ?>
  
  <div class="box-header with-border" style="border-color: #c7c7c7;">
<!--    <div class="inline pull-right">
    <button id="idPilih" class="btn btn-warning btnPilihCheckboxIndex" disabled>Pilih</button>
    </div>-->
    <div class="" style="padding-top:0px;">
    <h4>Berkas2</h4></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        
    'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_berkas'],'data-idberkas' => $model['id_berkas']];
    },
    
        'columns' => [
            /*[
                'attribute'=>'no_urut_romawi',
                'label' => '#',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return "Ke - " . Yii::$app->globalfunc->romanic_number($index+1);
                },
            ],*/

      [
                'attribute'=>'no_berkas',
                'label' => 'No Berkas',
                'format' => 'raw',
                'value'=>$model->no_berkas,


            ],
            [
                'attribute'=>'tgl_berkas',
                'label' => 'Tanggal Berkas',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
      
                return (date('d-m-Y',strtotime($model[tgl_berkas])));
    

                },


            ],
      
      [
                'attribute'=>'nama_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>$model->nama_tersangka,


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
            // var_dump($model);exit;
                        return ['value' => $model[id_berkas], 'class' => 'checkPilih'];
                    }
            ],
//      
       ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>
  </div>
</div>
      
    </div>

<div class="box box-primary keterangan" style="border-color: #f39c12;padding: 15px;overflow: hidden; display:none">
    <div class="pull-right">
    <button id="idUbah" class="btn btn-success inline" disabled >Isi Pendapat</button>
    </div>
    <div class="col-md-12 inline pull-right">
      <div class="">
            <?php // echo Html::a('Cetak CekLis', ['/template/pidum/checklist.odt'], ['class' => 'btn btn-warning']) ?>
			<button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak Ceklis</button>
        </div>
    </div>
<div class="pdm-berkas-tahap1-index child-keterangan" >
<div class="" style="padding-top:0px;">
<h4>Surat Pengantar</h4></div>
<div id="w0-pjax">
<div id="w0" class="grid-view" data-krajee-grid="kvGridInit_e03753b6">
<div class="rc-handle-container" style="width: 1289px;">
<div class="rc-handle" style="left: 379px; height: 172px;"></div><div class="rc-handle" style="left: 904px; height: 172px;"></div></div>
<div id="w0-container" class="table-responsive kv-grid-container">
<table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap pengantar-tahap-1">
    <thead>
    <tr>
        <th data-col-seq="0" style="width:20%;">
        <a >No dan Tanggal</a>
        </th>
        <!--<th data-col-seq="1" style="width:10%;">
        <a >Tanggal Pengantar</a>
        </th>-->
        <th data-col-seq="2" style="width: 10%;">
        <a href="javascript:void(0)">Tanggal Diterima</a>
        </th>
        <!--<th data-col-seq="2" style="width: 20%;">
        <a href="javascript:void(0)">Tersangka</a>
        </th>-->
        <th data-col-seq="2" style="width: 10%;">
        <a href="javascript:void(0)">Tanggal Selesai</a>
        </th>
        <th data-col-seq="2" style="width: 20%;">
        <a href="javascript:void(0)">Keterangan</a>
        </th>
        <th data-col-seq="2" style="width: 3%;">
        Pilih
        </th>
    </tr>
    </thead>
    <tbody>
  
    </tbody>
</table>
</div>
</div>
</div>
   

</div>
</div>                
</div>
<?php

$js = <<< JS
$(document).ready(function(){
    if($(".empty").text()=='Tidak ada data yang ditemukan.'){
        $(".select-on-check-all").hide();
    }
        
        function openBerkas(id_berkas){
        if(id_berkas != '')
        {
            $.ajax({
                type        : 'POST',
                url         :'/pidum/pdm-berkas-tahap1/get-pengantar-thp1',
                data        : 'id_berkas='+id_berkas,
                dataType    : 'json',
                success     : function(data){
                    var result = $.parseJSON(JSON.stringify(data));
                    if(result.count>0){
                        $('div.keterangan').show();
                        var table = $.parseJSON(result.result);
                        var tr ='';
                        $.each(table,function(i,x){
                            // //var link = "/pidum/pdm-berkas-tahap1/update?id_berkas=" +x.id_berkas+"&id_pengantar="+x.id_pengantar;
                            //  alert(link);
                            tr  +=  '<tr class="pengantar" >'+
                            '<td ondblclick="window.location=\'/pidum/pdm-berkas-tahap1/pendapat?id_berkas='+x.id_berkas+'&id_pengantar='+x.id_pengantar+'&id_ceklist='+x.id_ceklist+'\'" data-col-seq="0" style="width:20%;">'+x.no_pengantar+'<br>'+x.tgl_pengantar+'</td>'+
                            /*'<td ondblclick="window.location=\'/pidum/pdm-berkas-tahap1/pendapat?id_berkas='+x.id_berkas+'&id_pengantar='+x.id_pengantar+'&id_ceklist='+x.id_ceklist+'\'" data-col-seq="1" style="width:10%;">'+x.tgl_pengantar+'</td>'+*/
                            '<td ondblclick="window.location=\'/pidum/pdm-berkas-tahap1/pendapat?id_berkas='+x.id_berkas+'&id_pengantar='+x.id_pengantar+'&id_ceklist='+x.id_ceklist+'\'" data-col-seq="3" style="width: 10%;">'+x.tgl_terima+'</td>'+
                            '<td ondblclick="window.location=\'/pidum/pdm-berkas-tahap1/pendapat?id_berkas='+x.id_berkas+'&id_pengantar='+x.id_pengantar+'&id_ceklist='+x.id_ceklist+'\'" data-col-seq="5" style="width: 10%;">'+x.tgl_selesai+'</td>'+
                            '<td ondblclick="window.location=\'/pidum/pdm-berkas-tahap1/pendapat?id_berkas='+x.id_berkas+'&id_pengantar='+x.id_pengantar+'&id_ceklist='+x.id_ceklist+'\'" data-col-seq="7" style="width: 20%;">'+x.keterangan+'</td>'+
                            '<td data-col-seq="6" style="width: 3%;text-align:center">'+
                            '<input type="checkbox" class="child-chekbox" value="'+x.id_pengantar+'" data-id="'+x.id_berkas+'" data-idpengantar="'+x.id_pengantar+'" data-idceklist="'+x.id_ceklist+'" >'+
                            '</td>'+
                            ' </tr>';
                        });
                         $('.pengantar-tahap-1 tbody').html(tr)
                     } else {
                         alert('data kosong');
                         $('div.keterangan').hide();
                     }
                 }
             });
         }
     }

     var id_berkas=$('.table').closest('table').find(' tbody tr:first').data('idberkas');
     openBerkas(id_berkas);

     $('td').dblclick(function (e) {
         var id_berkas = $(this).closest('tr').data('idberkas');
        
     });

     $('#idPilih').click (function (e) {
         var count =$('.checkPilih:checked').length;
         if (count != 1 ){
             bootbox.dialog({
                 message: "Silahkan pilih hanya 1 berkas untuk proses ceklis",
                 buttons:{
                     ya : {
                         label: "OK",
                         className: "btn-warning",
                     }
                 }
             });
         } else {
             var id_berkas =$('.checkPilih:checked').val();
             openBerkas(id_berkas);
         }
     });

     $('.summary').remove();

     $('#idUbah').click(function(){
         var idbks1        = $('#idUbah').attr('data-idbks1');
         var id_pengantar  = $('#idUbah').attr('data-idpengantar');
         var id_ceklist  = $('#idUbah').attr('data-idceklist');
         var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-berkas-tahap1/pendapat?id_berkas=" + idbks1+"&id_pengantar=" +id_pengantar+"&id_ceklist=" +id_ceklist;
         $(location).attr('href',url);
     });

     $(document).on('change',function(){
         if($('.child-chekbox:checked').length>1||$('.child-chekbox:checked').length==0){
             $('#idUbah').prop('disabled',true);
             $('.btnPrintCheckboxIndex').prop('disabled',true);
             $('#idUbah').removeAttr('data-idbks1');
             $('#idUbah').removeAttr('data-idpengantar');
         }else{
             var id_berkas        = $('.child-chekbox:checked').data('id');
             (id_berkas == null)?id_berkas='null':id_berkas;
             var id_pengantar  = $('.child-chekbox:checked').data('idpengantar');
             var id_ceklist  = $('.child-chekbox:checked').data('idceklist');
             $('#idUbah').removeAttr('disabled');
             $('.btnPrintCheckboxIndex').removeAttr('disabled');
             $('#idUbah').attr('data-idbks1',id_berkas);
             $('#idUbah').attr('data-idpengantar',id_pengantar);
             $('#idUbah').attr('data-idceklist',id_ceklist);
         }
     });

     $(document).on('change',function(){
         if($('.checkPilih:checked').length>1||$('.checkPilih:checked').length==0){
             $('#idPilih').prop('disabled',true);
             // $('#idPilih').removeAttr('data-idbks1');
             // $('#idPilih').removeAttr('data-idpengantar');
         }else{
             var id_berkas        = $('.checkPilih:checked').data('id');
             // (id_berkas == null)?id_berkas='null':id_berkas;
             // var id_pengantar  = $('.checkPilih:checked').data('idpengantar');
             // var id_ceklist  = $('.checkPilih:checked').data('idceklist');
             $('#idPilih').removeAttr('disabled');
             // $('#idPilih').attr('data-idbks1',id_berkas);
             // $('#idPilih').attr('data-idpengantar',id_pengantar);
             // $('#idPilih').attr('data-idceklist',id_ceklist);
         }
     });
 });

 $('.btnPrintCheckboxIndex').click(function(){
     var id_pengantar = $('.child-chekbox:checked').val();
     var cetak   = 'cetak?id='+id_pengantar;
     window.location.href = cetak;
 });
JS;
    $this->registerJs($js);
?>
