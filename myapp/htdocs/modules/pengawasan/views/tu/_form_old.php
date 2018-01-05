<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
    var url1 = '<?php echo Url::toRoute('was1/cetak'); ?>';

</script>
<?php $this->registerJs("
    $(document).ready(function(){
         
       if($(\"input[name='Was1[saran]']:checked\").val() != '1'){
       $('#hasil_saran').hide();
       }else{
       $('#hasil_saran').show();
       }
       
       $(\"input[name='Was1[saran]']\").change(function() {
        if (this.value == '1') {
         $('#hasil_saran').show();
         
        }else{
        $('#hasil_saran').hide();
        $('#was1-sebab_tdk_dilanjuti').val('');
        }
        });
          $('.cetakwas').click(function(){
         
       window.open('" . Url::to('pengawasan/was1/cetak', true) . "?id_register=' + $(\"#was1-id_register\").val() + '&id_was_1=' + $(\"#was1-id_was_1\").val());

      });
}); ", \yii\web\View::POS_END);
?>
<section class="content" style="padding: 0px;margin-top: 25px;">
    <div class="content-wrapper-1">
        <div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'was1-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'autoPlaceholder' => false
                        ],
                        'formConfig' => [
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                            'showLabels' => false
                        ],
                        'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
            ]);
            ?>
            <?php if (!$model->isNewRecord) { ?>
                <?php echo $form->field($model, 'id_was_1')->hiddenInput(); ?>
            <?php } ?>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-4">NO. Surat</label>
                        <div class="col-md-8">
                            <?php
                            $was_register = 0;
                            $searchModel = new \app\modules\pengawasan\models\Was1Search();
                            if ($model->isNewRecord) {
                                $session = Yii::$app->session;
                                $was_register = $session->get('was_register');
                            } else {
                                $was_register = $model->id_register;
                            }

                            $no_register = $searchModel->searchRegister($was_register);

                            $model->no_register = $no_register->no_register;
                            $model->id_register = $no_register->id_register;
                            ?>
                            <?= $form->field($model, 'no_register')->textInput(['readonly' => true]) ?>


                        </div>
                    </div>  
                    <?php //echo $form->field($model, 'id_register')->hiddenInput() ?>
                    <input id="was1-id_register" class="form-control" type="hidden" value="<?php echo $model->id_register ?>" name="Was1[id_register]">
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_was_1')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [

                                    'pluginOptions' => [

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
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-4">Kejaksaan</label>
                        <div class="col-md-8">
                            <?php
                            /* $was_register = 0;
                              if($model->isNewRecord){
                              $session = Yii::$app->session;
                              $was_register= $session->get('was_register');


                              }else{
                              $was_register = $model->id_register;
                              }
                             */
                              if ($model->isNewRecord) {
                                 $data_satker = $searchModel->searchSatker($was_register);
                            $model->inst_satkerkd = $data_satker['inst_satkerkd'];
                            $model->inst_nama = $data_satker['inst_nama'];
                            } else {
                           $model->inst_satkerkd = $model->inst_satkerkd;
                           $model->inst_nama = \app\modules\pengawasan\models\KpInstSatker::find()->where(['=', 'inst_satkerkd', $model->inst_satkerkd])->one()->inst_nama;
                            }
                           
                            ?>
                            <?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                            <?php //echo $form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true]) ?>

                            <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php echo $model->inst_satkerkd; ?>">

                        </div>
                    </div>  
                </div>

               <div class="col-md-4">
          <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#p_kejaksaan"><i class="glyphicon glyphicon-user"></i> ...</a> </span> </div>
   </div>
            </div>
            <div class="col-md-12">
                <label class="control-label col-md-2">Dugaan Pelanggaran</label>
                <div class="col-md-10">
                    <?php
                    $model->dugaan_pelanggaran = app\modules\pengawasan\models\DugaanPelanggaran::findOne(['id_register' => $was_register])->ringkasan;
                    ?>
                    <?= $form->field($model, 'dugaan_pelanggaran')->textarea(['rows' => 5, 'readonly' => true]) ?>
                </div>
            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2">Uraian</label>
                <div class="col-md-10">
                    <?php ?>
                    <?= $form->field($model, 'uraian')->textarea(['rows' => 5]) ?>
                </div>



            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2">Identitas Pelapor</label>
                <div class="col-lg-10">
                    <?php
                    $dataProvider = $searchModel->searchPelapor($was_register);
                    $gridColumn = [
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'nama',
                            'label' => 'Nama',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'alamat',
                            'label' => 'Alamat',
                    ]];


                    echo GridView::widget([

                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'layout' => "{items}",
                        'columns' => $gridColumn,
                        'responsive' => true,
                        'hover' => true,
                        'export' => false,
                            //'panel'=>[
                            //      'type'=>GridView::TYPE_PRIMARY,
                            //  'heading'=>$heading,
                            //],
                    ]);
                    ?>
                </div>



            </div>
            <div class="col-md-12" style="margin-top: 10px;">


                <label class="control-label col-md-2">Identitas Terlapor</label>
                <div class="col-lg-10">
                    <?php
                    $searchModel2 = new \app\modules\pengawasan\models\Was1Search();
                    $dataProvider2 = $searchModel2->searchTerlapor($was_register);
                    $gridColumn2 = [
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'peg_nama',
                            'label' => 'Nama',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'peg_nip_baru',
                            'label' => 'NIP',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'jabatan',
                            'label' => 'Jabatan',
                        ],
                    ];


                    echo GridView::widget([

                        'dataProvider' => $dataProvider2,
                        // 'filterModel' => $searchModel,
                        'layout' => "{items}",
                        'columns' => $gridColumn2,
                        'responsive' => true,
                        'hover' => true,
                        'export' => false,
                            //'panel'=>[
                            //      'type'=>GridView::TYPE_PRIMARY,
                            //  'heading'=>$heading,
                            //],
                    ]);
                    ?>
                </div>



            </div>

            <div class="col-md-12" style="margin-top: 10px;">


                <label class="control-label col-md-2">Penelitian Surat / Laporan(Buril)</label>
                <div class="col-lg-10">
                    <?= $form->field($model, 'buril')->textarea(['rows' => 5]) ?>
                </div>



            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2">Analisa</label>
                <div class="col-lg-10">
                    <?= $form->field($model, 'analisa')->textarea(['rows' => 5]) ?>
                </div>


            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2">Kesimpulan</label>
                <div class="col-lg-10">
                    <?= $form->field($model, 'kesimpulan')->textarea(['rows' => 5]) ?>
                </div>



            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2" style="margin-right: 20px;">Hasil Kesimpulan</label>
                <div class="col-md-9">
                    <?php
                    $options = [
                        'item' => function($index, $label, $name, $checked, $value) {

                            // check if the radio button is already selected
                            $checked = ($checked) ? 'checked' : '';

                            $return = '<label class="radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                            $return .= $label;
                            $return .= '</label>';

                            return $return;
                        }
                    ];
                    $query_hasil2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '05'")->all();
                    $query_hasil = ArrayHelper::map($query_hasil2, 'kd_lookup_item', 'nm_lookup_item');
                    ?>
                    <?= $form->field($model, 'hasil_kesimpulan')->radioList($query_hasil, $options) ?>
                </div>



            </div>
            <div class="col-md-12">


                <label class="control-label col-md-2" style="margin-right: 20px;">Saran</label>
                <div class="col-md-9">
                    <?php
                    $options2 = [
                        'item' => function($index, $label, $name, $checked, $value) {

                            // check if the radio button is already selected
                            $checked = ($checked) ? 'checked' : '';

                            $return = '<label class="radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                            $return .= $label;
                            $return .= '</label>';

                            return $return;
                        }
                    ];
                    $query_saran2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '06'")->all();
                    $query_saran = ArrayHelper::map($query_saran2, 'kd_lookup_item', 'nm_lookup_item');
                    ?>
                    <?= $form->field($model, 'saran')->radioList($query_saran, $options2) ?>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0px" id="hasil_saran">
            <div class="col-md-6" >
                <label class="control-label col-md-4" style="margin-top:-10px;">Sebab tidak ditindaklanjuti</label>
                <div class="col-md-8">
                    <?php
                    $query_sebab2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '07'")->all();
                    $query_sebab = ArrayHelper::map($query_sebab2, 'kd_lookup_item', 'nm_lookup_item');
                    ?>
                    <?=
                    $form->field($model, 'sebab_tdk_dilanjuti')->dropDownList($query_sebab, ['prompt' => 'Pilih'])
                    ?>
                </div>
            </div>
            </div>
            <div class="col-md-6">
                <!--<label class="control-label col-md-3">#WAS-2</label> -->
                <label class="control-label col-md-4">Upload File</label>
                <div class="col-md-8">
                    <?php
                    echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'showPreview' => true,
