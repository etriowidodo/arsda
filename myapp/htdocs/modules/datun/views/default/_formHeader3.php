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
                <?= $form->field($model, 'no_surat') ?>
            </div>
            <label class="control-label col-sm-2" style="width: 10%;">Dikeluarkan</label>
            <div class="col-sm-3" style="width: 19%;">
                <?php
                    if($model->isNewRecord){
                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                    }else{
                       echo $form->field($model, 'dikeluarkan');
                    } 
				//Vaalidasi p21
				$TglTerima = $_SESSION['tgl_ba'];
				$MinTgl  = date('d-m-Y', strtotime('+1 days', strtotime($TglTerima))); 	
				$MaxTgl  = date('d-m-Y', strtotime('+7 days', strtotime($TglTerima))); 	
				
				//Validasi P21A
				if ($_SESSION['tgl_p21'] != ''){
				$TglDikeluarkan = $_SESSION['tgl_p21'];
				$MinTgl2  = date('d-m-Y', strtotime('+30 days', strtotime($TglDikeluarkan))); 	
				$MaxTgl2  = date('d-m-Y');
				}else if($_SESSION['tgl_p22'] !='' ){
				//Validasi P23
				$TglDikeluarkan = $_SESSION['tgl_p22'];
				$MinTgl2  = date('d-m-Y', strtotime('+1 days', strtotime($TglDikeluarkan))); 	
				$MaxTgl2  = date('d-m-Y', strtotime('+7 days', strtotime($TglDikeluarkan))); 
				}				
                ?>				
                
				
            </div>
			 <label class="control-label col-sm-2" style="width: 11%;">Tanggal</label>
            <div class="col-sm-4" style="width:10%;"><!-- jaka merubah lebar field tanggal -->
			<?php if ($TglTerima != '') 
			{?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi format tanggal
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							'startDate' => $MinTgl,
							//'endDate'   => $MaxTgl,
                        ]
                    ]
                ]);
				//End Danar
                ?>
				<?php } else if ($TglDikeluarkan != '') 
			{?>
                <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi format tanggal
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							'startDate' => $MinTgl2,
							'endDate'   => $MaxTgl2,
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
                            'autoclose' => true
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
        $connection = \Yii::$app->db;

        $route = substr(Yii::$app->request->url, 0, strrpos( Yii::$app->request->url, '/'));
        $query = $connection->createCommand("select default_kepada from pidum.pdm_sys_menu a inner join public.menu b on a.id_menu = b.id
                                                where b.route like '%$route/%'");

        $txtKepada = $query->queryOne();


        if($model['kepada'] == null){
            $value = $txtKepada['default_kepada'];
        }

        if(stripos($route, 'p21') !== FALSE || stripos($route, 'p21a' ) !== FALSE || stripos($route, 'p23' ) !== FALSE){
            $id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama,akronim FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
            $value = "Kepala Instansi Penyidik " . $instansiPenyidik['nama'];   
        }
    ?>
	
	
	<?php
	//CMS_PIDUM04_57 #default kepada Yth mengarah pada id penyidik SPDP 06 junni 2016
        $connection = \Yii::$app->db;

        $route = substr(Yii::$app->request->url, 0, strrpos( Yii::$app->request->url, '/'));
		 $id_perkara1 = Yii::$app->session->get('id_perkara');
        $query = $connection->createCommand("select kepada from pidum.pdm_t5 where id_perkara='".$id_perkara1."'");
        $txtKepada = $query->queryOne();

        if($model['kepada'] == null){
            $value1 = $txtKepada['kepada'];
        }

        if(stripos($route, 't5') !== FALSE){
            $id_perkara = Yii::$app->session->get('id_perkara');
            $spdp = $connection->createCommand("SELECT id_penyidik FROM pidum.pdm_spdp WHERE id_perkara='".$id_perkara."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_penyidik WHERE id_penyidik = '$spdp[id_penyidik]'")->queryOne();
            $value1 = $instansiPenyidik['nama'];   
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
            <div class="col-sm-4" style="width:40%;">
			<?php if($model->isNewRecord){ ?>
			<?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $value]) ?>
			<?php }else{ ?>
			<?= $form->field($model, 'kepada')->textarea(['rows' => 2, 'value' => $model->kepada]) ?>
			<?php } ?></div>
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
