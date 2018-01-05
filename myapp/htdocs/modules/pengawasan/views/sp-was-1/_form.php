<style>
#m_terlapor 
{
    margin-top: 70px !important;
} 
</style>
<?php
  use yii\helpers\Html;
  use yii\helpers\ArrayHelper;
  use kartik\widgets\ActiveForm;
  use yii\bootstrap\Modal;
  use kartik\datecontrol\DateControl;
  use kartik\date\DatePicker;
  use kartik\widgets\Select2;
  use app\modules\pengawasan\models\VRiwayatJabatan;
  use app\modules\pengawasan\models\VPejabatTembusan;
  use app\modules\pengawasan\models\SpWas1Search;
  use app\components\InspekturComponent;
  use yii\grid\GridView;
  use yii\widgets\Pjax;
  use yii\db\Query;
  use yii\db\Command;

  /* @var $this yii\web\View */
  /* @var $model app\modules\pengawasan\models\SpWas1 */
  /* @var $form yii\widgets\ActiveForm */
 
  $form = ActiveForm::begin([
              'id' => 'spwas1',
              'type' => ActiveForm::TYPE_HORIZONTAL,
              'enableAjaxValidation' => false,
              'fieldConfig' => [
                  'autoPlaceholder' => false
              ],
              'options'=>['enctype'=>'multipart/form-data'] ,
              'formConfig' => [
                  'deviceSize' => ActiveForm::SIZE_SMALL,
                  'showLabels' => false
              ]
  ]);
?>
 
