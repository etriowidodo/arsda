<?php

use app\modules\pdsold\models\PdmB9;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm as ActiveForm2;

CKEditorAsset::register($this);
/* @var $this View */
/* @var $model PdmB9 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-b9-form">

    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'b9-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 2,
                'showLabels' => false

            ]
        ]);
    ?>

    <div class="box box-warning">
        <div class="box-header"></div>
        <div class="box-body">
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Wilayah Kerja</label>
                            <div class="col-md-8">
                                <input class="form-control" value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Dibuat</label>
                            <div class="col-md-4">
                                <?= $form->field($model,'tgl_b9')->widget(DateControl::className(),[
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'options' => [
                                        'options' => [
                                            'placeholder' => 'Tanggal Dibuat',
                                            ],
                                        'pluginOptions' => [
                                            'autoclose' => true
                                            ]
					]
                                    ]) 
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
                            <div class="col-md-8">
                                <?php
                                    echo $form->field($model, 'nip_jaksa')->dropDownList(
                                    ArrayHelper::map($modeljaksi, 'nip', 'nama'), // Flat array ('id'=>'label')
                                    ['prompt' => 'Pilih Jaksa', 'class' => 'cmb_jaksa']    // options
                                    );
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
                            <label class="control-label col-md-4">Petugas Penyitaan</label>
                            <div class="col-md-8">
                                <?php
                                    echo $form->field($model, 'nama_petugas', [
                                        'addon' => [
                                            'append' => [
                                                'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_petugas']),
                                                'asButton' => true
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Barang Bukti</label>
                            <div class="col-md-8">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!------------------------------------------------------ HIDDEN ------------------------------------------>
    <div class="box box-warning hide">
        <div class="box-header"><h3>Putusan Pengadilan</h3></div>
        <div class="box-body">
            <div class="form-group">
                <label class="control-label col-sm-3">No. Putusan Pengadilan Negeri</label>
                <div class="col-sm-3">
                    <?= $form->field($model, 'putusan_negeri') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Tanggal</label>
                <div class="col-sm-3">
                    <?= $form->field($model,'tgl_pn')->widget(DateControl::className(),[
					'type'=>DateControl::FORMAT_DATE,
					'ajaxConversion'=>false,
					'options' => [
						'options' => [
                            'placeholder' => 'Tanggal PN',
                        ],
						'pluginOptions' => [
							'autoclose' => true
						]
					]
				]) ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-3">Barang Bukti</label>
                <div class="col-sm-3">
                    <?php echo $form->field($model, 'barbuk')->textarea() ?>

                    <?php

                    $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                    $this->registerJs("
                                CKEDITOR.inline( 'PdmB9[barbuk]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-3">Amar Putusan mengenai barang bukti PN</label>
                <div class="col-sm-3">
                    <?= $form->field($model, 'amar_pn') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">No. Putusan Pengadilan Tinggi</label>
                <div class="col-sm-3">
                    <?= $form->field($model,'putusan_tinggi') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Tanggal</label>
                <div class="col-sm-3">
                    <?= $form->field($model,'tgl_pt')->widget(DateControl::className(),[
					'type'=>DateControl::FORMAT_DATE,
					'ajaxConversion'=>false,
					'options' => [
						'options' => [
                            'placeholder' => 'Tanggal PT',
                        ],
						'pluginOptions' => [
							'autoclose' => true
						]
					]
				]) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Amar Putusan mengenai barang bukti PT</label>
                <div class="col-sm-3">
                    <?= $form->field($model, 'amar_pt') ?>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-sm-3">No. Mahkamah Agung</label>
                <div class="col-sm-3">
                    <?= $form->field($model,'no_ma') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Tanggal</label>
                <div class="col-sm-3">
                    <?= $form->field($model,'tgl_ma')->widget(DateControl::className(),[
					'type'=>DateControl::FORMAT_DATE,
					'ajaxConversion'=>false,
					'options' => [
						'options' => [
                            'placeholder' => 'Tanggal MA',
                        ],
						'pluginOptions' => [
							'autoclose' => true
						]
					]
				]) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Amar Putusan mengenai barang bukti MA</label>
                <div class="col-sm-3">
                    <?= $form->field($model, 'amar_ma') ?>
                </div>
            </div>
        </div>

    </div>

   

   <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b9/cetak?id='.$model->tgl_b9])?>">Cetak</a>
        <?php } ?>
    </div>
    <?php
            //if(!$model->isNewRecord ){
                echo $form->field($model, 'nip_petugas')->hiddenInput();
            //}else{
                //echo Html::hiddenInput('PdmPetugas[nip]', null, ['id' => 'pdmpetugas-nip']);
            //}
        ?>
    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_petugas',
    'header' => 'Data Petugas Penyitaan',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_petugas', [
    'model' => $model,
    'searchPetugas' => $searchPetugas,
    'dataPetugas' => $dataPetugas,
])
?>

<?php
Modal::end();
?>

<?php 
/*$this->registerJs( "
$('#m_petugas').click(function(){
        $('#m_petugas').html('');
        $('#m_petugas').load('/pdsold/pdm-b9/get-petugas');
        $('#m_petugas').modal('show');
    });", \yii\web\View::POS_END);*/

?>