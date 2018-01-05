<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
// use kartik\widgets\DatePicker;
use app\modules\pengawasan\models\SumberLaporan;
use kartik\datecontrol\DateControl;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\bootstrap\Modal;
// use app\models\MsJkl;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
#pelapor-kewarganegaraan_pelapor {
 background-color: #FFF;
  cursor: text;
}
</style>
<div class="modalContent">
    <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12">
             <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Sumber <i style="color:#FF0000">*</i></label>
                    <div class="col-md-8 kejaksaan">
                        <input id="asal" type="hidden" maxlength="32"  value="" readonly="readonly">
                       <?php
                        echo $form->field($modelPelapor, 'id_sumber_laporan')->dropDownList(
                                 ArrayHelper::map(SumberLaporan::find()->all(), 'id_sumber_laporan', 'nama_sumber_laporan'), ['prompt' => ''],['width'=>'40%']
                                
                       );   
                     ?>
                        <input type="hidden" name="cek" value="" id="cek">
                    </div>
                </div>
            </div>

            <div class="col-md-6 sumberlain">
                <div class="form-group">
                    <label class="control-label col-md-4" id="lbl_sumber">Sumber Lainya</label>
                    <div class="col-md-8 kejaksaan">
                       <?= $form->field($modelPelapor, 'sumber_lainnya')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nama</label>
                    <div class="col-md-8 kejaksaan">
                        <?= $form->field($modelPelapor, 'nama_pelapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pekerjaan</label>
                    <div class="col-md-8 kejaksaan">
                        <?= $form->field($modelPelapor, 'pekerjaan_pelapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">No Telepon</label>
                    <div class="col-md-8 kejaksaan">  <!-- #bowo 19 agustus 2016 no tlf hanya angka saja-->
						   <?php echo $form->field($modelPelapor, 'telp_pelapor')->input('text',
                                ['oninput'  =>'var number =  /^[0-9 +]+$/;
                                        if(this.value.length>24)
                                        {
                                          this.value = this.value.substr(0,24);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        var str   = "";
                                        var slice = "";
                                        var b   = 0;
                                        for(var a =1;a<=this.value.length;a++)
                                        {
                                            slice = this.value.substr(b,1);
                                            if(slice.match(number))
                                            {
                                                str+=slice;
                                            }
                                            
                                            b++
                                        }
                                        this.value=str;
                                        ']) ?>
						  
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Email</label>
                    <div class="col-md-8 kejaksaan">
                        <?= $form->field($modelPelapor, 'email_pelapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Alamat</label>
                    <div class="col-md-10 kejaksaan">
                    <?php //= $form->field($modelPelapor, 'alamat_pelapor')->textarea(['rows' => 3]) ?>
					<?= $form->field($modelPelapor, 'alamat_pelapor')->textarea() ?>
                    </div>
                </div>
            </div>     
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat Lahir</label>
                    <div class="col-md-8 kejaksaan">
                    <?= $form->field($modelPelapor, 'tempat_lahir_pelapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>   
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Lahir</label>
                    <div class="col-md-6 kejaksaan">
                    <?php

                    echo $form->field($modelPelapor, 'tanggal_lahir_pelapor',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'displayFormat' => 'dd-MM-yyyy',
                            'options' => [

                                'pluginOptions' => [
                                    //'startDate' =>  date("d-m-Y", strtotime($modelPelapor->tanggal_lahir_pelapor)),
                                    'startDate' =>  0,
                                    'endDate' => '-17y',
                                    'autoclose' => true,
                                ]
                            ],
                        ]);
                     ?>
                    </div>
                </div>
            </div> 
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Warganegara</label>
                    <div class="col-md-8 kejaksaan">
				    <input id='cari_Wn' class='form-control' type='text' maxlength='32' readonly='readonly'>
                    <?php
                    function search_wn($strorage,$id=null)
                                {
                                    foreach($strorage AS $index=>$value )
                                    {
                                        if($id!=null)
                                        {
                                            if($id==$index)
                                            {
                                                return $value;
                                                
                                            }
                                        }                                       
                                        
                                    }
                                }
                                $i_wn = $modelPelapor->kewarganegaraan_pelapor;  
                                // $pop warganegara                                                                                     
                                echo $form->field($modelPelapor, 'kewarganegaraan_pelapor')->textInput(['type'=>'hidden','value'=>search_wn($warganegara,$i_wn),'readonly'=>'readonly','placeholder'=>'','data-id'=>$i_wn]); 
                            
                    ?>
                    </div>
                </div>
            </div>   
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Agama</label>
                    <div class="col-md-8 kejaksaan">
                    <?php
                    echo $form->field($modelPelapor, 'agama_pelapor')->dropDownList(
                                 ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), ['prompt' => ''],['width'=>'40%']
                                //  print_r($x);
                       );   
                     ?>
                    </div>
                </div>
            </div> 
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pendidikan</label>
                    <div class="col-md-8 kejaksaan">
                     <?php
                    echo $form->field($modelPelapor, 'pendidikan_pelapor')->dropDownList(
                                 ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), ['prompt' => ''],['width'=>'40%']
                                //  print_r($x);
                       );   
                     ?>
                    </div>
                </div>
            </div>   
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kota</label>
                    <div class="col-md-8 kejaksaan">
                    <?= $form->field($modelPelapor, 'nama_kota_pelapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div> 
        </div>




    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer">
        <button class="btn btn-primary" type="button" id="btn-tambah-pelapor">Simpan</button>
        <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button>
    </div>

</div>	
<?php
$script = <<< JS
 $('#cari_Wn').click(function(){
		
        $('#m_kewarganegaraan').html('');
        $('#m_kewarganegaraan').load('/pengawasan/lapdu/wn');
        $('#m_kewarganegaraan').modal('show');
    });
	
	$(document).ready(function(){
		$('#tgl_pelanggaran').change(function () {
              var date_start=$("#dt2").val().split('-');/*diambil dari tanggal surat lapdu*/
           });

    });

    

JS;
$this->registerJs($script);
?>