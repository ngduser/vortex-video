

Create table TESTVIDEO(
    v_id int NOT NULL,
    file_type varchar(4),
    length_sec int,
    name varchar(40),
    u_id int NOT NULL,
    views int,
    vid_filepath varchar(50),
    tn_id int,
    description varchar(300),
    Primary Key (v_id)
    );
