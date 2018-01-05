<?php

use app\models\MsSifatSurat;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\modules\pdsold\models\VwPenandatangan;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT15 */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    function delRow() {
        $("#row").remove();
        $("#btnTmbhTersangka").show();
        $("#mstersangka-tinggi").val("");
        $("#mstersangka-kulit").val("");
        $("#mstersangka-muka").val("");
        $("#mstersangka-ciri_khusus").val("");
    }
</script>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 't15-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false,
                            ]
                        ]
                )
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;">
            <?php
            echo Form::widget([ /* nomor surat */
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'nomor_surat' => [
                        'label' => 'Nomor Surat',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'no_surat' => [
                                'type' => Form::INPUT_TEXT,
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                    'sifat_surat' => [
                        'label' => 'Sifat',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'sifat' => [
                                'type' => Form::INPUT_DROPDOWN_LIST,
                                'options' => ['prompt' => 'Pilih Sifat Surat'],
                                //'items' => ["1" => "Biasa", "2" => "Rahasia", "3" => "Sangat Rahasia"],
                                'items' => ArrayHelper::map(MsSifatSurat::find()->asArray()->all(), 'nama', 'nama'),
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                ]
            ]);
            ?>
            <?php if ($model->isNewRecord) $model->kepada = 'JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS'; ?>
            <?php
            echo Form::widget([ /* lampiran */
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'lampiran_surat' => [
                        'label' => 'Lampiran',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'lampiran' => [
                                'type' => Form::INPUT_TEXT,
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                    'kepada_surat' => [
                        'label' => 'Kepada',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'kepada' => [
                                'type' => Form::INPUT_TEXT,
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                ]
            ]);
            ?>

            <?php $model->di = \Yii::$app->globalfunc->getNamaSatker($di)->inst_nama; ?>
            <?php
            echo Form::widget([ /* di */
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'di_surat' => [
                        'label' => 'di',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'di' => [
                                'type' => Form::INPUT_TEXT,
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                    'tanggal_kabur' => [
                        'label' => 'Tanggal Melarikan Diri',
                        'labelSpan' => 4,
                        'columns' => 8,
                        'attributes' => [
                            'tgl_kabur' => [
                                'type' => Form::INPUT_WIDGET,
                                //'widgetClass' => '\kartik\widgets\DatePicker',
                                'widgetClass' => '\kartik\datecontrol\DateControl',
                                'hint' => 'format tanggal DD/MM/YYYY',
                                'options' => ['pluginOptions' => [
                                        'format' => 'dd-mm-yyyy',
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                    ]],
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                ]
            ]);
            ?>

        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;">
            <?php
            // echo Form::widget([ /* nomor registrasi */
            //     'model' => $model,
            //     'form' => $form,
            //     'columns' => 2,
            //     'attributes' => [
            //         'nomor_registrasi' => [
            //             'label' => 'Nomor Registrasi',
            //             'labelSpan' => 4,
            //             'columns' => 8,
            //             'attributes' => [
            //                 'no_registrasi' => [
            //                     'type' => Form::INPUT_TEXT,
            //                     'columnOptions' => ['colspan' => 12],
            //                 ],
            //             ]
            //         ],
            //         'tanggal_registrasi' => [
            //             'label' => 'Tanggal Registrasi',
            //             'labelSpan' => 4,
            //             'columns' => 8,
            //             'attributes' => [
            //                 'tgl_registrasi' => [
            //                     'type' => Form::INPUT_WIDGET,
            //                     //'widgetClass' => '\kartik\widgets\DatePicker',
            //                     'widgetClass' => '\kartik\datecontrol\DateControl',
            //                     'hint' => 'format tanggal DD/MM/YYYY',
            //                     'options' => ['pluginOptions' => [
            //                             'format' => 'dd-mm-yyyy',
            //                             'autoclose' => true,
            //                             'todayHighlight' => true,
            //                         ]],
            //                     'columnOptions' => ['colspan' => 12],
            //                 ],
            //             ]
            //         ],
            //     ]
            // ]);
            ?>

            <?php
            echo Form::widget([ /* nomor registrasi */
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'putusan_pengadilan' => [
                        'label' => 'Putusan Pengadilan',
                        'labelSpan' => 2,
                        'columns' => 10,
                        'attributes' => [
                            'put_pengadilan' => [
                                'type' => Form::INPUT_TEXTAREA,
                                'columnOptions' => ['colspan' => 12],
                            ],
                        ]
                    ],
                ]
            ]);
            ?>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <span class="pull-right">
                    <a class="btn btn-primary" id="btnTmbhTersangka" style="<?= $style; ?>" data-toggle="modal" data-target="#m_tersangka"><i
                            class="glyphicon glyphicon-user"></i> Tambah Tersangka</a>
                </span>

                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Identitas Tersangka</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <table id="table_tersangka" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%">Nama</th>
                            <th width="20%">Alamat</th>
                            <th width="20%">Pendidikan</th>
                            <th width="20%">Pekerjaan</th>
                            <th width="8%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_tersangka">

                        <?php
                        if (!$model->isNewRecord) {
                            echo '<tr id="row">';
                            echo '<td><input type="hidden" class="form-control" id="pdmt15-id_tersangka" name="PdmT15[id_tersangka]" readonly="true" value="' . $model->id_tersangka . '">';
                            echo '<input type="text" class="form-control" name="nmTersangka" readonly="true" value="' . $tblTersangka->nama . '"></td>';
                            echo '<td><input type="text" class="form-control" name="almtTersangka" readonly="true" value="' . $tblTersangka->alamat . '"></td>';
                            echo '<td><input type="text" class="form-control" name="pekerjaanTersangka" readonly="true" value="' . $tblTersangka->pekerjaan . '"></td>';
                            echo '<td><input type="text" class="form-control" name="pendidikanTersangka" readonly="true" value="' . $tblTersangka->is_pendidikan . '"></td>';
                            echo '<td><input type="button" class="btn btn-danger delete hapus" name="brnHapus" value="" onclick="delRow()"></td>';
                            echo '</tr>';
                        }
                        ?>

                        <?php
                        /* if (!$model->isNewRecord) {
                          foreach ($terlapor as $data) {
                          $query = new Query;
                          $query->select('*')
                          ->from('was.v_riwayat_jabatan')
                          ->where("id= :id", [':id' => $data->id_h_jabatan]);

                          $pegawai = $query->one();

                          echo '<tr id="trterlapor' . $pegawai['peg_nip_baru'] . '">';
                          echo '<td><input type="text" class="form-control" name="namaTerlapor[]" readonly="true" value="' . $pegawai['peg_nama'] . '"> </td>';
                          echo '<td><input type="text" class="form-control" name="nipTerlapor[]" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
                          echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                          echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
                          echo '</td>';
                          echo '<td><input type="text" class="form-control" name="jabatanTerlapor[]" readonly="true" value="' . $pegawai['jabatan'] . '"> </td>';
                          echo '<td><a class="btn btn-primary" id="btn_delete_terlapor">Hapus</a></td>';
                          '</tr>';
                          }
                          } */
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="box-header with-border" style="border-bottom:none;">

                <?php
                echo Form::widget([
                    'model' => $modelMsTersangka,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'tinggi_badan' => [
                            'label' => 'Tinggi Badan',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'tinggi' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                        'warna_kulit' => [
                            'label' => 'Warna Kulit',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'kulit' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                echo Form::widget([
                    'model' => $modelMsTersangka,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'bentuk_muka' => [
                            'label' => 'Bentuk Muka',
                            'labelSpan' => 4,
                            'columns' => 12,
                            'attributes' => [
                                'muka' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                        'ciri_khusus' => [
                            'label' => 'Ciri Khusus Lain',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'ciri_khusus' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                echo Form::widget([ /* modus */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'modus' => [
                            'label' => 'Modus',
                            'labelSpan' => 2,
                            'columns' => 10,
                            'attributes' => [
                                'modus' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php if ($model->isNewRecord) $model->kerugian = 'Kerugian Negara ...................../ Akibat yang ditimbulkan....................'; ?>
                <?php
                echo Form::widget([ /* kerugian */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'modus' => [
                            'label' => 'Kerugian Negara & Akibat',
                            'labelSpan' => 2,
                            'columns' => 10,
                            'attributes' => [
                                'kerugian' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>

            </div>
        </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T15, 'id_table' => $model->id_t15]) ?>
        
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?= Html::a('Batal', ['/pdsold/pdm-t15/index'], ['class' => 'btn btn-warning']); ?>
            <?php
            if (!$model->isNewRecord)
                echo Html::a('Cetak', ['/pdsold/pdm-t15/cetak', 'id' => $model->id_t15], ['class' => 'btn btn-warning']);
            ?>
        </div>

<?php ActiveForm::end(); ?>
    </div>
</section>

<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => 'Data Tersangka',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_modalTersangka', [
    'model' => $model,
    //'searchPegawai' => $searchPegawai,
    'dataProviderTersangka' => $dataProviderTersangka,
])
?>

<?php
Modal::end();
?>

<?php
/* $script = <<< JS
  $("#btn_hapus_tersangka").click(function(){
  $("tr#row").remove();
  });
  JS;

  $this->registerJs($script); */
?>