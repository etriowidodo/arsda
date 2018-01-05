<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsUUndangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Undang-Undang';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-uundang-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="divTambah" class="col-md-11" style="width:87%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/ms-u-undang/delete/'
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
            return ['data-id' => $model['id']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute'=>'uu',
				'value'=>function($model){
					return $model->uu;
				}
			],
			'tentang',
            'deskripsi',
            [
				'attribute'=>'tanggal',
				'header'=>'Diundangkan',
				'value'=>function($model){
					return date('d-m-Y', strtotime($model->tanggal));
				}
			],

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id'], 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-u-undang/update?id="+id;
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
		var id =$('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-u-undang/update?id="+id;
        $(location).attr('href',url);
		
		}
    });
	
		

JS;

        $this->registerJs($js);
        ?>
