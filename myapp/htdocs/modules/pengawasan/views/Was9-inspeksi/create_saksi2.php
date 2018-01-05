<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\widgets\Pjax;
use app\modules\pengawasan\models\Was9_InspeksiSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Was9Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-9 Inspeksi (Surat Permintaan Keterangan Saksi Eksternal)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was9-index">
     <?php $form = ActiveForm::begin([ 
            // 'action' => ['create'],
            //'method' => 'get',
            //'id'=>'searchFormKpegawai', 
            //'options'=>['name'=>'searchFormKpegawai'],
            /*'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                            ],
                        ],*/
     ]); ?>
    <h1><?//= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <fieldset class="group-border">
    <legend class="group-border">Tambah Saksi Eksternal</legend>
    <div class="panel box box-primary" style="padding: 15px 0px;">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Nama</label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="nama" name="nama" class="form-control"></input> -->
                    <?= $form->field($modelSaksiEksternal, 'nama_saksi_eksternal')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Tempat Lahir</label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="tempat" name="tempat" class="form-control"></input> -->
                    <?= $form->field($modelSaksiEksternal, 'tempat_lahir_saksi_eksternal')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal Lahir</label>
                <div class="col-md-8 kejaksaan">
                    <?= $form->field($modelSaksiEksternal, 'tanggal_lahir_saksi_eksternal',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
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
                    ]
                ])->label(false);; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Warganegara</label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="warga" name="warga" class="form-control"></input> -->
                    <?= $form->field($modelSaksiEksternal, 'id_negara_saksi_eksternal')->dropDownList(
                      ArrayHelper::map(MsWarganegara::find()->all(), 'id', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Negara']
                       )->label(false);;  
                     ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Agama</label>
                <div class="col-md-7 kejaksaan"> 
                      <?
                        echo $form->field($modelSaksiEksternal, 'id_agama_saksi_eksternal')->dropDownList(
                      ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Agama']
                       )->label(false);;  

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Pendidikan</label>
                <div class="col-md-8 kejaksaan">
                  
                      <?
                   echo $form->field($modelSaksiEksternal, 'pendidikan')->dropDownList(
                      ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), 
                       ['class' => 'form-control','prompt' => 'Pilih Pendidikan']
                       )->label(false);;  

                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Kota</label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="kota" name="kota" class="form-control"></input> -->
                    <?= $form->field($modelSaksiEksternal, 'nama_kota_saksi_eksternal')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5">Pekerjaan</label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="kota" name="kota" class="form-control"></input> -->
                    <?= $form->field($modelSaksiEksternal, 'pekerjaan_saksi_eksternal')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-5"></label>
                <div class="col-md-7 kejaksaan">
                    <!-- <input id="kota" name="kota" class="form-control"></input> -->
                    <?//= $form->field($modelSaksiEksternal, 'pekerjaan_saksi_eksternal')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-md-5">Alamat</label>
                    <div class="col-md-7 kejaksaan">
                        <!-- <textarea id="alamat" class="form-control" name="alamat"></textarea> -->
                        <?= $form->field($modelSaksiEksternal, 'alamat_saksi_eksternal')->textArea(['style'=>'width: 350px'])->label(false); ?>
                    </div>
                </div>
        </div>
    </div>

</div>
</fieldset>

<div class="modal-footer">
    <div class="btn-toolbar">
        <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was9-inspeksi/index"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Batal</a>
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right'])  ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>
