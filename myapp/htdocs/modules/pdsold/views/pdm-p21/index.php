<?php


use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmP21;
use app\modules\pdsold\models\MsTersangkaBerkas;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP21Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p21-index">
<div class="col-md-11" style="width:82%;">
<!--<button id="tambah" class='btn btn-warning btnUbahCheckboxIndex'>Tambah P21</button>-->
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
            'action' => '/pdsold/pdm-p21/delete/'
        ]); 
    ?>  
    <div class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
   
<div class="clearfix"><br><br></div>
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'   => function ($model, $key, $index, $grid) {
         return ['data-id' => $model['id_pengantar'],'data-idp21' => $model['id_p21']];
		},
        'columns' => [

			[
                'attribute'=>'no_berkas',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
               'value'=>function ($model, $key, $index, $widget) {
						//print_r($model);exit;
                        return ($model[no_berkas]);
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
                'label' => 'Nomor dan Tanggal P21',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				$IdPengantar=$model[id_pengantar];
				
				$modelP21= PdmP21::find()
								->select ("no_surat,tgl_dikeluarkan")
								->from ("pidum.pdm_p21")
								->where ("pidum.pdm_p21.id_pengantar = '".$IdPengantar."'")
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
                        return ['value' => $model[id_pengantar],'data-id'=>$model[id_p21], 'class' => 'checkHapusIndex'];
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
            
	if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
        $('td').dblclick(function (e) {
        var idpengantar = $(this).closest('tr').data('id');
		var idp21 = $(this).closest('tr').data('idp21');
		
		if (idpengantar ==undefined)
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
        if(idp21==0)
        {
            var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p21/create?id_pengantar="+idpengantar+"&&idp21="+idp21;
            $(location).attr('href',url);
        }
		else
        {
            var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p21/update?id_pengantar="+idpengantar+"&&idp21="+idp21;
            $(location).attr('href',url);
        }


		}
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
        var p21         =$('.checkHapusIndex:checked').attr('data-id');
            if(p21==0)
            {
               var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p21/create?id_pengantar="+idpengantar;
                $(location).attr('href',url); 
            }
            else
            {
                var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p21/update?id_pengantar="+idpengantar;
                $(location).attr('href',url);                 
    		}
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
         var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p21/create?id_pengantar="+idpengantar;
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
            var id_pengantar = $('.checkHapusIndex:checked').val();
            var id_p21 = $('.checkHapusIndex:checked').data('id');
			if (id_p21 == '0')
		{
    		 bootbox.dialog({
                    message: "Maaf P21 belum diinput",
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
            var cetak   = 'cetak?id_pengantar='+id_p21+'&idp21='+id_p21; 
            window.location.href = cetak;
		}
        }); 	
    $(".btnHapusCheckboxIndex").attr("disabled",true);

    $(".select-on-check-all").on('click',function(){
        if($(this).is(':checked'))
        {
            $('.checkHapusIndex').attr('checked','checked');
        }
        else
        {
            $('.checkHapusIndex').attr('checked', 'checked');
        }
    });

    // $('.btnHapusCheckboxIndex').on('click',function(){
    //     $button = 
    //     // $('form').submit();
    // });
JS;

    $this->registerJs($js);
?>