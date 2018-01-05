<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmBa20;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use kartik\builder\Form;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
        [
            'id' => 'ba20-form',
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

<div class="content-wrapper-1">
    <div class="pdm-ba20-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. BA-20</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_ba20')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl BA-20'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+4m'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Bertempat di</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'lokasi')->textInput(['placeholder' => 'Bertempat di','value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Surat Perintah</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'surat_perintah')->textInput(['placeholder' => 'Surat Perintah']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No Surat Perintah</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_surat_perintah')->textInput(['placeholder' => 'No Surat Perintah']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Surat Perintah</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_surat_perintah')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Surat Perintah'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+4m'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No Putusan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_putusan')->textInput(['placeholder' => 'No Putusan']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Putusan</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_putusan')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Putusan'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+4m'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row hide" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tersangka</label>
                                        <div class="col-md-6">
                                            <?php
                                                echo $form->field($model, 'id_tersangka')->dropDownList(
                                                ArrayHelper::map(VwTerdakwaT2::find()->where(['no_register_perkara'=>$no_register])->all(), 'no_urut_tersangka', 'nama'), ['prompt' => 'Pilih Tersangka']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jaksa</label>
                                        <div class="col-md-6">
                                            <?php
                                                if ($model->isNewRecord) {?>
                                                    <div class="form-group field-pdmjaksasaksi-nama required">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                                <div class="input-group-btn">
                                                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"></div>
                                                        <div class="col-sm-12">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                            <?php
                                                } else {
                                            ?>
                                                <div class="form-group field-pdmjaksasaksi-nama required">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input value ="<?= $modeljaksi['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
                                                        echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-12"></div>
                                                    <div class="col-sm-12">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <h4>Kepada</h4>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Nama</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'nama')->textInput(['placeholder' => 'Nama']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Pekerjaan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'pekerjaan')->textInput(['placeholder' => 'Pekerjaan']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Alamat</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'alamat')->textInput(['placeholder' => 'Alamat']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary" style="border-color: #f39c12">
                    <div style="border-color: #c7c7c7;" class="box-header with-border">
                        <h3 class="box-title">
                            <strong>Saksi</strong>
                        </h3>
                    </div>
                    <div style="border-color: #c7c7c7;" class="box-header">
                        <div class="col-md-6" style="padding: 0px;">
                            <h3 class="box-title">
                                <a class='btn btn-danger delete hapus hapusSurat'></a>
                                &nbsp;
                                <a class="btn btn-primary tambah_memperhatikan">+ Saksi</a>
                            </h3>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <table id="table_grid_surat" class="table table-bordered table-striped">
                            <thead>
                                <th></th>
                                <th style="width: 97%">Saksi</th>
                            </thead>
                            <tbody id="tbody_grid_surat">
                                <?php if(!$model->isNewRecord){ ?>
                                <?// $i = 0;?>
                                    <?php foreach($dekot as $value): ?>
                                    <tr>
                                        <td style="height: 70px"></td>
                                        <td width="20%"><input name="txt_nama_surat[]" id=""  type='text' class='form-control' value="<?=$value?>"></input></td>
                                    </tr>
                                    <?// $i++;?>
                                    <?php endforeach; ?>
                                <?php }else{ ?>
                                <tr>
                                    <td style="height: 70px"></td>
                                    <td width="20%"><input name="txt_nama_surat[]" id=""  type='text' class='form-control'></input></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12">
            <div style="border-color: #c7c7c7;" class="box-header with-border">
                <h3 class="box-title">
                    <strong>Barang Bukti</strong>
                </h3>
            </div>

            <div class="form-group col-md-12">
                    <div class="col-md-4">
                        <table id="table_barbuk" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="4%" style="text-align: center;vertical-align: middle;">No</th>
                                    <th width="35%" style="text-align: center;vertical-align: middle;">Nama Barang Bukti</th>
                                    <th width="4%" style="text-align: center;vertical-align: middle;"></th>
                                </tr>
                            </thead>
                            <tbody id="tbody_barbuk">
                                <?php
                                    

                                    if (!$model->isNewRecord) {
                                        $arr = json_decode($model->barbuk);
                                        //echo '<pre>';print_r($arr);exit;
                                        //$arr = $dec->undang;
                                        $jum_undang= count($arr);
                                    }
                                    
                                    $ix = 0;
                                    foreach ($modelBarbuk as $listbarbuk):

                                        $check='';
                                    if (!$model->isNewRecord) {
                                        for ($i=0; $i < $jum_undang; $i++) { 
                                            if($listbarbuk['no_urut_bb'] == $arr[$i]){
                                                $check=' checked "true" '.$listbarbuk['no_urut_bb'];
                                            }
                                        }
                                    }
                                    $nama = Yii::$app->globalfunc->GetDetBarbuk(Yii::$app->session->get('no_register_perkara'),$listbarbuk['no_urut_bb']);
                                    //echo '<pre>';print_r($nama);exit;
                                        
                                        
                                    
                              
                                    echo '<tr id="row-'.$listbarbuk['no_urut_bb'].'">';
                                        echo '<td style="text-align: center">'.$listbarbuk['no_urut_bb'].'</td>';
                                        echo '<td style="text-align: left">'.$nama.'</td>';
                                        echo '<td style="text-align: left; "><input type="checkbox" name="barbuk[]" "'.$check.'" value="'.$listbarbuk['no_urut_bb'].'" style="width:100%"></td>';
                                    echo '</tr>';
                                        $ix++;
                                    endforeach;//exit;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6"></div>
                </div>

        </div>
    </div>
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): 
//            echo Html::a('Cetak', ['cetak', 'id' => rawurlencode($model->no_surat_p26)], ['class' => 'btn btn-warning']);?>
            <a class="btn btn-warning" href="<? echo Url::to(["pdm-ba20/cetak?id=".$model->no_register_perkara."&id2=".$model->tgl_ba20]) ?>">Cetak</a>
        <?php endif ?>	
        <?php  //} else {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                    ?>
        <?php
//        if (!$model->isNewRecord) {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//        } else {
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', NULL, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', $model->no_surat_p16a, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', $model->no_urut_jaksa_p16a, ['id' => 'pdmjaksasaksi-no_urut']);
            echo Html::hiddenInput('PdmJaksaSaksi[nip]', NULL, ['id' => 'pdmjaksasaksi-nip']);
            echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', NULL, ['id' => 'pdmjaksasaksi-jabatan']);
            echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', NULL, ['id' => 'pdmjaksasaksi-pangkat']);
//        }
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
        
var id=1;
	$('.tambah_memperhatikan').on('click', function() {
		$("#table_grid_surat > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check[]' class='hapusSuratCheck'></td><td><input type='text' class='form-control' name='txt_nama_surat[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});

    $('body').off().on('submit',function() {
    var cek = $('input:checkbox:checked').length;
    if(cek == 0){
        alert('Harus Ceklis Salah Satu Barang Bukti!!');
        return false;
    }  
    });

JS;
$this->registerJs($script);
?>

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>
