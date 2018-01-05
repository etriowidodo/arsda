<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmP21A;
use app\modules\pidum\models\MsTersangkaBerkas;
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p21-a-index">


<div class="col-md-11" style="width:82%;">
<!--<button id="tambah" class='btn btn-warning btnUbahCheckboxIndex'>Tambah P21A</button>-->
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
            'action' => '/pidum/pdm-p21-a/delete/'
        ]);  
    ?>  
    <div  class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
   
<div class="clearfix"><br><br></div>
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_pengantar'],'data-idp21a' => $model['id_p21a']];
		},
        'columns' => [

			[
                'attribute'=>'no_berkas',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {
						//print_r($model);exit;
                        return ($model[no_berkas].'<br>'.$model[tgl_berkas]);
                    },
            ],
			[
                'attribute'=>'no_surat',
                'label' => 'Nomor dan Tanggal P21',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {
						//print_r($model);exit;
                        return ($model[no_surat].'<br>'.(date('d-m-Y',strtotime($model[tgl_dikeluarkan]))));
                    },
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
                'attribute'=>'id_pengantar',
                'label' => 'Nomor dan Tanggal P21A',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {
			
				$IdPengantar=$model[id_pengantar];
				
				$modelP21= PdmP21A::find()
								->select ("no_surat,tgl_dikeluarkan")
								->from ("pidum.pdm_p21a")
								->where ("pidum.pdm_p21a.id_pengantar = '".$IdPengantar."'")
								->all();
				foreach ($modelP21 as $key => $value) {
				$resultStatus .= $value['no_surat']."<br>".(date('d-m-Y',strtotime($value['tgl_dikeluarkan'])));
				}
				$resultStatus;
				if (!empty($resultStatus))
				{
				return $resultStatus;
				}else{
				$resultStatus ="-";
				return $resultStatus;				
				}
				
                },
            ],
			
			[
                    'class' => 'kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model[id_pengantar].'&idp21a='.$model[id_p21a], 'class' => 'checkHapusIndex'];
                    }
					
                ],	
		
       ],
       	'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>
     <?php \kartik\widgets\ActiveForm::end() ?>
</div>




<?php
 
    $js = <<< JS
            
            
        $('td').dblclick(function (e) {
        var idpengantar = $(this).closest('tr').data('id');
		var idp21a = $(this).closest('tr').data('idp21a');
		var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p21-a/create?id_pengantar="+idpengantar+"&idp21a="+idp21a;
        $(location).attr('href',url);
    });
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
		var idpengantar =$('.checkHapusIndex:checked').val();
         var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p21-a/create?id_pengantar="+idpengantar;
        $(location).attr('href',url);
		}
    });
	
	$('#tambah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
		 bootbox.dialog({
                message: "Silahkan pilih hanya 1 data",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else {
		 var idpengantar =$('.checkHapusIndex:checked').val();
         var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p21-a/create?id_pengantar="+idpengantar;
        $(location).attr('href',url);
		}
    });
	
	 $(document).on('change',function(){
            var length_check = $('.checkHapusIndex:checked').length;
            if(length_check==1)
            {
                 $('.btnPrintCheckboxIndex').removeAttr('disabled');
            
            }
            if(length_check > 1||length_check==0)
            {

                $('.btnPrintCheckboxIndex').prop('disabled','true');
            }
        });
	  $('.btnPrintCheckboxIndex').click(function(){
            var id_p21a = $('.checkHapusIndex:checked').val();
			if (id_p21a.length == 24)
		{
		 bootbox.dialog({
                message: "Maaf P21A belum diinput",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else {
            var cetak   = 'cetak?id_pengantar='+id_p21a; 
            window.location.href = cetak;
			}
        }); 	
JS;

    $this->registerJs($js);
?>
