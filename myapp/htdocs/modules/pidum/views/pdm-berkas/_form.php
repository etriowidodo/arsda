<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\MsLoktahanan;
use kartik\datecontrol\DateControl;
use kartik\typeahead\TypeaheadAsset;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkas */
/* @var $form yii\widgets\ActiveForm */

TypeaheadAsset::register($this);

//jaka | 17 Juni 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#CklBerkas-form').on('afterValidate', function (event, messages) {
     
    if(typeof $('.has-error').first().offset() !== 'undefined') {
      var scroll     = $('.has-error').first().closest(':visible').offset().top;
      var minscroll  = (86.6/100)*scroll;
        $('html, body').animate({
            scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
        }, 1500);
        var lenghInput = $('.has-error div input[type=text]').length;
        var lenghSearch = $('.has-error div input[type=search]').length;
         $('.has-error div input').first().focus();  
        if(lenghInput==0)
        {
          var minscrollText = (39/100)*($(document).height()-$(window).height());
          $('html, body').animate({
            scrollTop: ($(document).height()-$(window).height())-minscrollText
        }, 1500);
           $('.has-error div textarea').first().focus();
        }
        
      }
  });
  
  
  "
  );
//END <-- CMS_PIDUM001 -->
?>

<div class="box box-primary"  style="border-color: #f39c12;">
    <div class="box-header"></div>
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'CklBerkas-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels' => false

            ]
        ]);
    ?>
    <div class="hapus_undang_pasal"></div>
    <div class="box-body">
        <div class="col-md-12" style="padding:0">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Asal Surat</label>

                    <div class="col-md-8">
                        <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3">Instansi Penyidik</label>

                    <div class="col-md-9">
                        <input class="form-control" value="<?= $modelSpdp->idPenyidik->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix" style="margin-bottom:14px;"></div>

        <div class="col-md-12 hide">
        <?php
        //form wilayah kerja
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'wilayah_kerja' => [
                        'label' => 'Wilayah Kerja',
                        'labelSpan' => 2,
                        'columns' => 7,
                        'attributes' => [
                            'wilayah_kerja' => [
                                'type' => Form::INPUT_TEXT,
                                'options' => ['value' => \Yii::$app->globalfunc->getSatker()->inst_nama],
                                'columnOptions' => ['colspan' => 4]
                            ],
                        ],
                    ],
                ]
            ]);
        ?>
        </div>
        <div class="col-md-12" style="padding:0px;">
            <div class="col-md-6">
            <?php
            //form pengiriman berkas
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'no_pengiriman' => [
                        'label' => 'Nomor Berkas Perkara',
                
                        'labelSpan' => 4,
                        'columns' => 7,
                        'attributes' => [
                            'no_pengiriman' => [
                                'type' => Form::INPUT_TEXT,
                                'columnOptions' => ['colspan' => 12]
                            ]
                        ]
                    ]
                ]
            ]);
            ?>
            </div>
            <div class="col-md-6" style="padding:0px;">
                <div class="col-md-12" style="padding:0px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-6">Tanggal Berkas</label>
                            <div class="col-md-6">
                                 <?php                                   
                                  $trim   = explode('-',date('Y-m-d',strtotime("+1 days",strtotime($modelSpdp->tgl_surat))));
                                  $tgl_spdp = $trim[2].'-'.$trim[1].'-'.$trim[0];
                                  ?>
                                <?=
                                    $form->field($model, 'tgl_pengiriman')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'startDate'=>  $tgl_spdp,
                                                'endDate'  =>  $tgl_spdp_end
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-6">Tanggal Diterima</label>
                            <div class="col-md-6">
                                <?=

                                    $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
												'endDate'   => '+30d',
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
                    
                </div>
               
            </div>

        
        <!--    
        <?php
        //form pengiriman berkas
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'no_pengiriman' => [
                    'label' => 'No. Berkas Perkara',
            
                    'labelSpan' => 2,
                    'columns' => 7,
                    'attributes' => [
                        'no_pengiriman' => [
                            'type' => Form::INPUT_TEXT,
                            'columnOptions' => ['colspan' => 4]
                        ],
                        'tgl_pengiriman' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\datecontrol\DateControl',
                            'options' => [
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Pengiriman']
                                ],
                            ],
                            'columnOptions' => ['colspan' => 3]
                        ],
                        'tgl_terima' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => '\kartik\datecontrol\DateControl',
                            'options' => [
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal Terima']
                                ],
                            ],
                            'columnOptions' => ['colspan' => 3],
                        ]
                    ],
                ],
            ],
        ]);

        ?>-->
        </div>
        <div class="panel box box-warning hide"> <?php //revisi redmine nomor #2263 (dasar acuan di hilangkan) ?>
            <div class="box-header with-border">
                <h3 class="box-title">DASAR ACUAN</h3>
            </div>
            <?php
                //form no spdp
                echo Form::widget([
                    'model' => $modelSpdp,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'no_surat' => [
                            'label' => 'Nomor SPDP',
                            'labelSpan' => 2,
                            'columns' => 7,
                            'attributes' => [
                                'no_surat' => [
                                    'type' => Form::INPUT_TEXT,
                                    'options' => [
                                      'readonly' => 'true'
                                    ],
                                    'columnOptions' => ['colspan' => 4]
                                ]
                            ],

                        ],
                    ],
                ]);

                //form tgl surat spdp
                echo Form::widget([
                    'model' => $modelSpdp,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'tgl_surat' => [
                            'label' => 'Tanggal',
                            'labelSpan' => 2,
                            'columns' => 7,
                            'attributes' => [
                                'tgl_surat' => [
                                    'type' => Form::INPUT_TEXT,
                                    'options' => [
                                        'readonly' => 'true',
                                        'value' => date('d-m-Y', strtotime($modelSpdp->tgl_surat))
                                    ],
                                    'columnOptions' => ['colspan' => 4]
                                ]
                            ],
                        ],
                    ],
                ]);
            ?>

        </div>
        <div class="panel box box-warning" style="margin-top: 111px;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                 <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2" id="popUpTersangka">Tersangka</a><!--jaka | memindahkan posisi-->
                </h3>
				<!---<h3 class="box-title">
                   Tersangka
                </h3>--------->
            </div>
            <div class="box-header with-border">
			
			   <table id="table_tersangka" class="table table-bordered">
                    <thead>
                       
                    </thead>
                    <tbody id="tbody_tersangka">
                        <?php if (!$model->isNewRecord): ?>
					
                            <?php foreach ($modelTersangka as $key => $value): ?>
                                <tr data-id="<?= $value['id_tersangka'] ?>">
									<td id="tdTRS" width="20px"><input type='checkbox' name='tersangka[]' class='hapusTersangka' id='hapusTersangka' value="<?= $value['id_tersangka'] ?>"></td>
                                    <input type="hidden" name="no_urut[]" class="form-control" value="<?= ($value['no_urut'] != null) ? $key+1:$value['no_urut'] ?>" style="width: 50px;">
                                    <td><input type="text" name="nama_tersangka[]" class="form-control" readonly="true" value="<?= $value->nama ?>"><input type="hidden" name="id_tersangka[]" class="form-control" readonly="true" value="<?= $value->id_tersangka ?>"></td>
                               
                                    
                                </tr>
                            <?php endforeach; ?>
			
                        <?php endif; ?>
                    </tbody>
                </table>
				<div id="hiddenId"></div>
              <!---  <?php
              /*      if (!empty($modelTersangka)){

                    $layout = <<< HTML
                                <div class="clearfix"></div>
                                {items}
                                <div class="col-sm-5">&nbsp;</div><div class="col-sm-2">{pager}</div><div class="col-sm-5">&nbsp;</div>
HTML;
                    echo kartik\grid\GridView::widget([
                        'id' => 'tersangka',
                        'dataProvider' => $dataProviderTersangka,
                        'layout' => $layout,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:3.38%;']],
                            'nama',
                        ],
                        'export' => false,
                        'pjax'=> true,
                        'responsive' => true,
                        'hover' => true
                    ]);
                    }*/
                ?>------>
            </div>
        </div>

        <div class="panel box box-warning">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h3 class="box-title"> Undang-Undang & Pasal <a class="btn btn-small btn-warning" id="tambah-undang-pasal">+</a></h3>&nbsp;
                </div>
                <div class="col-md-6">

                    <span class="pull-right hide"><a class="btn btn-primary" id="tambah-pasal">+</a></span>
                            <span class="pull-right hide">
                                <select class="form-control" id="jenis-pasal">
                                    <option value="tunggal">Tunggal</option>
                                </select>

                            </span>
                </div>
            </div>
            <div class="box-body" id="undang-pasal">

                
                    <div class="col-sm-8">
                        <div class="pull-right"><a class="btn btn-warning hide" id="tambah-undang-pasal">+</a></div>
                    </div>
                    <div class="col-sm-8">
                            <div class="undang-pasal-append"></div>
						<?php if(!$model->isNewRecord){?>
                        <?php foreach ($modelPasal as $key => $value): ?>
                        <div class="hapus<?php echo $key+1 ?>">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Undang-undang</label>
                                </div>
                                <div class="col-sm-8">
                                	<div class="col-sm-8">
                                    	<input type="text" name="undang1[]" class="form-control" readonly="true" value="<?= $value['undang'] ?>" placeholder="undang - undang">
                                    </div>
                                    <div class="col-sm-3"><a class='btn btn-danger delete' onclick="hapusPasal(<?php echo $key+1 ?>,'<?php echo $value['id_pasal'] ?>')"></a></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label>Pasal</label>
                                </div>
                                <div class="col-sm-8">
                                	<div class="col-sm-8">
                                    	<input type="text" name="pasal1[]" class="form-control" readonly="true" value="<?= $value['pasal'] ?>" placeholder="pasal - pasal">
                                    </div>
                                </div>
                            </div>
                         </div>
                        <?php endforeach; ?>
						<?php } ?>
                    </div>

                    <!--<table class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th><a class="btn btn-primary" id="tambah-undang-pasal">+</a></th>
                        </tr>
                        </thead>
                        <tbody id="undang-pasal-body">

                        <?php /*foreach ($modelPasal as $value): */?>
                            <tr>
                                <td><input type="text" name="undang1[]" class="form-control" readonly="true" value="<?/*= $value['undang'] */?>" placeholder="undang - undang"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="pasal1[]" class="form-control" readonly="true" value="<?/*= $value['pasal'] */?>" placeholder="pasal - pasal"></td>
                            </tr>
                        <?php /*endforeach; */?>
                        </tbody>
                    </table>-->
                <?php //endif; ?>

                
            </div>
        </div>

        <?php /*div penambahan field baru revisi redmine #2263 (tempat dan tanggal kejadian)*/ ?>
        <div class="panel box box-warning">
            <div class="box-header">
                <div class="col-md-6" style="margin-left=0;">
				<?php
                    echo Form::widget([
                        'model' => $modelSpdp,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'tempat_kejadian' => [
                                'label' => 'Tempat Kejadian',
                                'labelSpan' => 5,
                                'columns' => 6,
                                'attributes' => [
                                    'tempat_kejadian' => [
                                        'type' => Form::INPUT_TEXT,
                                        'options' => ['placeholder' => 'Tempat Kejadian'],
                                        'columnOptions' => ['colspan' => 4],
										'value' => $modelSpdp->tempat_kejadian
                                    ],
                                    
                                ],

                            ], ],
							]);
					?>
					</div>
					<?php
						echo Form::widget([	
							'model' => $model,
							'form' => $form,
                            'columns'=>2,
                                'attributes'=>[
                                    'tgl_kejadian' => [
									 'label'=>'Tanggal Kejadian',
									 'labelSpan'=>3,
									'columns' => 6,
									'attributes' => [
                                    'tgl_kejadian' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\datecontrol\DateControl',
                                        'options' => [
                                            'options' => [
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                ],
                                                'options' => ['placeholder' => 'DD-MM-YYYY']//jaka | rubah ke format tanggal
                                            ],
                                        ],
                                        'columnOptions' => ['colspan' => 2],
                                    ],
									],
									],
                         ],
                        
                    ]);
					?>
					<div class="col-md-6" style="margin-left=0;">
					<?php
                    echo Form::widget([
                        'model' => $modelSpdp,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'no_reg' => [
                                'label' => 'Nomor Register Perkara',
                                'labelSpan' => 5,
                                'columns' => 6,
                                'attributes' => [
                                    'no_reg' => [
                                        'type' => Form::INPUT_TEXT,
                                        'options' => ['placeholder' => 'Nomor Register Perkara','value' => ''],
                                        'columnOptions' => ['colspan' => 4]
										
                                    ],
                                ],

                            ],
                        ],
                    ]);
                ?>
				</div>
            </div>
        </div>
    </div>

    <div class="box-header with-border hide"><?php //revisi redmine nomor #2263 (check berkas di hilangkan) ?>
        <div class="form-group">
            <label for="" class="control-label col-md-2">Check Berkas</label>

            <div class="col-md-3">
                <?php
                $listCheckBerkas = ['1' => 'LENGKAP', '2' => 'TIDAK LENGKAP', '3' => 'OPTIMAL'];
                echo $form->field($model, 'id_statusberkas')->dropDownList($listCheckBerkas);
                ?>
            </div>
        </div>
    </div>


		
		 <table id="table_riwayat" class="table table-bordered">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6" style="padding: 0px;">
                <h3 style="margin:0px;"> Riwayat Penahanan Tahap Penyidikan</h3><!--jaka | mengganti dari sebelumnya "Riwayat Tahanan Penyidik"-->
            </div>
        </div>	
		
        <div class="box-header with-border">
			
        <div class="col-md-12" style="padding:0px;">	
        <!-- CMS_PIDUM00|JAKA|16-06-2016| MENAMBAHKAN HEADER-->
                <div class="well well-sm col-md-12 " style="background-color:#fcbd3e">
                    <label class="col-md-2" style="padding-left:2px;font-size:16px;">Nama</label>
                    <div class="form-inline col-md-10" style="padding:0;">
                        <div class="col-md-3" style="font-size:16px;padding-left:0;">
                            Jenis Penahanan
                        </div>
                        <div class="col-md-5" style="font-size:16px;padding-left:25px;">
                            Masa Penahanan   
                        </div>
                        <div class="col-md-3" style="font-size:16px;">
                            Lokasi
                        </div>
                        
                        
                    </div>
                </div>
            <!-- END CMS_PIDUM003_46-->
        </div>
        </div>
        <div class="col-md-12" style="padding:0px;">
        <tbody id='tbody_riwayat' class="">
                <?php
                    if (!$model->isNewRecord):
                        $i = 1;
                        foreach ($modelTersangka as $key => $value):
						
                ?>	
			
			
			<tr>	<td><input type="hidden"  name="PdmTahananPenyidik[<?php echo ($i-1); ?>][id]" value="<?php echo $modelTahananPenyidik[($i-1)]->id;?>">
                <input type="hidden" id="riwayatTahanan" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][id_tersangka]" value="<?php echo $value->id_tersangka;?>"></td>
                 </tr>   
				 <tr data-id="<?= $value['id_tersangka'] ?>" >  
				 <td>  <div class="well well-sm col-md-12" style="width:100%;">


                              <label class="control-label col-md-2" id="<?php echo $value->id_tersangka;?>" style="padding-top:16px;padding-left:0px;font-size:16px;"><?php echo $i . ". " . $value->nama; ?></label>
                                <div class="form-inline col-md-10" style="padding-left:50;">
                                    <div class="col-md-3" style="padding-left:200;">Jenis Penahanan<select class="form-control" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][id_msloktahanan]" id="lokasi-tahanan-selector-<?php echo $i; ?>" style="width: 180px;">
                                            <option value="">Pilih Jenis Penahanan</option>
                                        <?php
                                            $loktahanan = ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama');
                                            foreach ($loktahanan as $kei => $row):
                                        ?>
                                            <option value="<?php echo $kei; ?>" <?php echo $modelTahananPenyidik[($i-1)]->id_msloktahanan == $kei ? "selected" : "";?>>
                                                <?php echo $row; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
									<div class="col-md-5" id="startEndDate-<?php echo $i; ?>" style="padding:0 0 0 24px;">
                                        Masa Penahanan<br>
                                        <?= DateControl::widget([
                                                'name' => 'PdmTahananPenyidik[' . ($i-1) . '][tgl_mulai]',
                                                'type' => DateControl::FORMAT_DATE,
                                                'id' => 'tgl-mulai-' . $i,
                                                'ajaxConversion' => false,
                                                'value' => !empty($modelTahananPenyidik[($i-1)]->tgl_mulai) ? $modelTahananPenyidik[($i-1)]->tgl_mulai : '',
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'endDate' => '+1y',
                                                    ],
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Mulai',
                                                        'style' => 'width:143px;',
                                                    ]
                                                ],
                                            ]);
                                        ?>
                                        <label class="control-label" style="margin-top: 6px;">s.d.</label>
                                        <?= DateControl::widget([
                                                'name' => 'PdmTahananPenyidik[' . ($i-1) . '][tgl_selesai]',
                                                'type' => DateControl::FORMAT_DATE,
                                                'value' => !empty($modelTahananPenyidik[($i-1)]->tgl_selesai) ? $modelTahananPenyidik[($i-1)]->tgl_selesai : '',
                                                'id' => 'tgl-selesai-' . $i,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'endDate' => '+1y',
                                                    ],
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Selesai',
                                                        'style' => 'width:143px;',
                                                    ]
                                                ],
                                            ]);
                                        ?>
                                    </div>
                                 <div class="col-md-3" id="lokasi-<?php echo $i; ?>"  style="padding:0px 0px 0px 7px;">
                                        Lokasi
                                        <br>
                                        <input class="lokasi-rutan form-control" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][lokasi_rutan]" placeholder="Lokasi" style="width:184px;" value="<?php echo $modelTahananPenyidik[($i-1)]->lokasi_rutan; ?>" style="width:10px;">
                                    </div>
                                 <div class="col-md-2 hide" style="padding:0;" id="status-<?php echo $i; ?>">
                                        <select class="form-control" style="width:120px;" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][status_perpanjangan]" id="status-perpanjangan-<?php echo $i; ?>">
                                            <option value="">Status</option>
                                            <option value="1">Disetujui</option>
                                            <option value="2">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1" id="lamaTahan-<?php echo $i; ?>" style="padding:17px 0px 0px 0px;">
                                        <input type="checkbox" id="lama-penahanan-<?php echo $i; ?>"> <span style="color:red;">20 hari</span>
                                    </div></td>
                                </div>
                        

