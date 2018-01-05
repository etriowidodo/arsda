<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
/**
 * This is the model class for table "pidum.pdm_rt3".
 *
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property integer $no_urut
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmRt3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_rt3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'id_tersangka'], 'required'],
            [['no_urut', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'no_urut' => 'No Urut',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
    
    public function searchPer($no_register, $params){
//            $q1  = htmlspecialchars($params['q1'], ENT_QUOTES);
            $sql = "SELECT b.no_register_perkara, a.no_reg_tahanan_jaksa AS no_reg_tahanan, 
                    a.no_urut_tersangka, b.nama, b.tmpt_lahir, b.tgl_lahir, d.nama AS is_jkl, 
                    b.alamat, c.nama AS is_agama, b.pekerjaan, e.nama AS is_pendidikan, 
                    f.nama AS is_identitas, a.no_surat_t7, g.nama AS warganegara, a.tgl_mulai, 
                    a.lokasi_tahanan, b.umur, b.foto, a.tindakan_status, b.id_jkl, b.id_agama, 
                    b.id_identitas AS id_warganegara, b.id_pendidikan, b.jns_penahanan_penyidik, h.nama as jns_penahanan, b.lokasi_penyidik, b.tgl_ba4, b.tgl_awal_penyidik, b.tgl_akhir_penyidik
                   FROM pidum.pdm_t7 a
                   LEFT JOIN pidum.pdm_ba4_tersangka b ON a.no_register_perkara::text = b.no_register_perkara::text AND a.no_urut_tersangka::text = b.no_urut_tersangka::text
                   LEFT JOIN ms_agama c ON b.id_agama = c.id_agama
                   LEFT JOIN ms_jkl d ON b.id_jkl = d.id_jkl
                   LEFT JOIN ms_pendidikan e ON b.id_pendidikan = e.id_pendidikan
                   LEFT JOIN ms_identitas f ON b.id_identitas = f.id_identitas
                   LEFT JOIN ms_warganegara g ON b.id_identitas = g.id
                   left join pidum.ms_loktahanan h on b.jns_penahanan_penyidik = h.id_loktahanan
                   where a.tindakan_status = '1' and a.no_register_perkara = '".$no_register."'";
//            if($q1)
//                    $sql .= " and ( upper(b.uu) like '%".strtoupper($q1)."%' or upper(a.pasal) like '%".strtoupper($q1)."%' or upper(a.bunyi) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a. no_urut_tersangka";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    public function getriwayat($id, $no_register){
        $sql = "select * from (
                select a.no_urut_tersangka, a.no_surat_t7, b.tgl_ba7, 'T-7' as jenis, a.lokasi_tahanan, 'Ditahan' as status
                from pidum.pdm_t7 a
                LEFT JOIN pidum.pdm_ba7 b on a.no_surat_t7 = b.no_surat_t7
                LEFT JOIN pidum.pdm_ms_tindakan_status c on a.tindakan_status = c.id
                where a.tindakan_status = '1' and a.no_urut_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select a.no_urut_tersangka,a.no_surat_t7, b.tgl_ba8, 'T-7' as jenis, a.lokasi_tahanan, 'Ditahan' as status
                from pidum.pdm_t7 a
                LEFT JOIN pidum.pdm_ba8 b on a.no_surat_t7 = b.no_surat_t7
                LEFT JOIN pidum.pdm_ms_tindakan_status c on a.tindakan_status = c.id
                where a.tindakan_status = '2' and a.no_urut_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select a.id_tersangka,a.no_surat_t8, b.tgl_ba9, 'T-8' as jenis, '' as lokasi_tahanan, 'Ditangguhkan' as status
                from pidum.pdm_t8 a
                LEFT JOIN pidum.pdm_ba9 b on a.no_surat_t8 = b.no_surat_t8
                LEFT JOIN pidum.pdm_ms_status_t8 c on a.id_ms_status_t8 = c.id
                where a.id_ms_status_t8 = '1' and a.id_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select a.id_tersangka, a.no_surat_t8, b.tgl_ba10, 'T-8' as jenis, '' as lokasi_tahanan, 'Ditangguhkan' as status
                from pidum.pdm_t8 a
                LEFT JOIN pidum.pdm_ba10 b on a.no_surat_t8 = b.no_surat_t8
                LEFT JOIN pidum.pdm_ms_status_t8 c on a.id_ms_status_t8 = c.id
                where a.id_ms_status_t8 = '2' and a.id_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select a.id_tersangka, a.no_surat_t8, b.tgl_ba11, 'T-8' as jenis, '' as lokasi_tahanan, 'Ditangguhkan' as status
                from pidum.pdm_t8 a
                LEFT JOIN pidum.pdm_ba11 b on a.no_surat_t8 = b.no_surat_t8
                LEFT JOIN pidum.pdm_ms_status_t8 c on a.id_ms_status_t8 = c.id
                where a.id_ms_status_t8 = '3' and a.id_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select no_urut_tersangka, no_surat_t6, tgl_dikeluarkan, 'T-6' as jenis, '' as lokasi_tahanan, 'Ditahan' as status 
                from pidum.pdm_t6 where no_urut_tersangka = '".$id."' and no_register_perkara = '".$no_register."'
                union
                select  CAST (a.id_tersangka AS INTEGER), a.no_surat_t9, b.tgl_dikeluarkan, 'T-9' as jenis, '' as lokasi_tahanan, 'Ditahan' as status 
                from pidum.pdm_detail_t9 as a
                LEFT JOIN pidum.pdm_t9 b on a.no_surat_t9 = b.no_surat_t9
                where a.id_tersangka = '".$id."' and a.no_register_perkara = '".$no_register."'
                union
                select CAST (id_tersangka AS INTEGER), no_surat_t10, tgl_dikeluarkan, 'T-10' as jenis, '' as lokasi_tahanan, 'Ditahan' as status 
                from pidum.pdm_t10
                where id_tersangka = '".$id."' and no_register_perkara = '".$no_register."'
                union
                select CAST (id_tersangka AS INTEGER), no_surat_t11, tgl_dikeluarkan, 'T-11' as jenis, '' as lokasi_tahanan, 'Ditahan' as status 
                from pidum.pdm_t11
                where id_tersangka = '".$id."' and no_register_perkara = '".$no_register."' ) as a";
//            if($q1)
//                    $sql .= " and ( upper(b.uu) like '%".strtoupper($q1)."%' or upper(a.pasal) like '%".strtoupper($q1)."%' or upper(a.bunyi) like '%".strtoupper($q1)."%')";

            $kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
            $count = $kueri->queryScalar();
            $sql .= " order by a.tgl_ba7";
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                            'totalCount' => $count,
            ]);
            return $dataProvider;
    }
    
    
}
