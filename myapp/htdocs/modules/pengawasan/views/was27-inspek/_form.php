<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\models\LookupItem;
use kartik\builder\Form;
//use app\modules\pengawasan\models\Was27KlariSearch;
use app\modules\pengawasan\models\Was27InspekSearch;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Klari */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
$this->registerJs("
    $(document).ready(function(){
   $('.cetakwas').click(function(){
         
       window.open('" . Url::to('pengawasan/was27-inspek/cetak', true) . "?id_register=' + $(\"#was27inspek-id_register\").val() + '&id_was_27=' + $(\"#was27inspek-id_was_27_inspek\").val());

      });
      


}); ", \yii\web\View::POS_END);


$script = <<<JS
    function removeRow(id)
    {
     
      $("#"+id).remove();
        

    }
        
        function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
     $("#delete_tembusan").val(nilai);
      $("#"+id).remove();
        

    }
        
     
JS;
$this->registerJs($script, View::POS_BEGIN);
?>
<div class="was27-inspek-form">
   
  <?php $form = ActiveForm::begin([
        'id' => 'was27-inspek-form',
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
<div class="box box-primary">
  <?php   $was_register = 0;
          $searchModel = new \app\modules\pengawasan\models\Was1Search();
          if($model->isNewRecord){
            $session = Yii::$app->session;
            $was_register= $session->get('was_register'); 
          
          }else{ ?>
              <?= $form->field($model, 'id_was_27_inspek')->hiddenInput() ?>
           <?php   $was_register = $model->id_register;
          } 
          $no_register = $searchModel->searchRegister($was_register);
            
            $model->no_register = $no_register->no_register;
            $model->id_register = $no_register->id_register;
            
          $data_satker = $searchModel->searchSatker($was_register);
          $model->inst_satkerkd = $data_satker['inst_satkerkd'];
          $model->inst_nama = $data_satker['inst_nama'];
          
          ?>
   <?= Html::hiddenInput('delete_tembusan', null, ['id' => 'delete_tembusan']); ?>
   <?= $form->field($model, 'id_register')->hiddenInput() ?>
      <?= $form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true]) ?>
  <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-4">NO. Surat</label>
        <div class="col-md-8">
        
          <?= $form->field($model, 'no_register')->textInput() ?>
        
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
 <div class="col-md-12">
   <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-4">Kejaksaan</label>
        <div class="col-md-8">
          <?php  
         /* $was_register = 0;
          if($model->isNewRecord){
               $session = Yii::$app->session;
               $was_register= $session->get('was_register'); 
              
          
          }else{
             $was_register = $model->id_register;
          }
           */
          
                  
            
         
          ?>
              <?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true]) ?>
           
        
         
        </div>
      </div>  
   </div>
 </div>    
  <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" >Nomor</label>
        <div class="col-md-8">
          <?= $form->field($model, 'no_was_27_inspek')->textInput(['maxlength' => true]) ?>
        </div>
      </div>
    </div>
     <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4" style="text-align:left;">Tanggal</label>
        <div class="col-md-8" style="margin-left:-115px;">
          <?= $form->field($model, 'tgl')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                        
                        'pluginOptions' => [
                            
                            'autoclose' => true,
                            
                        ]
                    ],
                    
                ]); ?>
        </div>
      </div>
    </div>
  </div>
  

     <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Sifat</label>
        <div class="col-md-8">

          <?= $form->field($model, 'sifat_surat')->dropDownList(ArrayHelper::map(app\models\LookupItem::find()->where("kd_lookup_group = '01' and kd_lookup_item <> '3' ")->all(),'kd_lookup_item','nm_lookup_item'),['prompt'=>'Pilih']) ?>
        </div>
      </div>
    </div> <div class="col-md-6"></div>
  </div>
 <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Jumlah Lampiran</label>
        <div class="col-md-8">
          <?= $form->field($model, 'jml_lampiran')->textInput() ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
       <?php //echo $form->field($model, 'satuan_lampiran')->textInput(); ?>
           Berkas
  </div>
 </div> 
     <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Kepada Yth</label>
        <div class="col-md-8">


          <?= $form->field($model, 'kepadayth')->dropDownList(ArrayHelper::map(app\modules\pengawasan\models\SpWas2::find()->select('a.ttd_sp_was_2,b.jabatan')->from('was.sp_was_2 a')->join('inner join','was.v_pejabat_pimpinan b','(a.ttd_sp_was_2=b.id_jabatan_pejabat)')->where("id_register = :id",[":id"=>$was_register])->all(),'ttd_sp_was_2','jabatan')) ?>
        </div>
      </div>
    </div> <div class="col-md-6"></div>
  </div>
   
  <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Uraian Permasalahan</label>
        <div class="col-md-8">
          <?php if($model->isNewRecord){
              $model->uraian = app\modules\pengawasan\models\DugaanPelanggaran::findOne($was_register)->ringkasan;
          } ?>
          <?= $form->field($model, 'data_data')->textarea(['rows' => 5]) ?>
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
   
  <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-4">Identitas Pelapor</label>
        <div class="col-md-8">
          <?php 
                        
     $dataProvider = $searchModel->searchPelapor($was_register);
    $gridColumn =  [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama',
        'label' => 'Nama',
         
       
    ],
                         [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alamat',
        'label' => 'Alamat',
        
       
    ]];


        echo GridView::widget([
                
                    'dataProvider'=> $dataProvider,
                   // 'filterModel' => $searchModel,
                   'layout'=>"{items}",
                    'columns' => $gridColumn,
                    'responsive'=>true,
                    'hover'=>true,
                    'export'=>false,
                    //'panel'=>[
                      //      'type'=>GridView::TYPE_PRIMARY,
                          //  'heading'=>$heading,
                    //],
             
            ]);  ?>
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
    
      <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-3">Identitas Terlapor</label>
        <div class="col-md-8">
          <?php 
                        
     $searchModel2 = new \app\modules\pengawasan\models\Was1Search();
    $dataProvider2 = $searchModel2->searchTerlapor($was_register);
    $gridColumn2 =  [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nama',
        'label' => 'Nama',
         
       
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nip_baru',
        'label' => 'NIP',
        
       
    ],
    
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jabatan',
        'label' => 'Jabatan',
         
       
    ],
    ];


        echo GridView::widget([
                
                    'dataProvider'=> $dataProvider2,
                   // 'filterModel' => $searchModel,
                   'layout'=>"{items}",
                    'columns' => $gridColumn2,
                    'responsive'=>true,
                    'hover'=>true,
                    'export'=>false,
                    //'panel'=>[
                      //      'type'=>GridView::TYPE_PRIMARY,
                          //  'heading'=>$heading,
                    //],
             
            ]);  ?>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
    
    
     <div class="col-md-12">
    
      <div class="form-group">
       
        <label class="control-label col-md-2">Saksi Internal</label>
        <div class="col-md-12">
          <?php 
           
     $searchModel2 = new VRiwayatJabatan();
     $dataProvider2 = $searchModel2->searchSaksiInternal($was_register);
    $gridColumn =  [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nama',
        'label' => 'Nama',
         
       
    ],
                         [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nip_baru',
        'label' => 'NIP',
        
       
    ],
                      [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jabatan',
        'label' => 'JABATAN',
        
       
    ]
        ];


        echo GridView::widget([
                
                    'dataProvider'=> $dataProvider2,
                   // 'filterModel' => $searchModel,
                   'layout'=>"{items}",
                    'columns' => $gridColumn,
                    'responsive'=>true,
                    'hover'=>true,
                    'export'=>false,
                    //'panel'=>[
                      //      'type'=>GridView::TYPE_PRIMARY,
                          //  'heading'=>$heading,
                    //],
             
            ]);  ?>
        </div>
      </div>
    
    
  </div>  
    
      <div class="col-md-12">
    
      <div class="form-group">
       
        <label class="control-label col-md-2">Saksi Eksternal</label>
        <div class="col-md-12">
          <?php 
           
     $searchModel3 = new app\modules\pengawasan\models\SaksiEksternal();
     $dataProvider3 = $searchModel3->searchSaksiEksternal($was_register);
    $gridColumn =  [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama',
        'label' => 'Nama',
         
       
    ],
                         [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alamat',
        'label' => 'Alamat',
        
       
    ],
            
        ];


        echo GridView::widget([
                
                    'dataProvider'=> $dataProvider3,
                   // 'filterModel' => $searchModel,
                   'layout'=>"{items}",
                    'columns' => $gridColumn,
                    'responsive'=>true,
                    'hover'=>true,
                    'export'=>false,
                    //'panel'=>[
                      //      'type'=>GridView::TYPE_PRIMARY,
                          //  'heading'=>$heading,
                    //],
             
            ]);  ?>
        </div>
      </div>
    
    
  </div>  
   
    <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Analisa </label>
        <div class="col-md-8">
        
          <?= $form->field($model, 'analisa')->textarea(['rows' => 5]) ?>
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
      <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Kesimpulan </label>
        <div class="col-md-8">
        
          <?= $form->field($model, 'kesimpulan')->textarea(['rows' => 5]) ?>
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
</div>
   <div class="box box-primary" style="overflow: hidden;"> 
         <div class="box-header with-border">
    <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
      <div class="form-group">
        <label class="col-md-10" style="margin-top:5px;">RENCANA PENGHENTIAN PEMERIKSAAN</label>
        
      </div>
    </div>
  
  </div>
       
        <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">1. Team Klarifikasi</label>
        <div class="col-md-8">


          <?= $form->field($model, 'rncn_henti_riksa_1_was_27_ins')->dropDownList(ArrayHelper::map(LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '13'")->all(),'kd_lookup_item','nm_lookup_item'),['prompt'=>'Pilih']) ?>
        </div>
      </div>
    </div> <div class="col-md-6"></div>
  </div> 
       
   <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-3">Terlapor</label>
        <div class="col-md-8">
            <table id="was27-inspek-terlapor_saran" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Terlapor</th>
                        <th>Saran</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
            $searchModel4 = new Was27InspekSearch();
            $dataProvider4 = $searchModel4->searchTerlaporWas27Inspek1($was_register);  
          
            foreach($dataProvider4 as $data27inspek1){ ?>
            <tr>
                <td>
                    <?= Html::textinput('terlapor_1[]',(empty($data27inspek1['peg_nama'])? '-': $data27inspek1['peg_nama']),['readonly'=>true]) ?>
                     <?= Html::hiddenInput('id_terlapor_1[]',(empty($data27inspek1['id_terlapor'])? '-': $data27inspek1['id_terlapor']),['readonly'=>true]) ?>
                </td>
                <td>
                    <?= Html::textarea('saran_1[]',(empty($data27inspek1['saran'])? '': $data27inspek1['saran']),['rows'=>5]) ?>
                </td>
                
            </tr>


            <?php }  ?>
                </tbody>
            </table>
          
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
       
         <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">2. </label>
        <div class="col-md-8">


          <?= $form->field($model, 'rncn_henti_riksa_2_was_27_ins')->dropDownList(ArrayHelper::map(app\modules\pengawasan\models\VPejabatTembusan::find()->select('id_pejabat_tembusan,jabatan')->where("jabatan like '%INSPEKTUR%' OR id_pejabat_tembusan = 160 ")->all(),'id_pejabat_tembusan','jabatan'),['prompt'=>'Pilih']) ?>
        </div>
      </div>
    </div> <div class="col-md-6"></div>
  </div>   
    
   <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-3">Terlapor</label>
        <div class="col-md-8">
            <table id="was27-inspek-terlapor_saran" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Terlapor</th>
                        <th>Saran</th>
                        
                    </tr>
                </thead>
                <tbody>
                       <?php 
            $searchModel4 = new Was27InspekSearch();
            $dataProvider4 = $searchModel4->searchTerlaporWas27Inspek2($was_register);  
          
            foreach($dataProvider4 as $data27inspek1){ ?>
            <tr>
                <td>
                    <?= Html::textinput('terlapor_2[]',(empty($data27inspek1['peg_nama'])? '-': $data27inspek1['peg_nama']),['readonly'=>true]) ?>
                    <?= Html::hiddenInput('id_terlapor_2[]',(empty($data27inspek1['id_terlapor'])? '-': $data27inspek1['id_terlapor']),['readonly'=>true]) ?>
                </td>
                <td>
                    <?= Html::textarea('saran_2[]',(empty($data27inspek1['saran'])? '': $data27inspek1['saran']),['rows'=>5]) ?>
                </td>
                
            </tr>


            <?php }  ?>
                </tbody>
            </table>
         
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
        <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-3">PENDAPAT</label>
       
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
    <?php 
    
  /*  echo Form::widget([
    
   'formName'=>'kvform',
    'columns' => 1,
   // 'inputContainer' => ['class'=>'col-sm-5'],
    'options' =>['class'=>'col-sm-5'],
    'attributes' => [
                'fld1'=>['type'=>Form::INPUT_RAW, 'value'=>   Html::label('PENDAPAT'), ],
            ]
]);*/
    
    echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
   // 'inputContainer' => ['class'=>'col-sm-5'],
    'options' =>['class'=>'col-sm-5'],
    'attributes' => [
                'pendapat' => [
                  
                            'label'=>false, 
                            'type' => Form::INPUT_DROPDOWN_LIST,
                            'items' => ArrayHelper::map(VPejabatPimpinan::find()->select('id_jabatan_pejabat,jabatan')->where("id_jabatan_pejabat in (35,158)")->all(),'id_jabatan_pejabat','jabatan'),
                            'options' => [
                                
                                'options' => [
                                    
                                ],
                            ],
                           //  'container '=>  ['class'=>'col-sm-5'],
                           //  'inputContainer' => ['class'=>'col-sm-5'],
                           // 'columnOptions' => ['colspan' => 2],
                       
                   
                ],
            ]
]);
   ?>  <div class="col-md-12">
    <div class="col-md-6">
     
    </div>
    <div class="col-md-6"></div>
  </div><?php 
    echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
   // 'inputContainer' => ['class'=>'col-sm-5'],
    'options' =>['class'=>'col-sm-5'],
    'attributes' => [
                'persetujuan' => [
                  
                            'label'=>false, 
                            'type' => Form::INPUT_RADIO_LIST,
                            'items'=>[true=>'Setuju', false=>'Tidak setuju'], 
                            'options' => [
                                
                                'options' => [
                                    
                                ],
                            ],
                           //  'container '=>  ['class'=>'col-sm-5'],
                           //  'inputContainer' => ['class'=>'col-sm-5'],
                           // 'columnOptions' => ['colspan' => 2],
                       
                   
                ],
            ]
]);
    
    
    ?> 
       
       
       
   </div>
    
    
    <div class="box box-primary">
  <div class="box-header with-border">
    <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12">
      <div class="form-group">
        <label style="margin-top:5px;" class="col-md-2">Penandatangan</label>
        <div class="col-lg-10"> <span style="margin-left:-55px;" class="pull-left"> <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> Pilih</a> </span> </div>
      </div>
    </div>
    <hr>
    <?php  if(!$model->isNewRecord){
        $searchModel2 = new \app\models\KpPegawaiSearch();
       $modelKepegawaian = $searchModel2->searchPegawaiTtd($model->ttd_peg_nik,$model->ttd_id_jabatan);
       $model->ttd_peg_nama = $modelKepegawaian['peg_nama'];
       $model->ttd_peg_nip = (empty($modelKepegawaian['peg_nip_baru']) ? $modelKepegawaian['peg_nip']:$modelKepegawaian['peg_nip_baru']);
       $model->ttd_peg_pangkat = $modelKepegawaian['gol_pangkat'];
       $model->ttd_peg_jabatan = $modelKepegawaian['jabatan'];
    } ?>
     <?= $form->field($model, 'ttd_peg_nik')->hiddenInput() ?>
     <?= $form->field($model, 'ttd_id_jabatan')->hiddenInput() ?>
    <?= $form->field($model, 'ttd_was_27_inspek')->hiddenInput() ?>

    <div class="col-md-6">
      <div class="form-group">
        <label style="margin-top:18px;" class="control-label  col-md-3">Nama</label>
        <div class="col-lg-9">
          <div class="form-group field-was2-ttd_peg_nik">
            <div class="col-sm-12">
             
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="form-group field-was2-ttd_peg_nama">
            <div class="col-sm-12">
             
               <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">NIP</label>
        <div class="col-lg-9">
          <div class="form-group field-was2-ttd_peg_nip">
            <div class="col-sm-12">
               <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
    <div style="margin-top:15px;" class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-3">Pangkat</label>
        <div class="col-lg-9">
          <div class="form-group field-was2-ttd_peg_jabatan">
            <div class="col-sm-12">
                <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">Jabatan</label>
        <div class="col-lg-9">
          <div class="form-group field-was2-ttd_peg_inst_satker">
            <div class="col-sm-12">
               <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-9">
          <div class="form-group field-was2-ttd_peg_nrp">
            <div class="col-sm-12">
             
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-3">
          <div class="form-group field-was2-ttd_peg_unitkerja">
            <div class="col-sm-12">
              
            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel box box-primary">
  <div class="box-header with-border">
    <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
      <div class="form-group">
        <label class="col-md-2" style="margin-top:5px;">Tembusan</label>
         <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="glyphicon glyphicon-user"></i> Tambah</a> </span> </div>
      </div>
    </div>
    <div class="col-md-8" style="margin-top:15px;">
      <div class="form-group">
        <!--<label class="control-label col-md-2"></label>-->
       
        <div class="col-md-8" style="margin-left:0px;">
         <table id="table_tembusan-was27-inspek" class="table table-bordered">
			<thead>
				<tr>
					<th>Tembusan</th>
					<th width=10%>Hapus</th>
				</tr>
			</thead>
			
                        <tbody id="tbody_tembusan-was27-inspek">
			<?php if(!$model->isNewRecord){
     
                           foreach($modelTembusan as $modelTembusan2){
                         //       echo $modelTembusan2['id_pejabat_tembusan'];
                                
                         ?><tr id="tembusan-<?php echo $modelTembusan2['id_pejabat_tembusan'];?>">
                             <td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="<?php $modelPejabat = app\modules\pengawasan\models\VPejabatTembusan::find()->where('id_pejabat_tembusan = :id',[':id'=>$modelTembusan2['id_pejabat_tembusan']])->asArray()->one();echo $modelPejabat['jabatan']; ?>"> </td><input type="hidden" class="form-control" name="id_jabatanupdate[]" readonly="true" value="<?php echo $modelTembusan2['id_pejabat_tembusan']; ?>"> 
				<td><button onClick="removeRowUpdate('tembusan-<?php echo $modelTembusan2['id_pejabat_tembusan'];?>')" class="btn btn-primary" type="button">Hapus</button></td>
			</tr>
                       <?php 
                            }
                       
                            } ?>
                        </tbody>
		</table>
        </div>
      </div>
    </div>
  </div>
