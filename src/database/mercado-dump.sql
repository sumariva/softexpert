--
-- PostgreSQL database dump
--

-- Dumped from database version 13.2
-- Dumped by pg_dump version 13.2

-- Started on 2022-08-15 22:35:50

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3058 (class 1262 OID 32768)
-- Name: mercado; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE mercado WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Portuguese_Brazil.1252';


ALTER DATABASE mercado OWNER TO postgres;

\connect mercado

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3059 (class 0 OID 0)
-- Dependencies: 3058
-- Name: DATABASE mercado; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE mercado IS 'Base de dados do sistema E-mercado.
Implementação para o cliente SoftExpert.';


--
-- TOC entry 209 (class 1259 OID 32856)
-- Name: item_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.item_id_seq OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 204 (class 1259 OID 32826)
-- Name: item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item (
    id integer DEFAULT nextval('public.item_id_seq'::regclass) NOT NULL,
    produto integer NOT NULL,
    quantidade integer NOT NULL,
    valor_imposto numeric(12,2) NOT NULL,
    valor_produto numeric(12,2) NOT NULL,
    pedido integer NOT NULL,
    CONSTRAINT constraint_check_quantidade_item CHECK ((0 < quantidade)),
    CONSTRAINT constraint_check_valor_imposto_item CHECK (((0)::numeric <= valor_imposto)),
    CONSTRAINT constraint_check_valor_produto_item CHECK ((valor_imposto <= valor_produto))
);


ALTER TABLE public.item OWNER TO postgres;

--
-- TOC entry 3060 (class 0 OID 0)
-- Dependencies: 204
-- Name: TABLE item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.item IS 'Lista de itens de um pedido.
Produtos podem repetir no pedido e podem ter sua quantidade multiplicada em cada item.';


--
-- TOC entry 3061 (class 0 OID 0)
-- Dependencies: 204
-- Name: COLUMN item.valor_imposto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.item.valor_imposto IS 'Valor calculado do imposto no momento da compra.
Se houver alteração nos valores do produto, a informação
da compra permanece aqui.
O valor salvo aqui se refere ao valor total do item, ou seja,
para o valor unitário do imposto, dividir pela quantidade.';


--
-- TOC entry 3062 (class 0 OID 0)
-- Dependencies: 204
-- Name: COLUMN item.valor_produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.item.valor_produto IS 'O valor registrado aqui se refere ao valor total desse item.
Para se obter o valor original de um produto na época do pedido,
deve se dividir o valor pela quantidade.';


--
-- TOC entry 3063 (class 0 OID 0)
-- Dependencies: 204
-- Name: CONSTRAINT constraint_check_valor_imposto_item ON item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_valor_imposto_item ON public.item IS 'Verificação do valor do imposto no item.';


--
-- TOC entry 3064 (class 0 OID 0)
-- Dependencies: 204
-- Name: CONSTRAINT constraint_check_valor_produto_item ON item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_valor_produto_item ON public.item IS 'Verifica que o valor do produto seja maior que o imposto.';


--
-- TOC entry 208 (class 1259 OID 32853)
-- Name: pedido_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedido_id_seq OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 32813)
-- Name: pedido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido (
    id integer DEFAULT nextval('public.pedido_id_seq'::regclass) NOT NULL,
    usuario integer NOT NULL,
    data_criacao date NOT NULL,
    qtd_item integer NOT NULL,
    total_imposto numeric(12,2) NOT NULL,
    total numeric(12,2) NOT NULL,
    CONSTRAINT constraint_check_imposto_pedido CHECK (((0)::numeric <= total_imposto)),
    CONSTRAINT constraint_check_qtd_item_pedido CHECK ((qtd_item > 0)),
    CONSTRAINT constraint_check_total_pedido CHECK ((total_imposto <= total))
);


ALTER TABLE public.pedido OWNER TO postgres;

--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 203
-- Name: TABLE pedido; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.pedido IS 'Lista dos pedidos dos clientes.';


--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN pedido.usuario; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.pedido.usuario IS 'Usuário que realizou o pedido.';


--
-- TOC entry 3068 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN pedido.data_criacao; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.pedido.data_criacao IS 'Data que o pedido foi realizado.';