<div class="box box-primary" style="padding: 15px 0px;">
    <?php
      if($model->isNewRecord) {
        if($result_expire=='1'){
          ?>
          <div class="alert alert-warning" style="margin:0 15px 15px 15px;">
              <strong>Peringatan!</strong> . Sp.WAS-1 Masih Aktif!. Anda Tidak Bisa Membuat Sp.WAS-1 lagi
          </div> 
          <?php
        }
      }else{
        ?>
        <?php
        if($result_expire=='0'){ ?>
          <div class="alert alert-warning" style="margin:0 15px 15px 15px;">
              <strong>Peringatan!</strong> . Batas Tanggal Sp-Was-1 Sudah Kadaluarsa
          </div> 
          <?php
        }
      } ?>
   
  <?php if(!$model->isNewRecord) {?>
        
        <div class="col-md-7">
        <fieldset class="group-border">
        <legend class="group-border">Nomor dan Tanggal Surat</legend>
        <div class="" style="padding:0px">
          <div class="col-md-8">
            <div class="form-group">
              <div class="">
              <!-- <label for="no_sp_was_2" style="padding:0px">No Surat</label> -->
                <?php/*
                $bulan=date('m');
                $tahun=date('Y');
                $default_nomor="PRIN-..../H/Hjw/".$bulan.'/'.$tahun;
                if($model->nomor_sp_was1==''){
                  $model->nomor_sp_was1=$default_nomor;
                }
                echo $form->field($model, 'nomor_sp_was1')->textInput();
                */?>
<!-- .////////////////////////////////////////// -->
              <label for="no_sp_was_1" style="padding:0px">No Sprint</label>
                          <div class="form-group field-spwas1-nomor_sp_was1">
                          <div class="col-md-12">
                           <?php $nomor_sp1=explode("/H/Hjw/", $model->nomor_sp_was1); 
                            $x1= substr($nomor_sp1[0],5);
                            ?>
                            <div class="col-sm-4" style="padding-left: 0px;">
                              <input id="spwas1-nomor_sp_was1" class="form-control" name="no_print" value="PRIN-" readonly="readonly" type="text">
                              <div class="col-sm-12"></div>
                              <div class="col-sm-12"><div class="help-block"></div></div>
                            </div>
                            <div class="col-sm-4"  style="padding-left: 0px;">
                            <?php
                                $bulan=date('m');
                                $tahun=date('Y');
                                $default_nomor="/H/Hjw/".$bulan.'/'.$tahun;
                                // if($model->nomor_sp_was1==''){
                                //   $model->nomor_sp_was1=$default_nomor;
                                // }
                                $model->nomor_sp_was1=$x1;
                                echo $form->field($model, 'nomor_sp_was1')->textInput();
                                ?>
                            </div>
                            <div class="col-sm-4"  style="padding-left: 0px;">
                              <input class="form-control" name="no_hwj" value="<?= ($nomor_sp1[1] !='' ? $default_nomor: '/H/Hjw/'.$nomor_sp1[1] )?>" readonly="readonly" type="text"></input>
                                
                            </div>
                          </div>
                        </div>

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div class="col-md-12">
              <label for="tanggal_sp_was2" style="padding:0px">Tanggal Surat</label>
                <?=
                $form->field($model, 'tanggal_sp_was1',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                      'pluginOptions' => [
                          'autoclose' => true,
                          'startDate' => date("d/m/Y", strtotime($model->tanggal_mulai_sp_was1)),
                          'endDate' => date("d/m/Y", strtotime($model->tanggal_akhir_sp_was1)),
                      ]
                    ]
                  ]);
                ?>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
      </div>
      <?php } ?>


        <div class="col-md-5">
        <fieldset class="group-border">
        <legend class="group-border">Tanggal berlaku SPRINT</legend>
        <div class="col-md-12" style="padding:0px">
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-md-12">
              <label for="tanggal_sp_was2" style="padding:0px">Dari Tanggal</label>
                <?php
                  if($model->tanggal_mulai_sp_was1!=''){
                    $model->tanggal_mulai_sp_was1=date("d-m-Y", strtotime($model->tanggal_mulai_sp_was1));
                  }
                  echo  $form->field($model, 'tanggal_mulai_sp_was1',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]); 
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="col-md-12">
              <label for="tanggal_sp_was2" style="padding:0px">Sampai Tanggal</label>
                <?php
                  if($model->tanggal_akhir_sp_was1!=''){
                    $model->tanggal_akhir_sp_was1=date("d-m-Y", strtotime($model->tanggal_akhir_sp_was1));
                  }
                  echo $form->field($model, 'tanggal_akhir_sp_was1',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]); 
                ?>
              </div>
            </div>
          </div>
        </div>
      </fieldset>
      </div>
 
    <div class="col-sm-12" style="margin-top:20px;">
      <div class="btn-toolbar">
          <a class="btn btn-primary btn-sm pull-right" id="tambah_dasar"><i class="glyphicon glyphicon-plus">  </i> Tambah</a>&nbsp;
      </div>
    </div>

    <?php
          if(!$model->isNewRecord){
            foreach ($modelDasarSurat as $dasar_surat) {

          ?>
              <div class="tampungan dasar_surat<?php echo $dasar_surat['id_dasar_sp_was1'] ?>">
                <div class="col-sm-11" style="margin-top:10px;"><!-- ini default dari LAPDU -->
                  <label for="inputsm">Dasar Surat</label>
                  <?//= $form->field($model, 'isi_dasar_sp_was_2[]')->textArea(['value'=>$dasar_surat['id_dasar_surat_sp_was2']]) ?>
                  <textarea class="form-control" name="isi_dasar_sp_was_1[]"><?php echo $dasar_surat['isi_dasar_sp_was1'] ?></textarea>
                </div>
                <div class="col-sm-1 hapus" style="margin-top:30px;width:59px;padding:0px"><a  rel="<?php echo $dasar_surat['id_dasar_sp_was1'] ?>" class="btn btn-primary btn-sm pull-right hapus_dasar" id="hapus_dasar"><i class="glyphicon glyphicon-trash"></i></a></div>
              </div>
      <?php
          }
        }else{
          /*perubahan daskrimti minta di tampilkan 2 dasar yg bersumber dari was1*/
           $connection = \Yii::$app->db;
           //and id_wilayah='".$_SESSION['id_wil']."' and id_level1='". $_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'

          $c=new InspekturComponent();
          $x=$c->getInspektur($_SESSION['id_wil'].'.'.$_SESSION['id_level_1'].'.'.$_SESSION['id_level_2'].'.'.$_SESSION['id_level_3'].'.'.$_SESSION['id_level_4']);
          $var=str_split($x['kode']);

          $sqlLapdu="select a.* from was.lapdu a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
          $result_lapdu = $connection->createCommand($sqlLapdu)->queryOne();

          $sqlpelapor="select string_agg(nama_pelapor,', ') as nama_pelapor from was.pelapor a  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
          $result_pelapor = $connection->createCommand($sqlpelapor)->queryOne();

          $sqldasar10     ="select string_agg(a.nama_pegawai_terlapor,', ') as nama from was.pegawai_terlapor_was10 a
                            where a.no_register='".$_SESSION['was_register']."' 
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' 
                            and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
                            and a.id_wilayah='".$_SESSION['id_wil']."'
                            and a.id_level1='".$_SESSION['id_level_1']."' and a.id_level2='".$_SESSION['id_level_2']."'
                            and a.id_level3='".$_SESSION['id_level_3']."' and a.id_level4='".$_SESSION['id_level_4']."'";
          $result_dasar10 = $connection->createCommand($sqldasar10)->queryOne();

          $sqldasarPegTer ="select string_agg(a.nama_pegawai_terlapor,', ') as nama from was.pegawai_terlapor a
                            where a.no_register='".$_SESSION['was_register']."' 
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' 
                            and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
                            and a.id_wilayah='".$_SESSION['id_wil']."'
                            and a.id_level1='".$_SESSION['id_level_1']."' and a.id_level2='".$_SESSION['id_level_2']."'
                            and a.id_level3='".$_SESSION['id_level_3']."' and a.id_level4='".$_SESSION['id_level_4']."'
                            and id_sp_was1=(select distinct max(id_sp_was1)  
                            from was.pegawai_terlapor where no_register='".$_SESSION['was_register']."' 
                            and id_tingkat='".$_SESSION['kode_tk']."' 
                            and id_kejati='".$_SESSION['kode_kejati']."' 
                            and id_kejari='".$_SESSION['kode_kejari']."' 
                            and id_cabjari='".$_SESSION['kode_cabjari']."' 
                            and id_wilayah='".$_SESSION['id_wil']."'
                            and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."'
                            and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."')";
          $result_dasar11 = $connection->createCommand($sqldasarPegTer)->queryOne();                            

          $sqldasar1="select string_agg(b.nama_terlapor_awal,', ') as nama from was.was_disposisi_irmud a inner join was.terlapor_awal b
                        on a.no_register=b.no_register and
                        a.id_tingkat=b.id_tingkat and
                        a.id_kejati=b.id_kejati and
                        a.id_kejari=b.id_kejari and
                        a.id_cabjari=b.id_cabjari 
                      where a.no_register='".$_SESSION['was_register']."' 
                      and a.id_tingkat='".$_SESSION['kode_tk']."' 
                      and a.id_kejati='".$_SESSION['kode_kejati']."' 
                      and a.id_kejari='".$_SESSION['kode_kejari']."' 
                      and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                      and a.id_wilayah='".$_SESSION['id_wil']."'
                      and a.id_level1='".$_SESSION['id_level_1']."' and a.id_level2='".$_SESSION['id_level_2']."'
                      and a.id_level3='".$_SESSION['id_level_3']."' and a.id_level4='".$_SESSION['id_level_4']."' 
                      and a.id_pemeriksa='".$var[2]."'";
           $result_dasar12 = $connection->createCommand($sqldasar1)->queryOne();

           if($result_dasar10['nama'] == ''){
              $terlapor = $result_dasar11['nama'];
              //echo"muncul1";
           }else if($result_dasar11['nama'] == ''){
              $terlapor = $result_dasar12['nama'];
              //echo"muncul2";
           }else{
              $terlapor = $result_dasar10['nama'];
            //  echo"muncul3";
           }

           $newDate = date("Y-m-d", strtotime($result_lapdu['tanggal_surat_lapdu']));
           $dasar1="Laporan Pengaduan dari ".$result_pelapor['nama_pelapor']." Tanggal ".\Yii::$app->globalfunc->ViewIndonesianFormat($newDate)."  Nomor ".$result_lapdu['nomor_surat_lapdu']." perihal ".$result_lapdu['ringkasan_lapdu']." Atas pelanggaran yang di lakukan oleh oknum pegawai/jaksa atas nama ".$terlapor;
          // print_r($result_dasar1);
          
          // print_r($result_lapdu);
          // print_r($dasar1);
          // print_r($result_pelapor);
          // echo $_SESSION['id_wil'].$_SESSION['id_level_1'].$_SESSION['id_level_2'].$_SESSION['id_level_3'].$_SESSION['id_level_4'];

           $sqldasar2="select*from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['id_wil']."' and id_level1='". $_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'";
           $result_dasar2 = $connection->createCommand($sqldasar2)->queryOne();
          $dasar2="Disposisi Jaksa  Agung Muda Pengawasan Tanggal ". \Yii::$app->globalfunc->ViewIndonesianFormat($result_dasar2['was1_tgl_disposisi'])." Atas nota dinas ".$result_dasar2['was1_dari']." Pada Jaksa Agung Muda Bidang Pengawasan nomor ".$result_dasar2['no_surat']." Tanggal ".\Yii::$app->globalfunc->ViewIndonesianFormat($result_dasar2['was1_tgl_surat']);
           
          // print_r($dasar2);
       ?>
     <div class="col-sm-12" style="margin-bottom: 15px;"><!-- ini default dari LAPDU -->
         <label for="inputsm">Dasar Surat</label>
             <textarea class="form-control" name="isi_dasar_sp_was_1[]"><?=$dasar1?></textarea>
     </div>
     <div class="col-sm-12" style="margin-bottom: 15px;"><!-- ini default dari LAPDU -->
         <!-- <label for="inputsm">Dasar Surat</label> -->
         <textarea class="form-control" name="isi_dasar_sp_was_1[]"><?= $dasar2?></textarea>
     </div>
       <? 
     // } 
     }
       ?>
  <div class="col-sm-12 for_dasar_surat"> </div>

  <div class="col-sm-12" style="margin-top:20px">
    <div class="btn-toolbar">
      <a class="btn btn-primary btn-sm pull-right" id="hapus_pemeriksa"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
      <a class="btn btn-primary btn-sm pull-right cari_riksa" id="Tambah_pemeriksa"><i class="glyphicon glyphicon-plus"> </i> Tambah Pemeriksa</a>
    </div>
  </div>


  <div class="col-sm-12">
         <label class="for">Daftar Pemeriksa</label>
    <table class="table table-bordered">
            <thead>
                <tr>
                   <th width="4%" style="text-align:center;">No</th>
                      <th style="text-align:center;">NIP/NRP</th>
                      <th width="20%" style="text-align:center;">Nama</th>
                      <th style="text-align:center;">Jabatan</th>
                      <th style="text-align:center;">Pangkat</th>
                      <th width="2%" rowspan="2" style="text-align:center;"><input class="" type="checkbox" name="hapus_all_pemeriksa" id="hapus_all_pemeriksa"></th>
                </tr>
            </thead>
            <tbody class="bd_pemeriksa_tmp">
                <?php 
                 if(!$model->isNewRecord){
                $no_1=1;
                foreach ($modelPemeriksa as $value_pemeriksa) { ?>
                    <tr class="trpemeriksa<?php echo $value_pemeriksa['nip']; ?>" id="<?= $value_pemeriksa['nip'] ?>" nilai="<?= $value_pemeriksa['nip'] ?>" >
                      <td style="text-align:center;"><?= $no_1 ?></td>
                      <td><?= $value_pemeriksa['nip'].' '.$value_pemeriksa['nrp']?></td>
                      <td><?= $value_pemeriksa['nama_pemeriksa']?></td>
                      <td><?= $value_pemeriksa['jabatan_pemeriksa']?></td>
                      <td><?= $value_pemeriksa['pangkat_pemeriksa']?></td>
          <?php
                    echo "<td width='2%'><input class='hapus_one_pemeriksa' type='checkbox' name='ck_pr_ubah' rel='trpemeriksa".$value_pemeriksa['id_pemeriksa_sp_was1']."' value='".$value_pemeriksa['nip']."'enama='".$value_pemeriksa['nama_pemeriksa']. "'epangkat='".$value_pemeriksa['pangkat_pemeriksa']."'enip='".$value_pemeriksa['nip']."'ejabatan='".$value_pemeriksa['jabatan_pemeriksa']."'egolongan='".$value_pemeriksa['golongan_pemeriksa']."'enrp='".$value_pemeriksa['nrp']."'></td>";
                      ?>
                    <input type="hidden" name="nip[]" class="nip" value="<?= $value_pemeriksa['nip']?>">
                    <input type="hidden" name="nama_pemeriksa[]" class="nama_pemeriksa" value="<?= $value_pemeriksa['nama_pemeriksa']?>">
                    <input type="hidden" name="jabatan[]" class="jabatan" value="<?= $value_pemeriksa['jabatan_pemeriksa'] ?>">
                    <input type="hidden" name="pangkat[]" class="pangkat" value="<?= $value_pemeriksa['pangkat_pemeriksa']?>">
                    <input type="hidden" name="nrp[]" class="nrp" value="<?= $value_pemeriksa['nrp'] ?>">
                    <input type="hidden" name="golongan[]" class="golongan" value="<?= $value_pemeriksa['golongan_pemeriksa']?>">
                  </tr>
                <?php 
                $no_1++;
                    }
                  }   
              ?>
            </tbody>
    </table>
    </div>

    <div class="col-sm-12" style="margin-top:20px">
        <div class="btn-toolbar role-index">
          <a class="btn btn-primary btn-sm pull-right" id="hapus_terlapor"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
          <a class="btn btn-primary btn-sm pull-right" id="ubah_terlapor" data-placement="left" title="Ubah Terlapor"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
          <a class="btn btn-primary btn-sm pull-right cari_terlapor" id="tambah_terlapor" rel='0'><i class="glyphicon glyphicon-plus"></i> Tambah Terlapor</a>
        </div>
    </div>

    <div class="col-sm-12">
         <label class="for">Daftar Terlapor</label>
    <table id="terlapor" class="table table-bordered">
            <thead>
                <tr>
                    <th width="4%" style="text-align:center;">No</th>
                    <th width="20%" style="text-align:center;">Nama</th>
                    <th width="20%" style="text-align:center;">Golongan / Pangkat</th>
                    <th style="text-align:center;">NIP/NRP</th>
                    <th style="text-align:center;">Jabatan</th>
                    <th style="text-align:center;">Satker</th>
                    <th width="2%" rowspan="2" style="text-align:center;"><input class="" type="checkbox" name="select_all" id="select_all"></th>
                </tr>
            </thead>
            <tbody id="tbody_terlapor">
         <?php
         if($model->isNewRecord){/*jika dalam keadaan create ambil terlapor dari terlapor awal*/
                 $no=1;
                 foreach ($modelTerlapor as $terlapor) {
                 $tmp=json_encode($terlapor);
                ?>
                  <tr id="trterlapor<?php echo $terlapor['no_urut'] ?>">
                    <td style="text-align:center;"><?= $no ?><input name="noTerlapor[]" class="noTerlapor" value="<?= $no ?>" type="hidden"></td>
                    <td class="td_nama"><?= $terlapor['nama_terlapor_awal']?></td>
                    <td class="td_pangkat"><?= $terlapor['golongan_terlapor_awal'].($terlapor['pangkat_terlapor_awal']!=''?'('.$terlapor['pangkat_terlapor_awal'].')':'')?></td>
                    <td class="td_nip"><?= $terlapor['nip'].($terlapor['nrp_pegawai_terlapor']!=''?'/'.$terlapor['nrp_pegawai_terlapor']:'')?></td>
                    <td class="td_jabatan"><?= $terlapor['jabatan_terlapor_awal']?></td>
                    <td class="td_satker"><?= $terlapor['satker_terlapor_awal']?></td>
                    <td class="ck_box" width="2%">
                      <input name="namaTerlapor[]" class="namaTerlapor" value="<?= $terlapor['nama_terlapor_awal']?>" type="hidden">
                      <input name="pangkatTerlapor[]" class="pangkatTerlapor" value="<?= $terlapor['pangkat_terlapor_awal']?>" type="hidden">
                      <input name="golonganTerlapor[]" class="golonganTerlapor" value="<?= $terlapor['golongan_terlapor_awal']?>" type="hidden">
                      <input name="nipTerlapor[]" class="nipTerlapor" value="<?= $terlapor['nip']?>" type="hidden">
                      <input name="nrpTerlapor[]" class="nrpTerlapor" value="<?= $terlapor['nrp_pegawai_terlapor']?>" type="hidden">
                      <input name="jabatanTerlapor[]" class="jabatanTerlapor" value="<?= $terlapor['jabatan_terlapor_awal']?>" type="hidden">
                      <input name="satkerTerlapor[]" class="satkerTerlapor" value="<?= $terlapor['satker_terlapor_awal']?>" type="hidden">
                      <input class="selection_one" type="checkbox" value="" name="ck_tr" rel='<?=$tmp ?>' atrTerlapor="<?= $terlapor['nama_terlapor_awal'].'#'.$terlapor['jabatan_terlapor_awal'].'#'.$terlapor['satker_terlapor_awal']?>">
                    </td> 
                  </tr>
                  <?php
                  $no++;
                    }
          }else{ /*Jika keadaan update ambil data dari pegawai terlapor*/
                $no=1;
                 foreach ($modelTerlapor as $terlapor) {
                 $tmp=json_encode($terlapor);
                 ?>
                  <tr id="trterlapor<?php echo $terlapor['no_urut'] ?>">
                      <td style="text-align:center;"><?= $no ?><input name="noTerlapor[]" class="noTerlapor" value="<?= $no ?>" type="hidden"></td>
                      <td class="td_nama"><?= $terlapor['nama_terlapor_awal']?></td>
                      <td class="td_pangkat"><?= $terlapor['golongan_terlapor_awal'].($terlapor['pangkat_terlapor_awal']!=''?'('.$terlapor['pangkat_terlapor_awal'].')':'')?></td>
                      <td class="td_nip"><?= $terlapor['nip'].($terlapor['nrp_pegawai_terlapor']!=''?'/'.$terlapor['nrp_pegawai_terlapor']:'')?></td>
                      <td class="td_jabatan"><?= $terlapor['jabatan_terlapor_awal']?></td>
                      <td class="td_satker"><?= $terlapor['satker_terlapor_awal']?></td>
                      <td class="ck_box" width="2%">
                      <input name="namaTerlapor[]" class="namaTerlapor" value="<?= $terlapor['nama_terlapor_awal']?>" type="hidden">
                      <input name="pangkatTerlapor[]" class="pangkatTerlapor" value="<?= $terlapor['pangkat_terlapor_awal']?>" type="hidden">
                      <input name="golonganTerlapor[]" class="golonganTerlapor" value="<?= $terlapor['golongan_terlapor_awal']?>" type="hidden">
                      <input name="nipTerlapor[]" class="nipTerlapor" value="<?= $terlapor['nip']?>" type="hidden">
                      <input name="nrpTerlapor[]" class="nrpTerlapor" value="<?= $terlapor['nrp_pegawai_terlapor']?>" type="hidden">
                      <input name="jabatanTerlapor[]" class="jabatanTerlapor" value="<?= $terlapor['jabatan_terlapor_awal']?>" type="hidden">
                      <input name="satkerTerlapor[]" class="satkerTerlapor" value="<?= $terlapor['satker_terlapor_awal']?>" type="hidden">
                      <input class="selection_one" type="checkbox" value="<?= $terlapor['nip']?>" name="ck_tr" rel='<?=$tmp ?>' atrTerlapor="<?= $terlapor['no_urut']?>" atrTerlapor2="<?= $terlapor['nama_terlapor_awal'] ?>#<?= $terlapor['jabatan_terlapor_awal'] ?>#<?= $terlapor['satker_terlapor_awal'] ?>#<?= $terlapor['nip'] ?>#<?= $terlapor['nrp_pegawai_terlapor'] ?>#<?= $terlapor['pangkat_terlapor_awal'] ?>#<?= $terlapor['golongan_terlapor_awal'] ?>"></td>
                      
                  </tr>
                  <?php
                  $no++;
                    }

          }
                 ?>
              
            </tbody>
    </table>
    </div>


        <?php
    $result=new Query;
    $connection = \Yii::$app->db;
   
    $sql="select a.nip,b.nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan,b.golongan_penandatangan,c.nama,c.id_jabatan
          from was.penandatangan_surat a 
          inner join was.penandatangan b on a.nip=b.nip
          inner join was.was_jabatan c on a.id_jabatan=c.id_jabatan where a.unitkerja_kd='1.6'";
    $result = $connection->createCommand($sql)->queryOne();

if(!$model->isNewRecord){
    $query="select string_agg(nip,',') as nip_pemeriksa from was.pemeriksa_sp_was1 where no_register='".$_GET['id']."' and id_sp_was1='".$_GET['id_sp_was1']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' ";
    $resultNip=$connection->createCommand($query)->queryOne();
}

if(!$model->isNewRecord){
    $sql="select string_agg(nip,',') as nip_terlapor from was.pegawai_terlapor where no_register='".$_GET['id']."' and id_sp_was1='".$_GET['id_sp_was1']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and nip<>''";
    $resultNip_terlapor=$connection->createCommand($sql)->queryOne();
}
    $sqlWas1="select (CURRENT_DATE-was1_tgl_disposisi) as hari from was.was1  where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
    $resultWas1=$connection->createCommand($sqlWas1)->queryOne();

    ?>
<input type="hidden" class="form-control" id="Nip_TMP" name="Nip_TMP" value="<?php echo $resultNip['nip_pemeriksa'] ?>">
<input type="hidden" class="form-control" id="Nip_Terlapor_TMP" name="resultNip_terlapor" value="<?php echo $resultNip_terlapor['nip_terlapor'] ?>">
    <div class="col-md-12">
             <fieldset class="group-border">
                <legend class="group-border">Penandatangan</legend>

                <div class="col-md-12" style="padding: 0px">
                  

                  <div class="col-md-8">
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                     
                  </div>
                  </div>

                </div>

                 <div class="col-md-4">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-2" style="width:22%">Nip</label>
                        <div class="col-md-10" style="width:75%">
                          <?php
                          if(!$model->isNewRecord){
                          echo $form->field($model, 'nip_penandatangan',['addon' => ['append' => ['content'=>Html::button('Pilih', ['class'=>'btn btn-primary cari_ttd','id'=>'pilih_pegawai','data-toggle'=>'modal','data-target'=>'#penandatangan2',"data-backdrop"=>"static", "data-keyboard"=>false]), 
            'asButton' => true]]])->textInput(['readonly'=>'readonly']);
                         }else{
                          echo $form->field($model, 'nip_penandatangan',['addon' => ['append' => ['content'=>Html::button('Pilih', ['class'=>'btn btn-primary cari_ttd','id'=>'pilih_pegawai','data-toggle'=>'modal','data-target'=>'#penandatangan2',"data-backdrop"=>"static", "data-keyboard"=>false]), 
            'asButton' => true]]])->textInput(['readonly'=>'readonly','value'=>$result['nip']]);
                        } 
                           ?>
                        </div>
                    </div>  
                </div>
               <!--  <div class="col-sm-1">
                    <button class="btn btn-primary" type="button" id="pilih_pegawai" data-toggle="modal" data-target="#peg_tandatangan">Pilih</button>
                </div> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-sm-10">
                      <?//= $form->field($model, 'was1_nama_penandatangan')->textInput(['readonly'=>'readonly']) ?>
                      <?php
                      if(!$model->isNewRecord){
                        echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$result['nama_penandatangan']]);
                      } 
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                 <div class="form-group">
                    <label class="control-label col-md-2">Jabatan</label>
                <div class="col-sm-10">
                  <?php
                        if(!$model->isNewRecord){
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                       }else{
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$result['nama']]);
                      } 
                      ?>

                       <?php
                        if(!$model->isNewRecord){
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                        }else{
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$result['golongan_penandatangan']]);
                        }
                      ?>
                     <?php
                        if(!$model->isNewRecord){
                        echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                        }else{
                        echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$result['jabatan_penandatangan']]);
                        }
                      ?>
                      <?php
                        if(!$model->isNewRecord){
                        echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                        }else{
                        echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$result['pangkat_penandatangan']]);
                        }
                      ?>
                      <?php
                        // if(!$model->isNewRecord){
                        // echo $form->field($model, 'status_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                        // }else{
                        // echo $form->field($model, 'status_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$result['id_jabatan']]);
                        // }
                      ?>

                    

                </div>
                </div>
                </div>

                
             </fieldset>
        <!-- </div> -->
    <!-- </div> -->

    </div>

    <div class="col-md-12">
      <fieldset class="group-border">
        <legend class="group-border">Tembusan</legend>
        <!-- <div class="col-md-12" style="margin-bottom:10px;"> -->
        <div class="col-sm-12" style="margin-bottom: 15px">
            <div class="col-sm-6">
        <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
        <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a>
            </div>
        </div>
        <div class="for_tembusan">
    
            <?php 
        if(!$model->isNewRecord){
          
            $no=1;
            foreach ($modelTembusan as $key) {
        ?>
        <div class="col-md-7 <?php echo"tembusan".$key['id_tembusan_was']; ?>" style="margin-bottom: 15px" id="<?= $key['id_tembusan_was']?>">
            <div class="col-sm-1" style="text-align:center">
               <input type="checkbox" value="<?= $key['id_tembusan_was']?>" id="cekbok" class="cekbok">
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly style="text-align:center;">
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $key['tembusan']?>">
            </div>
        </div>
        <?php 
        $no++;
                }
            }else{ 

                $no_2=1;
                foreach ($modelTembusanMaster as $valueTembusanAwal) {   
              ?>

              <div class="col-md-7 <?php echo"tembusan".$valueTembusanAwal['id_tembusan']; ?>" style="margin-bottom: 15px" id="<?= $valueTembusanAwal['id_tembusan']?>">
                  <div class="col-sm-1" style="text-align:center">
                     <input type="checkbox" value="<?= $valueTembusanAwal['id_tembusan']?>" id="cekbok" class="cekbok">
                  </div>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly style="text-align:center;">
                  </div>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $valueTembusanAwal['nama_tembusan']?>">
                  </div>
              </div>
              <?php
               $no_2++;
                  }
                }
              ?>

    </div>
      </fieldset>
    </div>

