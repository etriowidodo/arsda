<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBerkasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penerimaan Berkas Tahap I';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-berkas-index">
<!-- jaka : menghilangkan label
    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
-->
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
 </div>
  <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-berkas/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
	
	 
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
	   'rowOptions'   => function ($model, $key, $index, $grid) {
	
            return ['data-id' => $model['id_berkas']];	
        },
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

            //'id_berkas',
           // 'id_perkara',
          //  'tgl_terima',
          //  'id_statusberkas',
			//'no_pengiriman',
			[
                'attribute'=>'tgl_berkas',
                'label' => 'Nomor dan Tanggal Berkas',//jaka : rubah jadi nomor
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[no_pengiriman].' -- '.$model[tgl_pengiriman]);
			
                },

            ],
			[
                'attribute'=>'Nama_tersangka',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[nama]);
			
                
			

                },

            ],
			[
                'attribute'=>'Tanggal_Terima',
                'label' => 'Tanggal Terima',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[tglterima]);
			
                
			

                },

            ],
             [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
						// var_dump($model);exit;
                        return ['value' => $model[id_berkas], 'class' => 'checkHapusIndex'];
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
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-berkas/update?id="+id;
        $(location).attr('href',url);
    });


JS;

        $this->registerJs($js);
        ?>