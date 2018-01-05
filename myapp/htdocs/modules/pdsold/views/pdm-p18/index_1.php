<?php


use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP21Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P-18';
$this->subtitle = 'Hasil Penyelidikan Belum Lengkap';
?>
<div class="pdm-p21-index">
<div id="divTambah" class="col-md-11" style="width:82%;">
        <button id="tambah" class='btn btn-warning' >Tambah</button>
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak</button>
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    <?php
        $form = \kartik\widgets\ActiveForm::begin([
             'id' => 'hapus-index',
             'action' => '/pdsold/pdm-p18/delete/'
         ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php  \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"></div>
<div class="" style="padding-top:0px;"><h4>Berkas</h4></div>
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p18'],'data-idpengantar' => $model['id_pengantar']];
		},
        'columns' => [

			[
                'attribute'=>'no_tgl_berkas',
                'label' => 'Nomor dan  Tanggal Berkas',
                'format' => 'raw',
                'value'=>$model->no_tgl_berkas,


            ],
			
			[
                'attribute'=>'id_tersangka',
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
			
			[
                'attribute'=>'no_tgl_p18',
                'label' => 'Nomor dan Tanggal P-18',
                'format' => 'raw',
                'value'=> $model->no_tgl_p18,


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['data-id' => $model['id_p18'],'data-idpengantar' => $model['id_pengantar'],'value' => $model['id_p18'], 'class' => 'checkHapusIndex'];
                    }
            ],
			
		
       ],
       	'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>



<?php

 
    $js = <<< JS
//        var idp18       = $('.table').closest('table').find(' tbody tr:first').data('id');
//            alert(idp18);
            

//    var idp18       = $('.table').closest('table').find(' tbody tr:first').data('id');
//    var idpengantar = $('.table').closest('table').find(' tbody tr:first').data('idpengantar');
//            if(idp18 == ""){
//                alert("data kosong");
//            }
//            else{
//            var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p18/update?id_p18=" + idp18+"&id_pengantar=" +idpengantar;
//    $(location).attr('href',url);
//            }
            
//        var idp18       = $(this).closest('tr').data('id');
//        var idpengantar = $(this).closest('tr').data('idpengantar');
//            alert('idp18');
               
    
            
            
	
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
        if($('tbody tr td:eq(2)').text()!='-')
        {
            $('#divTambah button').hide();
        }
  $('#divTambah button').click(function(){
        var idp18       = $('.checkHapusIndex:eq(0)').data('id');
        var idpengantar = $('.checkHapusIndex:eq(0)').data('idpengantar');
        console.log(idpengantar);
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p18/update?id_p18=" + idp18+"&id_pengantar=" +idpengantar;
       $(location).attr('href',url);
    });

        $('td').dblclick(function (e) {
        var idp18       = $(this).closest('tr').data('id');
        var idpengantar = $(this).closest('tr').data('idpengantar');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p18/update?id_p18=" + idp18+"&id_pengantar=" +idpengantar;
            $(location).attr('href',url);
        });

    $(document).on('change',function(){
        var length_check = $('.checkHapusIndex:checked').length;
        if(length_check==1)
        {
             $('.btnUbahCheckboxIndex').removeAttr('disabled');
        
        }
        if(length_check > 1||length_check==0)
        {

            $('.btnUbahCheckboxIndex').prop('disabled','true');
        }
    }); 

      $('.btnUbahCheckboxIndex').click(function(){
        var idp18       = $('.checkHapusIndex:checked').data('id');
        var idpengantar = $('.checkHapusIndex:checked').data('idpengantar');
        console.log(idpengantar);
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p18/update?id_p18=" + idp18+"&id_pengantar=" +idpengantar;
       $(location).attr('href',url);
    });
    
      $(document).on('change',function(){
            var length_check = $('.checkHapusIndex:checked').length;
            if(length_check==1)
            {
                 $('.btnPrintCheckboxIndex,.btnHapusCheckboxIndexi').removeAttr('disabled');
            
            }
            if(length_check > 1||length_check==0)
            {

                $('.btnPrintCheckboxIndex,.btnHapusCheckboxIndexi').prop('disabled','true');
            }
        });
     $('.btnPrintCheckboxIndex').click(function(){
            var id_p18 = $('.checkHapusIndex:checked').data('id');
            var idpengantar = $('.checkHapusIndex:checked').data('idpengantar');
            if(id_p18!='0')
            {
               
               var cetak   = 'cetak?id_p18='+id_p18+'&id_pengantar='+idpengantar; 
                window.location.href = cetak;  
            }
            else
            {
             bootbox.dialog({
                message: "<center>Tidak Dapat Cetak, Data P-18 Masih Kosong</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning"
                    }
                    }
                });
            }
            
        }); 
    $(".btnHapusCheckboxIndexi").attr("disabled",true);


    
JS;

    $this->registerJs($js);
?>