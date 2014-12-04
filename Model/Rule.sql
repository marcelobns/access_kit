CREATE TABLE rules
(
  id serial NOT NULL,
  requester character varying(100) NOT NULL,
  requester_key integer NOT NULL,
  controller character varying(100) NOT NULL,
  action character varying(100) NOT NULL,
  allow boolean NOT NULL,
  CONSTRAINT permissions_pk PRIMARY KEY (id)
)