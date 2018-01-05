<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP24Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'P24';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;


?>

<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
  
<div class="pdm-p24-index">

    <div id="divTambah" class="col-md-11">
        <?php // Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-p24/delete/'
        ]);  
    ?>  
	  <!-- <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div> -->
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"></div>
	
<!--	<div class="inline pull-right">
    <button id="idPilih" class="btn btn-warning btnPilihCheckboxIndex" disabled>Pilih</button>
    </div>-->
    <div class="" style="padding-top:0px;">
    <h4>Berkas Perkara</h4></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p24'],'data-idberkas' => $model['id_berkas']];
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
                'value'=>$model->no_tgl_berkas,


            ],
            [
                'attribute'=>'tgl_berkas',
                'label' => 'Tanggal Berkas',
                'format' => 'raw',
                'value'=>$model->tgl_berkas,


            ],
			
			[
                'attribute'=>'nama_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
						$modelGridTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $model['id_berkas']])->orderBy(['no_urut'=>sort_asc])->all();
						$tersangka = '';
						$i=1; 
						foreach ($modelGridTersangka as $key => $value): 
							$tersangka .= $i.". ".$value->nama."<br/>";
							$i++; 
						endforeach;
                        return $tersangka;
                    }


            ],
//			[
//                'class'=>'kartik\grid\CheckboxColumn',
//                    'headerOptions'=>['class'=>'kartik-sheet-style'],
//                    'checkboxOptions' => function ($model, $key, $index, $column) {
//                        return ['value' => $model['id_berkas'], 'class' => 'checkPilih'];
//                    }
//            ],
			
       ],
       	'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>
      
    </div>

<div class="box box-primary keterangan" style="border-color: #f39c12;padding: 15px;overflow: hidden; display:none">


			
    <div class="inline pull-right">
	<button id="cetak" class='btn btn-warning btnPrintCheckboxIndex' disabled>Cetak</button> 
    <button id="cetak_draft" class='btn btn-primary btnPrintCheckboxIndexDraft' disabled>Cetak Draft P-24</button> <button id="idUbah" class="btn btn-success" disabled >Resume Pendapat</button>
    </div>
<div class="pdm-p24-index child-keterangan" >
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
        <th data-col-seq="0" style="width:30;">
        <a >No Pengantar</a>
        </th>
        <th data-col-seq="1" style="width:30%;">
        <a >Tanggal Pengantar</a>
        </th>
        <th data-col-seq="2" style="width: 10%;">
        <a href="javascript:void(0)">Tanggal Diterima</a>
        </th>
       <!-- <th data-col-seq="2" style="width: 25%;">
        <a href="javascript:void(0)">Tersangka</a>
        </th>-->
        <th data-col-seq="2" style="width: 5%;">
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
<?php

 
$js = <<< JS
$(document).on('change',function(){
	if($('.checkPilih:checked').length>1||$('.checkPilih:checked').length==0)
	{
	 $('#idPilih').prop('disabled',true);
	}
	else
	{
	  var id_berkas        = $('.checkPilih:checked').data('id');
	  $('#idPilih').removeAttr('disabled');
	}
});
		   
$('.summary').remove();
        
        var id_berkas=$('.table').closest('table').find(' tbody tr:first').data('idberkas');
     pilihPengantar(id_berkas);

