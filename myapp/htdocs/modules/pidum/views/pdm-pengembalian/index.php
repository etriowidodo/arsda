<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmpengembalianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengembalian Berkas';

?>
<div class="pdm-pengembalian-index">

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
            'action' => '/pidum/pdm-pengembalian/deleteberkas/'
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
         return ['data-id' => $model['id_pengembalian'],'data-idberkas' => $model['id_berkas']];
		},
        'columns' => [

			[
                'attribute'=>'berkas',
                'label' => 'Nomor dan Tanggal berkas',
                'format' => 'raw',
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
                'attribute'=>'pengembalian',
                'label' => 'Nomor dan Tanggal Pengembalian',
                'format' => 'raw',
            ],
			[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_pengembalian'],'data-id' => $model['id_pengembalian'],'id_berkas'=>$model['id_berkas'], 'class' => 'checkHapusIndex'];
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
        var idpengembalian = $(this).closest('tr').data('id');
        var idberkas = $(this).closest('tr').data('idberkas');
		if (idpengembalian ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-pengembalian/updateberkas?id=" + idpengembalian+"&id_berkas=" +idberkas;
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
		var idberkas = $('.checkHapusIndex:checked').attr('id_berkas');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-pengembalian/updateberkas?id=" + id+"&id_berkas=" +idberkas;
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
                message: "Belum Input Data Pengembalian",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
				});
				return false;
			}else{
				var cetak   = 'cetakberkas?id='+id; 
				window.location.href = cetak;
			}
		}
    }); 
	
	
	
JS;

    $this->registerJs($js);
?>