-- Table: pidum.pdm_p48

-- DROP TABLE pidum.pdm_p48;

CREATE TABLE pidum.pdm_p48
(
  id_p48 character(16) NOT NULL,
  id_perkara character(16),
  no_surat character varying(32),
  dikeluarkan character varying(64),
  tgl_dikeluarkan date,
  id_penandatangan character varying(20),
  flag character(1) NOT NULL DEFAULT 1,
  created_by integer NOT NULL DEFAULT (-1),
  created_ip character varying(15),
  created_time timestamp without time zone NOT NULL DEFAULT now(),
  updated_ip character varying(15),
  updated_by integer NOT NULL DEFAULT (-1),
  updated_time timestamp without time zone NOT NULL DEFAULT now(),
  tgl_putusan date,
  CONSTRAINT pk_pdm_p48 PRIMARY KEY (id_p48)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE pidum.pdm_p48
  OWNER TO postgres;
