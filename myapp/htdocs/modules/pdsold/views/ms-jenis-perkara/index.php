<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsJenisPidana;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\MsJenisPerkaraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jenis Perkara';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-jenis-perkara-index">

    <div id="divTambah" class="col-md-11" style="width:87%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
	
	<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/ms-jenis-perkara/delete/'
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
            return ['data-kodepidana' => $model['kode_pidana'],'data-jenisperkara'=>$model['jenis_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute'=>'kode_pidana',
				'header'=>'Jenis Pidana',
				'value'=>function($model){
                    return MsJenisPidana::find()->where(['kode_pidana' =>$model->kode_pidana])->one()->akronim;
                }
			],
            //'jenis_perkara',
            [
				'attribute'=>'nama',
				'header'=>'Jenis Perkara',
				'value'=>function($model){
                    return $model->nama;
                }
			],

            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['kode_pidana']."#".$model['jenis_perkara'], 'class' => 'checkHapusIndex'];
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
		var kodepidana = $(this).closest('tr').data('kodepidana');
		var jenisperkara = $(this).closest('tr').data('jenisperkara');
		if (kodepidana ==undefined)
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-jenis-perkara/update?kode_pidana="+kodepidana+"&jenis_perkara="+jenisperkara;
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
        var kodepidana = id[0];
        var jenisperkara = id[1];       
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/ms-jenis-perkara/update?kode_pidana="+kodepidana+"&jenis_perkara="+jenisperkara;
        $(location).attr('href',url);
		
		}
    });
	
		

JS;

        $this->registerJs($js);
        ?>

