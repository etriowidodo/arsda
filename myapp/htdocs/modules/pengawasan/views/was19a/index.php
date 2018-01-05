<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19a */


$this->title = 'WAS 19A' ;
$this->subtitle = 'SURAT PENYAMPAIAN SK PHD RINGAN / SEDANG / BERAT';
$this->params['breadcrumbs'][] = ['label' => 'Was19a', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<script>
    var url1 = '<?php echo Url::to('pengawasan/was19a/create', true); ?>';
  var url3 = '<?php echo Url::to('pengawasan/was19a/update', true) ?>';
    var url4 = '<?php echo Url::to('pengawasan/was19a/cetak', true);?>';
</script>
  <?php $this->registerJs( "
      $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        if (e.target == this && id)
     
            $.ajax(
        {
            type: 'POST',
            url: url3,
            data: 'id_was_19a='+id,
            dataType : 'json',
            cache: false,
            
            success: function(data)
            {
             
                $('#update-19a').html(data.view_pemberitahuan);
               
                $('#p_was19a').modal('show'); 
         
            }
        });
    });
    

 $('#tambah_19a').click(function(){
 var id = $('#was19a-id_register').val();
  $.ajax(
        {
            type: 'POST',
            url: url1,
            data: 'id='+id,
            dataType : 'json',
            cache: false,
            
            success: function(data)
            {
             
              $('#update-19a').html(data.view_pemberitahuan);
               
                $('#p_was19a').modal('show'); 
         
            }
        });
        
});
    
 $('#btnCetak').click(function(){
      $('input:checkbox[class=removechecktable]').each(function () {
        if($(this).is(':checked')) { 
       window.open(url4+'?id_register=' + $(\"#was19a-id_register\").val() + '&id_was_19a=' + $(this).val());
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



<div class="was19a-create">
  <?php  ?>
  

 <div>
          <?php $form = ActiveForm::begin([
        'id' => 'was19a-formdelete',
        'action' => Url::toRoute('was19a/delete'),
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
        <label class="control-label col-md-4">No. Surat</label>
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
              <div class="col-lg-10"> <span class="pull-left" style="margin-left: 15px;"><button class="btn btn-primary" id="tambah_19a" type="button"><i class="glyphicon glyphicon-user"></i> Tambah Identitas Terlapor</button> </span> </div>
              <button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak</button>&nbsp;
              <button id="btnHapus" namaform="was19a-formdelete" class="btnHapusCheckboxIndex2 btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button>
            </div>
    </div>
     
    </div>
    <div class="col-md-12" style="margin-top:15px;">
      <div class="form-group">
        <!--<label class="control-label col-md-2"></label>-->
       
        <div class="col-md-12" style="margin-left:0px;">
            <?php //Pjax::begin(['id' => 'models', 'timeout' => false, 'enablePushState' => false]) ?>
            <?php
            $searchModel = new \app\modules\pengawasan\models\Was19aSearch();
            $dataProvider = $searchModel->searchWas19a(Yii::$app->request->queryParams,$was_register);
            ?>
            <?= GridView::widget([
            'id'=>'was19a-grid',
             'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_was_19a']];
            },
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'no_was_19a',
                
                [
                    'class' => '\kartik\grid\DataColumn',
                    'format'=>'raw',//text, html
                   
                    'value'=>function ($model, $key, $index, $widget) use($was_register){
        
                       return ($model['id_terlapor'] == ''? '-' : app\modules\pengawasan\models\VTerlapor::find()->where('id_terlapor = :id',[':id'=>$model['id_terlapor']])->one()->peg_nip);
                            },
       // 'attribute'=>'tempat',
        'label' => 'NIP ',
                    
                ],
               [
                    'class' => '\kartik\grid\DataColumn',
                    'format'=>'raw',//text, html
                   
                    'value'=>function ($model, $key, $index, $widget) use($was_register){
        
                       return ($model['id_terlapor'] == ''? '-' : app\modules\pengawasan\models\VTerlapor::find()->where('id_register = :id',[':id'=>$was_register])->one()->peg_nama);
                            },
       // 'attribute'=>'tempat',
        'label' => 'NAMA ',
                    
                ],
                
               /*  [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                             return Html::checkbox('<i class="fa fa-check"></i> Pilih',false ,['class' => 'btn btn-primary', 'value'=>$model['id_was_19a'], 'id'=>'pilihWas19a'.$model['id_was_19a']]);
                        },
                    ]
                ],*/
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_was_19a'],'id'=>'checkbox','class' => 'removechecktable', 'dataurl'=>Url::toRoute('was19a/delete')];
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
		'id' => 'p_was19a',
		'size' => 'modal-lg',
		'header' => 'Terlapor',
	]); ?>
     <div id="update-19a">
           </div>
	<?php
Modal::end();?>
<?php
    Modal::begin([
		'id' => 'p_kejaksaan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Kejaksaan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_dataKejaksaan', ['param'=> 'was19a'] );
Modal::end();?>

<?php
Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Pegawai</h2>',
]);

echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was19a']);

Modal::end();
?>
<?php
Modal::begin([
    'id' => 'tembusan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Tembusan</h2>',
]);
echo $this->render('@app/modules/pengawasan/views/global/_tembusan', ['param' => 'was19a']);
Modal::end();
?>