<?php if(!$model->isNewRecord){ ?>
          <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas Sp-Was-1 : 
                     <?php if (substr($model['file_sp_was1'],-3)!='pdf'){?>
                     <?= ($model->file_sp_was1!='' ? '<a href="viewpdf?id='.$model['id_sp_was1'].'&no_register='.$model['no_register'].'" ><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                     <?= ($model->file_sp_was1!='' ? '<a href="viewpdf?id='.$model['id_sp_was1'].'&no_register='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                </label>
                <!-- <input type="file" name="file_sp_was1" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Upload File </span>
                <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="file_sp_was1" id="file_sp_was1" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
          </div>
 <?php 
    }
 ?>  



<!-- </div> -->
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?php
      // echo $result_expire;
       if (!$model->isNewRecord){
         
         if($result_expire=='1' && $model->tanggal_sp_was1==''){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ;
          }

       }else{

         if($result_expire=='0'){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ;
          }

       }
       ?>
      <?php
      if (!$model->isNewRecord) {
        
        echo " ".Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/sp-was-1/cetakdoc', 'id_sp_was1' => $model->id_sp_was1], ['class' => 'btn btn-primary']);
       // echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/sp-was-1/hapus', 'id' => $model->id_sp_was1], ['id' => 'hapusSpwas2', 'class' => 'btn btn-primary']);
      }
      
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/sp-was-1/index'], ['id' => 'KembaliSpWas1', 'class' => 'btn btn-primary']);
     ?>
    </div>

  
    <?php ActiveForm::end(); ?>

<!-- modal TERLAPOR UBAH-->
<div id="TerlaporModalUbah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lebar">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title label-terlapor"><!-- Tambah Terlapor --></h4>
      </div>
      <div class="modal-body">
        <div class="col-md-6">
        <div class="box box-primary" style="padding: 15px 0px;margin-top:70px;">
        
        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">NIP</label>
              <div class="col-md-8 kejaksaan">
                <input class="form-control" id="Mnip" name="Mnip" value="" type="text" readonly="readonly"><input class="form-control" id="Mnrp" name="Mnrp" value="" type="hidden">
                <input class="form-control" id="asal" name="asal" value="" type="hidden">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">Nama</label>
              <div class="col-md-10 kejaksaan">
                <input class="form-control" id="Mnama_terlapor" name="Mnama_terlapor" value="" type="text">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">Jabatan</label>
              <div class="col-md-10 kejaksaan">
                <input class="form-control" id="Mjabatan" name="Mjabatan" value="" type="text">
              </div>
          </div>
        </div>
            
        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">Golongan</label>
              <div class="col-md-8 kejaksaan"> 
                <input class="form-control" id="Mgolongan" name="Mgolongan" value="" type="text">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">Pangkat</label>
              <div class="col-md-10 kejaksaan">
                <input class="form-control" id="Mpangkat" name="Mpangkat" value="" type="text">
              </div>
          </div>
        </div>

        <div class="col-md-12" style="margin:4px 0px 4px 0px;">
          <div class="form-group">
              <label class="control-label col-md-2">Satker</label>
              <div class="col-md-10 kejaksaan">
                <input class="form-control" id="Msatker" name="Msatker" value="" type="text">
              </div>
          </div>
        </div>

    </div>
    </div>
    <div class="col-md-6">
       <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormMterlapor', 
                      'options'=>['name'=>'searchFormMterlapor'],
                      'fieldConfig' => [
                                  'options' => [
                                      'tag' => false,
                                      ],
                                  ],
                  ]); ?>
          <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-2">Cari</label>
                  <div class="col-md-8 kejaksaan">
                    <div class="form-group input-group">       
                      <input type="text" name="cari_pemeriksa" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                    </span>
                  </div>
              </div>
            </div>
          </div>
          <?php ActiveForm::end(); ?>

          <div class="box box-primary" id="grid-terlapor_surat" style="padding: 15px;overflow: hidden;">
      <?php
            $searchModel = new SpWas1Search();
            $dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize = 5;
            ?>
            <?php Pjax::begin(['id' => 'Mterlapor-ubah-grid', 'timeout' => false,'formSelector' => '#searchFormMterlapor','enablePushState' => false]) ?>
            <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nama Pegawai',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama',    
                ],

                
                ['label'=>'NIP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'peg_nip_baru',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan',
                ],   

            ['header'=>'Action',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['style' => 'width:5%;text-align:center;'],
            'contentOptions' => ['style' => 'width:5%;text-align:center;'],
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            $result=json_encode($model);
                            return Html::button('<i class="fa fa-plus"> Pilih </i>', ['class' => 'btn btn-primary btn-xs MTpilih_terlapor','json'=>$result,'data-placement'=>'left', 'title'=>'Pilih Terlapor']);
                        },
                    ]
                ],
                
             ],   

        ]); ?>
        <?php Pjax::end(); ?>
    <div class="modal-loading-new"></div>  
    </div>
    <div class="clearfix"></div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="Madd_terlapor"><p class="btn_pilih"></p></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
 </div>
