<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPenandatanganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'PenandaTangan';
//$this->subtitle = 'Penandatangan';
?>
<div class="pdm-penandatangan-index">

    
<div id="divTambah" class="col-md-10">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	<div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
       <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-penandatangan/delete/'
        ]);  
    ?>  
	 
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
        return ['data-id' => $model['id_ttd']];
		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'peg_nip_baru',
            'nama',
            'pangkat',
            'jabatan',
         //  'keterangan',
            // 'is_active',
            // 'flag',
            // 'id_ttd',        
             [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_ttd'], 'class' => 'checkHapusIndex'];
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
        var idttd = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-penandatangan/update?id_ttd=" + idttd;
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
		var id =$('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-penandatangan/update?id_ttd=" + id;
        $(location).attr('href',url);
		}
    });
	
JS;
    $this->registerJs($js);
?>