--
-- TOC entry 3069 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN pedido.qtd_item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.pedido.qtd_item IS 'Quantidade de itens do pedido.
Nota: produtos podem repetir e a quantidade individual de cada produto pode ser mutliplicada em um item.
O valor aqui deve coincidir com a quantidade de itens do pedido.
';


--
-- TOC entry 3070 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN pedido.total_imposto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.pedido.total_imposto IS 'Valor total de imposto desse pedido.';


--
-- TOC entry 3071 (class 0 OID 0)
-- Dependencies: 203
-- Name: COLUMN pedido.total; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.pedido.total IS 'Valor total do pedido.';


--
-- TOC entry 3072 (class 0 OID 0)
-- Dependencies: 203
-- Name: CONSTRAINT constraint_check_imposto_pedido ON pedido; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_imposto_pedido ON public.pedido IS 'Garante que o valor de imposto seja N.';


--
-- TOC entry 3073 (class 0 OID 0)
-- Dependencies: 203
-- Name: CONSTRAINT constraint_check_qtd_item_pedido ON pedido; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_qtd_item_pedido ON public.pedido IS 'Garante que tenha itens no pedido.';


--
-- TOC entry 3074 (class 0 OID 0)
-- Dependencies: 203
-- Name: CONSTRAINT constraint_check_total_pedido ON pedido; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_total_pedido ON public.pedido IS 'Verifica que o total do pedido seja maior que o valor do imposto.';


--
-- TOC entry 207 (class 1259 OID 32850)
-- Name: produto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.produto_id_seq OWNER TO postgres;

--
-- TOC entry 3076 (class 0 OID 0)
-- Dependencies: 207
-- Name: SEQUENCE produto_id_seq; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON SEQUENCE public.produto_id_seq IS 'Sequencia para o atributo id da tabela produto.';


--
-- TOC entry 201 (class 1259 OID 32781)
-- Name: produto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produto (
    id integer DEFAULT nextval('public.produto_id_seq'::regclass) NOT NULL,
    tipo integer NOT NULL,
    nome character varying NOT NULL,
    preco numeric(12,2) NOT NULL,
    esta_disponivel smallint NOT NULL,
    CONSTRAINT constraint_check_esta_disponivel_produto CHECK (((0 <= esta_disponivel) AND (esta_disponivel <= 1))),
    CONSTRAINT constraint_check_preco_produto CHECK ((preco >= 0.0))
);


ALTER TABLE public.produto OWNER TO postgres;

--
-- TOC entry 3077 (class 0 OID 0)
-- Dependencies: 201
-- Name: TABLE produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.produto IS 'Lista de produtos no mercado.';


--
-- TOC entry 3078 (class 0 OID 0)
-- Dependencies: 201
-- Name: CONSTRAINT constraint_check_esta_disponivel_produto ON produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_esta_disponivel_produto ON public.produto IS 'Garante que o atributo esta_disponivel esteja marcado
como zero ou um.';


--
-- TOC entry 3079 (class 0 OID 0)
-- Dependencies: 201
-- Name: CONSTRAINT constraint_check_preco_produto ON produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_preco_produto ON public.produto IS 'Restringe preço a valores inteiros.';


--
-- TOC entry 206 (class 1259 OID 32847)
-- Name: tipo_produto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_produto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_produto_id_seq OWNER TO postgres;

--
-- TOC entry 3081 (class 0 OID 0)
-- Dependencies: 206
-- Name: SEQUENCE tipo_produto_id_seq; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON SEQUENCE public.tipo_produto_id_seq IS 'Sequencia do atributo id na tabela tipo_produto.';


--
-- TOC entry 200 (class 1259 OID 32770)
-- Name: tipo_produto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_produto (
    tipo character varying NOT NULL,
    id integer DEFAULT nextval('public.tipo_produto_id_seq'::regclass) NOT NULL,
    imposto double precision NOT NULL,
    CONSTRAINT constraint_check_tipo_tipo_produto CHECK ((((0)::double precision <= imposto) AND (imposto <= (100)::double precision)))
);


ALTER TABLE public.tipo_produto OWNER TO postgres;

--
-- TOC entry 3082 (class 0 OID 0)
-- Dependencies: 200
-- Name: TABLE tipo_produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.tipo_produto IS 'Tabela com os tipos de produto.
@since sprint 1';