</div>




<!-- modal PEMERIKSA TAMBAH-->
<div id="PemeriksaModalTambah" class="modal fade" role="dialog">
  <div class="modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Pemeriksa</h4>
      </div>
      <div class="modal-body">
        <div class="box box-primary" style="padding: 15px 0px;">
           <?php $form = ActiveForm::begin([
                      // 'action' => ['create'],
                      'method' => 'get',
                      'id'=>'searchFormPemeriksa', 
                      'options'=>['name'=>'searchFormPemeriksa'],
                      'fieldConfig' => [
                                  'options' => [
                                      'tag' => false,
                                      ],
                                  ],
                  ]); ?>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label col-md-2">Cari</label>
                  <div class="col-md-8 kejaksaan">
                    <div class="form-group input-group">       
                      <input type="text" name="cari_pemeriksa" class="form-control">
                      <span class="input-group-btn">
                          <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                      </span>
                    </div>
                  </div>
              </div>
            </div>
          <?php ActiveForm::end(); ?>

          <div class="col-md-12">
          <div class="box box-primary" id="grid-pemeriksa_surat" style="padding: 15px;overflow: hidden;">
            <?php
              $searchModel = new SpWas1Search();
              $dataProvider = $searchModel->searchPemeriksa(Yii::$app->request->queryParams);
              $dataProvider->pagination->pageSize = 10;
            ?>
            <?php Pjax::begin(['id' => 'Mpemeriksa-grid', 'timeout' => false,'formSelector' => '#searchFormPemeriksa','enablePushState' => false]) ?>
            <?= GridView::widget([
              'dataProvider'=> $dataProvider,
              // 'filterModel' => $searchModel,
              // 'layout' => "{items}\n{pager}",
              'columns' => [
                  ['header'=>'No',
                  'headerOptions'=>['style'=>'text-align:center;'],
                  'contentOptions'=>['style'=>'text-align:center;'],
                  'class' => 'yii\grid\SerialColumn'],
                  
                  ['label'=>'Nama Pemeriksa',
                      'headerOptions'=>['style'=>'text-align:center;'],
                      'attribute'=>'nama',    
                  ],

                  
                  ['label'=>'NIP',
                      'headerOptions'=>['style'=>'text-align:center;'],
                      'attribute'=>'peg_nip_baru',
                  ],

                  ['label'=>'Jabatan',
                      'headerOptions'=>['style'=>'text-align:center;'],
                      'attribute'=>'jabatan',
                  ],   

                  ['class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function ($data) {
                      $result=json_encode($data);
                      return ['value' => $data['peg_nip_baru'],'class'=>'Mselection_one','json'=>$result];
                      },
                  ],
                  
               ],   

            ]); ?>
        <?php Pjax::end(); ?>
          <div class="modal-loading-new"></div>   
          </div>
        </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="Mtambah_pemeriksa">Pilih</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>

