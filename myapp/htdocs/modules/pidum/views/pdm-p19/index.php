<?php


use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP21Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P-19';
$this->subtitle = 'Pengembalian Berkas Perkara untuk Dilengkapi';
?>
<div class="pdm-p19-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <div id="divTambah" class="col-md-11">

 </div>
<div class="clearfix"></div>
<div class="" style="padding-top:0px;"><h4>Berkas</h4></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p18'],'data-idberkas' => $model['id_berkas']];
        },
        'columns' => [

            [
                'attribute'=>'no_tgl_berkas',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
                'value'=>$model->no_tgl_berkas,


            ],
            
            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $column) {
                        $ex_id = explode('|',$model['id_pengantar']);
                        //echo '<pre>';print_r($ex_id);exit;
						$modelGridTersangka = MsTersangkaBerkas::find()->where(['id_berkas' => $model['id_berkas'], 'no_pengantar'=>$ex_id[1]])->orderBy(['no_urut'=>sort_asc])->all();
						$tersangka = '';
						$i=1; 
						foreach ($modelGridTersangka as $key => $value): 
							$tersangka .= $i.". ".$value->nama."<br/>";
							$i++; 
						endforeach;
                        return $tersangka;
                    }


            ],
            
        
       ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>

<div class="box box-primary keterangan " style="border-color: #f39c12;padding: 15px;overflow: hidden;">

     <div style="float:right;margin-right:1%">
    <button id="idUbah" class="btn btn-success" disabled >Tambah P-19</button>
    </div>
    <div  style="float:right;margin-right:1%">
    <button id="idUbah" class="btn btn-success btnPrintCheckboxIndex" disabled >Cetak</button>
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
        <a >Nomor dan Tanggal Pengantar</a>
        </th>
        <th data-col-seq="1" style="width:30%;">
        <a >Tanggal Terima Penyidik</a>
        </th>
        
        <th data-col-seq="2" style="width: 5%;">
        <a href="javascript:void(0)">Nomor P-19</a>
        </th>
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
            
        
            
            
	$('.keterangan').hide();

	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}

    $(document).ready(function(){
            var id_berkas=$('.table').closest('table').find(' tbody tr:first').data('idberkas');
            pilihPengantar(id_berkas);    
            function pilihPengantar(id_berkas){
	if(id_berkas != '')
            {
                $.ajax({
                        type        : 'POST',
                        url         :'/pidum/pdm-p19/get-pengantar-thp1',
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
                                       // //var link = "/pidum/pdm-p24/update?id_p24=" +x.id_p24+"&id_pengantar="+x.id_pengantar;
                                       //  alert(link);
                                        tr  +=  '<tr ondblclick="window.location=\'/pidum/pdm-p19/update?id_p19='+ x.id_p19+'&id_pengantar='+x.id_pengantar+'&id_berkas='+x.id_berkas+'\'" class="pengantar" >'+
                                                    '<td  data-col-seq="0" style="width:30;">'+x.no_pengantar+'</td>'+
                                                    '<td  data-col-seq="3" style="width: 10%;">'+x.tgl_terima+'</td>'+
                                                     '<td data-col-seq="5" style="width: 5%;">'+x.no_surat+'</td>'+
                                                    '<td data-col-seq="5" style="width: 5%;">'+
                                                    '<input type="checkbox" class="child-chekbox" data-id="'+x.id_p19+'" data-berkas="'+x.id_berkas+'" data-idpengantar="'+x.id_pengantar+'" data-idp24="'+x.id_p24+'" >'+
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
            
            
         $('td').dblclick(function (e) {
			
			 
            var id_berkas = $(this).closest('tr').data('idberkas');
            if(id_berkas != '')
            {
                $.ajax({
                        type        : 'POST',
                        url         :'/pidum/pdm-p19/get-pengantar-thp1',
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
                                       // //var link = "/pidum/pdm-p24/update?id_p24=" +x.id_p24+"&id_pengantar="+x.id_pengantar;
                                       //  alert(link);
                                        tr  +=  '<tr ondblclick="window.location=\'/pidum/pdm-p19/update?id_p19='+ x.id_p19+'&id_pengantar='+x.id_pengantar+'&id_berkas='+x.id_berkas+'\'" class="pengantar" >'+
                                                    '<td  data-col-seq="0" style="width:30;">'+x.no_pengantar+'</td>'+
                                                    '<td  data-col-seq="3" style="width: 10%;">'+x.tgl_terima+'</td>'+
                                                     '<td data-col-seq="5" style="width: 5%;">'+x.no_surat+'</td>'+
                                                    '<td data-col-seq="5" style="width: 5%;">'+
                                                    '<input type="checkbox" class="child-chekbox" data-id="'+x.id_p19+'" data-berkas="'+x.id_berkas+'" data-idpengantar="'+x.id_pengantar+'" data-idp24="'+x.id_p24+'" >'+
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
            
            
        });

      
        $(document).on('change',function(){
         if($('.child-chekbox:checked').length>1||$('.child-chekbox:checked').length==0)
           {
             $('#idUbah,.btnPrintCheckboxIndex').prop('disabled',true);
             $('#idUbah,.btnPrintCheckboxIndex').removeAttr('data-idp24');
             $('#idUbah,.btnPrintCheckboxIndex').removeAttr('data-idpengantar');
           }
           else
           {
              var id_p24        = $('.child-chekbox:checked').data('id');
              (id_p24 == null)?id_p24='null':id_p24;
              var id_pengantar  = $('.child-chekbox:checked').data('idpengantar');
              $('#idUbah,.btnPrintCheckboxIndex').removeAttr('disabled');
              $('#idUbah,.btnPrintCheckboxIndex').attr('data-idp24',id_p24);
              $('#idUbah,.btnPrintCheckboxIndex').attr('data-idpengantar',id_pengantar);
           }
        })

     });

     $('.btnPrintCheckboxIndex').click(function(){
            var idp19        = $('.child-chekbox:checked').data('id');
            var idpengantar  = $('.child-chekbox:checked').data('idpengantar');
            var idberkas     = $('.child-chekbox:checked').data('berkas');
            if(idp19!=null)
            { 
           
               var cetak = "cetak?id=" + idp19+"&id_pengantar=" +idpengantar;
                window.location.href = cetak;  
            }
            else
            {
             bootbox.dialog({
                message: "<center>Tidak Dapat Cetak, Data P-19 Masih Kosong</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning"
                    }
                    }
                });
            }
        }); 

      $('#idUbah').click(function(){
        var idp19        = $('.child-chekbox:checked').data('id');
        var idpengantar  = $('.child-chekbox:checked').data('idpengantar');
        var idberkas     = $('.child-chekbox:checked').data('berkas');
        var url = 'update?id_p19='+ idp19 +'&id_pengantar='+idpengantar+'&id_berkas='+idberkas;
        window.location.href = url;
    });
       


JS;

    $this->registerJs($js);
?>