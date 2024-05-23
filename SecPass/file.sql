CREATE DATABASE secpass;

create table codeLog (code varchar(255), namee varchar(50), checksumm varchar(50));

create table passwords (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user varchar(1000),
    password varchar(1000),
    description varchar(1000)
);

create table passwords (id int NOT NULL AUTOINCREMENT,user varchar(1000),password varchar(1000),description varchar(1000));


insert into codeLog (code, name, checksum) values ("", "", "");