<?php 
    $iterationScript = <<< JS
                        $(document).ready(function(){
                            var id_loktahanan = $('#lokasi-tahanan-selector-$i').val();
                            var loktahanan = $('#lokasi-tahanan-selector-$i').html();
                            if(id_loktahanan == 4 || loktahanan == 'Tidak Ditahan'){
                                $('#startEndDate-$i').hide();
                                $('#lokasi-$i').hide();
                                $('#lamaTahan-$i').hide();
                                $('#status-$i').hide();
                            }else{
                                $('#startEndDate-$i').show();
                                $('#lokasi-$i').show();
                                $('#lamaTahan-$i').show();
                                $('#status-$i').show();
                            }
                        });

                        $('#lokasi-tahanan-selector-$i').change(function(){
                            var id_loktahanan = $(this).val();
                            var loktahanan = $(this).html();
                            if(id_loktahanan == 4 || loktahanan == 'Tidak Ditahan'){
                                $('#startEndDate-$i').hide();
                                $('#lokasi-$i').hide();
                                $('#lamaTahan-$i').hide();
                                $('#status-$i').hide();
                            }else{
                                $('#startEndDate-$i').show();
                                $('#lokasi-$i').show();
                                $('#lamaTahan-$i').show();
                                $('#status-$i').show();
                            }
                        });

                        $('#lama-penahanan-$i').change(function(){
                            var tgl_mulai = $('#tgl-mulai-$i').val();
                            if (tgl_mulai != null && tgl_mulai != '') {
                                if(this.checked){
                                    var str_tgl_mulai = tgl_mulai.split('-');
                                    console.log(str_tgl_mulai);
                                    var startDate = new Date(str_tgl_mulai);
                                    console.log(startDate);
                                    var the40DaysAfter = new Date(startDate).setDate(startDate.getDate() + 20);
                                    console.log(the40DaysAfter);
                                    var endDate = new Date(the40DaysAfter);
                                    console.log(endDate);

                                    function pad(number){
                                        return (number < 10) ? '0' + number : number;
                                    }

                                    var tgl_selesai_human_format = pad(endDate.getDate()) + '-' + pad(endDate.getMonth() + 1) + '-' + endDate.getFullYear();
                                    var tgl_selesai_db_format = endDate.getFullYear() + '-' + pad(endDate.getMonth() + 1) + '-' + pad(endDate.getDate());
                                    $('#tgl-selesai-$i').val(tgl_selesai_db_format);
                                    $('#tgl-selesai-$i-disp').val(tgl_selesai_human_format);
                                }
                            }
                        });				
					
