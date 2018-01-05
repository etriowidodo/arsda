<?php

use app\modules\pidsus\models\KpInstSatker;
use kartik\form\ActiveForm;
use kartik\select2\Select2Asset;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\modules\pdsold\models\PdmPkTingRef;
use kartik\datecontrol\DateControl;
use app\modules\pdsold\models\MsJenisPidana;


$this->title = 'RP-6';
$this->subtitle ='REGISTER PEMBERITAHUAN DIMULAINYA PENYIDIKAN / DIHENTIKANYA PENYIDIKAN';
/* @var $this yii\web\View */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
            [
                'id' => 'lp3-form',
                'action' => Url::to(['pdm-lp3/cetak/']),
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels' => false,
                ],
            ]
        )
        ?>

         <div class="col-md-12">
                     <div class="col-md-4">
                     <div class="form-group">
                      <label class="control-label col-md-12">
                      <input type="radio" id="cektanggal2" name="radio" value="1"> <span style="padding-left: 32%;"> Laporan Bulanan</span>
                      </label>
                     </div>                
                          <div class="form-group">
                            <label class="control-label col-md-4">Bulan</label>
                            <div class="col-md-8">
                               <?php echo Html::dropDownList('bulan', '', [
                                                                '01' => 'Januari',
                                                                '02' => 'Februari',
                                                                '03' => 'Maret',
                                                                '04' => 'April',
                                                                '05' => 'Mei',
                                                                '06' => 'Juni',
                                                                '07' => 'Juli',
                                                                '08' => 'Agustus',
                                                                '09' => 'September',
                                                                '10' => 'Oktober',
                                                                '11' => 'November',
                                                                '12' => 'Desember',
                                                            ], ['prompt' => 'Pilih Bulan', 'class' => 'form-control']
                                                        ) ?>

                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Tahun</label>
                            <div class="col-md-8">
                                <select class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        $starting_year = date('Y', strtotime('-10 year'));
                                        $ending_year = date('Y');
                                        for($ending_year;$ending_year>=$starting_year;$ending_year--) {
                                            echo '<option value="'. $ending_year .'" >'.$ending_year.'</option>';
                                        }
                                    ?>
                                    </select>

                            </div> 
                        </div>
                     </div>
                     <div class="col-md-4">
                     <div class="form-group">
                      <label class="control-label col-md-12">
                      <input type="radio" id="cektanggal2" name="radio" value="2"> <span style="padding-left: 32%;"> Laporan Tahunan</span>
                      </label>
                     </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Tahun</label>
                            <div class="col-md-8">
                                <select class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        $starting_year = date('Y', strtotime('-10 year'));
                                        $ending_year = date('Y');
                                        for($ending_year;$ending_year>=$starting_year;$ending_year--) {
                                            echo '<option value="'. $ending_year .'" >'.$ending_year.'</option>';
                                        }
                                    ?>
                                    </select>

                            </div> 
                        </div>
                     </div>
                       <div class="col-md-4">
                     <div class="form-group">
                      <label class="control-label col-md-12">
                      <input type="radio" id="cektanggal2" name="radio" value="3"> <span style="padding-left: 18%;"> Laporan Periodik</span>
                      </label>
                     </div>
                      <div class="form-group">
                      <label class="control-label col-md-2">
                      Periode
                      </label>
                      <div class="col-md-10">  
                      <div class="col-md-5">
                        <?php echo DateControl::widget(['name'=>'p-1', 'type'=>DateControl::FORMAT_DATE]); ?>
                      </div>
                      <span class="col-md-2"> s/d </span> 
                        <div class="col-md-5">
                        <?php echo DateControl::widget(['name'=>'p-2', 'type'=>DateControl::FORMAT_DATE]); ?>
                      </div>      
                      </div>
                      </div>
                     </div>
            
         </div>
         
        
    </div>
<br>
<div class="content-wrapper-1" style="padding-top: 10px">
          <div class="col-md-12" style="padding-top: 5px;">
                 <div class="col-md-4">
                  <div class="form-group">
                        <label class="control-label col-md-4">Tindak Pidana</label>
                        <div class="col-md-8">
                            <?php
                            echo Html::dropDownList('cb_pdm_mst_perkara',$mst_perkara,
                                    ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'), // Flat array ('id'=>'label')
                                    ['class'=>'form-control','id'=>'cb_pdm_mst_perkara']    // options
                            );
                            
                            ?>
                        </div>
                    </div>
                 </div>
                  <div class="col-md-4">
                  <div class="form-group">
                        <label class="control-label col-md-4"> Kejaksaan </label>
                        <div class="col-md-8">
                            <input id="satker" name="wilayah_kerja" value="<?= \Yii::$app->globalfunc->getSatker()->inst_satkerkd ?>">
                        </div>
                    </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                        <label class="control-label col-md-5" style="padding-left: 5%;"> <input type="checkbox" >Dengan Bawahan </label>
                        <div  class="col-md-4">
                         <?= Html::submitButton('Cetak', ['style'=>'margin-left: -30%;','class' => 'btn btn-warning']); ?>   
                        </div>
                    </div>
                 </div>
             </div>
        <?php ActiveForm::end(); ?>
    </div>
    <br>
<div class="content-wrapper-1" style="padding-top: 10px">
        <div class="box-header with-border">
        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
        <thead>
            <tr>
                <th style="width: 5.05%;">No</th>
                <th data-col-seq="1" >
                    <a href="/pdsold/p16/index?sort=no_surat" data-sort="no_surat">Jenis Tindak Pidana</a>
                </th>
                <th data-col-seq="1" >
                    <a href="/pdsold/p16/index?sort=no_surat" data-sort="no_surat">Sisa</a>
                </th>
                <th data-col-seq="2" >
                    Masuk
                </th>
                <th class="kartik-sheet-style kv-all-select kv-align-center kv-align-middle skip-export" style="width: 4.68%;" data-col-seq="3">
                Diselesaikan
                </th>
                <th class="kartik-sheet-style kv-all-select kv-align-center kv-align-middle skip-export" style="width: 4.68%;" data-col-seq="3">
                Jumlah
                </th>
            </tr>
        </thead>
        <tbody>
        <tr data-id="000000p16-01" data-key="000000p16-01">
            <td>1</td>
            <td></td>
            <td data-col-seq="1"></td>
            <td data-col-seq="2"></td>
            <td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="3">
            </td>
            <td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="3">
            </td>
        </tr>
        </tbody>
        </table>
        </div>
    </div>
</section>

<?php $satker = $this->context->getSatker(); ?>
<script type="text/javascript">
    var satker = JSON.parse('<?php echo json_encode($satker); ?>');
    console.log(satker);
</script>

<?php
$script = <<< JS
        $(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});
        
        $("#satker").select2({
            minimumInputLength: 2,
            placeholder: 'Pilih Wilayah Kerja',
            data: satker,
           
         });
		 
		 $(document).on({
			
			 submit  : function(){ body.removeClass("loading"); }    
		});
		
		$('#lp3-form').submit(function(e) {
			
			setTimeout(function(){ // Delay for Chrome
				body.removeClass("loading");
			}, 100);
		});


JS;
$this->registerJs($script);
?>        