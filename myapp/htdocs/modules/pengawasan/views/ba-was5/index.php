<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'BA-WAS 5';
$this->subtitle = 'BERITA ACARA PENYAMPAIAN SK PHD';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>




<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">
<br />

<div class="box box-primary" style="padding:10px;">
<div class="pidum-pdm-spdp-index">

   <?php// echo $this->render('_search', ['model' => $searchModel]); ?>
    <br />
	<!--<strong><h3>BERITA ACARA PEMBERITAHUAN AKAN DIJATUHKAN HUKUMAN DISIPLIN BERAT</h3></strong>-->
	<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div id="divHapus">
		<div class="pull-right">
			<a class="btn btn-primary" href="/pengawasan/ba-was5/create"><i class="fa fa-plus"></i> Tambah</a>
			<button id="btnUbah" class="btn btn-primary" type="button"><i class="fa fa-pencil"></i> Ubah</button>&nbsp;
			<button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>&nbsp;
			<button id="btnHapus" class="btn btn-primary" type="button"><i class="fa fa-trash"></i> Hapus</button>
		</div>
    </div>
	
	<br /><br />
	<?= GridView::widget([
            'id' => 'ba_was_5',
            'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_ba_was_5']];
            },
            'dataProvider' => $dataProvider,
            'tableOptions'=>['class'=>'table table-striped table-bordered table-hover'],
            'columns' => [
                ['header'=>'No',
                'class' => 'yii\grid\SerialColumn'],
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'NIP',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['nip_penerima'];
					},
                ],
				
				
				[
                    //'attribute'=>'peg_nama',
                    'label' => 'Nama',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['nama_penerima'];
					},
                ],
				
	
				[
                    'label' => 'Jabatan',
                    'format' => 'raw',
                    'value'=>function ($model, $key, $index, $grid) {
						return $model['jabatan_penerima'];
					},
                ],
				
							
				
				
				['class' => 'yii\grid\CheckboxColumn',
                     'headerOptions'=>['style'=>'text-align:center'],
                     'contentOptions'=>['style'=>'text-align:center; width:5%','class'=>' aksinya'],
                               'checkboxOptions' => function ($data) {
                                $result=json_encode($data);
                                return ['value' => $data['id_ba_was_5'],'class'=>'selection_one','json'=>$result];
                                },
                        ],
				
            ],
            // 'export' => false,
            // 'pjax' => true,
            // 'responsive'=>true,
            // 'hover'=>true,
        ]); 
        ?>
		
		<br />
		<!--
		<div id="divHapus">
		<div class="pull-left"><button type="button" id="btn-tambah" class="btn btn-primary" data-toggle="modal" data-target="#m_wawancara" style="border:none;"><i class="fa fa-plus"></i> Kembali</button></div>
		</div>
		-->
		

</div>
</div>

</div>
</section>
<script type="text/javascript">
window.onload=function(){		
	$('#btnCetak,#btnUbah, #btnHapus').addClass('disabled');
	$(document).on('click','#btnUbah',function(){
		var data=JSON.parse($('.selection_one:checked').attr('json'));
           // alert(data.id_was_16b);
            location.href='/pengawasan/ba-was5/update?id='+data.id_ba_was_5;  
	});

	 $(document).on('click', '#btnCetak', function () {
          var nilai=$('.selection_one:checked').val();
          location.href='/pengawasan/ba-was5/cetak?id='+nilai;
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

	function ConditionOfButton(n){
        if(n == 1){
           $('#btnCetak,#btnUbah, #btnHapus').removeClass('disabled');
        } else if(n > 1){
           $('#btnHapus').removeClass('disabled');
           $('#btnCetak,#btnUbah').addClass('disabled');
        } else{
           $('#btnCetak,#btnUbah, #btnHapus').addClass('disabled');
        }
    }

        $(document).on('click','#btnHapus',function(){
  
        var x=$(".selection_one:checked").length;
         if(x<=0){
         return false
         }else{
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
                                      return $(this).attr('json');
                                }).get();
                                 var jml=$('.selection_one:checked').length;
                                    for (var i = 0; i<jml; i++) {
                                        var data=JSON.parse(checkValues[i]);
                                        $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/ba-was5/delete',
                                            data:'id='+data.id_ba_was_5+'&jml='+jml,
                                            success:function(data){
                                                alert(data);
                                            }
                                            });

                                    };                          
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

     $(document).on('dblclick', 'tr td:not(.aksinya)', function () {
        var id = $(this).closest('tr').find('.selection_one').val(); 
               // location.href='/pengawasan/was12-inspeksi/update?id='+id;  
                location.href='/pengawasan/ba-was5/update?id='+id; 
      });
}


</script>

