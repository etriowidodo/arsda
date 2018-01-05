<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pidsus8Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'P 37';
//$this->subtitle= 'Berita Acara Pemeriksaan Saksi/Tersangka';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapTut'];
?>
<div class="pds-tut-surat-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<h1><?= Html::encode('Surat Panggilan Saksi Ahli') ?></h1>
	
<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/p37/deletebatch'
        ]);
    ?>
    <div id="divHapus">

    </div>
    <div id="btnHapus"></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvidersks,
        //'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    			return ['data-id' => $model['id_pds_tut_surat']];    		
    		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            //'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_tut_surat']];
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
    		
    		'toolbar' =>  [
    				'{toggleData}',['content'=>
    						Html::a('Tambah', ['create?id='.$id.'&type=sks'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create pidsus'])
    				],
    				
    		],
    ]); ?>
	<h1><?= Html::encode('Surat Panggilan Terdakwa') ?></h1>
    
<?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-spdp',
            'action' => '/pidsus/p37/deletebatch'
        ]);
    ?>
    <div id="divHapus">

    </div>
    <div id="btnHapus"></div>
    <div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
	 <?= GridView::widget([
        'dataProvider' => $dataProvidertdw,
        //'filterModel' => $searchModel,
    	'rowOptions'   => function ($model, $key, $index, $grid) {
    			return ['data-id' => $model['id_pds_tut_surat']];    		
    		},
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            //'no_surat',
            ['attribute'=>'tgl_surat','header'=>'Tanggal Surat','format'=>['date','dd-MM-yyyy']],
        		[
        		'class'=>'kartik\grid\CheckboxColumn',
        		'headerOptions'=>['class'=>'kartik-sheet-style'],
        		'checkboxOptions' => function ($model, $key, $index, $column) {
        			return ['value' => $model['id_pds_tut_surat']];
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
    		
    		'toolbar' =>  [
    				'{toggleData}',['content'=>
    						Html::a('Tambah', ['create?id='.$id.'&type=tdw'], ['data-pjax'=>0, 'class' => 'btn btn-success', 'title'=>'create pidsus'])
    				],
    				
    		],
    ]); ?>
</div>

<?php
	
		$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidsus/p37/update?id="+id;
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
                "<a href='/pidsus/p37/update?id="+e.target.value+"' class='btn btn-primary ubah'>Ubah</a>"
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
