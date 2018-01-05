select b.id_perkara,   a.inst_lokinst, a.* 
from kepegawaian.kp_inst_satker a INNER JOIN pidum.pdm_spdp b ON ( a.inst_satkerkd = b.wilayah_kerja)
where 1=1 and a.inst_satkerkd='06.09' and b.id_perkara='0609002015000009';