JS;
$this->registerJs($iterationScript);
?>
           </tr>     <?php
                        $i++;
                        endforeach;
                    endif;
                ?></tbody>
            </div>
        </div></table>
    </div>

        <div class="box-footer" style="text-align: center;">
            <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
            <?php
            if (!$model->isNewRecord) {
            ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-berkas/cetak?id=' . $model->id_berkas]) ?>">Cetak</a>
            <?php } ?>
            <!-- jaka | 1 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/pdm-berkas/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
        </div>

<?php
$script = <<< JS
        var currentValue = 1;
        $('#tambah-pasal').click(function(){
            if($('#jenis-pasal').val() == 'tunggal'){
                $('#tunggal').show();
            }

            if($('#jenis-pasal').val() == 'berlapis'){
                $('#tunggal').hide();
                $('#berlapis').show();
            }

        });


        var undangPasal = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '/pidum/default/undang?q=%QUERY',
                wildcard: '%QUERY'
            }
        });

		var i =1;
        $('#tambah-undang-pasal').click(function(){
			
                $('.undang-pasal-append').append(
					'<div class="hapus_pasal_awal'+i+'">'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Undang-undang</label>'+
                        	'</div>'+
                        	'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="undang[]" class="form-control typeahead" placeholder="undang - undang">'+
								'</div>'+
								'<div class="col-sm-3">'+
									'<a class="btn btn-danger delete" onclick=hapusPasalAwal("'+i+'")></a>'+
								'</div>'+
                        	'</div>'+
                    	'</div>'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Pasal</label>'+
                        	'</div>'+
							'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal">'+
								'</div>'+	
							'</div>'+
                        '</div>'+    
                    '</div>'
                    
					
                );
                $('.typeahead').typeahead('destroy');
                $('.typeahead').typeahead(null, {
                    name: 'undang',
                    displayKey: 'value',
                    source: undangPasal,
                });
				i++;
            });

				//BEGIN DANAR CMS_PIDUM_SPDP_06 danar Wido 20-06-2016	
				
                        $('#pdmberkas-tgl_terima-disp').on('changeDate',function(){
					
                            var tgl_surat = $('#pdmberkas-tgl_pengiriman-disp').val();					
                            if (tgl_surat != null && tgl_surat !='') {                                
                                  
									c= $('#pdmberkas-tgl_pengiriman').val();
									d= $('#pdmberkas-tgl_terima').val();
									
									if ( d < c )
									{
									$('#pdmberkas-tgl_terima-disp').val('');
									window.alert('Maaf tanggal terima  tidak boleh kurang dari tanggal berkas');
								
									}

							    }
						});
						
						
                        $('#pdmberkas-tgl_pengiriman-disp').on('changeDate',function(){
					
                            var tgl_surat = $('#pdmberkas-tgl_terima-disp').val();					
                            if (tgl_surat != null && tgl_surat !='') {                                
                                  
									c= $('#pdmberkas-tgl_pengiriman').val();
									d= $('#pdmberkas-tgl_terima').val();
									
									if ( d < c )
									{
									$('#pdmberkas-tgl_pengiriman-disp').val('');
									window.alert('Maaf tanggal berkas tidak boleh lebih dari tanggal terima');
								
									}

							    }
						});
					
				//END DANAR

