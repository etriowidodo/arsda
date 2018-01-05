<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
use app\modules\pidum\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP17 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
<?php

    
$form = ActiveForm::begin(
    [
        'id' => 'p17-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'labelSpan' => 1,
            'showLabels' => false

        ],
						'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
		
    ]);
?>
     <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
		   
		   
	<div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                   Tersangka

                </h3>
            </div>
            <div class="box-header with-border">
                  <table id="table_grid_tersangka" class="table table-bordered table-striped">
                    <thead>
                            <th style="text-align:center;width:60px;">#</th>
                            <th>NAMA</th>
                            <th>Tgl Lahir</th>
							<th>Umur</th>
                            <th>Jenis Kelamin</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody_grid_tersangka">
                         <?php $i=1; foreach ($modelTersangka as $key => $value): ?>
                                <tr>
									<td><?=$i?></td>
									<td><?=$value->nama?></td>
									<td><?=date('d-m-Y', strtotime($value->tgl_lahir))?></td>
									<td><?=$value->umur." Tahun"?></td>
									<td><?php echo $value->id_jkl=='1'?'Laki-Laki':'Perempuan';?></td>
                                </tr>
                            <?php $i++;endforeach; ?>
                        <?php //endif; ?>
                    </tbody>
                </table>
            </div>
			
			<div class="col-md-12">
        <div class="form-group">

           
			<label class="control-label col-sm-2" >Tanggal Terima Berkas</label>
            <div class="col-sm-2" style="width:12%;"><!-- jaka merubah lebar field tanggal -->
			
                <?=
                $form->field($model, 'tgl_terima_berkas')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                            'disabled'    => true
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							'endDate'   => date('d-m-Y'),
                        ]
                    ]
                ]);
				
                ?>
            </div>
        </div>
    </div>
	
        </div>
		
		<div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
        <div class="col-md-12" >
        <div class="col-md-6" >
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
                                'browseLabel'=>'Unggah P-22...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
		
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P22, 'id_table' => $model->id_p22]) ?>
	
    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p22/cetak?id_p22='.$model->id_p22] ) ?>">Cetak</a>
		<?php } ?>
    </div>
	
    
    <?php ActiveForm::end(); ?>

</div>
</section>

<?php
 $tgl_terima_pengantar = date('Y-m-d',strtotime($data_berkas['tgl_terima']));
 $tgl_terima_pengantar2 = $data_berkas['tgl_terima'];
 $date_hari_ini  = date('Y-m-d');
$script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px"name="mytext[]"><br />'
                )
            });


         $('#pdmp22-tgl_terima_berkas-disp').val('$tgl_terima_pengantar2')
        $('#pdmp22-tgl_terima_berkas').val('$tgl_terima_pengantar');

        var date        = '$tgl_terima_pengantar';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date('$date_hari_ini');
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate());
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp22-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmp22-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp22-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date ,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp22-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp22-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp22-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp22-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp22-tgl_dikeluarkan-disp').removeAttr('disabled');
JS;
$this->registerJs($script);
?>
<br>
