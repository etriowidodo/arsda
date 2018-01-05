<?php

use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\builder\Form;
use app\models\MsSifatSurat;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
\dosamigos\ckeditor\CKEditorAsset::register($this);

?>

<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

    <div class="col-md-12 hide">
        <div class="form-group">
            <label class="control-label col-sm-2">Wilayah Kerja</label>
            <div class="col-sm-3" >
                <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Nomor</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'no_surat_p13')->input('text',
                                ['oninput'  =>'
										var number =  /^[A-Za-z0-9-/]+$/;
                                        if(this.value.length>50)
                                        {
                                          this.value = this.value.substr(0,50);
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
                                        '])  ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Dikeluarkan</label>
            <div class="col-sm-3" style="width: 19%;">
                <?php
                    if($model->isNewRecord){
                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                    }else{
                       echo $form->field($model, 'dikeluarkan');
                    } 
				//Danar Wido validasi tgl dikeluarkan min 1 hari setelah tgl terima Spdp :15/06/2016
				$TglTerima = $_SESSION['tgl_terima'];
				if(isset($id_p17)){
					$MinTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
					$MaxTgl  = date('d-m-Y', strtotime('+90 days', strtotime($TglTerima))); 		
				}else if(isset($id_p17)){
					$MinTgl  = date('d-m-Y', strtotime('+14 days', strtotime($TglTerima))); 
					$MaxTgl  = date('d-m-Y', strtotime('+90 days', strtotime($TglTerima))); 	
                }else
                {
					$MinTgl  = date('d-m-Y', strtotime('+1 days', strtotime($TglTerima))); 
					$MaxTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
				}

							
                ?>
            </div>
			 <label class="control-label col-sm-2" style="width: 9%;">Tanggal</label>
            <div class="col-sm-2" style="width:12%;"><!-- jaka merubah lebar field tanggal -->
			<?php if ($_SESSION['tgl_terima'] != '')
			{
				
				?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							//'startDate' => $MinTgl,
							//'endDate'   => $MaxTgl,
							'endDate' => date('d-m-Y'),
                        ]
                    ]
                ]);
				//End Danar
                ?>
				<?php
			}else {	?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tgl Surat',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							'endDate' => date('d-m-Y'),
                        ]
                    ]
                ]);
                ?>
		<?php		
			}
		//End Danar
		?>
            </div>
        </div>
    </div>




    <?php

    //CMS_PIDUM04_57 #default kepada Yth mengarah pada id penyidik SPDP 06 junni 2016
	if($model->kepada ==''){
        $connection = \Yii::$app->db;
        $id_perkara = Yii::$app->session->get('id_perkara');
        $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
        $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
        $value1 = "Kepala ".$instansiPenyidik['nama'];
	}else{
		$value1 = $model->kepada;
	}

    ?>
	
    <div class="col-md-12">
          <div class="form-group">
            <label class="control-label col-sm-2" >Sifat</label>
            <div class="col-sm-3">
                <?= $form->field($model, 'sifat')->dropDownList(
                    ArrayHelper::map(MsSifatSurat::find()->all(), 'id', 'nama'), 
                    ['prompt' => 'Pilih Sifat']) ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Kepada Yth.</label>
            <div class="col-sm-4" style="width:40%;"><?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $value1]) ?></div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-2">Lampiran</label>
            <div class="col-sm-3">
			<?php if($model->isNewRecord){
			?>
                <?= $form->field($model, 'lampiran')->textInput(['value' => '-'])  ?>
			<?php } else { ?>
			<?= $form->field($model, 'lampiran')  ?>
		<?php	} ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Di</label>
            <div class="col-sm-3"><?= $form->field($model, 'di_kepada') ?></div>
        </div>
    </div>
</div>