--
-- TOC entry 205 (class 1259 OID 32844)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO postgres;

--
-- TOC entry 3084 (class 0 OID 0)
-- Dependencies: 205
-- Name: SEQUENCE usuario_id_seq; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON SEQUENCE public.usuario_id_seq IS 'Sequencia usada no atributo id.';


--
-- TOC entry 202 (class 1259 OID 32798)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id integer DEFAULT nextval('public.usuario_id_seq'::regclass) NOT NULL,
    email character varying NOT NULL,
    senha character varying NOT NULL,
    nome character varying NOT NULL,
    perfil smallint NOT NULL,
    bloqueado smallint NOT NULL,
    CONSTRAINT constraint_check_bloqueado_usuario CHECK (((0 <= bloqueado) AND (bloqueado <= 1))),
    CONSTRAINT constraint_check_perfil_usuario CHECK (((0 <= perfil) AND (perfil <= 1)))
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 3085 (class 0 OID 0)
-- Dependencies: 202
-- Name: TABLE usuario; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE public.usuario IS 'Conjunto de usuários do sistema.';


--
-- TOC entry 3086 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN usuario.email; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.usuario.email IS 'Email de contato e funciona como identidade de acesso.';


--
-- TOC entry 3087 (class 0 OID 0)
-- Dependencies: 202
-- Name: CONSTRAINT constraint_check_bloqueado_usuario ON usuario; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_bloqueado_usuario ON public.usuario IS 'Verifica o estado de um usuário.
0 - ativo
1 - bloqueado';


--
-- TOC entry 3088 (class 0 OID 0)
-- Dependencies: 202
-- Name: CONSTRAINT constraint_check_perfil_usuario ON usuario; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_check_perfil_usuario ON public.usuario IS 'Verifica o perfil.
Enumeração dos perfis:
0 - cliente
1 - lojista';


--
-- TOC entry 3047 (class 0 OID 32826)
-- Dependencies: 204
-- Data for Name: item; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.item (id, produto, quantidade, valor_imposto, valor_produto, pedido) FROM stdin;
\.


--
-- TOC entry 3046 (class 0 OID 32813)
-- Dependencies: 203
-- Data for Name: pedido; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pedido (id, usuario, data_criacao, qtd_item, total_imposto, total) FROM stdin;
\.


--
-- TOC entry 3044 (class 0 OID 32781)
-- Dependencies: 201
-- Data for Name: produto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produto (id, tipo, nome, preco, esta_disponivel) FROM stdin;
\.


--
-- TOC entry 3043 (class 0 OID 32770)
-- Dependencies: 200
-- Data for Name: tipo_produto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_produto (tipo, id, imposto) FROM stdin;
\.


--
-- TOC entry 3045 (class 0 OID 32798)
-- Dependencies: 202
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario (id, email, senha, nome, perfil, bloqueado) FROM stdin;
2	sumariva@gmail.com	123456	Cristiano	1	0
\.


--
-- TOC entry 3090 (class 0 OID 0)
-- Dependencies: 209
-- Name: item_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.item_id_seq', 1, false);


--
-- TOC entry 3091 (class 0 OID 0)
-- Dependencies: 208
-- Name: pedido_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_id_seq', 1, false);


--
-- TOC entry 3092 (class 0 OID 0)
-- Dependencies: 207
-- Name: produto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produto_id_seq', 1, false);


--
-- TOC entry 3093 (class 0 OID 0)
-- Dependencies: 206
-- Name: tipo_produto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_produto_id_seq', 1, false);


--
-- TOC entry 3094 (class 0 OID 0)
-- Dependencies: 205
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_seq', 2, true);


--
-- TOC entry 2902 (class 2606 OID 32809)
-- Name: usuario constraint_uniq_email_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT constraint_uniq_email_usuario UNIQUE (email);


--
-- TOC entry 3095 (class 0 OID 0)
-- Dependencies: 2902
-- Name: CONSTRAINT constraint_uniq_email_usuario ON usuario; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_uniq_email_usuario ON public.usuario IS 'Garante que os emails não se repitam, evitando cadastro duplicados.';


--
-- TOC entry 2898 (class 2606 OID 32792)
-- Name: produto constraint_uniq_nome_produto; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT constraint_uniq_nome_produto UNIQUE (nome);


