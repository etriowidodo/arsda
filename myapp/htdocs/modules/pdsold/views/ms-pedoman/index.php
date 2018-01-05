<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsPedomanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pedoman Tuntutan Pidana';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-pedoman-index">

     <div id="divTambah" class="col-md-11" style="width:87%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/ms-pedoman/delete/'
        ]);  
    ?>  
	
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id'],'data-uu' => $model['id'],'data-pasal'=>$model['id_pasal'],'data-kategori'=>$model['kategori']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute'=>'id',
				'header'=>'No. UU',
				'value'=>function($model){
					return $model->id;
				}
			],
            'id_pasal',
            'kategori',
            'tuntutan_pidana',
            'ancaman',
            // 'ancaman_tahun',
            // 'denda',

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id']."#".$model['id_pasal']."#".$model['kategori'], 'class' => 'checkHapusIndex'];
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
		var uu = $(this).closest('tr').data('uu');
		var pasal = $(this).closest('tr').data('pasal');
		var kategori = $(this).closest('tr').data('kategori');
		if (uu ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-pedoman/update?uu="+uu+"&pasal="+pasal+"&kategori="+kategori;
        $(location).attr('href',url);
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
		
		var id =$('.checkHapusIndex:checked').val().split('#');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-pedoman/update?uu="+id[0]+"&pasal="+id[1]+"&kategori="+id[2];
        $(location).attr('href',url);
		
		}
    });
	
		

JS;

        $this->registerJs($js);
        ?>
