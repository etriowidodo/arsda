<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
<?php 
	$modul = htmlspecialchars($params['q1'], ENT_QUOTES);
	if(count($hasil) == 0)
		echo '<p class="text-center">Data tidak ditemukan</p>';
	else{
?>	
	<div style="max-height:400px; overflow:scroll;"><div class="table-responsive">
    	<?php if($modul != "PENGAWASAN"){ ?>
        <table class="table table-bordered table-hover explorer">
        	<thead>
            	<tr>
                    <th width="90%" class="text-center">Nama Menu</th>
                    <th width="10%" class="text-center"><input type="checkbox" name="allCheck" id="allCheck" class="allCheck" /></th>
				</tr>
            </thead>
            <tbody>
            <?php 
				$nom = 0;
				foreach($hasil as $data){ 
					$nom++;
					$marginLeft = (($data['depth'] - 1)* 20).'px';
					echo '
						<tr>
							<td><span class="'.$data['tipe'].'" style="margin-left:'.$marginLeft.'">'.$data['name'].'</span></td>
							<td class="text-center">
								<input type="checkbox" name="cek['.$data['id'].']" id="cek'.$nom.'" class="chkp" data-tree="'.$data['tree_menu'].'" value="'.$data['id'].'" />
							</td>
						</tr>';
				} 
			?>
            </tbody>
        </table>
        <?php } else{ ?>
        <table class="table table-bordered table-hover explorer">
        	<thead>
            	<tr>
                    <th width="75%" class="text-center" style="vertical-align:middle;">Nama Menu</th>
                    <th width="5%" class="text-center"><input type="checkbox" name="allCheck" id="allCheck" class="allCheck" /></th>
                    <th width="5%" class="text-center">Tambah<br /><input type="checkbox" name="allCheckT" id="allCheckT" class="allCheckT" /></th>
                    <th width="5%" class="text-center">Ubah<br /><input type="checkbox" name="allCheckU" id="allCheckU" class="allCheckU" /></th>
                    <th width="5%" class="text-center">Hapus<br /><input type="checkbox" name="allCheckH" id="allCheckH" class="allCheckH" /></th>
                    <th width="5%" class="text-center">Cetak<br /><input type="checkbox" name="allCheckC" id="allCheckC" class="allCheckC" /></th>
				</tr>
            </thead>
            <tbody>
            <?php 
				$nom = 0;
				foreach($hasil as $data){ 
					$nom++;
					$marginLeft = (($data['depth'] - 1)* 20).'px';
					echo '
						<tr>
							<td><span class="'.$data['tipe'].'" style="margin-left:'.$marginLeft.'">'.$data['name'].'</span></td>
							<td class="text-center">
								<input type="checkbox" name="cek['.$data['id'].']" id="cek'.$nom.'" class="chkp" data-tree="'.$data['tree_menu'].'" value="'.$data['id'].'" />
							</td>
							<td class="text-center">
								<input type="checkbox" name="cekT['.$data['id'].']" id="cekT'.$nom.'" class="chkpT" value="1" disabled />
							</td>
							<td class="text-center">
								<input type="checkbox" name="cekU['.$data['id'].']" id="cekU'.$nom.'" class="chkpU" value="1" disabled />
							</td>
							<td class="text-center">
								<input type="checkbox" name="cekH['.$data['id'].']" id="cekH'.$nom.'" class="chkpH" value="1" disabled />
							</td>
							<td class="text-center">
								<input type="checkbox" name="cekC['.$data['id'].']" id="cekC'.$nom.'" class="chkpC" value="1" disabled />
							</td>
						</tr>';
				} 
			?>
            </tbody>
        </table>
        <?php } ?>
    </div></div>
<?php } ?>
</div>
<script>
	$(document).ready(function(){
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
	});
</script>