<!-- modal TERLAPOR TAMBAH-->
<div id="TerlaporModalTambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lebar">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Terlapor</h4>
      </div>
      <div class="modal-body">
        <div class="box box-primary" style="padding: 15px 0px;">
             <?php $form = ActiveForm::begin([
              // 'action' => ['create'],
              'method' => 'get',
              'id'=>'searchFormTmbTerlapor', 
              'options'=>['name'=>'searchFormTmbTerlapor'],
              'fieldConfig' => [
                          'options' => [
                              'tag' => false,
                              ],
                          ],
          ]); ?>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-md-2">Cari</label>
              <div class="col-md-8 kejaksaan">
                  <div class="form-group input-group">       
                    <input type="text" name="cari_pemeriksa" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Terlapor"><i class="fa fa-search"> Cari </i></button>
                    </span>
                  </div>
              </div>
            </div>
          </div>
          <?php ActiveForm::end(); ?>
        
        <?php
            $searchModel = new SpWas1Search();
            $dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize = 10;
            ?>
            <?php Pjax::begin(['id' => 'MTerlapor-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTmbTerlapor','enablePushState' => false]) ?>
            <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nama Pegawai',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama',    
                ],

                
                ['label'=>'NIP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'peg_nip_baru',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan',
                ],   

                ['class' => 'yii\grid\CheckboxColumn',
                   'checkboxOptions' => function ($data) {
                    $result=json_encode($data);
                    return ['value' => $data['peg_nip_baru'],'class'=>'Mselection_one_tambah','json'=>$result];
                    },
                ],
                
             ],   

        ]); ?>
        <?php Pjax::end(); ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="Madd_terlapor_tambah">Pilih</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>

