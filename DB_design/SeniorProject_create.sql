-- Start of file

-- tables
-- Table: doc_result
CREATE TABLE doc_result (
    id int  NOT NULL,
    users_id int  NOT NULL,
    doc_id1 int  NOT NULL,
    doc_id2 int  NOT NULL,
    doc_name varchar(32)  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    doc_link_content varchar(50)  NOT NULL,
    CONSTRAINT doc_result_pk PRIMARY KEY (id)
);



-- Table: docs_uploaded
CREATE TABLE docs_uploaded (
    id int  NOT NULL,
    user_id int  NOT NULL,
    doc_name varchar(32)  NOT NULL,
    date date  NOT NULL,
    time_stamp timestamp  NOT NULL,
    doc_link_content varchar(50)  NOT NULL,
    CONSTRAINT docs_uploaded_pk PRIMARY KEY (id)
);



-- Table: users
CREATE TABLE users (
    id int  NOT NULL,
    user_type varchar(32)  NOT NULL,
    first_name varchar(32)  NOT NULL,
    last_name varchar(32)  NOT NULL,
    email varchar(50)  NOT NULL,
    password varchar(32)  NOT NULL,
    verified int  NOT NULL,
    CONSTRAINT users_pk PRIMARY KEY (id)
);







-- foreign keys
-- Reference:  doc_result_docs_uploaded1 (table: doc_result)


ALTER TABLE doc_result ADD CONSTRAINT doc_result_docs_uploaded1 
    FOREIGN KEY (doc_id1)
    REFERENCES docs_uploaded (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  doc_result_docs_uploaded2 (table: doc_result)


ALTER TABLE doc_result ADD CONSTRAINT doc_result_docs_uploaded2 
    FOREIGN KEY (doc_id2)
    REFERENCES docs_uploaded (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  doc_result_users (table: doc_result)


ALTER TABLE doc_result ADD CONSTRAINT doc_result_users 
    FOREIGN KEY (users_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;

-- Reference:  docs_uploaded_users (table: docs_uploaded)


ALTER TABLE docs_uploaded ADD CONSTRAINT docs_uploaded_users 
    FOREIGN KEY (user_id)
    REFERENCES users (id)
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE 
;






-- End of file.

