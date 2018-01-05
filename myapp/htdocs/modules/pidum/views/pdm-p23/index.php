<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmP21a;
use app\modules\pidum\models\MsTersangkaBerkas;

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p23-index">


<div class="col-md-11" style="width:82%;">

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
            'action' => '/pidum/pdm-p23/delete/'
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
         return ['data-id' => $model['id_p23'],'data-idpengantar' => $model['id_pengantar']];
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
                'label' => 'Nomor dan Tanggal P22',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {
						//print_r($model);exit;
                        return ($model[no_surat].'<br>'.(date('d-m-Y',strtotime($model[tgl_dikeluarkan]))));
                    },
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
                'attribute'=>'id_pengantar',
                'label' => 'Nomor dan Tanggal P23',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {

				$IdPengantar=$model[id_pengantar];

				$modelP23= PdmP21A::find()
								->select ("no_surat,tgl_dikeluarkan")
								->from ("pidum.pdm_p23")
								->where ("pidum.pdm_p23.id_pengantar = '".$IdPengantar."'")
								->all();
				foreach ($modelP23 as $key => $value) {
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
                        return ['value' => $model[id_pengantar],'data-idpengantar'=>$model[id_pengantar],'data-id'=>$model[id_p23], 'class' => 'checkHapusIndex'];
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
        var idpengantar = $(this).closest('tr').data('idpengantar');
		var idp23 = $(this).closest('tr').data('id');
		/*if (idp23 =='0')
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
        {*/
		var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p23/update?id="+idp23+"&id_pengantar="+idpengantar;
        $(location).attr('href',url);
		//}
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
		var idp23 = $('.checkHapusIndex:checked').data('id');
         var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p23/update?id="+idp23+"&id_pengantar="+idpengantar;
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
            var id_p23 = $('.checkHapusIndex:checked').data('id');
			if (id_p23 =='0')
		{
		 bootbox.dialog({
                message: "Maaf P23 belum diinput",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else {
            var cetak   = 'cetak?idp23='+id_p23;
            window.location.href = cetak;
			}
        });

JS;

    $this->registerJs($js);
?>
