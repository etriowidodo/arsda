<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
use app\modules\pdsold\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'p20-form',
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


    $date_awal  = date('Y-m-d');

    $date_akhir = date_create((date('Y-m-d',strtotime($data_berkas['tgl_terima']))));
    date_add($date_akhir, date_interval_create_from_date_string('14 days'));
    $date_akhir = $date_akhir->format('Y-m-d');

    // echo $date_awal.'-'.$date_akhir ;
    ?>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
	<div class="col-md-12">
        <div class="form-group">
		
            <label class="control-label col-sm-2">Nomor Berkas Tahap I</label>
            <div class="col-sm-3">
                <input  class="form-control" type="text" value="<?=$data_berkas['no_berkas']?>" readonly>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Tanggal Berkas</label>
            <div class="col-sm-3" style="width: 12%;">
                <input  class="form-control" type="text" value="<?=$data_berkas['tgl_berkas']?>" readonly>
            </div>
			 <label class="control-label col-sm-2" style="width: 10%;">Tanggal Terima</label>
            <div class="col-sm-3" style="width:12%;">
				<input  class="form-control" type="text" value="<?=$data_berkas['tgl_terima']?>" readonly>
            </div>
        </div>
    </div>
	<!--<br/><br/>
	<div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Instansi Penyidik</label>
            <div class="col-sm-3">
                <input  class="form-control" type="text" value="dffd" readonly>
            </div>
        </div>
    </div>-->
</div>



        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model, 'id_p20'=>'1']) ?>
		
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
                            <th>Nama</th>
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
                                'browseLabel'=>'Unggah P-20...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P20, 'id_table' => $model->id_p20]) ?>

    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p20/cetak?id_p20='.$model->id_p20] ) ?>">Cetak</a>
			
			<?= Html::a('Hapus', Url::to(['pdm-p20/delete', 'id' => $model->id_p20]), ['class'=>'btn btn-danger','data-method' => 'POST']) ?>
		<?php } ?>
    </div>



<?php ActiveForm::end(); ?>

        </div>
        </section>

            <?php
            $tgl_terima_pengantar = date('Y-m-d',strtotime($data_berkas['tgl_terima']));

            $script = <<< JS

            
       $(document).ready(function(){
        var date_awal = Date.parse('$date_awal');
        var date_akhir = Date.parse('$date_akhir');
        console.log((date_awal>date_akhir)?"TRUE":"FALSE");
        // console.log(date_akhir);
        if (date_awal < date_akhir)
        {
         bootbox.dialog({
                message: "Anda Belum Dapat Melakukan Input P20, Karena Tanggal Belum Melebihi 14 Hari Dari Tanggal Terima Surat Pengantar Terakhir",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
    });

    var date        = '$tgl_terima_pengantar';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate()+14);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp20-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmp20-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp20-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':finaldate ,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp20-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp20-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp20-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp20-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp20-tgl_dikeluarkan-disp').removeAttr('disabled');



            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px"name="mytext[]"><br />'
                )
            });
JS;
            $this->registerJs($script);
            ?>
