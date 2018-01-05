-- Table: pidum.pdm_b16

-- DROP TABLE pidum.pdm_b16;

CREATE TABLE pidum.pdm_b16
(
  id_b16 character(16) NOT NULL,
  id_perkara character(16),
  no_surat character varying(32),
  sifat character varying(20),
  lampiran character varying(16),
  kepada character varying(128),
  di_kepada character varying(128),
  dikeluarkan character varying(64),
  tgl_dikeluarkan date,
  id_tersangka character(16),
  pelaksanaan_lelang character varying(128),
  tgl_lelang date,
  total numeric(15,0),
  bank character varying(64),
  ba_penitipan character varying(32),
  tgl_ba date,
  no_persetujuan character varying(64),
  tgl_persetujuan date,
  kantor_lelang character varying(64),
  no_risalan character varying(32),
  id_penandatangan character varying(20),
  flag character(1) NOT NULL DEFAULT 1,
  created_by integer NOT NULL DEFAULT (-1),
  created_ip character varying(15),
  created_time timestamp without time zone NOT NULL DEFAULT now(),
  updated_ip character varying(15),
  updated_by integer NOT NULL DEFAULT (-1),
  updated_time timestamp without time zone NOT NULL DEFAULT now(),
  surat_perintah_kepada character varying(128),
  lokasi_penetapan character varying(128),
  CONSTRAINT pk_pdm_b16 PRIMARY KEY (id_b16),
  CONSTRAINT pdm_b16_id_spdp_fkey FOREIGN KEY (id_perkara)
      REFERENCES pidum.pdm_spdp (id_perkara) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE SET NULL
)
WITH (
  OIDS=FALSE
);
ALTER TABLE pidum.pdm_b16
  OWNER TO postgres;
