create table user(
    id integer primary key auto_increment,
    nome varchar(255),
    login varchar(255) unique,
    senha char(80)
);

create table msg(
    id integer primary key auto_increment,
    texto text,
    data datetime,
    idUser integer,
    foreign key(idUser) references user(id)
);