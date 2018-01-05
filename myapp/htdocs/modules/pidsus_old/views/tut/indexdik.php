<?php 
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;


$this->title = $type=='lid'?'Daftar Penerimaan Laporan (Pidsus 1)':($type=='dik'?'Daftar Penyidikan':'Daftar Penuntutan');
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

	<?php /*
	<table width ="60%" style ='background-color: white'>
	   		<tr>
	   			<td><label> </label></td><td colspan=3></td>
	   		</tr>
	   		<?php if($type=='lid') {?>
	   		<tr>
	   			<td width="20%" align="right"><label for="nomor_surat" >Nomor Surat </label></td>
				<td colspan=3><div class="col-md-6"><?= Html::textInput('noSurat',$_POST['noSurat'],['size'=>80]) ?></div></td>
			</tr>	
			<?php }?>	
			<tr>
				<td width="20%" align="right"><label for="nomor_lap" >Nomor Laporan </label></td>
				<td colspan=3><div class="col-md-6"><?= Html::textInput('noLap',$_POST['noLap'],['size'=>80]) ?></div></td>
			</tr>		
			<tr>
				<td width="20%" align="right"><label for="asal_surat" >Asal Surat </label></td>
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
	*/ ?>
		
   		</form>
   		</br>
   		
    <?php ActiveForm::end(); ?>
        <?= GridView::widget([
        'id'=>'id_pds_lid',
        'dataProvider' => $dataProvider,
        		'rowOptions' => function ($model, $key, $index, $grid) {
        		if($_SESSION['typeDaftar']=='lid'){
        			return ['id' => $model['id_pds_lid'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporan?id=\'+this.id'];
        		}
        		else if($_SESSION['typeDaftar']=='dik'){
        			return ['id' => $model['id_pds_dik'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporandik?id=\'+this.id'];
        		}
        		},
        'columns' => [
           // [
        	//'class' => '\kartik\grid\CheckboxColumn'
        	//],
			['class' => 'yii\grid\SerialColumn'],
        	//['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>'Nomor Laporan'],
			//['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>'Tanggal Laporan'],
			['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>($type=='lid'?'Nomor Surat':'Nomor SPDP')],
			['attribute'=>($type=='lid'?'asal_surat_lap':'asal_spdp'),'header'=>($type=='lid'?'Asal Surat':'Asal SPDP')],
			['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>($type=='lid'?'Tanggal Surat':'Tanggal SPDP'),'format'=>['date','dd-MM-yyyy']],
			['attribute'=>($type=='lid'?'tgl_diterima':'tgl_register_perkara'),'header'=>($type=='lid'?'Tanggal Diterima':'Tanggal Register'),'format'=>['date','dd-MM-yyyy']],

			['attribute'=>'perihal','header'=>'Perihal'],
			['attribute'=>'nama_status','header'=>'Status'],

             /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => $type=='lid'?'{listsurat}{delete}':'{listsuratdik}{deletedik}',
             	'buttons' => [
             				'listsurat' => function ($url,$model) {
             					return Html::a(
             							'<span class="glyphicon glyphicon-list"></span>',
             							$url);
             				},
             				'listsuratdik' => function ($url,$model) {
             				return Html::a(
             						'<span class="glyphicon glyphicon-list"></span>',
             						$url);
             				},

             				'deletedik' => function ($url,$model) {
             				return Html::a(
             						'<span class="glyphicon glyphicon-trash"></span>',
             						$url);
             				},
             				],

            ],*/
        ],
    		'export' => false,
    		'pjax' => true,
    		'responsive'=>true,
    		'hover'=>true,
    		'panel' => [
    				'type' => GridView::TYPE_DANGER,
    				
    		],
    		
    		'toolbar' =>  [
    				['content'=>
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						Html::a('Tambah', [$type=='dik'?'createdik':'create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Lid'])
    				],
    				'{toggleData}',
    		],
    ]); ?>
    </p>
</div>
