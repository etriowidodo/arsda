<?php 
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;


$this->title = $type=='pratut'?'Daftar Penerimaan SPDP':'Daftar Penuntutan';
//$this->params['breadcrumbs'][] = $this->title;
$_SESSION['typeDaftar']=$type;
$currentUrl=$_SERVER['REQUEST_URI'];
$_SESSION['urlDefaultString']='http://'.$_SERVER['HTTP_HOST'].'/pidsus/default/';
?>
<div class="security-default-index">
   		
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

	<table width ="700px" style ='background-color: white'>
		<tr><td colspan="4">&nbsp;</td></tr>
		<?//php if($type=='lid') {?>
		<tr>
			<td><label for="Pencarian" >&nbsp; Kata Kunci &nbsp;&nbsp;</label></td>
			<td><?= Html::textInput('merger_field',$_POST['merger_field'],['size'=>80]) ?></td>

			<td align="left" ><?= Html::submitButton( 'Cari', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan']) ?></td>
		</tr>
		<?php// }?>
		<tr><td colspan="4">&nbsp;</td></tr>
	</table>


		
   		</form>
   		</br>
   		
    <?php ActiveForm::end(); ?>
	<?php	if ($type=='pratut'){?>
	<?=
	GridView::widget([
		'id'=>'id_pds_tut',
		'dataProvider' => $dataProvider,
		'rowOptions' => function ($model, $key, $index, $grid) {
			if($_SESSION['typeDaftar']=='pratut'){
				return ['id' => $model['id_pds_tut'], 'onclick' => 'window.location=\'viewlaporan?id=\'+this.id'];
			}
			else if($_SESSION['typeDaftar']=='tut'){
				return ['id' => $model['id_pds_tut'], 'onclick' => 'window.location=\'viewlaporantut?id=\'+this.id'];
			}
		},
		'columns' => [
			// [
			//'class' => '\kartik\grid\CheckboxColumn'
			//],
			['class' => 'yii\grid\SerialColumn'],
			//['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>'Nomor Laporan'],
			//['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>'Tanggal Laporan'],
			['attribute'=>'no_spdp','header'=>'Nomor SPDP'],
			['attribute'=>'asal_spdp','header'=>'Asal SPDP'],
			['attribute'=>'tgl_spdp','header'=>'Tanggal SPDP','format'=>['date','dd-MM-yyyy']],
			['attribute'=>'tgl_diterima','header'=>'Tanggal Diterima','format'=>['date','dd-MM-yyyy']],

			['attribute'=>'perihal','header'=>'Perihal'],
			['attribute'=>'nama_status','header'=>'Status'],


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
				Html::a('Tambah','create', ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Penerimaan SPDP'])
			],
			
		],
	]); ?>
	<?php	}
	else {?>
	<?=
	GridView::widget([
		'id'=>'id_pds_lid',
		'dataProvider' => $dataProvider,
		'rowOptions' => function ($model, $key, $index, $grid) {
			if($_SESSION['typeDaftar']=='pratut'){
				return ['id' => $model['id_pds_tut'], 'onclick' => 'window.location=\''.'viewlaporan?id=\'+this.id'];
			}
			else if($_SESSION['typeDaftar']=='tut'){
				return ['id' => $model['id_pds_tut'], 'onclick' => 'window.location=\''.'viewlaporantut?id=\'+this.id'];
			}
		},
		'columns' => [
			// [
			//'class' => '\kartik\grid\CheckboxColumn'
			//],
			['class' => 'yii\grid\SerialColumn'],
			//['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>'Nomor Laporan'],
			//['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>'Tanggal Laporan'],
			['attribute'=>'no_spdp','header'=>'Nomor SPDP'],
			['attribute'=>'asal_spdp','header'=>'Asal SPDP'],
			['attribute'=>'tgl_spdp','header'=>'Tanggal SPDP','format'=>['date','dd-MM-yyyy']],
			['attribute'=>'tgl_diterima','header'=>'Tanggal Diterima','format'=>['date','dd-MM-yyyy']],
			['attribute'=>'perihal','header'=>'Perihal'],
			['attribute'=>'nama_status','header'=>'Status'],

		],
		'export' => false,
		'pjax' => true,
		'responsive'=>true,
		'hover'=>true,
		'panel' => [
			'type' => GridView::TYPE_DANGER,
			
		],

		'toolbar' =>  [
			//'{toggleData}',['content'=>
			//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
				//Html::a('Tambah', [$type=='dik'?'createdik':'create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Lid'])
			//],
			
		],
	]); ?>
	<?php	}
	?>
    </p>
</div>
