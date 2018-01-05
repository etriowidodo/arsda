<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>

<div class="get-warga-index col-md-10 col-md-offset-1">
    <p style="margin-bottom:10px;"></p>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-tsk-modal">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckModal" id="allCheckModal" class="allCheckModal" /></th>
                        <th class="text-center" width="5%">#</th>
                        <th class="text-center" width="30%">Nama</th>
                        <th class="text-center" width="30%">Tempat, Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="4">Data tidak ditemukan</td></tr>
                <?php 
//                            $sqlnya = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
//                                        from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
//                            $hasil = PdsBa3::findBySql($sqlnya)->asArray()->all();
//                            if(count($hasil) == 0)
//                                echo '<tr><td colspan="6">Data tidak ditemukan</td></tr>';
//                            else{
//                                $nom = 0;
//                                foreach($hasil as $data){
//                                    $nom++;	
//                                    $idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];						
                 ?>	
<!--                              <tr data-id="<?php echo $data['nip'];?>">
                        <td class="text-center">
                            <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                        </td>
                        <td class="text-center">
                            <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                            <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                        </td>
                        <td class="text-left"><?php echo $data['nama'];?></td>
                        <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                     </tr>-->
                 <?php// } } ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer" style="text-align:center;">
            <button class="btn btn-warning jarak-kanan pilih-jpn" id="simpan_usul" type="button">Simpan</button>
            <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
        </div><br/>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/pds-p15/gettsk?id='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
    </div>
<style>
	.get-warga-index.loading {overflow: hidden;}
	.get-warga-index.loading .modal-loading-new {display: block;}
</style>
<script>
    $(document).ready(function(){
        $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
    });
</script>