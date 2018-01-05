<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'BA-WAS 8';
$this->subtitle = 'SURAT PEMBELAAN DIRI DIHADAPAN MAJELIS KEHORMATAN JAKSA TERHADAP HUKUMAN DISIPLIN YANG AKAN DIJATUHKAN';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>




<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">
<br />

<div class="box box-primary" style="padding:10px;">
<div class="pidum-pdm-spdp-index">

   <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <br />
	<!--<strong><h3>BERITA ACARA PEMBERITAHUAN AKAN DIJATUHKAN HUKUMAN DISIPLIN BERAT</h3></strong>-->
	<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div id="divHapus">
		<div class="pull-left"></div>
		<div class="pull-right">
		<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" style="border:none;"><i class="fa fa-plus"></i> Tambah</button>
		<button type="button" id="ubah" class="btn btn-primary" data-toggle="modal" style="border:none;"><i class="fa fa-edit"></i> Ubah</button>
		<button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>&nbsp;
		<button id="btnHapus" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button>
		</div>
    </div>
	
	<br /><br />
	
	<?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'table table-striped table-bordered table-hover'], 
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'header'=>'No',
                                    'class' => 'yii\grid\SerialColumn'],
                                      
                                    ['label'=>'Nip Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_terlapor',
                                    ],
 
                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_terlapor',
                                    ],

                                    ['label'=>'Nama Menerima',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_menerima',
                                    ],

                                    ['label'=>'Keterangan',
										'format'=>'raw',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        value=>function($data){
											if($data['terima_tolak']=='1'){
												$hasil = 'Terima';
											}else if($data['terima_tolak']=='2'){
												$hasil = 'Tolak';
											}else{
												$hasil = '-';
											}
											return '<b>'.$hasil.'</b>';
										}
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_ba_was_8'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);  ?>
		
		<br />
		 

</div>
</div>
<?//= Html::Button('<i class="fa fa-arrow-left"></i> Kembali', ['class' => 'tombolbatal btn btn-primary', 'value' => $id_register]) ?>
</div>
</section>

<script type='text/javascript'>
	window.onload=function(){
		$('#ubah,#btnHapus, #btnCetak').addClass('disabled'); 
	
	
	$(document).on('change','.selection_one',function() {
		var c = this.checked ? '#f00' : '#09f';
        if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
		var x =$('.selection_one:checked').length;
		ConditionOfButton(x);
	});

    $(document).on('change','.select-on-check-all',function() {
        var c = this.checked ? true : false;
        if(c==true){
             $('tbody tr').addClass('danger');
            }else{
            $('tbody tr').removeClass('danger');
            }
        var x=$('.selection_one:checked').length;
        ConditionOfButton(x);
    });
	
 
	function ConditionOfButton(n){
			if(n == 1){
			   $('#btnCetak,#ubah, #btnHapus').removeClass('disabled');
			} else if(n > 1){
			   $('#btnHapus').removeClass('disabled');
			   $('#btnCetak,#ubah').addClass('disabled');
			} else{
			   $('#btnCetak,#ubah, #btnHapus').addClass('disabled');
			}
	}
	
	$(document).on('click','#ubah',function() {
		var data= JSON.parse($(".selection_one:checked").attr('json'));
		location.href='/pengawasan/ba-was8/update?id='+data.id_ba_was_8;
	});
	
	$(document).on('click','#btnCetak',function() {
		var data= JSON.parse($(".selection_one:checked").attr('json')); 
		location.href='/pengawasan/ba-was8/cetak?id='+data.id_ba_was_8;
	});
	
	$(document).on('click','#tambah',function() { 
		location.href='/pengawasan/ba-was8/create';
	});
	
	$(document).on('click','#btnHapus',function(){  
		var x=$(".selection_one:checked").length;
               // alert(x);/
                 if(x<=0){ 
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
                                        var checkValues = $('.selection_one:checked').map(function()
                                        {
                                             return $(this).val();
                                        }).get();
									
										//alert(checkValues);
										//return false();
                                        $.ajax({
                                                type:'POST',
                                                url:'/pengawasan/ba-was8/delete',
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
 $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.selection_one').val();
          // alert(id);
                 location.href='/pengawasan/ba-was8/update?id='+id;   
          //do something with id
        });
};

$(document).ready(function(){

        // $('tr').dblclick(function(){
        //     var id = $(this).find('.selection_one').val();
        //  // var data=JSON.parse($('.selection_one:checked').attr('json'));
        //           location.href='/pengawasan/ba-was8/update?id='+id; 
        // });
 });
</script>

