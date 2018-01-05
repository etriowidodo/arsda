-- Table: pidum.pdm_ba20

-- DROP TABLE pidum.pdm_ba20;

CREATE TABLE pidum.pdm_ba20
(
  id_ba20 character(16) NOT NULL,
  id_perkara character(16),
  tgl_surat date,
  lokasi character varying(128),
  id_tersangka character(16),
  bar_buk text,
  nama character varying(64),
  pekerjaan character varying(128),
  alamat character varying(128),
  flag character(1) NOT NULL DEFAULT 1, -- 1. insert, 2. update 3. delete Note: untuk jpu dismpan pada pdm_jaksa_penerima dan jaksa saksi simpan pada tabel : pdm_jaksa_saksi
  created_by integer NOT NULL DEFAULT (-1),
  created_ip character varying(15),
  created_time timestamp without time zone NOT NULL DEFAULT now(),
  updated_ip character varying(15),
  updated_by integer NOT NULL DEFAULT (-1),
  updated_time timestamp without time zone NOT NULL DEFAULT now(),
  CONSTRAINT pk_pdm_ba20 PRIMARY KEY (id_ba20),
  CONSTRAINT pdm_ba20_id_tersangka_fkey FOREIGN KEY (id_tersangka)
      REFERENCES pidum.ms_tersangka (id_tersangka) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE SET NULL
)
WITH (
  OIDS=FALSE
);
ALTER TABLE pidum.pdm_ba20
  OWNER TO postgres;
COMMENT ON COLUMN pidum.pdm_ba20.flag IS '1. insert, 2. update 3. delete Note: untuk jpu dismpan pada pdm_jaksa_penerima dan jaksa saksi simpan pada tabel : pdm_jaksa_saksi ';

