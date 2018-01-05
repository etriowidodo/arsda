<?php

namespace app\components;

use app\models\KpInstSatker;
use app\models\KpPegawai;
use app\models\MsSifatSurat;
use app\modules\security\models\ConfigSatker;
use app\modules\pidum\models\PdmB4;
use app\modules\pidum\models\PdmP16a;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
use app\modules\pidum\models\PdmRb2;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\MsTersangkaBerkas;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\MsJenisPerkara;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmTembusanP16;
use app\modules\pidum\models\PdmTembusanP16a;
use app\modules\pidum\models\PdmPengantarTahap1;
use app\modules\pidum\models\PdmTembusanP17;
use app\modules\pidum\models\PdmTembusanP18;
use app\modules\pidum\models\PdmTembusanP19;
use app\modules\pidum\models\PdmTembusanP21;
use app\modules\pidum\models\PdmTembusanP20;
use app\modules\pidum\models\PdmTembusanP21a;
use app\modules\pidum\models\PdmTembusanP22;
use app\modules\pidum\models\PdmTembusanP23;
use app\modules\pidum\models\PdmTembusanP31;
use app\modules\pidum\models\PdmTembusanP27;
use app\modules\pidum\models\PdmTembusanT6;
use app\modules\pidum\models\PdmTembusanP36;
use app\modules\pidum\models\PdmTembusanP40;
use app\modules\pidum\models\PdmTembusanRendak;
use app\modules\pidum\models\PdmTembusanPengembalian;
use app\modules\pidum\models\PdmTembusanPengembalianBerkas;
use app\modules\pidum\models\PdmTembusanPratutLimpah;
use app\modules\pidum\models\PdmTembusanT4;
use app\modules\pidum\models\PdmTembusanT5;
use app\modules\pidum\models\PdmTembusanT7;
use app\modules\pidum\models\PdmTembusanT8;
use app\modules\pidum\models\PdmTembusanT12;
use app\modules\pidum\models\PdmTembusanP39;
use app\modules\pidum\models\PdmTembusanP41;
use app\modules\pidum\models\PdmTembusanP43;
use app\modules\pidum\models\PdmTembusanP47;
use app\modules\pidum\models\PdmTembusanP48;
use app\modules\pidum\models\PdmTembusanT11;
use app\modules\pidum\models\PdmTembusanT14;
use app\modules\pidum\models\PdmTembusanBa17;
use app\modules\pidum\models\PdmTembusanB19;
use app\modules\pidum\models\PdmTembusanP49;
use app\modules\pidum\models\PdmTembusanNarkotika;
use app\modules\pidum\models\PdmStatusSurat;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\PdmBarbukTambahan;
use app\modules\pidum\models\PdmTemplateTembusan;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use app\modules\pidum\models\PdmTembusanP45Upayahukum;
use app\modules\datun\models\MsWilayah;
use app\modules\pidum\models\PdmBa5Barbuk;
use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\PdmT7;
use Yii;
use yii\db\Command;
use yii\db\Query;
use yii\web\Session;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use Nasution\Terbilang;

class GlobalFuncComponent extends Widget
{

    public $peg_nip;

    public function init()
    {
        parent::init();
        $this->peg_nip = Yii::$app->user->identity->peg_nip;
    }