--
-- TOC entry 2894 (class 2606 OID 32780)
-- Name: tipo_produto constraint_uniq_tipo_tipo_produto; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_produto
    ADD CONSTRAINT constraint_uniq_tipo_tipo_produto UNIQUE (tipo);


--
-- TOC entry 3096 (class 0 OID 0)
-- Dependencies: 2894
-- Name: CONSTRAINT constraint_uniq_tipo_tipo_produto ON tipo_produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_uniq_tipo_tipo_produto ON public.tipo_produto IS 'Garante que não tenha tipos duplicados.';


--
-- TOC entry 2908 (class 2606 OID 32833)
-- Name: item item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item
    ADD CONSTRAINT item_pkey PRIMARY KEY (id);


--
-- TOC entry 2906 (class 2606 OID 32820)
-- Name: pedido pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT pedido_pkey PRIMARY KEY (id);


--
-- TOC entry 2900 (class 2606 OID 32790)
-- Name: produto produto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);


--
-- TOC entry 2896 (class 2606 OID 32778)
-- Name: tipo_produto tipo_produto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_produto
    ADD CONSTRAINT tipo_produto_pkey PRIMARY KEY (id);


--
-- TOC entry 2904 (class 2606 OID 32807)
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- TOC entry 2912 (class 2606 OID 32839)
-- Name: item constraint_fk_pedido_item; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item
    ADD CONSTRAINT constraint_fk_pedido_item FOREIGN KEY (pedido) REFERENCES public.pedido(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 3097 (class 0 OID 0)
-- Dependencies: 2912
-- Name: CONSTRAINT constraint_fk_pedido_item ON item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_fk_pedido_item ON public.item IS 'Relacionamento com pedido 1..N';


--
-- TOC entry 2911 (class 2606 OID 32834)
-- Name: item constraint_fk_produto_item; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item
    ADD CONSTRAINT constraint_fk_produto_item FOREIGN KEY (produto) REFERENCES public.produto(id);


--
-- TOC entry 3098 (class 0 OID 0)
-- Dependencies: 2911
-- Name: CONSTRAINT constraint_fk_produto_item ON item; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_fk_produto_item ON public.item IS 'Referência para o produto adquirido.';


--
-- TOC entry 2909 (class 2606 OID 32793)
-- Name: produto constraint_fk_tipo_produto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT constraint_fk_tipo_produto FOREIGN KEY (tipo) REFERENCES public.tipo_produto(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 3099 (class 0 OID 0)
-- Dependencies: 2909
-- Name: CONSTRAINT constraint_fk_tipo_produto ON produto; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_fk_tipo_produto ON public.produto IS 'Relacionamento 1..1.';


--
-- TOC entry 2910 (class 2606 OID 32821)
-- Name: pedido constraint_fk_usuario_pedido; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT constraint_fk_usuario_pedido FOREIGN KEY (usuario) REFERENCES public.usuario(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 3100 (class 0 OID 0)
-- Dependencies: 2910
-- Name: CONSTRAINT constraint_fk_usuario_pedido ON pedido; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON CONSTRAINT constraint_fk_usuario_pedido ON public.pedido IS 'Relacionamento 1..N';


--
-- TOC entry 3065 (class 0 OID 0)
-- Dependencies: 204
-- Name: TABLE item; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.item TO "mercado-softexpert";


--
-- TOC entry 3075 (class 0 OID 0)
-- Dependencies: 203
-- Name: TABLE pedido; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.pedido TO "mercado-softexpert";


--
-- TOC entry 3080 (class 0 OID 0)
-- Dependencies: 201
-- Name: TABLE produto; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.produto TO "mercado-softexpert";


--
-- TOC entry 3083 (class 0 OID 0)
-- Dependencies: 200
-- Name: TABLE tipo_produto; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.tipo_produto TO "mercado-softexpert";


--
-- TOC entry 3089 (class 0 OID 0)
-- Dependencies: 202
-- Name: TABLE usuario; Type: ACL; Schema: public; Owner: postgres
--

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.usuario TO "mercado-softexpert";


-- Completed on 2022-08-15 22:35:53

--
-- PostgreSQL database dump complete
--