<!-- modal PENANDATANGAN -->
<div class="modal fade" id="penandatangan2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penandatangan</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenandatangan', 
                                      'options'=>['name'=>'searchFormPenandatangan'],
                                      'fieldConfig' => [
                                                  'options' => [
                                                      'tag' => false,
                                                      ],
                                                  ],
                                  ]); ?>
                          <div class="col-md-12">
                             <div class="form-group">
                                <label class="control-label col-md-2">Cari</label>
                                  <div class="col-md-8 kejaksaan">
                                    <div class="form-group input-group">       
                                      <input type="text" name="cari_penandatangan" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelSpwas1 = new SpWas1Search();
                            $dataProviderPenandatangan = $searchModelSpwas1->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_jabatan',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ],

                                    ['class' => 'yii\grid\CheckboxColumn',
                                      'headerOptions'=>['style'=>'text-align:center'],
                                      'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                      'checkboxOptions' => function ($data) {
                                          $result=json_encode($data);
                                          return ['value' => $data['id_surat'],'class'=>'selection_one_tandatangan','json'=>$result];
                                      },
                                    ],
                                    
                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?>
                        </div>
                        <div class="modal-loading-new"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_penandatangan">Tambah</button>
                </div>
            </div>
        </div>
</div>




<!-- =======================================================MODAL TAMBAH PELAPOR========================================================-->

<!-- =======================================================END MODAL TAMBAH PELAPOR====================================================-->
<style type="text/css">

/*Penandatangan-id-grid*/
#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}

/*Pemeriksa-id-grid*/
#grid-pemeriksa_surat.loading {overflow: hidden;}
#grid-pemeriksa_surat.loading .modal-loading-new {display: block;}

/*Terlapor-id-grid*/
#grid-terlapor_surat.loading {overflow: hidden;}
#grid-terlapor_surat.loading .modal-loading-new {display: block;}

