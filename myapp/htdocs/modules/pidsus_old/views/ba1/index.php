<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pidsus8Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BA 1 - Berita Acara Pemeriksaan Saksi/Tersangka';
//$this->subtitle= 'Berita Acara Pemeriksaan Saksi/Tersangka';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-surat-index">
<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/default/deletebatchsurat'
        ]);
    ?>
    <div id="divHapus" class="form-group">
	<input type="hidden" name="typeSurat" value="dik">
	<input type="hidden" name="jenisSurat" value="<?=$idJenisSurat ?>">
    </div>
    
   <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<h1><?= Html::encode('Berita Acara Pemeriksaan Saksi') ?></h1>
	<p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create?type=sks&id='.$id], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    			return ['data-id' => $model['id_pds_dik_surat']];    		
    		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            //'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_dik_surat']];
        		}
        		],
             //[
               // 'class' => 'yii\grid\ActionColumn',
                //'//template' => '{update}{delete}',
             	//'buttons' => [
             		//		'update' => function ($url,$model) {
             			//		return Html::a(
             				//			'<span class="glyphicon glyphicon-pencil"></span>',
             					//		$url.'&type=p1');
             				//},
             				//],

            //],
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
    
	<h1><?= Html::encode('Berita Acara Pemeriksaan Tersangka') ?></h1>
	<p>
	<span class="pull-right"><?= Html::a('<i class="fa fa-plus"> </i> Tambah ', ['create?type=tsk&id='.$id], ['class' => 'btn btn-success']) ?>
    
    <button id="btnHapusBatch" class="btn btn-danger" type="button"><i class="fa fa-times"></i> Hapus</button>
    </span>
  </br>
  </br>
  </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    			return ['data-id' => $model['id_pds_dik_surat']];    		
    		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            //'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_dik_surat']];
        		}
        		],
             //[
               // 'class' => 'yii\grid\ActionColumn',
                //'//template' => '{update}{delete}',
             	//'buttons' => [
             		//		'update' => function ($url,$model) {
             			//		return Html::a(
             				//			'<span class="glyphicon glyphicon-pencil"></span>',
             					//		$url.'&type=p1');
             				//},
             				//],

            //],
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

<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/ba1/deletebatch'
        ]);
    ?>
    <div id="divHapus">

    </div>
    <div id="btnHapus"></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
<?php
	
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/ba1/update?id="+id;
        $(location).attr('href',url);
    });


    $( "input" ).change(function(e) {
        $('.hapus').hide();
        var input = $( this );
        if(input.prop( "checked" ) == true){
            console.log(e.target.value);
            $('.hapus').show();
            $('#btnHapus').append(
                "<button class='btn btn-danger hapus' type='submit'>Hapus</button>"
            );
			$('#btnUpdate').html(
                "<a href='/pidsus/ba1/update?id="+e.target.value+"' class='btn btn-primary ubah'>Ubah</a>"
            );
            $('#divHapus').append(
                ""
            );


        }
		
		 $('.ubah').click(function(){
            if($('input#hapus').length > 1){
                alert('Harap Pilih Satu Perkara untuk Update Data');
                location.reload();
                return false;
            }
        });                    		
       

    });
JS;
	
    

    $this->registerJs($js);
?>
