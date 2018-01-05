<?php 
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;


$this->title = $type=='lid'?'Daftar Penerimaan Laporan (Pidsus 1)':($type=='dik'?'Laporan Terjadinya Tindak Pidana':'Daftar Penuntutan');
//$this->params['breadcrumbs'][] = $this->title;
$_SESSION['typeDaftar']=$type;
$currentUrl=$_SERVER['REQUEST_URI'];
$_SESSION['urlDefaultString']='http://'.$_SERVER['HTTP_HOST'].'/pidsus/default/';

if(isset($_SESSION['messageDelete'])){
	$this->registerJs("bootbox.alert(\"".$_SESSION['messageDelete']."\", function() { });");
	$_SESSION['messageDelete']=null;
}
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

	
   		
    <?php ActiveForm::end(); ?>
    
<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/default/deletebatch'
        ]);
    ?>
    <div id="divHapus" class="form-group">

    </div>
    
    <div class="form-group"><div class="col-md-11"></div></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <p>
    <span class="pull-right">
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </p>
  </br></br>
        <?php if($_SESSION['typeDaftar']=='dik'){ echo GridView::widget([
        'id'=>'id_pds_lid',
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
		        if($_SESSION['typeDaftar']=='lid'){
		        	return ['data-id' => $model['id_pds_lid']];
		        }
		        else if($_SESSION['typeDaftar']=='dik'){
					return ['data-id' => $model['id_pds_dik']];
        		}
        		},
        		/*'rowOptions' => function ($model, $key, $index, $grid) {
        		if($_SESSION['typeDaftar']=='lid'){
        			return ['id' => $model['id_pds_lid'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporan?id=\'+this.id'];
        		}
        		//else if($_SESSION['typeDaftar']=='dik'){
        		//	return ['id' => $model['id_pds_dik'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporandik?id=\'+this.id'];
				else if($_SESSION['typeDaftar']=='dik'){
					return ['id' => $model['id_pds_dik'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'draftlaporandik?id=\'+this.id'];
        		}
        		},*/
        'columns' => [
           // [
        	//'class' => '\kartik\grid\CheckboxColumn'
        	//],
			['class' => 'yii\grid\SerialColumn'],
        	//['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>'Nomor Laporan'],
			//['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>'Tanggal Laporan'],
			['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>($type=='lid'?'Nomor Surat':'Nomor SPDP')],
			['attribute'=>($type=='lid'?'asal_surat_lap':'asal_spdp'),'header'=>($type=='lid'?'Asal Surat':'Asal Laporan')],
			['attribute'=>($type=='lid'?'tgl_lap':'tgl_diterima'),'header'=>($type=='lid'?'Tanggal Surat':'Tanggal Diterima')],
			['attribute'=>($type=='lid'?'tgl_diterima':'nama_tersangka'),'header'=>($type=='lid'?'Tanggal Diterima':'Tersangka')],

			['attribute'=>'perihal','header'=>'Perihal'],
			['attribute'=>'nama_status','header'=>'Status'],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
	        		if($_SESSION['typeDaftar']=='lid'){
	        			return ['value' => $model['id_pds_lid']];
	        		}
	        		else if($_SESSION['typeDaftar']=='dik'){
	        			return ['value' => $model['id_pds_dik']];
	        		}
        		}
        		],

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
    				'{toggleData}',['content'=>
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						Html::a('Tambah', [$type=='dik'?'createdik':'create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Lid'])
    				],
    				
    		],
    ]);} else { echo GridView::widget([
        'id'=>'id_pds_lid',
        'dataProvider' => $dataProvider,
        'rowOptions'   => function ($model, $key, $index, $grid) {
		        if($_SESSION['typeDaftar']=='lid'){
		        	return ['data-id' => $model['id_pds_lid']];
		        }
		        else if($_SESSION['typeDaftar']=='dik'){
					return ['data-id' => $model['id_pds_dik']];
        		}
        		},
        		/*'rowOptions' => function ($model, $key, $index, $grid) {
        		if($_SESSION['typeDaftar']=='lid'){
        			return ['id' => $model['id_pds_lid'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporan?id=\'+this.id'];
        		}
        		//else if($_SESSION['typeDaftar']=='dik'){
        		//	return ['id' => $model['id_pds_dik'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporandik?id=\'+this.id'];
				else if($_SESSION['typeDaftar']=='dik'){
					return ['id' => $model['id_pds_dik'], 'onclick' => 'window.location=\''.$_SESSION['urlDefaultString'].'draftlaporandik?id=\'+this.id'];
        		}
        		},*/
        'columns' => [
           // [
        	//'class' => '\kartik\grid\CheckboxColumn'
        	//],
			['class' => 'yii\grid\SerialColumn'],
        	//['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>'Nomor Laporan'],
			//['attribute'=>($type=='lid'?'tgl_lap':'tgl_spdp'),'header'=>'Tanggal Laporan'],
			['attribute'=>($type=='lid'?'no_lap':'no_spdp'),'header'=>($type=='lid'?'Nomor Surat':'Nomor SPDP')],
			['attribute'=>($type=='lid'?'asal_surat_lap':'asal_spdp'),'header'=>($type=='lid'?'Asal Surat':'Asal Laporan')],
			['attribute'=>($type=='lid'?'tgl_lap':'tgl_diterima'),'header'=>($type=='lid'?'Tanggal Surat':'Tanggal Diterima')],
			['attribute'=>($type=='lid'?'tgl_diterima':'nama_tersangka'),'header'=>($type=='lid'?'Tanggal Diterima':'Tersangka')],

			['attribute'=>'perihal','header'=>'Perihal'],
			['attribute'=>'nama_status','header'=>'Status'],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_lid']];
        		}
        		],

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
    				//'{toggleData}',['content'=>
    						//Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'create p16', 'class'=>'btn btn-success']),
    						//Html::a('Tambah', [$type=='dik'?'createdik':'create'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'Tambah Lid'])
    				//],
    				
    		],
    ]);}?>
    </p>
</div>
<?php
	if($_SESSION['typeDaftar']=='lid'){
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/default/viewlaporan?id="+id;
        $(location).attr('href',url);
    });


    $( "input" ).change(function(e) {
        $('.hapus').hide();
        var input = $( this );
        if(input.prop( "checked" ) == true){
            console.log(e.target.value);
            $('.hapus').show();
           
			$('#divHapus').append(
                ""
            );


        }

        

    });
	
		$(document).on("pjax:beforeSend", function (e, xhr, settings) {
        var uri = URI(settings.url);
        uri.removeSearch("_pjax");
        location.href = uri.toString();
        return false;
    
});
JS;
	}
	else if($_SESSION['typeDaftar']=='dik'){
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/default/viewlaporandik?id="+id;
        $(location).attr('href',url);
    });


    $( "input" ).change(function(e) {
        $('.hapus').hide();
        var input = $( this );
        if(input.prop( "checked" ) == true){
            console.log(e.target.value);
            $('.hapus').show();
            $('#btnHapus').append(
                ""
            );
			$('#divHapus').append(
                ""
            );


        }              		
       
		
    });
		$(document).on("pjax:beforeSend", function (e, xhr, settings) {
        var uri = URI(settings.url);
        uri.removeSearch("_pjax");
        location.href = uri.toString();
        return false;
    
});
JS;
	}
    

    $this->registerJs($js);
?>
