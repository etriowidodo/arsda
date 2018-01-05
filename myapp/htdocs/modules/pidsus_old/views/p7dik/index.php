<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P7 - Matrix Perkara Penyidikan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pds-dik-matrix-perkara-index">

	<?php 
	$form = \kartik\widgets\ActiveForm::begin([
			'id' => 'hapus-spdp',
			'action' => '/pidsus/p7dik/deletebatch'
	]);
	?>
	<div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
    <div class="form-group"><div class="col-md-11"></div><div class="col-md-1" id="btnHapus"><div id='btnHapusBatch' class='btn btn-danger hapus' >Hapus</div></div></div>
    <div id="btnUpdate"></div>
        <?php \kartik\widgets\ActiveForm::end(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    		'rowOptions'   => function ($model, $key, $index, $grid) {
    			return ['data-id' => $model['id_pds_dik_matrix_perkara']];
    		},
        'columns' => [
            
            //'id_pds_dik_matrix_perkara',
            //'id_pds_dik_surat',
            'no_urut',
        	'nama_tersangka',
            'kasus_posisi',
            'pasal_disangkakan',
            'uraian_fakta',
            'alat_bukti',
            'barang_bukti',
            'keterangan',
            // 'create_by',
            // 'create_date',
            // 'update_by',
            // 'update_date',
            // 'create_ip',
            // 'update_ip',
            // 'flag',
            // 'id_dik_tersangka',

            [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_dik_matrix_perkara']];
        		}
        		],
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    		
    		],
    	'toolbar' =>  [
    				'{toggleData}',['content'=>
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						Html::a('Tambah', 'create', ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Matrix Perkara'])
    				],
    				
    		],
    ]); 
    ?>
        <?php 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/p7dik/update?id="+id;
        $(location).attr('href',url);
    }); 
    

    $('.ubah').click(function(){
            if($('input#hapus').length > 1){
                alert('Harap Pilih Satu Perkara untuk Update Data');
                location.reload();
                return false;
            }
        });   
JS;
    $this->registerJs($js);
    ?>

</div>