JS;
$this->registerJs($script);
?>
<div class="asdf"></div>

<script>
	function hapusPasalAwal(key)
	{
		$('.hapus_pasal_awal'+key).remove();
	}
	
	function hapusPasal(key, id_pasal)
	{
		$('.hapus'+key).remove();
		$('.hapus_undang_pasal').append(
			'<input type="hidden" name="hapus_undang_pasal[]" value="'+id_pasal+'">'
		);
	}
</script>
<?php ActiveForm::end(); ?>
</div>
<div id="hiddenId"></div>
<?php


 /*
<div class="col-md-12" style="padding:0px;">
                <?php
                    if (!empty($modelTersangka)):
                        $i = 1;
                        foreach ($modelTersangka as $key => $value):
                ?>
                            <h4 id="<?php echo $value->id_tersangka;?>"><?php echo $i . ". " . $value->nama; ?></h4>
                            <input type="hidden" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][id_tersangka]" value="<?php echo $value->id_tersangka;?>">
                            <div class="well well-sm col-md-12">
                                <label class="control-label col-md-2" style="padding-top:8px;padding-left:2px;font-size:12px;">Penahanan Oleh Penyidik</label>
                                <div class="form-inline col-md-10" style="padding:0;">
                                    <div class="col-md-2" style="padding:0;">
                                        <select class="form-control" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][id_msloktahanan]" id="lokasi-tahanan-selector-<?php echo $i; ?>">
                                            <option value=""></option>
                                        <?php
                                            $loktahanan = ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama');
                                            foreach ($loktahanan as $kei => $row):
                                        ?>
                                            <option value="<?php echo $kei; ?>" <?php echo $modelTahananPenyidik[($i-1)]->id_msloktahanan == $kei ? "selected" : "";?>>
                                                <?php echo $row; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="startEndDate-<?php echo $i; ?>" style="padding:0 0 0 10px;width:36%">
                                        <?= DateControl::widget([
                                                'name' => 'PdmTahananPenyidik[' . ($i-1) . '][tgl_mulai]',
                                                'type' => DateControl::FORMAT_DATE,
                                                'id' => 'tgl-mulai-' . $i,
                                                'ajaxConversion' => false,
                                                'value' => !empty($modelTahananPenyidik[($i-1)]->tgl_mulai) ? $modelTahananPenyidik[($i-1)]->tgl_mulai : '',
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'endDate' => '+1y',
                                                    ],
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Mulai',
                                                        'style' => 'width:118px;',
                                                    ]
                                                ],
                                            ]);
                                        ?>
                                        <label class="control-label" style="margin-top: 6px;">s.d.</label>
                                        <?= DateControl::widget([
                                                'name' => 'PdmTahananPenyidik[' . ($i-1) . '][tgl_selesai]',
                                                'type' => DateControl::FORMAT_DATE,
                                                'value' => !empty($modelTahananPenyidik[($i-1)]->tgl_selesai) ? $modelTahananPenyidik[($i-1)]->tgl_selesai : '',
                                                'id' => 'tgl-selesai-' . $i,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'endDate' => '+1y',
                                                    ],
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Selesai',
                                                        'style' => 'width:118px;',
                                                    ]
                                                ],
                                            ]);
                                        ?>
                                    </div>
                                    <div class="col-md-3" id="lokasi-<?php echo $i; ?>"  style="padding:0px 0px 0px 2px;width:22%">
                                        <label style="padding-top:8px;font-size:12px;">Lokasi</label>
                                        <input class="lokasi-rutan form-control" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][lokasi_rutan]" placeholder="Lokasi" style="width:120px;" value="<?php echo $modelTahananPenyidik[($i-1)]->lokasi_rutan; ?>" style="width:10px;">
                                    </div>
                                    <div class="col-md-2 hide" style="padding:0;" id="status-<?php echo $i; ?>">
                                        <select class="form-control" style="width:120px;" name="PdmTahananPenyidik[<?php echo ($i-1); ?>][status_perpanjangan]" id="status-perpanjangan-<?php echo $i; ?>">
                                            <option value="">Status</option>
                                            <option value="1">Disetujui</option>
                                            <option value="2">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1" id="lamaTahan-<?php echo $i; ?>" style="padding:6px 0px 0px 0px;">
                                        <input type="checkbox" id="lama-penahanan-<?php echo $i; ?>"> <span style="color:red;">20 hari</span>
                                    </div>
                                </div>
                            </div>

<?php 
    $iterationScript = <<< JS
                        $(document).ready(function(){
                            var id_loktahanan = $('#lokasi-tahanan-selector-$i').val();
                            var loktahanan = $('#lokasi-tahanan-selector-$i').html();
                            if(id_loktahanan == 4 || loktahanan == 'Tidak Ditahan'){
                                $('#startEndDate-$i').hide();
                                $('#lokasi-$i').hide();
                                $('#lamaTahan-$i').hide();
                                $('#status-$i').hide();
                            }else{
                                $('#startEndDate-$i').show();
                                $('#lokasi-$i').show();
                                $('#lamaTahan-$i').show();
                                $('#status-$i').show();
                            }
                        });

                        $('#lokasi-tahanan-selector-$i').change(function(){
                            var id_loktahanan = $(this).val();
                            var loktahanan = $(this).html();
                            if(id_loktahanan == 4 || loktahanan == 'Tidak Ditahan'){
                                $('#startEndDate-$i').hide();
                                $('#lokasi-$i').hide();
                                $('#lamaTahan-$i').hide();
                                $('#status-$i').hide();
                            }else{
                                $('#startEndDate-$i').show();
                                $('#lokasi-$i').show();
                                $('#lamaTahan-$i').show();
                                $('#status-$i').show();
                            }
                        });

                        $('#lama-penahanan-$i').change(function(){
                            var tgl_mulai = $('#tgl-mulai-$i').val();
                            if (tgl_mulai != null && tgl_mulai != '') {
                                if(this.checked){
                                    var str_tgl_mulai = tgl_mulai.split('-');
                                    console.log(str_tgl_mulai);
                                    var startDate = new Date(str_tgl_mulai);
                                    console.log(startDate);
                                    var the40DaysAfter = new Date(startDate).setDate(startDate.getDate() + 20);
                                    console.log(the40DaysAfter);
                                    var endDate = new Date(the40DaysAfter);
                                    console.log(endDate);

                                    function pad(number){
                                        return (number < 10) ? '0' + number : number;
                                    }

                                    var tgl_selesai_human_format = pad(endDate.getDate()) + '-' + pad(endDate.getMonth() + 1) + '-' + endDate.getFullYear();
                                    var tgl_selesai_db_format = endDate.getFullYear() + '-' + pad(endDate.getMonth() + 1) + '-' + pad(endDate.getDate());
                                    $('#tgl-selesai-$i').val(tgl_selesai_db_format);
                                    $('#tgl-selesai-$i-disp').val(tgl_selesai_human_format);
                                }
                            }
                        });
JS;
$this->registerJs($iterationScript);
?>
                <?php
                        $i++;
                        endforeach;
                    endif;
                ?>
            </div>
*/ ?>
<?php
$script1 = <<< JS



	$('#popUpTersangka').click(function(){
		$('#m_tersangka').html('');
        $('#m_tersangka').load('/pidum/pdm-berkas/tersangka');
        $('#m_tersangka').modal('show');
	});

   $( document ).on('click', '.hapusTersangka', function(e) {
        
        console.log(e.target.value);
        var input = $( this );
        if(input.prop( "checked" ) == true){
            //$(".hapus").prop("disabled",false);
        
            $(".hapus").click(function(){
                $('tr[data-id="'+e.target.value+'"]').remove();
                $('#hiddenId').append(
                    '<input type="hidden" name="nama_update[]" value='+e.target.value+'>'
                )
            });  
        }
     
    });


JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Tambah Tersangka</h7>'
]);
Modal::end();
?>
<script>
    function hapusTersangka(id)
    {
        //$("#tr_id"+id).remove();
        var arr = [id];
        jQuery.each(arr, function( i, val ) {
                    console.log(val);
                });
        //console.log(id);
    }
    function hapusTersangkaOld(id, value)
    {
        $("#tr_id_old"+id).remove();
        $('#hiddenId').append(
            '<input type="hidden" name="id_tersangka_remove[]" value='+value+'>'
        )
    }
</script>