function pilihPengantar(id_berkas){
	if(id_berkas != '')
            {
                $.ajax({
                        type        : 'POST',
                        url         :'/pdsold/pdm-p24/get-pengantar-thp1',
                        data        : 'id_berkas='+id_berkas,
                        dataType    : 'json',
                        success     : function(data)
                                    {
                                     var result = $.parseJSON(JSON.stringify(data));
                                     if(result.count>0)
                                     {

                                      $('div.keterangan').show();
                                      var table = $.parseJSON(result.result);
                                      var tr ='';
                                      
                                      $.each(table,function(i,x){
                                       // //var link = "/pdsold/pdm-p24/update?id_p24=" +x.id_p24+"&id_pengantar="+x.id_pengantar;
                                       //  alert(link);
                                        tr  +=  '<tr data-id="'+x.id_p24+'" class="pengantar" >'+
                                                    '<td ondblclick="window.location=\'/pdsold/pdm-p24/update?id_p24='+x.id_p24+'&id_pengantar='+x.id_pengantar+'\'" data-col-seq="0" style="width:30;">'+x.no_pengantar+'</td>'+
                                                    '<td ondblclick="window.location=\'/pdsold/pdm-p24/update?id_p24='+x.id_p24+'&id_pengantar='+x.id_pengantar+'\'" data-col-seq="1" style="width:30%;">'+x.tgl_pengantar+'</td>'+
                                                    '<td ondblclick="window.location=\'/pdsold/pdm-p24/update?id_p24='+x.id_p24+'&id_pengantar='+x.id_pengantar+'\'" data-col-seq="3" style="width: 10%;">'+x.tgl_terima+'</td>'+
                                                   // '<td //ondblclick="window.location=\'/pdsold/pdm-p24/update?id_p24='+x.id_p24+'&id_pengantar='+x.id_pengantar+'\'"// data-col-seq="4" style="width: 25%;">'+x.nama_tersangka+'</td>'+
                                                    '<td data-col-seq="5" style="width: 5%;">'+
                                                    '<input type="checkbox" value="'+x.id_pengantar+'" class="child-chekbox checkHapusIndex" data-id="'+x.id_p24+'" data-idpengantar="'+x.id_pengantar+'" data-idberkas="'+x.id_berkas+'" >'+
                                                    '</td>'+
                                               ' </tr>';
                                      });
                                      $('.pengantar-tahap-1 tbody').html(tr)
                                     }
                                     else
                                     {
                                        alert('data kosong');
                                        $('div.keterangan').hide();
                                     }
                                     
                                    }
                }); 
            }
}

 $('#idPilih').click (function (e) {
        var count =$('.checkPilih:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                    message: "Silahkan pilih hanya 1 berkas untuk proses P-24",
                    buttons:{
                        ya : {
                            label: "OK",
                            className: "btn-warning",

                        }
                    }
                });
        } else {
			var id_berkas =$('.checkPilih:checked').val();
			pilihPengantar(id_berkas);
		}
 });
 
     $(document).ready(function(){
         $('td').dblclick(function (e) {
            var id_berkas = $(this).closest('tr').data('idberkas');
            pilihPengantar(id_berkas);
        });
        $('#idUbah').click(function(){
          var idp24         = $('#idUbah').attr('data-idp24');
          var id_pengantar  = $('#idUbah').attr('data-idpengantar');
          var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p24/update?id_p24=" + idp24+"&id_pengantar=" +id_pengantar;
          $(location).attr('href',url);
        })
        $(document).on('change',function(){
         if($('.child-chekbox:checked').length>1||$('.child-chekbox:checked').length==0)
           {
			   
             $('#idUbah').prop('disabled',true);
             $('#cetak').prop('disabled',true);
             $('#idUbah').removeAttr('data-idp24');
             $('#idUbah').removeAttr('data-idpengantar');
             $('#cetak_draft').prop('disabled',true);
           }
           else
           {
			   
              var id_p24        = $('.child-chekbox:checked').data('id');
              (id_p24 == null)?id_p24='null':id_p24;
              var id_pengantar  = $('.child-chekbox:checked').data('idpengantar');
              $('#idUbah').removeAttr('disabled');
              $('#cetak').removeAttr('disabled');
              $('#cetak_draft').removeAttr('disabled');
              $('#idUbah').attr('data-idp24',id_p24);
              $('#idUbah').attr('data-idpengantar',id_pengantar); 
           }
        })

     });
       

  // $('td').dblclick(function (e) {
  //       var idp24 = $(this).closest('tr').data('id');
  //       var id_pengantar = $(this).closest('tr').data('idpengantar');
        
  //       var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p24/update?id_p24=" + idp24+"&id_berkas=" +idberkas;
  //       $(location).attr('href',url);
  //   });
  
  $('.btnPrintCheckboxIndexDraft').click(function(){
            var id_pengantar = $('.child-chekbox:checked').val();
            var cetak   = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p24/cetakdraft?id_pengantar="+id_pengantar; 
            window.location.href = cetak;
        }); 
		
	$('.btnPrintCheckboxIndex').click(function(){
		

			
            var id = $('.checkHapusIndex:checked').data('id');
            var idberkas = $('.checkHapusIndex:checked').data('idberkas');
			
			if(id==null){
				bootbox.dialog({
                message: "Belum Input Data P-24",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
				});
			}else{
				var cetak   = 'cetak?id_p24='+id+'&id_berkas='+idberkas; 
				window.location.href = cetak;
			}
		
    }); 

      
JS;

    $this->registerJs($js);
?>
