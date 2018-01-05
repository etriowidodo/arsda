<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmJaksaSaksi;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP16Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p16-index">
    <div id="divTambah" class="col-md-11" style="width:82%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
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
            'action' => '/pidum/p16/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_p16']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat',
                'label' => 'Nomor dan Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat."<br/>".date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },


            ],
			[
                'attribute'=>'jaksa',
                'label' => 'Jaksa Peneliti',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
					$jaksa = PdmJaksaSaksi::findAll(['id_table'=>$model->id_p16,'code_table'=>'P-16']);
					$no = 1;
					foreach($jaksa as $data){
						$isi .= $no."&nbsp;".$data->nama."<br/>";
						$no++;
					}
                    return $isi;
                },


            ],


            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->id_p16, 'class' => 'checkHapusIndex'];
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
		
        $('td').dblclick(function (e) {
		var id = $(this).closest('tr').data('id');
		if (id ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/p16/update?id="+id;
        $(location).attr('href',url);
		}
		});
		
		//Danar Wido Seno 03-08-2016
		
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/p16/update?id="+id;
        $(location).attr('href',url);
		//alert(count);
		}
    });



	
		//End Danar Wido Seno 03-08-2016

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
            var id_p16 = $('.checkHapusIndex:checked').val();
            var cetak   = 'cetak?id='+id_p16; 
            window.location.href = cetak;
        }); 

// $('body').on('click', 'td', function() {

//     var id = $(this).attr('data-col-seq');
//     alert(id);
// });

JS;

        $this->registerJs($js);
        ?>