fieldset.group-border {
    border: 1px solid #ddd;
    margin: 0;
    padding: 10px;
}
legend.group-border {
    border-bottom: none;
    width: inherit;
    margin: 0;
    padding: 0px 5px;
    font-size: 14px;
    font-weight: bold;
}
.modal-lebar{
  width: 1200px;
  overflow: hidden;
}
.modal-lebar table{
  font-size: 12px;
}
/*upload file css*/
.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.btn-file{overflow:hidden;position:relative;vertical-align:middle;}.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);transform:translate(-300px, 0) scale(4);font-size:23px;direction:ltr;cursor:pointer;}
.fileupload{margin-bottom:9px;}.fileupload .uneditable-input{display:inline-block;margin-bottom:0px;vertical-align:middle;cursor:text;}
.fileupload .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center;}.fileupload .thumbnail>img{display:inline-block;vertical-align:middle;max-height:100%;}
.fileupload .btn{vertical-align:middle;}
.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
.fileupload-inline .fileupload-controls{display:inline;}
.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.thumbnail-borderless .thumbnail{border:none;padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
.fileupload-new.thumbnail-borderless .thumbnail{border:1px solid #ddd;}
.control-group.warning .fileupload .uneditable-input{color:#a47e3c;border-color:#a47e3c;}
.control-group.warning .fileupload .fileupload-preview{color:#a47e3c;}
.control-group.warning .fileupload .thumbnail{border-color:#a47e3c;}
.control-group.error .fileupload .uneditable-input{color:#b94a48;border-color:#b94a48;}
.control-group.error .fileupload .fileupload-preview{color:#b94a48;}
.control-group.error .fileupload .thumbnail{border-color:#b94a48;}
.control-group.success .fileupload .uneditable-input{color:#468847;border-color:#468847;}
.control-group.success .fileupload .fileupload-preview{color:#468847;}
.control-group.success .fileupload .thumbnail{border-color:#468847;}

</style>
<script type="text/javascript">
 /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/
$(document).ready(function(){
  var hari="<?= $resultWas1['hari'] ?>";
// $('#spwas1-tanggal_mulai_sp_was1').datepicker({ minDate: -hari, maxDate: "0D" })
// $('#spwas1-tanggal_akhir_sp_was1').datepicker();

  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#spwas1-tanggal_mulai_sp_was1" )
        .datepicker({
          minDate: -hari,
          changeMonth: true,
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#spwas1-tanggal_akhir_sp_was1" ).datepicker({
        changeMonth: true,
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );

        var next = 1;
        $(".add-more").click(function(e){
            e.preventDefault();
            var addto = "#field" + next;
            var addRemove = "#field" + (next);
            next = next + 1;
            var newIn = '<input autocomplete="off" class="input" id="field' + next + '" name="field' + next + '" type="text">';
            var newInput = $(newIn);
            var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me btn-flat" ><i class="fa fa-times" aria-hidden="true"></i></button></div><div id="field">';
            var removeButton = $(removeBtn);
            $(addto).after(newInput);
            $(addRemove).after(removeButton);
            $("#field" + next).attr('data-source',$(addto).attr('data-source'));
            $("#count").val(next);  
            
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
        });
      localStorage.removeItem("nip_terlapor");
      var nipTerlapor=$('#Nip_Terlapor_TMP').val().split(',');
      localStorage.setItem('nip_terlapor', JSON.stringify(nipTerlapor));
      localStorage.removeItem("nip_pemeriksa");
      var nipPemeriksa=$('#Nip_TMP').val().split(',');
      localStorage.setItem("nip_pemeriksa_onDB", JSON.stringify(nipPemeriksa));
    });

window.onload=function(){
  $(document).on('click','#Madd_terlapor',function(){
   var asal=$('#asal').val();
   var Mnip=$('#Mnip').val();
   var Mnrp=$('#Mnrp').val();
   var Mnama_terlapor=$('#Mnama_terlapor').val();
   var Mjabatan=$('#Mjabatan').val();
   var Mgolongan=$('#Mgolongan').val();
   var Mpangkat=$('#Mpangkat').val();
   var Msatker=$('#Msatker').val();
   var gabung_nipNRP;
   var gabung_golPANGKAT;
   var tmp=Mnama_terlapor+'#'+Mjabatan+'#'+Msatker+'#'+Mnip+'#'+Mnrp+'#'+Mpangkat+'#'+Mgolongan;
   if(Mnrp!=''){
    gabung_nipNRP=Mnip+'/'+Mnrp;
   }else{
    gabung_nipNRP=Mnip;
   }

   if(Mpangkat!=''){
    gabung_golPANGKAT=Mgolongan+'('+Mpangkat+')';
   }else{
    gabung_golPANGKAT=Mgolongan;
   }

   if(asal=='ubah'){/*jika button yang di tekan ubah maka masuk kan data*/

   var json = JSON.parse(localStorage["nip_terlapor"]);
   if(Mnip!=''){/*cek lagi apakah nip ada atau tidak jika ada masukan*/
   if(jQuery.inArray(Mnip,json)==-1){
       $('.selection_one:checked').closest('tr').find('.td_nip').html(gabung_nipNRP);
       $('.selection_one:checked').closest('tr').find('.td_nama').html(Mnama_terlapor);
       $('.selection_one:checked').closest('tr').find('.td_jabatan').html(Mjabatan);
       $('.selection_one:checked').closest('tr').find('.td_satker').html(Msatker);
       $('.selection_one:checked').closest('tr').find('.td_pangkat').html(gabung_golPANGKAT);


       $('.selection_one:checked').closest('tr').find('.nipTerlapor').val(Mnip);
       $('.selection_one:checked').closest('tr').find('.nrpTerlapor').val(Mnrp);
       $('.selection_one:checked').closest('tr').find('.namaTerlapor').val(Mnama_terlapor);
       $('.selection_one:checked').closest('tr').find('.jabatanTerlapor').val(Mjabatan);
       $('.selection_one:checked').closest('tr').find('.golonganTerlapor').val(Mgolongan);
       $('.selection_one:checked').closest('tr').find('.pangkatTerlapor').val(Mpangkat);
       $('.selection_one:checked').closest('tr').find('.satkerTerlapor').val(Msatker);
       $('.selection_one:checked').val(Mnip);
       $('.selection_one:checked').attr('atrTerlapor2',tmp);

    }
   /*masukan ke table*/
   localStorage.removeItem("nip_terlapor");
   var checkValues = $('.selection_one').map(function()
                                {
                                    return $(this).val();
                                }).get();
    localStorage.setItem('nip_terlapor', JSON.stringify(checkValues));
    }else{ /*jika nip tidak ada maka masukan ini*/
           $('.selection_one:checked').closest('tr').find('.td_nama').html(Mnama_terlapor);
           $('.selection_one:checked').closest('tr').find('.td_jabatan').html(Mjabatan);
           $('.selection_one:checked').closest('tr').find('.td_satker').html(Msatker);
           $('.selection_one:checked').closest('tr').find('.td_pangkat').html(gabung_golPANGKAT);

           $('.selection_one:checked').closest('tr').find('.namaTerlapor').val(Mnama_terlapor);
           $('.selection_one:checked').closest('tr').find('.jabatanTerlapor').val(Mjabatan);
           $('.selection_one:checked').closest('tr').find('.golonganTerlapor').val(Mgolongan);
           $('.selection_one:checked').closest('tr').find('.pangkatTerlapor').val(Mpangkat);
           $('.selection_one:checked').closest('tr').find('.satkerTerlapor').val(Msatker);
           $('.selection_one:checked').attr('atrTerlapor2',tmp);
    }

  }else{/*jika button yang di rubah tambah maka apend data*/
    
    var json = JSON.parse(localStorage["nip_terlapor"]);
   if(Mnip!=''){
   if(jQuery.inArray(Mnip,json)==-1){/*jika tidak ada maka masukan data dan set localstorage*/
    $('#tbody_terlapor').append('<tr>'+
                      '<td style="text-align:center;"><input name="noTerlapor[]" class="noTerlapor" value="" type="hidden"></td>'+
                      '<td class="td_nama">'+Mnama_terlapor+'</td>'+
                      '<td class="td_pangkat">'+gabung_golPANGKAT+'</td>'+
                      '<td class="td_nip">'+gabung_nipNRP+'</td>'+
                      '<td class="td_jabatan">'+Mjabatan+'</td>'+
                      '<td class="td_satker">'+Msatker+'</td>'+
                      '<td class="ck_box" width="2%">'+
                      '<input name="namaTerlapor[]" class="namaTerlapor" value="'+Mnama_terlapor+'" type="hidden">'+
                      '<input name="pangkatTerlapor[]" class="pangkatTerlapor" value="'+Mpangkat+'" type="hidden">'+
                      '<input name="golonganTerlapor[]" class="golonganTerlapor" value="'+Mgolongan+'" type="hidden">'+
                      '<input name="nipTerlapor[]" class="nipTerlapor" value="'+Mnip+'" type="hidden">'+
                      '<input name="nrpTerlapor[]" class="nrpTerlapor" value="'+Mnrp+'" type="hidden">'+
                      '<input name="jabatanTerlapor[]" class="jabatanTerlapor" value="'+Mjabatan+'" type="hidden">'+
                      '<input name="satkerTerlapor[]" class="satkerTerlapor" value="'+Msatker+'" type="hidden">'+
                      '<input class="selection_one" type="checkbox" value="'+Mnip+'" name="ck_tr" rel="2" atrTerlapor="'+tmp+'"></td>'+
                  '</tr>');
  localStorage.removeItem("nip_terlapor");
    var checkValues = $('.selection_one').map(function()
                                {
                                    return ($(this).val()==''?'-':$(this).val());
                                }).get();
   
    localStorage.setItem('nip_terlapor', JSON.stringify(checkValues));
    // }
    }

    }else{/*jika tidak ada maka masukan data tanpa set localstorage*/
      $('#tbody_terlapor').append('<tr>'+
                      '<td style="text-align:center;"><input name="noTerlapor[]" class="noTerlapor" value="" type="hidden"></td>'+
                      '<td class="td_nama">'+Mnama_terlapor+'</td>'+
                      '<td class="td_pangkat">'+gabung_golPANGKAT+'</td>'+
                      '<td class="td_nip">'+gabung_nipNRP+'</td>'+
                      '<td class="td_jabatan">'+Mjabatan+'</td>'+
                      '<td class="td_satker">'+Msatker+'</td>'+
                      '<td class="ck_box" width="2%">'+
                      '<input name="namaTerlapor[]" class="namaTerlapor" value="'+Mnama_terlapor+'" type="hidden">'+
                      '<input name="pangkatTerlapor[]" class="pangkatTerlapor" value="'+Mpangkat+'" type="hidden">'+
                      '<input name="golonganTerlapor[]" class="golonganTerlapor" value="'+Mgolongan+'" type="hidden">'+
                      '<input name="nipTerlapor[]" class="nipTerlapor" value="'+Mnip+'" type="hidden">'+
                      '<input name="nrpTerlapor[]" class="nrpTerlapor" value="'+Mnrp+'" type="hidden">'+
                      '<input name="jabatanTerlapor[]" class="jabatanTerlapor" value="'+Mjabatan+'" type="hidden">'+
                      '<input name="satkerTerlapor[]" class="satkerTerlapor" value="'+Msatker+'" type="hidden">'+
                      '<input class="selection_one" type="checkbox" value="'+Mnip+'" name="ck_tr" rel="2" atrTerlapor="'+tmp+'"></td>'+
                  '</tr>');
    }


  }
   
   $('#TerlaporModalUbah').modal('hide');
    
  });

$(document).on('hidden.bs.modal','#TerlaporModalUbah', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

$(document).on('hidden.bs.modal','#penandatangan2', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

$(document).on('hidden.bs.modal','#PemeriksaModalTambah', function (e) {
  $(this)
    .find("input[name=cari_pemeriksa]")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});



  $(document).on('click','#ubah_terlapor',function(){
    $('#asal').val('ubah');
    $('.label-terlapor').html('Ubah Terlapor');
    $('.btn_pilih').html('Ubah');
    var data=JSON.parse($(".selection_one:checked").attr("rel"));
    var x =$(".selection_one:checked").attr("atrTerlapor2");
    // alert(data.nip);
    var pecah=x.split('#');
    //var tmp=Mnama_terlapor+'#'+Mjabatan+'#'+Msatker+'#'+Mnip+'#'+Mnrp+'#'+Mpangkat+'#'+Mgolongan;

  if(typeof data.nip=='undefined'){
    $('#Mnip').val();
    $('#Mnama_terlapor').val(pecah[0]);
    $('#Mjabatan').val(pecah[1]);
    $('#Mgolongan').val(pecah[6]);
    $('#Mpangkat').val(pecah[5]);
    $('#Msatker').val(pecah[2]);
  }else{
    // $('#Mnip').val(data.nip);
    // $('#Mnama_terlapor').val(data.nama_terlapor_awal);
    // $('#Mjabatan').val(data.jabatan_terlapor_awal);
    // $('#Mgolongan').val(data.golongan_terlapor_awal);
    // $('#Mpangkat').val(data.pangkat_terlapor_awal);
    // $('#Msatker').val(data.satker_terlapor_awal);
    $('#Mnip').val(pecah[3]);
    $('#Mnama_terlapor').val(pecah[0]);
    $('#Mjabatan').val(pecah[1]);
    $('#Mgolongan').val(pecah[6]);
    $('#Mpangkat').val(pecah[5]);
    $('#Msatker').val(pecah[2]);
  }
    // $('#TerlaporModalUbah').modal('show');
    $('#TerlaporModalUbah').modal({backdrop: 'static', keyboard: false});


  });

  /**/

  $(document).on('click','#Tambah_pemeriksa',function(){
    $('.Mselection_one').prop('checked',false);
    // $('#PemeriksaModalTambah').modal('show');
    $('#PemeriksaModalTambah').modal({backdrop: 'static', keyboard: false});
  });

  // $(document).on('click','#Tambah_pemeriksa',function(){
  //   $('#PemeriksaModalTambah').modal('show');
  // });

  $(document).on('click','#tambah_terlapor',function(){
    $('#asal').val('tambah');
    $('.label-terlapor').html('Tambah Terlapor');
    $('.btn_pilih').html('Tambah');
    // $('#TerlaporModalUbah').modal('show');
    $('#TerlaporModalUbah').modal({backdrop: 'static', keyboard: false});
  });

  
  $(document).on('click','#Mtambah_pemeriksa',function(){
    var jml=$(".Mselection_one:checked").length;
      var checkValues = $('.Mselection_one:checked').map(function()
                                {
                                    return $(this).attr("json");
                                }).get();
      var arrnip = $('.Mselection_one:checked').map(function()
                                {
                                    return $(this).val();
                                }).get();
       var cek_onDB = JSON.parse(localStorage.getItem("nip_pemeriksa_onDB"));
       for (var i = 0; i < jml; i++) {
        var trans=JSON.parse(checkValues[i]);

      var cek = JSON.parse(localStorage.getItem("nip_pemeriksa"));

      if(jQuery.inArray(trans.peg_nip_baru,cek)==-1 && jQuery.inArray(trans.peg_nip_baru,cek_onDB)==-1){/*jika kondisi tidak sama maka tambahkan data*/
        $('.bd_pemeriksa_tmp').append('<tr>'+
          '<td><input type="hidden" name="nrp[]" class="nrp" value="'+trans.peg_nrp+'"></td>'+
          '<td><input type="hidden" name="nip[]" class="nip" value="'+trans.peg_nip_baru+'">'+trans.peg_nip_baru+'</td>'+
          '<td><input type="hidden" name="nama_pemeriksa[]" class="nama_pemeriksa" value="'+trans.nama+'">'+trans.nama+'</td>'+
          '<td><input type="hidden" name="jabatan[]" class="jabatan" value="'+trans.jabatan+'">'+trans.jabatan+'</td>'+
          '<td><input type="hidden" name="golongan[]" class="golongan" value="'+trans.gol_kd+'"><input type="hidden" name="pangkat[]" class="pangkat" value="'+trans.gol_pangkat2+'">'+trans.gol_pangkat2+'</td>'+
          '<td></td>'+
        '</tr>');
      }
       }

       var names = arrnip;
      localStorage.setItem("nip_pemeriksa", JSON.stringify(names));
      $('#PemeriksaModalTambah').modal('hide');
  });

$("#hapus_terlapor").addClass("disabled");
$("#ubah_terlapor").addClass("disabled");


$(document).on('click','.MTpilih_terlapor',function() {
  var data=JSON.parse($(this).attr('json'));
   $('#Mnip').val(data.peg_nip_baru);
   $('#Mnrp').val(data.peg_nrp);
   $('#Mnama_terlapor').val(data.nama);
   $('#Mjabatan').val(data.jabatan);
   $('#Mgolongan').val(data.gol_pangkat2);
   $('#Mpangkat').val(data.gol_kd);
   $('#Msatker').val(data.instansi);
});

$(document).on('click','#hapus_terlapor',function() {
  $(".selection_one:checked").closest('tr').remove();
});


$(document).on('change','#select_all',function() {
    var c = this.checked ? true : false;
    $('.selection_one').prop('checked',c);
    var x=$('.selection_one:checked').length;
    ConditionOfButtonTr(x);
});
    
$(document).on('change','.selection_one',function() {
    var c = this.checked ? '#f00' : '#09f';
    var x=$('.selection_one:checked').length;
    ConditionOfButtonTr(x);
});


function ConditionOfButtonTr(n){
        if(n == 1){
           $('#ubah_terlapor, #hapus_terlapor').removeClass('disabled');
        } else if(n > 1){
           $('#hapus_terlapor').removeClass('disabled');
           $('#ubah_terlapor').addClass('disabled');
        } else{
           $('#ubah_terlapor, #hapus_terlapor').addClass('disabled');
        }
}

/*pemeriksa*/

$(document).on('click','#hapus_pemeriksa',function() {
  $(".hapus_one_pemeriksa:checked").closest('tr').remove();
});


$(document).on('change','#hapus_all_pemeriksa',function() {
    var c = this.checked ? true : false;
    $('.hapus_one_pemeriksa').prop('checked',c);
    var x=$('.hapus_one_pemeriksa:checked').length;
    ConditionOfButtonTr(x);
});
    
$(document).on('change','.hapus_one_pemeriksa',function() {
    var c = this.checked ? '#f00' : '#09f';
    var x=$('.hapus_one_pemeriksa:checked').length;
    ConditionOfButtonTr(x);
});

// $('#hapus_pemeriksa').addClass('disabled');
// $(document).on('change','#hapus_all_pemeriksa',function() {
//     var c = this.checked ? true : false;
//     $('.hapus_one_pemeriksa').prop('checked',c);
//     var x=$('.hapus_one_pemeriksa:checked').length;
//     ConditionOfButton(x);
// });
    
// $(document).on('change','.hapus_one_pemeriksa',function() {
//     var c = this.checked ? '#f00' : '#09f';
//     var x=$('.hapus_one_pemeriksa:checked').length;
//     ConditionOfButton(x);
// });


function ConditionOfButton(n){
        if(n == 1){
           $('#hapus_pemeriksa').removeClass('disabled');
        } else if(n > 1){
           $('#hapus_pemeriksa').removeClass('disabled');
        } else{
           $('#hapus_pemeriksa').addClass('disabled');
        }
}

$(document).on('click','#tambah_dasar',function() {
        $('.for_dasar_surat').append('<div class=\"tampungan\"><div class=\"col-sm-11\" style=\"margin-top:10px;padding: 0px\"><textarea class=\"form-control\" name=\"isi_dasar_sp_was_1[]\"></textarea></div><div class=\"col-sm-1 hapus\" style=\"margin-top:10px;width:59px;padding:0px\"><a  rel=\"\" class=\"btn btn-primary btn-sm pull-right hapus_dasar\" class=\"hapus_dasar\"><i class=\"glyphicon glyphicon-trash\"></i></a></div></div>');

        i = 0;
        $('.for_dasar_surat').find('.tampungan').each(function () {

        i++;
        $(this).find('a').attr('rel', i);
        });
    });

$(document).on('click','.hapus_dasar',function() {
    var x=$(this).attr('rel');
    $(this).closest('.tampungan').remove();
    });

$(document).on('click','#addtembusan',function() {
    $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\" style=\"text-align: center\"><input type=\"checkbox\" value=\"0\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" class=\"no_urut\" readonly></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
        i = 0;
    $('.for_tembusan').find('.col-sm-7').each(function () {

        i++;
        $(this).addClass('tembusan'+i);
        $(this).find('.cekbok').val(i);
    });
    });

$(document).on('click','#hapus_tembusan',function() {
     // $('#hapus_tembusan').click(function(){
        var cek = $('.cekbok:checked').length;
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
                for (var i = 0; i < cek; i++) {
                    $('.tembusan'+checkValues[i]).remove();
                };
                                
    });
$(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one_tandatangan:checked").attr("json"));
       $('#spwas1-nip_penandatangan').val(data.nip);
       $('#spwas1-nama_penandatangan').val(data.nama);
       $('#spwas1-jabatan_penandatangan').val(data.nama_jabatan);
       $('#penandatangan').modal('hide');
                                
    });
}

/*////////////reload grid penandatangan surat/////////////////*/
     $(document).on('click','.cari_ttd',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/sp-was-1/getttd",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
        $('#grid-penandatangan_surat').addClass('loading');
      }).on('pjax:success', function(){
        $('#grid-penandatangan_surat').removeClass('loading');
      });


      /*////////////reload grid Pemeeriksa surat/////////////////*/
     $(document).on('click','.cari_riksa',function() { 
      $('#grid-pemeriksa_surat').addClass('loading');
        $("#grid-pemeriksa_surat").load("/pengawasan/sp-was-1/getpemeriksa",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-pemeriksa_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mpemeriksa-grid").on('pjax:send', function(){
        $('#grid-pemeriksa_surat').addClass('loading');
      }).on('pjax:success', function(){
        $('#grid-pemeriksa_surat').removeClass('loading');
      });  

     /*////////////reload grid Terlapor surat/////////////////*/
     $(document).on('click','.cari_terlapor',function() { 
      $('#grid-terlapor_surat').addClass('loading');
        $("#grid-terlapor_surat").load("/pengawasan/sp-was-1/getterlapor",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-terlapor_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mterlapor-ubah-grid").on('pjax:send', function(){
        $('#grid-terlapor_surat').addClass('loading');
      }).on('pjax:success', function(){
        $('#grid-terlapor_surat').removeClass('loading');
      }); 
  
</script>   

