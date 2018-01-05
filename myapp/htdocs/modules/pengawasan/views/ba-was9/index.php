<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'BA-WAS 9';
$this->subtitle = 'SURAT PERNYATAAN BANDING ADMINISTRATIF TERHADAP SK PHD';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>




<section class="content" style="padding: 0px;">
<br>

<div class="pidum-pdm-spdp-index">
    <br>
    <div id="divHapus">
		<div class="pull-left"></div>
		<div class="pull-right">
		<button type="button" id="tambah" class="btn btn-primary" data-toggle="modal" style="border:none;"><i class="fa fa-plus"></i> Tambah</button>
		<button id="ubah" class="btn btn-primary" type="button"><i class="fa fa-pencil"></i> Ubah</button>&nbsp;
    <button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>
		<button id="btnHapus" class="btn btn-primary" type="button"><i class="fa fa-trash"></i> Hapus</button>
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
                                      
                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_terlapor',
                                    ],
 
                                    ['label'=>'Yang Menerima BA.WAS-9',
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
                                 'contentOptions'=>['style'=>'text-align:center; width:5%','class'=>'aksinya'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_ba_was_9'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);  ?>
		
		<br /> 
</div>
</section>
<script>
  window.onload=function(){
    $('#ubah,#btnHapus, #btnCetak').addClass('disabled'); 

    $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
          var id = $(this).closest('tr').find('.selection_one').val();
          // alert(id);
                 location.href='/pengawasan/ba-was9/update?id='+id;   
          //do something with id
        });
  



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

  $(document).on('click','#btnCetak',function() {
    var data= JSON.parse($(".selection_one:checked").attr('json')); 
    location.href='/pengawasan/ba-was9/cetak?id='+data.id_ba_was_9;
  });

	$(document).on('click','#tambah',function() { 
		location.href='/pengawasan/ba-was9/create';
	});

  $(document).on('click','#ubah',function() {
    var data= JSON.parse($(".selection_one:checked").attr('json'));
    location.href='/pengawasan/ba-was9/update?id='+data.id_ba_was_9;
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
                                                url:'/pengawasan/ba-was9/delete',
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
};
$(document).ready(function(){

        // $('tr').dblclick(function(){
        //     var id = $(this).find('.selection_one').val();
        //  // var data=JSON.parse($('.selection_one:checked').attr('json'));
        //           location.href='/pengawasan/ba-was9/update?id='+id; 
        // });
 });
</script>