//'uploadUrl' => Url::to(['/modules/pengawasan/upload']),
                            'showUpload' => false,
//'uploadExtraData' => [
//'album_id' => 20,
//'cat_id' => 'Nature'
//],
//'maxFileCount' => 1
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-2">
                    <?php if (!$model->isNewRecord && !empty($model['upload_file'])) { ?>
                        <label class="control-label col-md-2">
                        
                        <?= Html::label($model['upload_file']); ?></label>
                       
                    <?php } ?>
                </div>
            </div>



        </div>
        <!--=====================================================2-->
        <div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                
                    
                        <!--<label style="margin-top:5px;" class="control-label col-md-2">Penandatangan</label>-->
                        <span class="pull-left"> <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> Pilih Penandatangan</a> </span>
                    
                
            </div>
            <?php
            if (!$model->isNewRecord) {
                if (!empty($model->ttd_peg_nik)) {
                    $searchModel2 = new \app\models\KpPegawaiSearch();
                    $modelKepegawaian = $searchModel2->searchPegawaiTtd($model->ttd_peg_nik, $model->ttd_id_jabatan);
                    $model->ttd_peg_nama = $modelKepegawaian['peg_nama'];
                    $model->ttd_peg_nip = (empty($modelKepegawaian['peg_nip_baru']) ? $modelKepegawaian['peg_nip'] : $modelKepegawaian['peg_nip_baru']);
                    $model->ttd_peg_pangkat = $modelKepegawaian['gol_pangkat'];
                    $model->ttd_peg_jabatan = $modelKepegawaian['jabatan'];
                }
            }
            ?>
            <?php //echo $form->field($model, 'ttd_peg_nik')->hiddenInput() ?>
            <?php //echo $form->field($model, 'ttd_id_jabatan')->hiddenInput() ?>
            <input type="hidden" value="<?php echo $model->ttd_peg_nik ?>" name="Was1[ttd_peg_nik]" class="form-control" id="was1-ttd_peg_nik">
            <input type="hidden" value="<?php echo $model->ttd_id_jabatan ?>" name="Was1[ttd_id_jabatan]" class="form-control" id="was1-ttd_id_jabatan">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
                    <div class="col-lg-9">
                        <div class="form-group field-was2-ttd_peg_nik">
                            <!--<div class="col-sm-12">

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>-->
                        </div>
                        <div class="form-group field-was2-ttd_peg_nama">
                            <div class="col-sm-12">

                                <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control']) ?>
                            </div>
                            <!--<div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">NIP</label>
                    <div class="col-lg-9">
                        <div class="form-group field-was2-ttd_peg_nip">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control']) ?>
                            </div>
                            <!--<div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>-->
                        </div>
                    </div>
                </div>

            </div>
            <div style="margin-top:15px;" class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3">Pangkat</label>
                    <div class="col-lg-9">
                        <div class="form-group field-was2-ttd_peg_jabatan">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control']) ?>
                            </div>
                            <!--<div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Jabatan</label>
                    <div class="col-lg-9">
                        <div class="form-group field-was2-ttd_peg_inst_satker">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control']) ?>
                            </div>
                            <!--<div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-9">
                        <div class="form-group field-was2-ttd_peg_nrp">
                            <div class="col-sm-12">

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3">
                        <div class="form-group field-was2-ttd_peg_unitkerja">
                            <div class="col-sm-12">

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;"> 
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>
            <?php if (!$model->isNewRecord) { ?> 
          
            <?= Html::Button('Hapus', ['class' => 'hapuswasform btn btn-primary','url'=>Url::to('pengawasan/was1/delete', true),'namaform'=>'was1-form']) ?>
            <?= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
              <?php echo $form->field($model, 'id_was_1')->hiddenInput(['name'=>'id']) ?>
            <?php } ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        Modal::begin([
            'id' => 'peg_tandatangan',
            'size' => 'modal-lg',
            'header' => 'Pilih Pegawai',
        ]);

        echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was1']);

        Modal::end();
        ?>
    </div>
</section>

<?php
    Modal::begin([
		'id' => 'p_kejaksaan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Kejaksaan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_dataKejaksaan', ['param'=> 'was1'] );
Modal::end();?>