<?php

use yii\helpers\Html;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmBerkasTahap1Seacrh;
// use app\modules\pdsold\models\PdmP16;
use kartik\datecontrol\DateControl;
use kartik\typeahead\TypeaheadAsset;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\PdmUuPasalTahap1;
use app\modules\pdsold\models\MsInstPelakPenyidikan;
use app\modules\pdsold\models\PdmP16;
use kartik\grid\GridView;
use yii\web\Session;
use app\modules\pdsold\models\MsJenisPidana;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkasTahap1 */
/* @var $form yii\widgets\ActiveForm */
?>

  <?php $form = ActiveForm::begin([            
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [        
                'labelSpan' => 1,
                'showLabels' => false
            ],
  ]); ?>

  

<div class="pdm-berkas-tahap1-form">
<div class="box box-primary"  style="border-color: #f39c12;">
    <div class="box-header"></div>
	
	 <div class="col-md-12" style="padding:0">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Instansi Penyidik</label>

                    <div class="col-md-8">
                        <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
            <input type='hidden' name='PdmBerkasTahap1[id_berkas]' value="<?php echo $model['id_berkas']; ?>" />
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:35%;">Instansi Pelaksana Penyidikan</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" value="<?= MsInstPelakPenyidikan::findOne(['kode_ip'=>$modelSpdp->id_asalsurat,'kode_ipp'=>$modelSpdp->id_penyidik])->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
        </div>

        <div class="clearfix" style="margin-bottom:14px;"></div>
	
	           <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor Berkas</label>

                   <div class="col-md-8">
             <?= $form->field($model, 'no_berkas')->input('text',['onkeyup'  =>'
                                        var number =  /^[A-Za-z0-9-/]+$/+.;
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
                                        ']) ?>
            </div>
				</div>
					</div>
			 <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:35%;">Tanggal Berkas</label>

                    <div class="col-md-9"  style="width:21%;">
                                 <?php                                   
                                  $trim1   = date('Y-m-d',strtotime("+1 days",strtotime($modelSpdp->tgl_terima)));
								  $trim         = explode('-',$trim1);
                                  $tgl_spdp = $trim[2].'-'.$trim[1].'-'.$trim[0];
								  $trim_end     = explode('-',date('Y-m-d', strtotime("+1 days")));
                                  $tgl_spdp_end = $trim_end[2].'-'.$trim_end[1].'-'.$trim_end[0];
                                  ?>
                                <?=
                                    $form->field($model, 'tgl_berkas')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                /*'startDate'=>  $tgl_spdp,
												'endDate'=>  date('d-m-Y'),*/
                                               
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-12" style="padding:0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nomor P-16</label>

                                <div class="col-md-8">
                                    <?php
                                    $id = Yii::$app->session->get('id_perkara');
                                        echo $form->field($model, 'id_p16')->dropDownList(
                                                ArrayHelper::map(PdmP16::find()
                                                ->where(['id_perkara' => $id])
                                                ->all(), 'id_p16', 'no_surat'), // Flat array ('id'=>'label')
                                                ['id' => 'IdP16']    // options
                                        );?>
                                </div>

                            </div>
                        </div>
                        

                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label col-md-3" style="width:35%;">Tanggal P-16</label>
                    <div class="col-md-9"  style="width:21%;">
                    <?php $wew=PdmP16::findOne(['id_perkara'=>Yii::$app->session->get('id_perkara')])->tgl_dikeluarkan ?>
                                 <input class="form-control" id="tgl_p16" value="<?php $date=date_create($wew); echo date_format($date, "d-m-Y"); ?>" readOnly="true">
                    <?php ;?>
                            </div>
                        </div>    
                    </div>
                </div>


                    <div class="clearfix" style="margin-bottom:14px;"></div>
				</div>
            
   <!--  <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
    <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tambah P-16</label>
                    <div class="col-md-8">
                        <?php
                         $session = new Session();
                        $id_perkara = $session->get('id_perkara');
                        echo $form->field($model, 'id_p16')->dropDownList(
                                ArrayHelper::map(PdmP16::find()->where(['id_perkara'=>$id_perkara])->all(), 'id_p16', 'no_surat') // Flat array ('id'=>'label')
//                                ['id' => 'InstansiPenyidik']    // options
                        );?>
                    </div> 
                </div>
            </div>
        </div> -->
    
    
    
    
<?php if(!$model->isNewRecord){ ?>
    <div id="tambah" class="col-md-11" >
        <a class='btn btn-success tambah'>Tambah</a>
    </div>
    
        
    
    <div id="divHapus">
        <a class='btn btn-warning hapusPengantar' >Hapus</a>
    </div>
    <div class="clearfix" style="margin-bottom:14px;">
    </div>
    <table id="table_pengantar" class="table table-bordered table-striped">
        <thead>
            <tr>               
                <th>Nomor Pengantar</th>
                <th>Tanggal Pengantar</th>
                <th>Tanggal Terima</th>
                <th>Nama Tersangka</th>
                <th>Undang-Undang</th>
                <th style="text-align:center;" width="45px">#</th>
            </tr>
        </thead>
        <tbody id="tbody_pengantar">
            <?php if (!$model->isNewRecord):?>
            <?php $index_pengantar = 0;foreach ($modelPengantar as $key => $value): ?>
            <tr data-db="<?= $value['id_pengantar']?>" data-tglpengantar="<?php echo date('d-m-Y',strtotime($value['tgl_pengantar']))?>" id='tr_id<?= $value['id_pengantar']?>' ondblclick="edit_pengantar('<?= $value['id_pengantar']?>')" data-id="<?=  $value['id_pengantar']?>">
                <td>
                    <input type="text" name="no_pengantar[]" class="form-control hide" value="<?= $value->no_pengantar ?>">
                    <a  onclick="edit_pengantar('<?= $value['id_pengantar']?>')"  ><?= $value->no_pengantar ?></a></td>
                <td>
                    <?= date('d-m-Y',strtotime($value->tgl_pengantar)) ?>
                    <input type="hidden" name="PengantarDb[no_pengantar][]" class="form-control pengantar<?php echo $value['id_pengantar'] ?> hide" readonly="true" value="<?= $value['no_pengantar'] ?>">
                    <input type="text" name="tgl_pengantar[]" class="form-control hide" readonly="true" value="<?= date('d-m-Y',strtotime($value->tgl_pengantar)) ?>">
                </td>
                <td>
                    <input type="text" name="tgl_terima[]" class="form-control hide" readonly="true" value="<?= date('d-m-Y',strtotime($value->tgl_terima)) ?>"><?= date('d-m-Y',strtotime($value->tgl_terima)) ?>
                </td>
                <td>
                    <ol style="margin-left:0px;padding-left:0px">
                    <?php $modelTersangka = MsTersangkaBerkas::find()
                    ->where(['id_berkas'=>$value->id_berkas,'no_pengantar'=>$value->no_pengantar])
                    ->orderBy('no_urut')
                    ->all();
                    $no = 1; foreach ($modelTersangka as $key2 => $value2): ?>
                        <li style="list-style-type: none" id="<?= $value2->id_tersangka?>">
                        <?= $value2->no_urut.'. '.$value2->nama ?>
                            <div class="hide">
                                <input type="hidden" name="MsTersangkaDb[nama][]" value="<?= $value2->nama ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_tersangka][]" value="<?= $value2->id_tersangka?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_tersangka][]" value="<?= $value2->id_tersangka?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[tmpt_lahir][]" value="<?= $value2->tmpt_lahir ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[tgl_lahir][]" value="<?= date('d-m-Y',strtotime($value2->tgl_lahir)) ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[umur][]" value="<?= $value2->umur ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_jkl][]" value="<?= $value2->id_jkl ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[alamat][]" value="<?= $value2->alamat ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_identitas][]" value="<?= $value2->id_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[no_identitas][]" value="<?= $value2->no_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[no_hp][]" value="<?= $value2->no_hp ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_agama][]" value="<?= $value2->id_agama ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[warganegara][]" attr-id="Indonesia" value="<?= $value2->warganegara ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[pekerjaan][]" value="<?= $value2->pekerjaan ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[suku][]" value="<?= $value2->suku ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[id_pendidikan][]" value="<?= $value2->id_pendidikan ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[unix][]" value="<?= $value2->id_tersangka?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                                <input type="hidden" name="MsTersangkaDb[no_urut][]" value="<?= $value2->no_urut ?>" class="form-control tersangka<?= $value2->id_tersangka?>">
                            </div>
                        </li>
                    <?php endforeach ?>
                    </ol>
                    <div id="saveUndang<?= $value['id_pengantar'] ?>" class="hide">
                        <div class="body-undang-undang ">
                        <?php 
                        $modelUU1 = PdmUuPasalTahap1::find()->where(['id_pengantar' => $value->id_pengantar])->orderBy(['id_pasal'=>'SORT_ASC'])->All();
                        foreach ($modelUU1 as $key4 => $value4){?>
                            <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
                                <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
                                    <div class="form-group">                                                    
                                        <div class="col-md-12 " style="padding-right:0px">
                                            <div class="form-group field-mspedoman-uu">
                                                <div class="col-sm-11">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2" >Undang Undang</label>
                                                        <div class="input-group col-md-10" >
                                                            <input type="hidden" name="MsUndangDb[id_pasal][]" value="<?= $value4->id_pasal ?>">
                                                            <input type="text" readOnly  placeholder="Undang-Undang" value="<?= $value4->undang ?> " class="form-control undang-undang" name="MsUndangDb[undang][]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning pilih-undang" href="/pdsold/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2" >Pasal</label>
                                                        <div class="input-group col-md-10" >
                                                            <input type="text" readOnly  placeholder="Pasal Undang-Undang" value="<?= $value4->pasal ?> " class="form-control pasal-undang-undang" name="MsUndangDb[pasal][]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-2" >Dakwaan</label>
                                                        <div class="input-group col-md-4">
                                                            <select name="MsUndangDb[dakwaan][]" class="form-control select-dakwaan">
                                                                <option <?= ($value4->dakwaan ==0)?"selected='selected'":''; ?> value="0">-- Pilih --</option>
                                                                <option <?= ($value4->dakwaan ==1)?"selected='selected'":''; ?> value="1">-- Juncto --</option>
                                                                <option <?= ($value4->dakwaan ==2)?"selected='selected'":''; ?> value="2">-- Dan --</option>
                                                                <option <?= ($value4->dakwaan ==3)?"selected='selected'":''; ?> value="3">-- Atau --</option>
                                                                <option <?= ($value4->dakwaan ==4)?"selected='selected'":''; ?> value="4">-- Subsider --</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <?php if( $key4!=0) :?>
                                            <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                                <i class="fa fa-trash-o"></i> Hapus
                                            </a> 
                                            <?php  endif;?>
                                        </div>
                                            <!-- EDIT Undang-undang -->
                                    </div>                             
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </td>
                <td>
                <?=$array_uu[$index_pengantar];?>
                </td>
                <td style="text-align:center;" id="tdPengantar"><input type='checkbox' name='noPengantar[]' data-c-db='1' class='hapusPengantar' id='hapusPengantar' value="<?= $value['id_pengantar'] ?>">
                </td>
            </tr>
            <?php $index_pengantar++;endforeach; ?>
            <?php endif; ?>
            <?php  if ($model->isNewRecord): ?>
            <tr>
                <td colspan="6" ></td> 
            </tr>
            <?php endif;  ?>
        </tbody>
    </table>	
<?php } ?>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;"> 
        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-berkas-tahap1/index'], ['class' => 'btn btn-danger']) ?>
       
    </div>
        <div id="hiddenId"></div>
		<div id='trHpsTersangka'>      
        </div>
</div>



<?php ActiveForm::end(); ?>

<?php
$tgl_server = date('Y-m-d');
        $js = <<< JS
               
                
            $('.tambah').click(function(){
                var href = $(this).attr('href');
                if ($('#pdmberkastahap1-no_berkas').val() == '')
                {
                    bootbox.dialog({
                        message: "Silahkan masukan nomor berkas terlebih dahulu",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",

                            }
                        }
                    });
                }else if ($('#pdmberkastahap1-tgl_berkas').val() == '')
                {
                    bootbox.dialog({
                        message: "Silahkan masukan tanggal berkas terlebih dahulu",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",

                            }
                        }
                    });
                }
                else{
                    var href = $(this).attr('href');
                    if(href != null){
                            var id_pengantar = href.substring(1, href.length);
                    }else{
                            var id_pengantar = '';
                    }
                }
                var urli = window.location.href ;
                lastSegment = urli.split('/').pop();
                var id1   = lastSegment.split('=').pop();    
                var idnya = id1+"|0";
                var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/show-pengantar-simpan?idPengantar="+idnya;
                $(location).attr('href',url);
            });
                
                
        $('td').dblclick(function (e) {
            var id = $(this).closest('tr').data('id');
            var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar="+id;
            $(location).attr('href',url);
        });
                
                
                
        $("a.hapusPengantar").click(function()
        {
            bootbox.dialog({
                    message: "Data yang anda masukan belum lengkap",
                    buttons:{
                        ya : {
                            label: "Ya",
                            className: "btn-warning",
                            callback: function(){
                                $.each($('input.hapusPengantar'),function(x)
                                    {
                                        var input = $(this);
                                        if(input.prop('checked')==true)
                                        {   var id  = input.parent().parent();
                                            var cDb = $(this).attr('data-c-db');
                                           
                                            id.remove();
                                            if(cDb ==1)
                                            {
                                              $('#hiddenId').append(
                                                '<input type="hidden" name="hapuspengantar[]" value='+input.val()+'>'
                                                );
                                            }
                                        }
                                    }
                                 );
                                 }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning"
                            }
                        }
                    });
             

        });
        $('#pengantar').on('show.bs.modal', function () {   
            $("body").css('overflow-y','hidden');
        });
        $('#m_tersangka').on('show.bs.modal', function () {
            $("#m_tersangka").css('overflow','scroll');
            $("#pengantar").css('overflow-y','hidden');
            alert('hallo');            
        });
	
    $("#IdP16").change(function(){
        var id_perkara = $('#IdP16').val();
        console.log(id_perkara);
        $.ajax({
            type: "POST",
            url: '/pdsold/pdm-berkas-tahap1/tanggal',
            data: 'id_p16='+id_perkara,
            success:function(data){
                console.log(data);
                $('#tgl_p16').val(data);
                
            }
        });
    });

	$('.tambah').click(function(){
		var href = $(this).attr('href');		
        if ($('#pdmberkastahap1-no_berkas').val() == '')
        {
            bootbox.dialog({
                message: "Silahkan masukan nomor berkas terlebih dahulu",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
        else if ($('#pdmberkastahap1-tgl_berkas').val() == '')
        {
            bootbox.dialog({
                message: "Silahkan masukan tanggal berkas terlebih dahulu",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }else{
            var href = $(this).attr('href');
		if(href != null){
			var id_pengantar = href.substring(1, href.length);
		}else{
			var id_pengantar = '';
		}
                
        var urli = window.location.href ;
        lastSegment = urli.split('/').pop();
        var id1   = lastSegment.split('=').pop();    
        var idnya = id1+"|0";
//                alert(idnya);
                
                
                
//        $('#pengantar').html('');
//        $('#pengantar').load('/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+idnya);
//        $('#pengantar').modal('show');
                
                
//        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+idnya;
                
                
                
        // if(lastSegment!='create')
        // {
           
        //             var id = $('#tbody_pengantar tr').eq(0).attr('id').replace('tr_id','');
        //             var data_db                       = $('tbody#tbody_pengantar #tr_id'+id).attr('data-db');
        //             localStorage.no_pengantar         = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(1) input:eq(0)').val();
        //                 localStorage.tgl_pengantar          = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(1) input:eq(1)').val();
        //             localStorage.tgl_terima             = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(2) input:eq(0)').val();
        //             localStorage.tr_pengantar         = id;
        //            localStorage.data_flag_new_save   = 1;
        //             isi_table    = null;
        //             $('tbody#tbody_pengantar #tr_id'+id+' td:eq(3) ').find('li').each(function(x){
                      
        //                currentValue =  $(this).attr('id');

        //                nama         =  $(this).find('input:eq(0)').val();
        //                html         =  $(this).find('div.hide').html();

               
        //                 isi_table += '<tr id="tr_id'+currentValue+'">'+                
        //                     '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
        //                     '<td>' +
        //                         '<a href="javascript:void(0);" onclick="edit_tersangka('+"'"+currentValue+"'"+')">'+nama+'</a>'+
        //                         html+
        //                         '</td>' +
        //                     '<td>' +
        //                        $(this).find('input:eq(3)').val()  +','+ $(this).find('input:eq(4)').val() +
        //                     '</td>' +
        //                     '<td>' +
        //                        $(this).find('input:eq(5)').val() +' Tahun'+
        //                     '</td>' +
        //                 '</tr>';
        //             });
        //             localStorage.table_tersangka = isi_table.replace('null','');
        //             var href = $(this).attr('href');
        //             if(href != null){
        //                 var id_pengantar = href.substring(1, href.length);
        //             }else{
        //                 var id_pengantar = '';
        //             }
              
        // }
        // else
        // {
        //     if($('#tbody_pengantar tr').length>1)
        //     {
        //         var id = $('#tbody_pengantar tr').eq(1).attr('id').replace('tr_id','');
        //             var data_db                       = $('tbody#tbody_pengantar #tr_id'+id).attr('data-db');
        //             localStorage.no_pengantar         = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(1) input:eq(0)').val();
        //                 localStorage.tgl_pengantar          = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(1) input:eq(1)').val();
        //             localStorage.tgl_terima             = $('tbody#tbody_pengantar #tr_id'+id+' td:eq(2) input:eq(0)').val();
        //             localStorage.tr_pengantar         = id;
                    
        //             localStorage.data_flag_new_save   = 1;
        //             isi_table    = null;

        //            // $('body').append(localStorage.content_undang);
        //             $('tbody#tbody_pengantar #tr_id'+id+' td:eq(3) ').find('li').each(function(x){
                      
        //                currentValue =  $(this).attr('id');

        //                nama         =  $(this).find('input:eq(0)').val();
        //                html         =  $(this).find('div.hide').html();

               
        //                 isi_table += '<tr id="tr_id'+currentValue+'">'+                
        //                     '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
        //                     '<td>' +
        //                         '<a href="javascript:void(0);" onclick="edit_tersangka('+"'"+currentValue+"'"+')">'+nama+'</a>'+
        //                         html+
        //                         '</td>' +
        //                     '<td>' +
        //                        $(this).find('input:eq(3)').val()  +','+ $(this).find('input:eq(4)').val() +
        //                     '</td>' +
        //                     '<td>' +
        //                        $(this).find('input:eq(5)').val() +' Tahun'+
        //                     '</td>' +
        //                 '</tr>';
        //             });
        //             localStorage.table_tersangka = isi_table.replace('null','');
        //             //localStorage.content_undang = undang_html ;
        //             var href = $(this).attr('href');
        //             if(href != null){
        //                 var id_pengantar = href.substring(1, href.length);
        //             }else{
        //                 var id_pengantar = '';
        //             }
        //     }
        // }
                
//                alert("show nya "+id_pengantar);
//                var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+id_pengantar;
//                    $(location).attr('href',url);
//                });
//		$('#pengantar').html('');
//		$('#pengantar').load('/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+id_pengantar);
//		$('#pengantar').modal('show');

            }
        });

//         var id_pengantar = '';
//                var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+id_pengantar;
//                    $(location).attr('href',url);
//                });
                
                
//        $('#pengantar').html('');
//        $('#pengantar').load('/pdsold/pdm-berkas-tahap1/show-pengantar?idPengantar='+id_pengantar);
//        $('#pengantar').modal('show');


var date        = '$modelSpdp->tgl_surat';
var end         = '$tgl_server';
var someDate    = new Date(date);
var endDate     = new Date(end);
//someDate.setDate(someDate.getDate()+7);
someDate.setDate(someDate.getDate()+1);
endDate.setDate(endDate.getDate());
var dateFormated        = someDate.toISOString().substr(0,10);
var enddateFormated     = endDate.toISOString().substr(0,10);
var resultDate          = dateFormated.split('-');
var endresultDate       = enddateFormated.split('-');
finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
var input               = $('.field-pdmberkastahap1-tgl_berkas').html();
var datecontrol         = $('#pdmberkastahap1-tgl_berkas-disp').attr('data-krajee-datecontrol');
$('.field-pdmberkastahap1-tgl_berkas').html(input);
var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
var datecontrol_001 = {'idSave':'pdmberkastahap1-tgl_berkas','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
  $('#pdmberkastahap1-tgl_berkas-disp').kvDatepicker(kvDatepicker_001);
  $('#pdmberkastahap1-tgl_berkas-disp').datecontrol(datecontrol_001);
  $('.field-pdmberkastahap1-tgl_berkas').removeClass('.has-error');
  

	
JS;

$this->registerJs($js);
Modal::begin([
    'id' => 'pengantar',
    'header' => '<h7>Pengantar Tahap 1</h7>'
]);
Modal::end();
        ?>
<script>
    function hapusPengantar(id)
    {
        //$("#tr_id"+id).remove();
        var arr = [id];
        jQuery.each(arr, function( i, val ) {
                    console.log(val);
                });
        //console.log(id);
    }
    function hapusPengantarOld(id, value)
    {
        $("#tr_id_old"+id).remove();
        $('#hiddenId').append(
            '<input type="hidden" name="id_pengantar_remove[]" value='+value+'>'
        )
    }
</script>