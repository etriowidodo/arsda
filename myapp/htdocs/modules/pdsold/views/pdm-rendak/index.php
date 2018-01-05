<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsTersangkaBerkas;

$this->title = $sysMenu->kd_berkas;

?>
<div class="pdm-rendak-index">

    <div id="divTambah" class="col-md-11" style="width:74%;">
        
    </div>
	<div  class="col-md-1" style="width:14%;">
        <button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' >Unduh Blanko Rendak</button>
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-rendak/delete/'
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
         return ['data-id' => $model['id_rendak'],'data-idberkas' => $model['id_berkas']];
		},
        'columns' => [

			[
                'attribute'=>'berkas',
                'label' => 'Nomor dan Tanggal berkas',
                'format' => 'raw',
            ],
			[
                'attribute'=>'nama',
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
                'attribute'=>'tgl_rendak',
                'label' => 'Tanggal Rendak',
                'format' => 'raw',
            ],
			[
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_rendak'],'data-id'=>$model['id_rendak'],'id_berkas'=>$model['id_berkas'], 'class' => 'checkHapusIndex'];
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
        var idrendak = $(this).closest('tr').data('id');
        var idberkas = $(this).closest('tr').data('idberkas');
		
		if (idrendak ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-rendak/update?id=" + idrendak+"&id_berkas=" +idberkas;
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-rendak/update?id=" + id+"&id_berkas=" +idberkas;
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
			
            var id = $('.checkHapusIndex:checked').attr('id_berkas');
			if(id=='0'){
				bootbox.dialog({
                message: "Belum Input Data Rendana Dakwaan",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
				});
			}else{
				var cetak   = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-rendak/cetakblanko?id_berkas="+id; 
				window.location.href = cetak;
			}
		}
    }); 
	
JS;

    $this->registerJs($js);
?>