    public function getSatker()
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        if ($modelSpdp) {
            $satker_tujuan = $modelSpdp->id_satker_tujuan;
            if (!empty($satker_tujuan)) {
                $satker = KpInstSatker::find()
                    ->where(['inst_satkerkd' => $satker_tujuan])
                    ->one();
				
                return $satker;
            } else {
                $satker = KpPegawai::find()
                    ->with('satker')
                    ->where(['peg_nip' => $this->peg_nip])
                    ->orWhere(['peg_nip_baru' => $this->peg_nip])
                    ->one();
				
                return $satker->satker;
            }
        } else {
            $satker = KpPegawai::find()
                ->with('satker')
                ->where(['peg_nip' => $this->peg_nip])
                ->orWhere(['peg_nip_baru' => $this->peg_nip])
                ->one();
			
            return $satker->satker;
        }
    }

    public function getNamaSatker($kd_satker)
    {
        $satker = KpInstSatker::findOne(['inst_satkerkd' => $kd_satker]);

        return $satker;
    }

    public function getTembusan($form, $kd_berkas, $thisForm, $id_table, $id_perkara){
		
		if($kd_berkas=='P-16'){
			$modelTembusan = PdmTembusanP16::find()
            ->where(['id_p16' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
                
            if($kd_berkas=='P-16A'){
			$modelTembusan = PdmTembusanP16a::find()
            ->where(['no_surat_p16a' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
                
            if($kd_berkas=='P-43'){
			$modelTembusan = PdmTembusanP43::find()
            ->where(['no_surat_p43' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}

            if($kd_berkas=='P-45-1'){
            $modelTembusan = PdmTembusanP45Upayahukum::find()
            ->where(['no_surat_p45' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
                
        if($kd_berkas=='T-6'){
            $modelTembusan = PdmTembusanT6::find()
            ->where(['no_surat_t6' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='BA-17'){
            $modelTembusan = PdmTembusanBa17::find()
            ->where(['no_surat_ba17' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='B-19'){
            $modelTembusan = PdmTembusanB19::find()
            ->where(['no_surat_b19' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='P-49'){
            $modelTembusan = PdmTembusanP49::find()
            ->where(['no_surat_p49' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='P-36'){
            $modelTembusan = PdmTembusanP36::find()
            ->where(['no_surat_p36' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='P-39'){
            $modelTembusan = PdmTembusanP39::find()
            ->where(['no_surat_p39' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

        if($kd_berkas=='P-41'){
            $modelTembusan = PdmTembusanP41::find()
            ->where(['no_surat_p41' => $id_table])
            ->orderBy('no_urut asc')
            ->all();

            //echo '<pre>';print_r($modelTembusan);exit;
        }

        if($kd_berkas=='P-43'){
            $modelTembusan = PdmTembusanP43::find()
            ->where(['no_surat_p43' => $id_table])
            ->orderBy('no_urut asc')
            ->all();

            //echo '<pre>';print_r($modelTembusan);exit;
        }

        
        if($kd_berkas=='T-11'){
            $modelTembusan = PdmTembusanT11::find()
            ->where(['no_surat_t11' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
        
        if($kd_berkas=='P-27'){
            $modelTembusan = PdmTembusanP27::find()
            ->where(['no_surat_p27' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }
		
		if($kd_berkas=='RencanaDakwaan'){
			$modelTembusan = PdmTembusanRendak::find()
            ->where(['id_rendak' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='PengembalianSPDP'){
			$modelTembusan = PdmTembusanPengembalian::find()
            ->where(['id_pengembalian' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='PengembalianBerk'){
			$modelTembusan = PdmTembusanPengembalianBerkas::find()
            ->where(['id_pengembalian' => trim($id_table)])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='LimpahBerkas'){
			$modelTembusan = PdmTembusanPratutLimpah::find()
            ->where(['id_pratut_limpah' => trim($id_table)])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='PenetapanBarbuk'){
			$modelTembusan = PdmTembusanNarkotika::find()
            ->where(['id_sita' => trim($id_table)])
            ->orderBy('no_urut asc')
            ->all();
			
		}
		
		if($kd_berkas=='P-17'){
			$modelTembusan = PdmTembusanP17::find()
            ->where(['id_p17' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}

        
		
		if($kd_berkas=='T-4'){
			$modelTembusan = PdmTembusanT4::find()
            ->where(['id_t4' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}

        if($kd_berkas=='T-5'){
            $modelTembusan = PdmTembusanT5::find()
            ->where(['id_t5' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

        if($kd_berkas=='T-7' && $id_table <> NULL){
            $session = new Session();
            $no_register_perkara = $session->get('no_register_perkara');
            $modelTembusan = PdmTembusanT7::find()
            ->where(['no_register_perkara' =>$no_register_perkara ,'no_surat_t7'=>$id_table])
            ->orderBy('no_urut asc')
            ->all();
            // print_r($modelTembusan);exit;
            //echo '<pre>';print_r($modelTembusan);exit;
        }
        
        if($kd_berkas=='T-8'){
            $session = new Session();
            $no_register_perkara = $session->get('no_register_perkara');
            $modelTembusan = PdmTembusanT8::find()
            ->where(['no_register_perkara' =>$no_register_perkara ,'no_surat_t8'=>$id_table])
            ->orderBy('no_urut asc')
            ->all();
            // print_r($modelTembusan);exit;
        }
		
        if($kd_berkas=='T-12'){
            $modelTembusan = PdmTembusanT12::find()
            ->where(['no_surat_t12' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

        if($kd_berkas=='T-14'){
            $modelTembusan = PdmTembusanT14::find()
            ->where(['no_surat_t14' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

		

		if($kd_berkas=='P-18'){
			$modelTembusan = PdmTembusanP18::find()
            ->where(['id_p18' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-19'){
			$modelTembusan = PdmTembusanP19::find()
            ->where(['id_p19' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-20'){
			$modelTembusan = PdmTembusanP20::find()
            ->where(['id_p20' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-21'){
			$modelTembusan = PdmTembusanP21::find()
            ->where(['id_p21' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-21A'){
			$modelTembusan = PdmTembusanP21a::find()
            ->where(['id_p21a' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-22'){
			$modelTembusan = PdmTembusanP22::find()
            ->where(['id_p22' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}
		
		if($kd_berkas=='P-23'){
			$modelTembusan = PdmTembusanP23::find()
            ->where(['id_p23' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
		}

        if($kd_berkas=='P-31'){
            $modelTembusan = PdmTembusanP31::find()
            ->where(['no_surat_p31' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

         if($kd_berkas=='P-40'){
            $modelTembusan = PdmTembusanP40::find()
            ->where(['no_surat_p40' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

        if($kd_berkas=='P-47'){
            $modelTembusan = PdmTembusanP47::find()
            ->where(['no_akta' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

        if($kd_berkas=='P-48'){
            $modelTembusan = PdmTembusanP48::find()
            ->where(['no_surat' => $id_table])
            ->orderBy('no_urut asc')
            ->all();
        }

			
        if ($modelTembusan == null) {
            $modelTembusan = PdmTemplateTembusan::find()
                ->where(['kd_berkas' => $kd_berkas])
                ->orderBy('no_urut asc')
                ->all();
        }
		
		

        $fieldHtml = '<div class="row"><div class="col-md-12" style="margin-bottom:10px;"><a class="btn btn-danger delete hapusTembusan"></a> <a id="tambah-tembusan" class="btn btn-success tembusan" style="margin-top:0px;margin-right:3px;">Tembusan</a></div></div>';
        $no = 1;
		foreach ($modelTembusan as $index => $modelTembusanRow) {
			if(isset($modelTembusanRow->id_tembusan)){
				$idTembusan = $modelTembusanRow->id_tembusan;
			}else{
				$idTembusan = $index;
			}
            
            $fieldHtml = $fieldHtml . '
			<div id="rowtembusan' . $idTembusan . '" class="form-group">
             <div class="col-md-1" style="width:10px; margin-top:5px">
                                  <input type="checkbox" name="new_check[]" class="hapusTembusanCheck" value="' . $idTembusan . '">
                                </div>
				<div class="col-md-1" >
                                  <input type="text" name="new_no_urut[]" class="form-control" value="' . $no . '">
                                </div>
				<div class="col-md-8">
                                  <input type="text" name="new_tembusan[]" class="form-control" value="' . $modelTembusanRow['tembusan'] . '">
                                </div>
                               
			</div>  ';
			$no++;
        }

        $fieldHtml = $fieldHtml . '
						<div id="new_tembusan" style="margin-top:5px;"></div>
						';
        $fieldHtml = $fieldHtml . "<script>
							function hapusTembusan(id)
							{
							   $('#new_tembusan').append(
							       '<input type=\"hidden\" name=\"hapus_tembusan[]\" value=\"'+id+'\">'
							   );

							   $('#rowtembusan'+id).remove();
							};
							function hapusTembusanPop(id)
							{
							   $('#new'+id).remove();
							};
					</script>";

        $thisForm->registerJs("$(document).ready(function(){
							var x=1;
					        $('#tambah-tembusan').click(function(){
					                $('#new_tembusan').append(
					                    '" . preg_replace("/\s+/", " ", "	<div id=\"new'+x+'\" class=\"form-group\"><div class=\"col-md-1\" style=\"margin-top:5px;width:10px;\"><input class=\"hapusTembusanCheck\" type=\"checkbox\" value=\"'+x+'\" name=\"new_check[]\"></div><div  class=\"col-md-1\"><input type=\"text\" class=\"form-control\" readonly=\"true\" name=\"new_no_urut[]\"></input></div><div class=\"col-md-8\"><input type=\"text\" class=\"form-control\" name=\"new_tembusan[]\"></input></div></div>") . "'
					                );
									x++;
					            });
								
							$('.hapusTembusan').click(function()
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


					        });

					      
					");


        return $fieldHtml;
    }

    public function getTerdakwa($form, $model, $modelSpdp)
    {
        $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
            ArrayHelper::map(VwTerdakwa::find()->where(['=', 'id_perkara', $modelSpdp->id_perkara])->all(), 'id_tersangka', 'nama'), // Flat array ('id'=>'label')
            ['prompt' => '----- Pilih ---- ', 'class' => 'cmb_terdakwa'] // options
        )->label(false);

        $js = <<< JS
			$('.cmb_terdakwa').change(function(){

			$.ajax({
                type: "POST",
                url: '/pidum/default/terdakwa',
                data: 'id_tersangka='+$('.cmb_terdakwa').val(),
                success:function(data){
                    console.log(data);
                    $('#data-terdakwa').html(
                    	'<div class="form-group">'+
							'<label class="control-label col-sm-2">Tempat Lahir</label>'+
							'<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Tanggal Lahir</label>'+
							'<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Jenis Kelamin</label>'+
							'<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Tempat Tinggal</label>'+
							'<div class="col-sm-4">'+data.alamat+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Agama</label>'+
							'<div class="col-sm-4">'+data.agama+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Pekerjaan</label>'+
							'<div class="col-sm-4">'+data.pekerjaan+'</div>'+
						'</div>'+
						'<div class="form-group">'+
							'<label class="control-label col-sm-2">Pendidikan</label>'+
							'<div class="col-sm-4">'+data.pendidikan+'</div>'+
						'</div>'
                    );
                    $('.no_reg_tahanan').val(data.reg_tahanan);
                    $('.ditahan_sejak').val(data.ditahan_sejak);
                }
            });
            /*$.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '/pidum/default/terdakwa', //Your form processing file URL
                data      : 'aa', //Forms name
                dataType  : 'json',
                success   : function(data) {
                      		console.log(data);
            };*/
        });
JS;

        $this->view->registerJs($js);
        return $terdakwa;
    }

    public function getIdentitasTerdakwa($id_tersangka)
    {
        $terdakwa = VwTerdakwa::find()
            ->where(['id_tersangka' => $id_tersangka])
            ->one();

        $html = "<div class='form-group hide'>
                            <label class='control-label col-sm-2'>Nama</label>
                            <div class='col-sm-4'>" . $terdakwa['nama'] . "</div>
                        </div>
                    <div class='form-group'>
                            <label class='control-label col-sm-2'>Tempat Lahir</label>
                            <div class='col-sm-4'>" . $terdakwa['tmpt_lahir'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Tanggal Lahir</label>
                            <div class='col-sm-4'>" . $terdakwa['tgl_lahir'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Jenis Kelamin</label>
                            <div class='col-sm-4'>" . $terdakwa['is_jkl'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Tempat Tinggal</label>
                            <div class='col-sm-4'>" . $terdakwa['alamat'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Agama</label>
                            <div class='col-sm-4'>" . $terdakwa['is_agama'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Pekerjaan</label>
                            <div class='col-sm-4'>" . $terdakwa['pekerjaan'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Pendidikan</label>
                            <div class='col-sm-4'>" . $terdakwa['is_pendidikan'] . "</div>
                        </div>";
        return $html;
    }

    // TERDAKWA PENUNTUTAN
    public function getTerdakwaT2($form, $model, $no_register_perkara,$key)
    {

        //$test = VwTerdakwaT2::find()->where(['no_register_perkara'=>$no_register_perkara])->all();
        //echo '<pre>';print_r($test);exit;
        //echo '<pre>';print_r($no_register_perkara);exit;
        $test=ArrayHelper::map(VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]), 'no_urut_tersangka', 'nama'); // Flat array ('id'=>'label')
        
        $terdakwa = $form->field($model, 'id_tersangka')->dropDownList($test,['prompt' => '----- Pilih ---- ', 'class' => 'cmb_terdakwa'] // options
        )->label(false);

        $js = <<< JS
            $('.cmb_terdakwa').change(function(){
                if($('.cmb_terdakwa').val()!='')
                {
                    $.ajax({
                        type: "POST",
                        url: '/pidum/default/terdakwa-t2',
                        data: 'no_urut_tersangka='+$('.cmb_terdakwa').val(),
                        success:function(data){
                            console.log(data);
                            $('#data-terdakwa').html(
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                                    '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                                    '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                                    '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                                    '<div class="col-sm-4">'+data.alamat+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Agama</label>'+
                                    '<div class="col-sm-4">'+data.agama+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Pekerjaan</label>'+
                                    '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label class="control-label col-sm-2">Pendidikan</label>'+
                                    '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                                '</div>'
                            );
                            $('.no_reg_tahanan').val(data.no_reg_tahanan);
                            $('.ditahan_sejak').val(data.ditahan_sejak);
                            
                        }
                    });
                }
            
            /*$.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '/pidum/default/terdakwa', //Your form processing file URL
                data      : 'aa', //Forms name
                dataType  : 'json',
                success   : function(data) {
                            console.log(data);
            };*/
        });
JS;

        $this->view->registerJs($js);
        return $terdakwa;
    }

    public function getIdentitasTerdakwaT2($no_register_perkara,$id_tersangka)
    {
        //echo $id_tersangka.$no_register_perkara;exit;
        $terdakwa = VwTerdakwaT2::find()
            ->where(['no_register_perkara'=>$no_register_perkara,'no_urut_tersangka' => $id_tersangka])
            ->one();

        $html = "<div class='form-group hide'>
                            <label class='control-label col-sm-2'>Nama</label>
                            <div class='col-sm-4'>" . $terdakwa['nama'] . "</div>
                        </div>
                    <div class='form-group'>
                            <label class='control-label col-sm-2'>Tempat Lahir</label>
                            <div class='col-sm-4'>" . $terdakwa['tmpt_lahir'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Tanggal Lahir</label>
                            <div class='col-sm-4'>" . $terdakwa['tgl_lahir'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Jenis Kelamin</label>
                            <div class='col-sm-4'>" . $terdakwa['is_jkl'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Tempat Tinggal</label>
                            <div class='col-sm-4'>" . $terdakwa['alamat'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Agama</label>
                            <div class='col-sm-4'>" . $terdakwa['is_agama'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Pekerjaan</label>
                            <div class='col-sm-4'>" . $terdakwa['pekerjaan'] . "</div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2'>Pendidikan</label>
                            <div class='col-sm-4'>" . $terdakwa['is_pendidikan'] . "</div>
                        </div>";
        return $html;
    }


    //END TERDAKWA PENUNTUTAN
    public function returnDropDownList($form, $model, $query, $value, $label, $field, $disabled = false)
    {
        $list = ArrayHelper::map($query, $value, $label);
        return $form->field($model, $field)->dropDownList($list, [$value => $label, 'disabled' => $disabled, 'prompt' => '----  Pilih -----  ']);
    }

    public function returnRadioList($form, $model, $query, $value, $label, $field, $disabled = false)
    {
        $list = ArrayHelper::map($query, $value, $label);
        return $form->field($model, $field)->radioList($list, [$value => $label, 'disabled' => $disabled]);
    }

    public function returnCheckboxList($form, $model, $query, $value, $label, $field, $disabled = false)
    {
        $list = ArrayHelper::map($query, $value, $label);
        return $form->field($model, $field)->checkboxList($list, [$value => $label, 'disabled' => $disabled]);
    }

    public function returnHeaderSuratSifat($form, $model)
    {
        $fieldHtml = '';

        $fieldHtml = $fieldHtml . '<div class="form-group"><label class="control-label col-md-2">Nomor:</label>'
            . '     <div class="col-md-4">' . $form->field($model, 'no_surat') . '
                                            </div>
                                      </div>
                                     <div class="form-group"><label class="control-label col-md-2">Sifat:</label>
                                            <div class="col-md-4">
                                            ' . $this->returnDropDownList($form, $model, MsSifatSurat::find()->all(), 'nama', 'nama', 'sifat', false) . ''
            . '</div>
                                     </div>
                                    <div class="form-group"><label class="control-label col-md-2">Lampiran:</label>
                                            <div class="col-md-4">
                                            ' . $form->field($model, 'lampiran') . '
                                            </div>
                                    </div>';
        return $fieldHtml;
    }

    public function ViewIndonesianFormat($StringDate)
    {
        if ($StringDate != NULL && $StringDate != '0000-00-00 00:00:00') {
            $ArrDate = explode(" ", $StringDate);
            if ($ArrDate[0] != NULL && $ArrDate[0] != '0000-00-00') {
                $TempDate = explode("-", $ArrDate[0]);
                switch ($TempDate[1]) {
                    case '01' :
                        $Bulan = 'Januari';
                        break;
                    case '02' :
                        $Bulan = 'Februari';
                        break;
                    case '03' :
                        $Bulan = 'Maret';
                        break;
                    case '04' :
                        $Bulan = 'April';
                        break;
                    case '05' :
                        $Bulan = 'Mei';
                        break;
                    case '06' :
                        $Bulan = 'Juni';
                        break;
                    case '07' :
                        $Bulan = 'Juli';
                        break;
                    case '08' :
                        $Bulan = 'Agustus';
                        break;
                    case '09' :
                        $Bulan = 'September';
                        break;
                    case '10' :
                        $Bulan = 'Oktober';
                        break;
                    case '11' :
                        $Bulan = 'November';
                        break;
                    case '12' :
                        $Bulan = 'Desember';
                        break;
                }
                if(strlen($TempDate[0])>2){
                    return $TempDate[2] . " " . $Bulan . " " . $TempDate[0];    
                }else{
                    return $TempDate[0] . " " . $Bulan . " " . $TempDate[2];    
                }
                
            }
        } else
            return '-';
    }

    public function IndonesianFormat($Date)
    {
        if ($Date != NULL && $Date != '0000-00-00') {
            $ArrDate = explode("-", $Date);
            return $ArrDate[2] . "-" . $ArrDate[1] . "-" . $ArrDate[0];
        } else {
            return '-';
        }
    }

    public function datediff($awalData, $akhirData)
    {
        $awalData = (is_string($awalData) ? strtotime($awalData) : $awalData);
        $akhirData = (is_string($akhirData) ? strtotime($akhirData) : $akhirData);
        $diff_secs = abs($awalData - $akhirData);
        $base_year = min(date("Y", $awalData), date("Y", $akhirData));
        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
        $FormatTime = array(
            "years" => date("Y", $diff) - $base_year,
            "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
            "months" => date("n", $diff) - 1,
            "days_total" => floor($diff_secs / (3600 * 24)),
            "days" => date("j", $diff) - 1
        );
        return $FormatTime;
    }

    public function getSetStatusProcces($idPerkara, $kodeBerkas)
    {
        $modelStatusSurat = new PdmStatusSurat();
        $modelStatusSurat->id_perkara = $idPerkara;
        $modelStatusSurat->id_sys_menu = $kodeBerkas;
        $modelStatusSurat->id_user_login = Yii::$app->user->identity->username;
        $modelStatusSurat->durasi = date('Y-m-d h:m:s');
        $modelStatusSurat->is_akhir = '1';
        $modelStatusSurat->save();
    }

    public function getNextProcces($idPerkara, $idSysMenu)
    {
        if ($idSysMenu) {
            for ($i = 0; $i < count($idSysMenu); $i++) {
                $trxPemroresan = new PdmTrxPemrosesan();
                $trxPemroresan->id_perkara = $idPerkara;
                $trxPemroresan->id_sys_menu = $idSysMenu[$i];
                $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
                $trxPemroresan->durasi = date('Y-m-d h:m:s');
                if(!$trxPemroresan->save()){
					var_dump($trxPemroresan->getErrors());exit;
				}
            }
            return true;
        }
        return true;
    }
    
    public function getNextProcces2($idPerkara,$no_register_perkara, $idSysMenu)
    {
        if ($idSysMenu) {
            for ($i = 0; $i < count($idSysMenu); $i++) {
                $trxPemroresan = new PdmTrxPemrosesan();
                $trxPemroresan->id_perkara = $idPerkara;
                $trxPemroresan->id_sys_menu = $idSysMenu[$i];
                $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
                $trxPemroresan->durasi = date('Y-m-d h:m:s');
                $trxPemroresan->no_register_perkara = $no_register_perkara;
                if(!$trxPemroresan->save()){
                    var_dump($trxPemroresan->getErrors());exit;
                }
            }
            return true;
        }
        return true;
    }

    public static function tglToWord($tgl)
    {
        $tahun = substr($tgl, 0, 4);
        $bulan = substr($tgl, 5, 2);
        $tanggal = substr($tgl, 8, 2);
        switch ($bulan) {
            case "01":
                $bulan = "Januari";
                break;
            case "02":
                $bulan = "Februari";
                break;
            case "03":
                $bulan = "Maret";
                break;
            case "04":
                $bulan = "April";
                break;
            case "05":
                $bulan = "Mei";
                break;
            case "06":
                $bulan = "Juni";
                break;
            case "07":
                $bulan = "Juli";
                break;
            case "08":
                $bulan = "Agustus";
                break;
            case "09":
                $bulan = "September";
                break;
            case "10":
                $bulan = "Oktober";
                break;
            case "11":
                $bulan = "November";
                break;
            default:
                $bulan = "Desember";
        }
        return $tanggal . " " . $bulan . " " . $tahun;
    }

    public static function GetNamaHari($Date)
    {
        if ($Date != NULL && $Date != '0000-00-00') {
            $ArrDate = explode("-", $Date);
            $IntHari = date("N", mktime(0, 0, 0, $ArrDate[1], $ArrDate[2], $ArrDate[0]));
            switch ($IntHari) {
                case 1 :
                    $Hari = "Senin";
                    break;
                case 2 :
                    $Hari = "Selasa";
                    break;
                case 3 :
                    $Hari = "Rabu";
                    break;
                case 4 :
                    $Hari = "Kamis";
                    break;
                case 5 :
                    $Hari = "Jum'at";
                    break;
                case 6 :
                    $Hari = "Sabtu";
                    break;
                case 7 :
                    $Hari = "Minggu";
                    break;
            }
            return $Hari;
        } else {
            return '-';
        }
    }
	
	public function getNamaBulan($bulan){
		$list_bulan = array(
			"1"=>"Januari",
			"2"=>"Februari",
			"3"=>"Maret",
			"4"=>"April",
			"5"=>"Mei",
			"6"=>"Juni",
			"7"=>"Juli",
			"8"=>"Agustus",
			"9"=>"September",
			"10"=>"Oktober",
			"11"=>"Nopember",
			"12"=>"Desember",
		);
		return $list_bulan[$bulan];
	}

    public function autoIncrementRp9($model)
    {
        $id_perkara = Yii::$app->session->get('id_perkara');

        $thisMonth = preg_replace("/^0/", "", date("m")); //remove the 0 on the month
        $thisYear = date("Y");

        $query = new Query;
        $query->select('MAX(no_urut)')
            ->from('pidum.pdm_rp9');
        $max_no_urut = $query->createCommand();
        $max_no_urut = $max_no_urut->queryOne();
        $max_no_urut = $max_no_urut['max'];

        $bulan_dikeluarkanP16A = preg_replace("/^0/", "", date("m", strtotime($model->tgl_dikeluarkan))); //remove the 0 on the month
        $tahun_dikeluarkanP16A = date("Y", strtotime($model->tgl_dikeluarkan));
        if ($thisMonth == $bulan_dikeluarkanP16A && $thisYear == $tahun_dikeluarkanP16A) {
            $max_no_urut++;
        } else {
            $max_no_urut = 1;
        }

        $query1 = new Query;
        $query1->select('*')
            ->from('pidum.pdm_rp9')
            ->where(['id_perkara' => $id_perkara]);
        $existModelRp9 = $query1->createCommand();
        $existModelRp9 = $existModelRp9->queryOne();

        if (!$existModelRp9) {
            $modelRp9 = new PdmRp9();
            $modelRp9->id_perkara = $id_perkara;
            $modelRp9->no_urut = $max_no_urut;
            $modelRp9->save();
        }

        return true;
    }

    public function autoIncrementRt3($model)
    {
        $id_perkara = Yii::$app->session->get('id_perkara');

        $thisMonth = preg_replace("/^0/", "", date("m")); //remove the 0 on the month
        $thisYear = date("Y");

        $query = new Query;
        $query->select('MAX(no_urut)')
            ->from('pidum.pdm_rt3');
        $max_no_urut = $query->createCommand();
        $max_no_urut = $max_no_urut->queryOne();
        $max_no_urut = $max_no_urut['max'];

        $bulan_dikeluarkanBa10 = preg_replace("/^0/", "", date("m", strtotime($model->tgl_surat))); //remove the 0 on the month
        $tahun_dikeluarkanBa10 = date("Y", strtotime($model->tgl_surat));
        if ($thisMonth == $bulan_dikeluarkanBa10 && $thisYear == $tahun_dikeluarkanBa10) {
            $max_no_urut++;
        } else {
            $max_no_urut = 1;
        }

        $query1 = new Query;
        $query1->select('*')
            ->from('pidum.pdm_rt3')
            ->where(['id_perkara' => $id_perkara]);
        $existModelRt3 = $query1->createCommand();
        $existModelRt3 = $existModelRt3->queryOne();

        if (!$existModelRt3) {
            $modelRt3 = new PdmRt3();
            $modelRt3->id_perkara = $id_perkara;
            $modelRt3->id_tersangka = $model->id_tersangka;
            $modelRt3->no_urut = $max_no_urut;
            $modelRt3->save();
        }

        return true;
    }

    public function autoIncrementRb2($model)
    {
        $id_perkara = Yii::$app->session->get('id_perkara');

        $thisMonth = preg_replace("/^0/", "", date("m")); //remove the 0 on the month
        $thisYear = date("Y");

        $query = new Query;
        $query->select('MAX(no_urut)')
            ->from('pidum.pdm_rb2');
        $max_no_urut = $query->createCommand();
        $max_no_urut = $max_no_urut->queryOne();
        $max_no_urut = $max_no_urut['max'];

        $bulan_dikeluarkanBa18 = preg_replace("/^0/", "", date("m", strtotime($model->tgl_pembuatan))); //remove the 0 on the month
        $tahun_dikeluarkanBa18 = date("Y", strtotime($model->tgl_pembuatan));
        if ($thisMonth == $bulan_dikeluarkanBa18 && $thisYear == $tahun_dikeluarkanBa18) {
            $max_no_urut++;
        } else {
            $max_no_urut = 1;
        }

        $query1 = new Query;
        $query1->select('*')
            ->from('pidum.pdm_rb2')
            ->where(['id_perkara' => $id_perkara]);
        $existModelRb2 = $query1->createCommand();
        $existModelRb2 = $existModelRb2->queryOne();

        if (!$existModelRb2) {
            $modelRb2 = new PdmRb2();
            $modelRb2->id_perkara = $id_perkara;
            $modelRb2->no_urut = $max_no_urut;
            $modelRb2->save();
        }

        return true;
    }

    public function setKepalaReport($kd_satker)
    {
        if ($kd_satker == "00") {
            return "JAKSA AGUNG MUDA TINDAK PIDANA UMUM";
        } else {
            return "KEPALA " . $this->getNamaSatker($kd_satker)->inst_nama;
        }
    }

    public function setHeaderReport($spdp)
    {
        $kd_satker = ($spdp->id_satker_tujuan != '' ? $spdp->id_satker_tujuan : $spdp->wilayah_kerja);
        return $this->getNamaSatker($kd_satker)->inst_nama;
    }

    public function setHeaderKepalaReport($spdp)
    {
        $kd_satker = ($spdp->id_satker_tujuan != '' ? $spdp->id_satker_tujuan : $spdp->wilayah_kerja);
        if ($kd_satker == "00") {
            return "JAKSA AGUNG MUDA TINDAK PIDANA UMUM";
        } else {
            return "KEPALA " . $this->getNamaSatker($kd_satker)->inst_nama;;
        }
    }

    public function getListTerdakwa($id_perkara)
    {
        $dft_tersangka = '';
       
	$listTersangka = Yii::$app->db->createCommand("SELECT a.nama FROM pidum.ms_tersangka a INNER JOIN pidum.pdm_spdp b on a.id_perkara = b.id_perkara WHERE b.id_perkara='".$id_perkara."' order by a.no_urut desc ")->queryAll();
        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = $key[nama] ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka = $key[nama]." dan " ;
				}else{
					$nama_tersangka .= $key[nama] ;
				}
				$i++;
			 }
		}else {
            foreach ($listTersangka as $key) {
				$i=1;
				if($i==1){
					$nama_tersangka = $key[nama]." dkk. " ;
				}
			}
        }

        
        return $nama_tersangka;
    }

    public function getListTerdakwaBa4($no_register_perkara)
    {
        $dft_tersangka = '';
       
    $listTersangka = Yii::$app->db->createCommand("SELECT a.nama FROM pidum.pdm_ba4_tersangka a  WHERE a.no_register_perkara='".$no_register_perkara."' order by a.no_urut_tersangka ")->queryAll();
        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
                $nama_tersangka = $key[nama] ;
            }
        } else if(count($listTersangka) == 2){
             $i=1;
             foreach ($listTersangka as $key) {
                if($i==1){
                    $nama_tersangka = $key[nama]." dan " ;
                }else{
                    $nama_tersangka .= $key[nama] ;
                }
                $i++;
             }
        }else {
            foreach ($listTersangka as $key) {
                $i=1;
                if($i==1){
                    $nama_tersangka = $key[nama]." dkk. " ;
                }
            }
        }

        
        return $nama_tersangka;
    }

    public function getListTerdakwaBerkas($id_pengantar)
    {
        $dft_tersangka = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.ms_tersangka_berkas')
            ->where("no_pengantar='".trim($id_pengantar)."'")
            ->orderBy('no_urut');
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();

        //echo '<pre>';print_r(count($listTersangka));exit;

        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
                $nama_tersangka = $key[nama] ;
            }
        } else if(count($listTersangka) == 2){
             $i=1;
             foreach ($listTersangka as $key) {
                if($i==1){
                    $nama_tersangka = $key[nama]." dan " ;
                }else{
                    $nama_tersangka .= $key[nama] ;
                }
                $i++;
             }
        }else {
            foreach ($listTersangka as $key) {
                $i=1;
                if($i==1){
                    $nama_tersangka = $key[nama]." dkk. " ;
                }
            }
        }

        return $nama_tersangka;
    }
    public function getDaftarTerdakwa($id_perkara)
    {
        $dft_tersangka = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.ms_tersangka')
            ->where("id_perkara='" . $id_perkara . "' AND flag <>'3'")
            ->orderBy('id_tersangka');
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();

        if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
                $nama_tersangka = ucfirst(strtolower($key[nama])) ;
            }
        } else if(count($listTersangka) == 2){
             $i=1;
             foreach ($listTersangka as $key) {
                if($i==1){
                    $nama_tersangka = ucfirst(strtolower($key[nama]))." dan " ;
                }else{
                    $nama_tersangka .= ucfirst(strtolower($key[nama])) ;
                }
                $i++;
             }
        }else {
            foreach ($listTersangka as $key) {
                $i=1;
                if($i==1){
                    $nama_tersangka = ucfirst(strtolower($key[nama]))." dkk. " ;
                }
            }
        }

        return $nama_tersangka;
    }

    public function getDaftarBarbukT2($no_register_perkara)
    {
        $dft_barbuk = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.pdm_barbuk')
            ->where("no_register_perkara='" . $no_register_perkara . "' ")
            ->orderBy('no_urut_bb');
        $data = $query->createCommand();
        $listBarbuk = $data->queryAll();

        $tnda = ', ';
        foreach ($listBarbuk as $key) {
            $dft_barbuk .= $key[nama] . $tnda;
        }
        $Barbuk = preg_replace("/, $/", "", $dft_barbuk);
        return ucwords(strtolower($Barbuk));
    }

    public function getDaftarPasal($id_perkara)
    {
        $dft_pasal = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.pdm_pasal')
            ->where("id_perkara='" . $id_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        foreach ($listPasal as $key) {
            $dft_pasal .= $key['undang'] . ' ' . $key['pasal'] . ',';
        }
        $dft_pasal = preg_replace("/,$/", "", $dft_pasal);
        return ucwords(strtolower($dft_pasal));
    }

    public function getAlternativePasal($id_pengantar)
    {
        $dft_pasal = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.pdm_uu_pasal_tahap1')
            ->where("id_pengantar='" . $id_pengantar . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        foreach ($listPasal as $key) {
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
        }
        $dft_pasal = preg_replace("/, $/", "", $dft_pasal);
        return $dft_pasal;
    }

    public function getBarbuk($id_perkara)
    {

//        $modelB4 = PdmB4::find()->where(['id_perkara' => $id_perkara])->orderBy('tgl_sprint DESC')->one();
//        $modelbarbuk = PdmBarbukTambahan::findAll(['id_b4' => $modelB4->id_b4]);
        $modelbarbuk = \app\modules\pidum\models\VwBarangBukti::findAll(['id_perkara' => $id_perkara]);

        $barbuk = "";
        if (count($modelbarbuk) == 1) {
            $barbuk = $modelbarbuk[0]->nama;
        } else if (count($modelbarbuk) == 2) {
            $i = 0;
            foreach ($modelbarbuk as $key) {
                if ($i == 0) {
                    $barbuk .= $key->nama;
                    $i = 1;
                } else {
                    $barbuk .= ' dan ' . $key->nama;
                }
            }
        } else if (count($modelbarbuk) > 2) {
            $i = 1;
            foreach ($modelbarbuk as $key) {
                if ($i == count($modelbarbuk)) {
                    $barbuk .= 'dan ' . $key->nama;
                } else {
                    $barbuk .= $key->nama . ', ';
                    $i++;
                }
            }
        }
        return $barbuk;
    }


    public function getPasalTahap1H($id_pengantar)
    {

//        $modelB4 = PdmB4::find()->where(['id_perkara' => $id_perkara])->orderBy('tgl_sprint DESC')->one();
//        $modelbarbuk = PdmBarbukTambahan::findAll(['id_b4' => $modelB4->id_b4]);
        $modelbarbuk = \app\modules\pidum\models\PdmUuPasalTahap1::findAll(['id_pengantar' => $id_pengantar]);

        $barbuk = "";
        if (count($modelbarbuk) == 1) {
            $barbuk = $modelbarbuk[0]->undang.' '.$modelbarbuk[0]->tentang.' '.$modelbarbuk[0]->pasal;
        } else if (count($modelbarbuk) == 2) {
            $i = 0;
            foreach ($modelbarbuk as $key) {
                if ($i == 0) {
                    $barbuk .= $key->undang.' '.$key->tentang.' '.$key->pasal;
                    $i = 1;
                } else {
                    $barbuk .= ' dan ' . $key->undang.' '.$key->tentang.' '.$key->pasal;
                }
            }
        } else if (count($modelbarbuk) > 2) {
            $i = 1;
            foreach ($modelbarbuk as $key) {
                if ($i == count($modelbarbuk)) {
                    $barbuk .= 'dan ' . $key->undang.' '.$key->tentang.' '.$key->pasal;
                } else {
                    $barbuk .= $key->undang.' '.$key->tentang.' '.$key->pasal. ', ';
                    $i++;
                }
            }
        }

        //echo '<pre>';print_r($barbuk);exit;
        return $barbuk;
    }


    public function getPasalH($no_register_perkara)
    {

//        $modelB4 = PdmB4::find()->where(['id_perkara' => $id_perkara])->orderBy('tgl_sprint DESC')->one();
//        $modelbarbuk = PdmBarbukTambahan::findAll(['id_b4' => $modelB4->id_b4]);
        $modelbarbuk = \app\modules\pidum\models\PdmUuPasalTahap2::findAll(['no_register_perkara' => $no_register_perkara]);

        $barbuk = "";
        if (count($modelbarbuk) == 1) {
            $barbuk = $modelbarbuk[0]->undang.' '.$modelbarbuk[0]->tentang.' '.$modelbarbuk[0]->pasal;
        } else if (count($modelbarbuk) == 2) {
            $i = 0;
            foreach ($modelbarbuk as $key) {
                if ($i == 0) {
                    $barbuk .= $key->undang.' '.$key->tentang.' '.$key->pasal;
                    $i = 1;
                } else {
                    $barbuk .= ' dan ' . $key->undang.' '.$key->tentang.' '.$key->pasal;
                }
            }
        } else if (count($modelbarbuk) > 2) {
            $i = 1;
            foreach ($modelbarbuk as $key) {
                if ($i == count($modelbarbuk)) {
                    $barbuk .= 'dan ' . $key->undang.' '.$key->tentang.' '.$key->pasal;
                } else {
                    $barbuk .= $key->undang.' '.$key->tentang.' '.$key->pasal. ', ';
                    $i++;
                }
            }
        }

        //echo '<pre>';print_r($barbuk);exit;
        return $barbuk;
    }


    public function getTanggalBeritaAcara($tgl)
    {
        $terbilang = new Terbilang();
        if ($tgl != NULL && $tgl != '0000-00-00 00:00:00') {
            $tahun = substr($tgl, 0, 4);
            $bulan = substr($tgl, 5, 2);
            $tanggal = substr($tgl, 8, 2);
            switch ($bulan) {
                case "01":
                    $bulan = "Januari";
                    break;
                case "02":
                    $bulan = "Februari";
                    break;
                case "03":
                    $bulan = "Maret";
                    break;
                case "04":
                    $bulan = "April";
                    break;
                case "05":
                    $bulan = "Mei";
                    break;
                case "06":
                    $bulan = "Juni";
                    break;
                case "07":
                    $bulan = "Juli";
                    break;
                case "08":
                    $bulan = "Agustus";
                    break;
                case "09":
                    $bulan = "September";
                    break;
                case "10":
                    $bulan = "Oktober";
                    break;
                case "11":
                    $bulan = "November";
                    break;
                default:
                    $bulan = "Desember";
            }
            $tgl_surat = strtolower($terbilang->convert($tanggal)) . " bulan " . strtolower($bulan) . " tahun " . strtolower($terbilang->convert($tahun));

            return $tgl_surat;
        } else {
            return "-";
        }
    }


    public function getTanggalAngka($tgl)
    {
        $terbilang = new Terbilang();
        if ($tgl != NULL && $tgl != '0000-00-00 00:00:00') {
            $tahun = substr($tgl, 0, 4);
            $bulan = substr($tgl, 5, 2);
            $tanggal = substr($tgl, 8, 2);
            switch ($bulan) {
                case "01":
                    $bulan = "Januari";
                    break;
                case "02":
                    $bulan = "Februari";
                    break;
                case "03":
                    $bulan = "Maret";
                    break;
                case "04":
                    $bulan = "April";
                    break;
                case "05":
                    $bulan = "Mei";
                    break;
                case "06":
                    $bulan = "Juni";
                    break;
                case "07":
                    $bulan = "Juli";
                    break;
                case "08":
                    $bulan = "Agustus";
                    break;
                case "09":
                    $bulan = "September";
                    break;
                case "10":
                    $bulan = "Oktober";
                    break;
                case "11":
                    $bulan = "November";
                    break;
                default:
                    $bulan = "Desember";
            }
            $tgl_surat = $tanggal." bulan ".ucwords(strtolower($bulan))." Tahun ".$tahun;

            return $tgl_surat;
        } else {
            return "-";
        }
    }


    public function getTerbilang($Nilai)
    {
        $terbilang = new Terbilang();
        $Bilangan = $terbilang->convert($Nilai);
        return $Bilangan;

    }

    public function getMessage($tingkat_kd, $id_register)
    {
        $queryTerlapor = new Query();
        $terlapor = $queryTerlapor->from('was.v_terlapor a')
            ->innerJoin('was.l_was_2_saran b', 'a.id_terlapor = b.id_terlapor AND b.tingkat_kd=:tingkat_kd', [':tingkat_kd' => $tingkat_kd])
            ->where('a.id_register=:id_register', [':id_register' => $id_register])
            ->count();

        if ($terlapor < '1') {
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'info', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 10000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data SK Terlapor tidak ada dalam menu ini', // String
                'title' => 'Info', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
        }

        return $terlapor;
    }

    function romanic_number($integer, $upcase = true) 
    { 
        $table = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C'=>100,
            'XC'=>90,
            'L'=>50,
            'XL'=>40,
            'X'=>10,
            'IX'=>9,
            'V'=>5,
            'IV'=>4,
            'I'=>1
        ); 
        $return = ''; 
        while($integer > 0) 
        { 
            foreach($table as $rom=>$arb) 
            { 
                if($integer >= $arb) 
                { 
                    $integer -= $arb; 
                    $return .= $rom; 
                    break; 
                } 
            } 
        } 

        return $return; 
    }
    
    public function getSatkerWas(){
          
        $satker = (!empty(KpPegawai::find()->where('peg_nip = :pegNip',[":pegNip"=>  $this->peg_nip])->one()->peg_instakhir)? KpPegawai::find()->where('peg_nip = :pegNip',[":pegNip"=>  $this->peg_nip])->one()->peg_instakhir : '00');
        return $satker;
    }
	
    public function CekExpire($table,$filed,$where){
        $query = new Query;
        $connection = \Yii::$app->db;
        $sql = "select (max($filed)-CURRENT_DATE) as tanggal from was.$table where $where";
        $query = $connection->createCommand($sql)->queryOne();
        /* lebih besar dari sma dengan 0 Expire*/
        /* lebih besar dari -1  belum expire*/
        if($query['tanggal']<0){
            $Expire='0';
        }else if($query['tanggal']==''){
            $Expire='0';
        }else{
            $Expire='1';
        }
        // $Expire=($query['tanggal']<0 ? '0':'1');
        
        return $Expire;
    }
    

	public function getInstansipelaksanapenyidik(){
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
		return MsInstPelakPenyidikan::findOne(['kode_ip'=>$modelSpdp->id_asalsurat,'kode_ipp'=>$modelSpdp->id_penyidik])->nama;
	}
	
	//faiz datun
	public function getWil($kode)
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $modelSpdp  = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
		  $deskrip = MsWilayah::find()
                    ->where(['id_prop' => $kode])
                    ->One();

          return $deskrip;
    }

    public function CtkNoRegTahanan($kode)
    {
        $q = VwTerdakwaT2::find()->select('no_reg_tahanan')->where(['no_register_perkara'=>$kode])->asArray()->all();
        $len = count($q);
        
        switch ($len) {
            case 1:
                $q=$q[0][no_reg_tahanan];
                break;
            case 2:
                $q=$q[0][no_reg_tahanan].' Dan '.$q[1][no_reg_tahanan];    
                break;
            default:
                $q=$q[0][no_reg_tahanan].' S.d '.$q[$len-1][no_reg_tahanan];
                break;
        }
        //echo '<pre>';print_r($q);exit;
          return $q;
    }


    public function CtkNoRegTahananT7($kode)
    {
        $q = PdmT7::find()->select('no_reg_tahanan_jaksa')->where(['no_register_perkara'=>$kode])->asArray()->all();
        $len = count($q);
        
        switch ($len) {
            case 1:
                $q=$q[0][no_reg_tahanan_jaksa];
                break;
            case 2:
                $q=$q[0][no_reg_tahanan_jaksa].' Dan '.$q[1][no_reg_tahanan_jaksa];    
                break;
            default:
                $q=$q[0][no_reg_tahanan_jaksa].' S.d '.$q[$len-1][no_reg_tahanan_jaksa];
                break;
        }
        //echo '<pre>';print_r($q);exit;
          return $q;
    }


    public function GetHlistTerdakwaT2($kode)
    {
        $q = VwTerdakwaT2::find()->select('nama')->where(['no_register_perkara'=>$kode])->asArray()->all();
        $len = count($q);
        switch ($len) {
            case 1:
                $q=$q[0][nama];
                break;
            case 2:
                $q=$q[0][nama].' Dan '.$q[1][nama];    
                break;
            case 0:
                $q = '-';
                break;
            default:
                $q=$q[0][nama].' Dkk';
                break;
        }
        //echo '<pre>';print_r($q);exit;
        
          return $q;
    }

    public function GetHlistTerdakwaBerkas($kode)
    {
        $q = MsTersangkaBerkas::find()->select('nama')->where(['id_berkas'=>$kode])->asArray()->all();
        
        $len = count($q);
        switch ($len) {
            case 1:
                $q=$q[0][nama];
                break;
            case 2:
                $q=$q[0][nama].' Dan '.$q[1][nama];    
                break;
            default:
                $q=$q[0][nama].' Dkk';
                break;
        }
        //echo '<pre>';print_r($q);exit;
        
          return $q;
    }


    public function GetHlistTerdakwaPengantar($kode){
        $q = MsTersangkaBerkas::find()->select('nama')->where(['no_pengantar'=>$kode])->asArray()->all();
        $len = count($q);
        switch ($len){
            case 1:
                $q=$q[0][nama];
                break;
            case 2:
                $q=$q[0][nama].' Dan '.$q[1][nama];    
                break;
            default:
                $q=$q[0][nama].' Dkk';
                break;
        }
        return $q;
    }


    public function GetHlistTerdakwaSpdp($kode)
    {
        $q = MsTersangka::find()->select('no_urut,nama')->where(['id_perkara'=>$kode])->orderBy(['(no_urut)' => SORT_ASC])->asArray()->all();
        $len = count($q);
        switch ($len) {
            case 1:
                $q=$q[0][nama];
                break;
            case 2:
                $q=$q[0][nama].' Dan '.$q[1][nama];    
                break;
            default:
                $q=$q[0][nama].' Dkk';
                break;
        }
        //echo '<pre>';print_r($q);exit;
        
          return $q;
    }

    public function GetNamaTahananT2($kode,$reg)
    {
        $q = VwTerdakwaT2::find()->select('nama')->where(['no_register_perkara'=>$kode, 'no_reg_tahanan'=>$reg])->Scalar();
          return $q;
    }
	
    public function terbilang_get_valid($str,$from,$to,$min=1,$max=9){
            $val=false;
            $from=($from<0)?0:$from;
            for ($i=$from;$i<$to;$i++){
                if (((int) $str{$i}>=$min)&&((int) $str{$i}<=$max)) $val=true;
            }
            return $val;
        }
    
    public function terbilang_get_str($i,$str,$len){
            $numA=array("","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan");
            $numB=array("","Se","Dua ","Tiga ","Empat ","Lima ","Enam ","Tujuh ","Delapan ","Sembilan ");
            $numC=array("","Satu ","Dua ","Tiga ","Empat ","Lima ","Enam ","Tujuh ","Delapan ","Sembilan ");
            $numD=array(0=>"puluh",1=>"belas",2=>"ratus",4=>"ribu", 7=>"juta", 10=>"milyar", 13=>"triliun");
            $buf="";
            $pos=$len-$i;
            switch($pos){
                case 1:
                        if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
                            $buf=$numA[(int) $str{$i}];
                    break;
                case 2: case 5: case 8: case 11: case 14:
                        if ((int) $str{$i}==1){
                            if ((int) $str{$i+1}==0)
                                $buf=($numB[(int) $str{$i}]).($numD[0]);
                            else
                                $buf=($numB[(int) $str{$i+1}]).($numD[1]);
                        }
                        else if ((int) $str{$i}>1){
                                $buf=($numB[(int) $str{$i}]).($numD[0]);
                        }               
                    break;
                case 3: case 6: case 9: case 12: case 15:
                        if ((int) $str{$i}>0){
                                $buf=($numB[(int) $str{$i}]).($numD[2]);
                        }
                    break;
                case 4: case 7: case 10: case 13:
                        if ($this->terbilang_get_valid($str,$i-2,$i)){
                            if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
                                $buf=$numC[(int) $str{$i}].($numD[$pos]);
                            else
                                $buf=$numD[$pos];
                        }
                        else if((int) $str{$i}>0){
                            if ($pos==4)
                                $buf=($numB[(int) $str{$i}]).($numD[$pos]);
                            else
                                $buf=($numC[(int) $str{$i}]).($numD[$pos]);
                        }
                    break;
            }
            return $buf;
        }
        
    public function terbilang($nominal){
            $buf="";
            $str=$nominal."";
            $len=strlen($str);
            for ($i=0;$i<$len;$i++){
                $buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
            }
            return trim($buf);
        }

    public function GetDetBarbuk($no_register_perkara,$no_urut_bb)
    {
        $dft_barbuk = '';
        $query = new Query;
        $query->select('*')
            ->from('pidum.pdm_barbuk')
            ->where("no_register_perkara='" . $no_register_perkara . "' and no_urut_bb=".$no_urut_bb." ");
        $data = $query->createCommand();
        $result = $data->queryOne();
        $jumlah = is_float($result['jumlah']) ? number_format($result['jumlah'],2,',','.') : number_format($result['jumlah'],0,',','.');
        $satuan = PdmMsSatuan::findOne($result['id_satuan'])->nama;
        $terbilang = $this->terbilang($jumlah);
        $Barbuk  = $jumlah.' ('.$terbilang.') '.$satuan.' '.$result['nama'];
        return ucwords(strtolower($Barbuk));
    }

    public function GetLastP16a(){
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
    
        $p16a = PdmP16a::find()->where(['no_register_perkara'=>$no_register_perkara])->orderBy('tgl_dikeluarkan desc')->limit(1)->one();
        return $p16a;
    }

    public function GetLastP16(){
        $session = new session();
        $id_perkara = $session->get('id_perkara');
    
        $p16 = PdmP16::find()->where(['id_perkara'=>$id_perkara])->orderBy('tgl_dikeluarkan desc')->limit(1)->one();
        return $p16;
    }

    public function GetLastPengantar(){
        $session = new session();
        $id_berkas = $session->get('id_berkas');
    
        $pengantar = PdmPengantarTahap1::find()->where(['id_berkas'=>$id_berkas])->orderBy('tgl_pengantar desc')->limit(1)->one();
        return $pengantar;
    }

    public function GetConfSatker(){
        $session = new Session();
        $inst_satkerkd = $session->get('inst_satkerkd');
        $conf = ConfigSatker::find()->where(['kd_satker'=>$inst_satkerkd])->limit(1)->one();
        //echo '<pre>';print_r($conf);exit;
        return $conf;
    }


    public function JenisPidana(){
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $spdp = PdmSpdp::findOne($id_perkara);
        $pidana = MsJenisPerkara::findOne(['kode_pidana'=>$spdp->kode_pidana, 'jenis_perkara'=>$spdp->id_pk_ting_ref])->nama;
        return $pidana;
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
