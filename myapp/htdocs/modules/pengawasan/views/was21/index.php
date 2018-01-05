<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use app\modules\pengawasan\models\VTerlapor;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */

$this->title = 'WAS 21';
$this->subtitle = "NOTA DINAS PERTIMBANGAN THD KEBERATAN TERLAPOR";
$this->params['breadcrumbs'][] = ['label' => 'Was21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<script>
   var url1 = '<?php echo Url::to('pengawasan/was21/create', true);?>';
          var url3 = '<?php echo Url::to('pengawasan/was21/update', true);?>';
  var url4 = '<?php echo Url::to('pengawasan/was21/cetak', true);?>';

</script>
  <?php $this->registerJs( "
      $('td').dblclick(function (e) {
        e.preventDefault();
        var id = $(this).closest('tr').data('id');
        if (e.target == this && id)
      
            $.ajax(
        {
            type: 'POST',
            url: url3,
            data: 'id_was_21='+id,
            dataType : 'json',
            cache: false,
            
            success: function(data)
            {
             
                $('#update-21').html(data.view_pemberitahuan);
               
                $('#p_was21').modal('show'); 
         
            }
        });
    });
   
 $('#tambah_21').click(function(){
 var id = $('#was21-id_register').val();
  $.ajax(
        {
            type: 'POST',
            url: url1,
            data: 'id='+id,
            dataType : 'json',
            cache: false,
            
            success: function(data)
            {
             
              $('#update-21').html(data.view_pemberitahuan);
               
                $('#p_was21').modal('show'); 
         
            }
        });
        
});
 $('#btnCetak').click(function(){
      $('input:checkbox[class=removechecktable]').each(function () {
        if($(this).is(':checked')) { 
       window.open(url4+'?id_register=' + $(\"#was21-id_register\").val() + '&id_was_21=' + $(this).val());
           }
      });
});
    $(document)  
  .on('show.bs.modal', '.modal', function(event) {
    $(this).appendTo($('body'));
  })
  .on('shown.bs.modal', '.modal.in', function(event) {
    setModalsAndBackdropsOrder();
  })
  .on('hidden.bs.modal', '.modal', function(event) {
    setModalsAndBackdropsOrder();
  });
 $.fn.modal.Constructor.DEFAULTS.backdrop = 'static';
function setModalsAndBackdropsOrder() {  
  var modalZIndex = 1040;
  $('.modal.in').each(function(index) {
    var modal = $(this);
    modalZIndex++;
    modal.css('zIndex', modalZIndex);
    modal.css('overflow', 'scroll');
    modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
 
});
  $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
   
} ", \yii\web\View::POS_END);
?>



<div class="was21-create">
  <?php  ?>
  

 <div>
          <?php $form = ActiveForm::begin([
        'id' => 'was21-formdelete',
        'action' => Url::toRoute('was21/delete'),
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options' =>[
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>
        <div class="box box-primary" style="overflow: hidden;">
            
             <?php   $was_register = 0;
          $searchModel = new \app\modules\pengawasan\models\Was1Search();
          if($model->isNewRecord){
            $session = Yii::$app->session;
            $was_register= $session->get('was_register'); 
          
          }else{
              $was_register = $model->id_register;
          } 
          $no_register = $searchModel->searchRegister($was_register);
            
            $model->no_register = $no_register->no_register;
            $model->id_register = $no_register->id_register;
            
         
          
          ?>
        

    <?= $form->field($model, 'id_register')->hiddenInput(['maxlength' => true]) ?>
         <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-4">NO. Surat</label>
        <div class="col-md-8">
        
          <?= $form->field($model, 'no_register')->textInput(['readonly'=>true]) ?>
        
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
   
        </div>
     
            <div class="panel box box-primary">
  <div class="box-header with-border">
      <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);margin-top: -15px;">
       <div class="form-group">
              <div class="col-lg-10"> <span class="pull-left" style="margin-left: 15px;"><button class="btn btn-primary" id="tambah_21" type="button"><i class="glyphicon glyphicon-user"></i> Tambah Identitas Terlapor</button> </span> </div>
               <button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>&nbsp;
                <button id="btnHapus" namaform="was21-formdelete" class="btnHapusCheckboxIndex2 btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button>
            </div>
    </div>
    <div class="col-md-12" style="margin-top:15px;">
      <div class="form-group">
        <!--<label class="control-label col-md-2"></label>-->
       
        <div class="col-md-12" style="margin-left:0px;">
            <?php //Pjax::begin(['id' => 'models', 'timeout' => false, 'enablePushState' => false]) ?>
            <?php
            $searchModel = new \app\modules\pengawasan\models\Was21Search();
            $dataProvider = $searchModel->searchWas21(Yii::$app->request->queryParams,$was_register);
            ?>
            <?= GridView::widget([
            'id'=>'was21-grid',
             'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_was_21']];
            },
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'no_was_21',
                
                [
                    'class' => '\kartik\grid\DataColumn',
                    'format'=>'raw',//text, html
                   
                    'value'=>function ($model, $key, $index, $widget) use($was_register){
        
                        return (empty($model["id_terlapor"])?'-' : VTerlapor::find()->where("id_terlapor = :id",[":id"=>$model["id_terlapor"]])->one()->peg_nip);
                            },
       // 'attribute'=>'tempat',
        'label' => 'NIP ',
                    
                ],
               [
                    'class' => '\kartik\grid\DataColumn',
                    'format'=>'raw',//text, html
                   
                    'value'=>function ($model, $key, $index, $widget) use($was_register){
                       return (empty($model["id_terlapor"])?'-' : VTerlapor::find()->where("id_terlapor = :id",[":id"=>$model["id_terlapor"]])->one()->peg_nama);
                   //    return ($mo$model["id_terlapor"]del['id_terlapor'] == ''? '-' : app\modules\pengawasan\models\VTerlapor::find()->where('id_register = :id',[':id'=>$model['id_terlapor'])->one()->peg_nama);
                            },
       // 'attribute'=>'tempat',
        'label' => 'NAMA ',
                    
                ],
                
               /*  [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                             return Html::checkbox('<i class="fa fa-check"></i> Pilih',false ,['class' => 'removechecktable', 'value'=>$model['id_was_21'], 'dataurl'=>Url::toRoute('was21/delete'),'id'=>'pilihWas21'.$model['id_was_21']]);
                        },
                    ]
                ],*/
                 [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_was_21'],'id'=>'checkbox','class' => 'removechecktable', 'dataurl'=>Url::toRoute('was21/delete')];
                    }
                ],
                                    
               
            ],
           'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-book"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                     'id'=>'kv-unique-id-1',
                ],
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]); ?>
      <!--   <table id="table_saksiinternal-was9" class="table table-bordered">
			<thead>
				<tr>
					<th>No Was 9</th>
                                        <th>NIP </th>
                                        <th>Nama</th>
                                        <th>Nip Pemeriksa</th>
                                        <th>Nama Pemeriksa</th>
                                        <th>Waktu dan Tempat</th>
					<th width=10%>Hapus</th>
				</tr>
			</thead>
			
                        <tbody id="tbody_saksiinternal-was9">
			
                        </tbody>
		</table> !-->
            <?php //Pjax::end() ?>
        </div>
      </div>
    </div>
  </div>
</div>  <div class="box-footer" style="margin:0px;padding:0px;background:none;">
  
   <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>

</div><?php ActiveForm::end(); ?>
    </div>

</div>


<?php
    Modal::begin([
		'id' => 'p_was21',
		'size' => 'modal-lg',
		'header' => 'Terlapor',
	]); ?>
     <div id="update-21">
          </div>
	<?php
Modal::end();?>
<?php
    Modal::begin([
		'id' => 'p_kejaksaan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Kejaksaan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_dataKejaksaan', ['param'=> 'was21'] );
Modal::end();?>

<?php
Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Pegawai</h2>',
]);

echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was21']);

Modal::end();
?>
<?php
Modal::begin([
    'id' => 'tembusan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Tembusan</h2>',
]);
echo $this->render('@app/modules/pengawasan/views/global/_tembusan', ['param' => 'was21']);
Modal::end();
?>
