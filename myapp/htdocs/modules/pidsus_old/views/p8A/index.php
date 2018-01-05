<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PdsLidRenlidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P8a-Rencana Jadwal Kegiatan Penyidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Penyidikan', 'url' => ['../pidsus/default/index?type=dik']];
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Penyidikan', 'url' => ['../pidsus/default/viewlaporandik?id'.$modelSurat->id_pds_dik]];
//$this->params['breadcrumbs'][] = $this->title;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$this->params['idtitle']=$_SESSION['noSpdpDik'];

?>
<div class="pds-lid-renlid-index">

    <?php if(false){?>
	<?php $form = ActiveForm::begin(
	 [
                'id' => 'p2-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
           
   		<table width ="60%" style ='background-color: white'>
	   		<tr>
	   			<td><label> </label></td><td colspan=3></td>
	   		</tr>
	   		<tr>
				<td width="20%" align="right"><label for="nomor_lap" >Nomor Surat </label></td>
				<td colspan=3><div class="col-md-6"><?= Html::textInput('noLap',$_POST['noLap'],['size'=>80]) ?></div></td>
			</tr>		
			<tr>
				<td width="20%" align="right"><label for="asal_surat" >Lokasi Surat </label></td>
				<td colspan=3><div class="col-md-6"><?= Html::textInput('asalSurat',$_POST['asalSurat'],['size'=>80]) ?></div></td>
			</tr>	
			<tr>
				<td width="20%" align="right"><label for="tanggal_surat" >Tanggal Surat </label></td>
				<td><div class="col-md-12"><?= 
				DateControl::widget([
					'name'=>'startDate',
					'value'=>$_POST['startDate'],
					'type'=>DateControl::FORMAT_DATE
				]) ?></div></td>
				<td><div class="col-md-1">-</div></td>
				<td><div class="col-md-12"><?= 
				DateControl::widget([
					'name'=>'endDate',
					'value'=>$_POST['endDate'],
					'type'=>DateControl::FORMAT_DATE]) ?></div></td>
				
			</tr>				
			<tr><td colspan=3></td><td align="right"></br><?= Html::submitButton( 'Filter', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan']) ?>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>	
			<tr><td><label> </label></td><td colspan=3></td></tr>
		</table>
		
   		</form>
   		</br>
   		
    <?php ActiveForm::end(); }?>
    <?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/p8a/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="lid">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
   <p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create'], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    		return ['data-id' => $model['id_pds_dik_rendik']];
    		},
        'columns' => [
           
           		'no_urut',
        		'kasus_posisi',
        		'pasal_disangkakan',
        		'alat_bukti',
        		'tindakan_hukum',
        		'waktu_tempat',
        		'koor_dan_dal',
        		'keterangan',

            [
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_dik_rendik']];
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
    		
    		'toolbar' =>  false,
    ]); ?>

</div>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'p8a-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
					<div>
						        		
							        	<div class="col-md-10">
								        	</div>
								         
							        		      		     	
							        	<div class="col-md-2">
							        			<?=Html::a('Kembali', ['../pidsus/default/viewlaporandik?id='.$_SESSION['idPdsDik']], ['data-pjax'=>0, 'class' => 'btn btn-primary', 'title'=>'cancel','id' => 'btnCancel']) ?>
								      			<?=Html::a('Cetak', ['../pidsus/default/viewreportdik','id'=>$modelSurat->id_pds_dik_surat,'jenisSurat'=>'p8a'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'View Report']) ?>
								      	</div>
							        </div>
   
    <?php ActiveForm::end(); 
     $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/p8a/update?id="+id;
        $(location).attr('href',url);
    }); 
    
JS;
    $this->registerJs($js);
    ?>
    