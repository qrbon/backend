--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: items; Type: TABLE; Schema: public; Owner: qrbon; Tablespace: 
--

CREATE TABLE items (
    id integer NOT NULL,
    p_id integer NOT NULL,
    name character varying(255),
    price integer,
    amount integer,
    ean character varying(13),
    tax integer
);


ALTER TABLE items OWNER TO qrbon;

--
-- Name: items_id_seq; Type: SEQUENCE; Schema: public; Owner: qrbon
--

CREATE SEQUENCE items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE items_id_seq OWNER TO qrbon;

--
-- Name: items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: qrbon
--

ALTER SEQUENCE items_id_seq OWNED BY items.id;


--
-- Name: items_p_id_seq; Type: SEQUENCE; Schema: public; Owner: qrbon
--

CREATE SEQUENCE items_p_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE items_p_id_seq OWNER TO qrbon;

--
-- Name: items_p_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: qrbon
--

ALTER SEQUENCE items_p_id_seq OWNED BY items.p_id;


--
-- Name: purchase; Type: TABLE; Schema: public; Owner: qrbon; Tablespace: 
--

CREATE TABLE purchase (
    id integer NOT NULL,
    date timestamp without time zone,
    store character varying(255)
);


ALTER TABLE purchase OWNER TO qrbon;

--
-- Name: purchase_id_seq; Type: SEQUENCE; Schema: public; Owner: qrbon
--

CREATE SEQUENCE purchase_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE purchase_id_seq OWNER TO qrbon;

--
-- Name: purchase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: qrbon
--

ALTER SEQUENCE purchase_id_seq OWNED BY purchase.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: qrbon
--

ALTER TABLE ONLY items ALTER COLUMN id SET DEFAULT nextval('items_id_seq'::regclass);


--
-- Name: p_id; Type: DEFAULT; Schema: public; Owner: qrbon
--

ALTER TABLE ONLY items ALTER COLUMN p_id SET DEFAULT nextval('items_p_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: qrbon
--

ALTER TABLE ONLY purchase ALTER COLUMN id SET DEFAULT nextval('purchase_id_seq'::regclass);


--
-- Data for Name: items; Type: TABLE DATA; Schema: public; Owner: qrbon
--

COPY items (id, p_id, name, price, amount, ean, tax) FROM stdin;
\.


--
-- Name: items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: qrbon
--

SELECT pg_catalog.setval('items_id_seq', 1, false);


--
-- Name: items_p_id_seq; Type: SEQUENCE SET; Schema: public; Owner: qrbon
--

SELECT pg_catalog.setval('items_p_id_seq', 1, false);


--
-- Data for Name: purchase; Type: TABLE DATA; Schema: public; Owner: qrbon
--

COPY purchase (id, date, store) FROM stdin;
\.


--
-- Name: purchase_id_seq; Type: SEQUENCE SET; Schema: public; Owner: qrbon
--

SELECT pg_catalog.setval('purchase_id_seq', 1, true);


--
-- Name: items_pkey; Type: CONSTRAINT; Schema: public; Owner: qrbon; Tablespace: 
--

ALTER TABLE ONLY items
    ADD CONSTRAINT items_pkey PRIMARY KEY (id);


--
-- Name: purchase_pkey; Type: CONSTRAINT; Schema: public; Owner: qrbon; Tablespace: 
--

ALTER TABLE ONLY purchase
    ADD CONSTRAINT purchase_pkey PRIMARY KEY (id);


--
-- Name: items_p_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: qrbon
--

ALTER TABLE ONLY items
    ADD CONSTRAINT items_p_id_fkey FOREIGN KEY (p_id) REFERENCES purchase(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

