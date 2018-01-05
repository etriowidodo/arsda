<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP22Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p22-index">

    <div id="divTambah" class="col-md-11" style="width:82%;">
        
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
            'action' => '/pidum/pdm-p22/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
<div class="clearfix"><br><br></div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_p22'],'data-idpengantar' => $model['id_pengantar']];
		},
        'columns' => [

			[
                'attribute'=>'berkas',
                'label' => 'Nomor dan Tanggal berkas',
                'format' => 'raw',
                'value'=>$model->berkas,
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
                'attribute'=>'p19',
                'label' => 'Nomor dan Tanggal P-19',
                'format' => 'raw',
                'value'=>$model->p19,
            ],
			[
                'attribute'=>'p22',
                'label' => 'Nomor dan Tanggal P-22',
                'format' => 'raw',
                'value'=>$model->p22,
            ],
			[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_p22'],'data-id' => $model['id_p22'],'id_pengantar'=>$model['id_pengantar'], 'class' => 'checkHapusIndex'];
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
            
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
	
        $('td').dblclick(function (e) {
        var idp22 = $(this).closest('tr').data('id');
        var idpengantar = $(this).closest('tr').data('idpengantar');
		if (idp22 ==undefined)
		{
		bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else
        {
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p22/update?id=" + idp22+"&id_pengantar=" +idpengantar;
        $(location).attr('href',url);
		}
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
	
	$('#idUbah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
		 bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		} else {
		var id =$('.checkHapusIndex:checked').val();
		var idpengantar = $('.checkHapusIndex:checked').attr('id_pengantar');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p22/update?id=" + id+"&id_pengantar=" +idpengantar;
        $(location).attr('href',url);
		//alert(count);
		}
    });
	
	$('.btnPrintCheckboxIndex').click(function(){
		var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
			bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		} else {
			
            var id = $('.checkHapusIndex:checked').val();
			if(id=='0'){
				bootbox.dialog({
                message: "Belum Input Data P-22",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
				});
			}else{
				var cetak   = 'cetak?id_p22='+id; 
				window.location.href = cetak;
			}
		}
    }); 
	
JS;

    $this->registerJs($js);
?>