</div>    
   
     <div class="col-md-12">
    <div class="col-md-4">
      <div class="form-group">
        <!--<label class="control-label col-md-3">#WAS-2</label> -->
        <label class="control-label col-md-4">Upload File</label>
        <div class="col-md-8">
          <?php 
        echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [

'options'=>[
'multiple'=>false,
],
'pluginOptions' => [
    'showPreview'=>true, 
//'uploadUrl' => Url::to(['/modules/pengawasan/upload']),
    'showUpload' => false,
//'uploadExtraData' => [
//'album_id' => 20,
//'cat_id' => 'Nature'
//],
//'maxFileCount' => 1
]
]); ?>
        </div>
      </div>
    </div>
        <div class="col-md-2">
          <?php  if(!$model->isNewRecord && !empty($model['upload_file']) ){ ?>
            <label class="control-label col-md-2"><?= Html::label($model['upload_file']); ?></label>
          <?php } ?>
        </div>
  </div>

  

  <div class="box-footer" style="margin:0px;padding:0px;background:none;">
  <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>
  <?php if (!$model->isNewRecord) { ?> 
             <?= Html::Button('Hapus', ['class' => 'hapuswasform btn btn-primary','url'=>Url::to('pengawasan/was27-inspek/delete', true),'namaform'=>'was27-inspek-form']) ?>
                      <?= Html::Button('<i class="fa fa-print"></i> Cetak', ["id" => 'testcetak', 'class' => 'cetakwas btn btn-primary']) ?>
              <?php echo $form->field($model, 'id_was_27_inspek')->hiddenInput(['name'=>'id']) ?>
            <?php } ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
<?php
    Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => '<h2>Pilih Pegawai</h2>',
    
]);

echo $this->render( '@app/modules/pengawasan/views/global/_dataPegawai', ['param'=> 'was27inspek'] );

Modal::end();
     
    ?>
<?php
    Modal::begin([
		'id' => 'tembusan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Tembusan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_tembusan', ['param'=> 'was27-inspek'] );
Modal::end();?>
