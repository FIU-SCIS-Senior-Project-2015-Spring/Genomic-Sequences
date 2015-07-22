
-- tables
-- Table: data_type
CREATE TABLE data_type (
    id int  NOT NULL,
    user_id int  NOT NULL,
    an_uploaded_id int  NOT NULL,
    an_result_id int  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    processed smallint  NOT NULL,
    CONSTRAINT data_type_pk PRIMARY KEY (id)
);



-- Table: docs
CREATE TABLE docs (
    id int  NOT NULL,
    user_id int  NOT NULL,
    doc_name varchar(100)  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    CONSTRAINT docs_pk PRIMARY KEY (id)
);



-- Table: find_differences
CREATE TABLE find_differences (
    id int  NOT NULL,
    user_id int  NOT NULL,
    uploaded_id1 int  NOT NULL,
    uploaded_id2 int  NOT NULL,
    result_id int  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    processed smallint  NOT NULL,
    CONSTRAINT find_differences_pk PRIMARY KEY (id)
);



-- Table: probes
CREATE TABLE probes (
    id int  NOT NULL,
    user_id int  NOT NULL,
    prob_uploaded_id1 int  NOT NULL,
    prob_uploaded_id2 int  NOT NULL,
    prob_result_id int  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    processed smallint  NOT NULL,
    CONSTRAINT probes_pk PRIMARY KEY (id)
);



-- Table: rep_sequences
CREATE TABLE rep_sequences (
    id int  NOT NULL,
    user_id int  NOT NULL,
    seq_uploaded_id int  NOT NULL,
    seq_result_id int  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    processed smallint  NOT NULL,
    CONSTRAINT rep_sequences_pk PRIMARY KEY (id)
);



-- Table: users
CREATE TABLE users (
    id int  NOT NULL,
    user_type varchar(32)  NOT NULL,
    first_name varchar(32)  NOT NULL,
    last_name varchar(32)  NOT NULL,
    email varchar(50)  NOT NULL,
    password varchar(50)  NOT NULL,
    ver_code varchar(50)  NOT NULL,
    verified smallint  NOT NULL,
    CONSTRAINT users_pk PRIMARY KEY (id)
);







-- foreign keys
-- Reference:  data_type_docs1 (table: data_type)


ALTER TABLE data_type ADD CONSTRAINT data_type_docs1 
    FOREIGN KEY (an_uploaded_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  data_type_docs2 (table: data_type)


ALTER TABLE data_type ADD CONSTRAINT data_type_docs2 
    FOREIGN KEY (an_result_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  data_type_users (table: data_type)


ALTER TABLE data_type ADD CONSTRAINT data_type_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  doc_result_users (table: find_differences)


ALTER TABLE find_differences ADD CONSTRAINT doc_result_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  docs_uploaded_users (table: docs)


ALTER TABLE docs ADD CONSTRAINT docs_uploaded_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  find_differences_docs1 (table: find_differences)


ALTER TABLE find_differences ADD CONSTRAINT find_differences_docs1 
    FOREIGN KEY (uploaded_id1)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  find_differences_docs2 (table: find_differences)


ALTER TABLE find_differences ADD CONSTRAINT find_differences_docs2 
    FOREIGN KEY (uploaded_id2)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  find_differences_docs3 (table: find_differences)


ALTER TABLE find_differences ADD CONSTRAINT find_differences_docs3 
    FOREIGN KEY (result_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  probes_docs1 (table: probes)


ALTER TABLE probes ADD CONSTRAINT probes_docs1 
    FOREIGN KEY (prob_uploaded_id1)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  probes_docs2 (table: probes)


ALTER TABLE probes ADD CONSTRAINT probes_docs2 
    FOREIGN KEY (prob_uploaded_id2)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  probes_docs3 (table: probes)


ALTER TABLE probes ADD CONSTRAINT probes_docs3 
    FOREIGN KEY (prob_result_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  probes_users (table: probes)


ALTER TABLE probes ADD CONSTRAINT probes_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  rep_sequences_docs1 (table: rep_sequences)


ALTER TABLE rep_sequences ADD CONSTRAINT rep_sequences_docs1 
    FOREIGN KEY (seq_uploaded_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  rep_sequences_docs2 (table: rep_sequences)


ALTER TABLE rep_sequences ADD CONSTRAINT rep_sequences_docs2 
    FOREIGN KEY (seq_result_id)
    REFERENCES docs (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  rep_sequences_users (table: rep_sequences)


ALTER TABLE rep_sequences ADD CONSTRAINT rep_sequences_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;




-- sequences
-- Sequence: data_type_seq


CREATE SEQUENCE data_type_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;


-- Sequence: docs_seq


CREATE SEQUENCE docs_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;


-- Sequence: find_differences_seq


CREATE SEQUENCE find_differences_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;


-- Sequence: probes_seq


CREATE SEQUENCE probes_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;


-- Sequence: rep_sequences_seq


CREATE SEQUENCE rep_sequences_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;


-- Sequence: users_id_seq


CREATE SEQUENCE users_id_seq
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      START WITH 1 
      
      NO CYCLE
      
;






-- End of file.

