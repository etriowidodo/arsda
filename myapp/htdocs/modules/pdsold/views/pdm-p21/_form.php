<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
  "
  // $('#p21-form').on('afterValidate', function (event, messages) {
     
  //   if(typeof $('.has-error').first().offset() !== 'undefined') {
  //     var scroll     = $('.has-error').first().closest(':visible').offset().top;
  //     var minscroll  = (86.6/100)*scroll;
  //       $('html, body').animate({
  //           scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
  //       }, 1500);
  //       var lenghInput = $('.has-error div input[type=text]').length;
  //       var lenghSearch = $('.has-error div input[type=search]').length;
  //        $('.has-error div input').first().focus();  
  //       if(lenghInput==0)
  //       {
  //         var minscrollText = (39/100)*($(document).height()-$(window).height());
  //         $('html, body').animate({
  //           scrollTop: ($(document).height()-$(window).height())-minscrollText
  //       }, 1500);
  //          $('.has-error div textarea').first().focus();
  //       }
        
  //     }
  // });
    
"
  );

?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

 <?php
        $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'id' => 'p21-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);   
    
    //Danar Wido P21_02 23-06-2016
    // $_SESSION['tgl_ba']=$modelP24->tgl_ba;
    // $_SESSION['tgl_p21']='';
    //End Danar Wido P21_02 23-06-2016
     ?>
         <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         <div class="col-md-12" style="padding:0">
         <div class="col-md-6" style="width:41%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:39%;" >Nomor Berkas</label>

                   <div class="col-md-8" style="width:61%;">
               <input type="text" class="form-control" value="<?= $modelBerkas->no_berkas ?>" readonly="true">
            </div>
                </div>
                    </div>
                    
                     <div class="col-md-6" style="width:30%;">
                <div class="form-group">
                    <label class="control-label col-md-3"  style="width:35%;">Tanggal Berkas</label>

                   <div class="col-md-4">
               <input type="text" class="form-control" value="<?= date('d-m-Y',strtotime($modelBerkas->tgl_berkas)) ?>" readonly="true">
            </div>
                </div>
                    </div>
                    
                     <div class="col-md-6" style="width:28%;">
                <div class="form-group">
                    <label class="control-label col-md-3"  style="width:41%;">Tgl Terima Berkas</label>

                   <div class="col-md-4" style="width:37%;">
               <input type="text" class="form-control" value="<?= date('d-m-Y',strtotime($modelPengantar->tgl_terima)) ?>" readonly="true">
            </div>
                </div>
                    </div>
         </div>

    </div>
<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        
         
         <p><h4>Tersangka</h4><p>
          <?= GridView::widget([
       'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
       'rowOptions'   => function ($model, $key, $index, $grid) {
    
            return ['data-id' => $model['id_tersangka']];   
        },
        'columns' => [
          
           [
                'attribute'=>'namaTersangka',
                'label' => 'Nama',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
            
                return ($model[namaTersangka]);

                },

            ],
           [
                'attribute'=>'tgl_lahir',
                'label' => 'Tanggal Lahir',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
            
                return (date('d-m-Y',strtotime($model[tgl_lahir]))) ;
        

                },

            ],
             [
                'attribute'=>'umur',
                'label' => 'Umur',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
            
                return ($model[umur]);

                },

            ],
             [
                'attribute'=>'nama',
                'label' => 'Jenis Kelamin',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
            
                return ($model[nama]);

                },

            ],
            
        ],
             'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        
    ]); ?>

    </div>       
        <?= $this->render('//default/_formHeader3', ['form' => $form, 'model' => $model]) ?>
        
            <div class="form-group form-inline">                
                <div class="col-md-2 inline" >
<?php
        echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
                                'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf'],
                                'maxFileSize'=> 3027,
                                'browseLabel'=>'Unggah P21 ...',
                            ]
                        ]); 
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        } ?>
    
    </div>
</div>

         <div class="box box-primary" style="border-color: #f39c12">
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P21, 'id_table' => $model->id_p21]) ?>
    </div>
     </div>


    <div class="box-footer" style="text-align: center;">

        
        <?php if($modelP24['id_hasil']!=2){ ?>
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p21/cetak?id_pengantar='.$_GET['id_pengantar'].'&idp21='.$_GET['idp21']])?>">Cetak</a>
            <button id='hapus' type="button" class="btn btn-danger" >Hapus</button>
        <?php } ?>
        <!-- jaka | 24 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-p21/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
         <?php } ?>
    </div>

    
<input id="tmp_id" type="hidden" value="<?php echo $model['id_pengantar']; ?>">
    <?php ActiveForm::end(); ?>
    </div>
    </section>
    <?php
    $id_hasil = $modelP24['id_hasil'];
    $js = <<< JS
         $('.summary').remove();
         
         $('#hapus').click(function(){
             bootbox.dialog({
                message: "Apakah anda ingin menghapus data ini?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                           $.ajax({
                                     type       : 'POST',
                                     url        :  '/pdsold/pdm-p21/hapus',
                                     data       : 'hapusIndex='+$('#tmp_id').val(),             
                                     success    : function(data)
                                                {
                                                    location.reload();
                                                }
                                    });
                        }
                    },
                    tidak : {
                        label: "Tidak",
                        className: "btn-warning",
                        callback: function(result){
                        }
                    }
                }
            });
                
        });

        var date        = '$modelP24->tgl_ba';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        endDate.setDate(endDate.getDate()+7);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('#tgl_dikeluarkan_p21').html();
        var datecontrol         = $('#pdmp21-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('#tgl_dikeluarkan_p21').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate ,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp21-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp21-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp21-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp21-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp21-tgl_dikeluarkan-disp').removeAttr('disabled');


          if ($id_hasil == 2 )
        {
         bootbox.dialog({
                message: "Belum Bisa Input P-21 Karena P-24 Masih perlu melengkapi berkas perkara dengan melakukan pemeriksaan tambahan ",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
JS;

    $this->registerJs($js);
?>