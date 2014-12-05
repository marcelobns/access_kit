--Postgres syntaxe
CREATE TABLE logs
(
  id bigserial NOT NULL,
  date_time timestamp without time zone NOT NULL,
  alias character varying(100) NOT NULL,
  action character varying(30) NOT NULL,
  oid integer NOT NULL,
  content text NOT NULL,
  user_id integer NOT NULL,
  username character varying(100) NOT NULL,
  client_ip character varying(20),
  CONSTRAINT logs_pk PRIMARY KEY (id)
);
CREATE TABLE rules
(
  id serial NOT NULL,
  requester character varying(100) NOT NULL,
  requester_key integer NOT NULL,
  controller character varying(100) NOT NULL,
  action character varying(100) NOT NULL,
  allow boolean NOT NULL,
  CONSTRAINT rules_pk PRIMARY KEY (id)
)