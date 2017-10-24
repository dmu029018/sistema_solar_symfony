-- BD Sistema Solar -----------------------------------------------

-- DDL Estructura -------------------------------------------------

DROP DATABASE IF EXISTS sistemasolar;
create database IF NOT EXISTS sistemasolar DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
use sistemasolar;

create table planeta(
    id int(10) NOT NULL AUTO_INCREMENT,
    nom varchar(20) not null,
    distancia float not null check(distancia>=0),
    periode float not null check(periode>=0),
    diametre  float not null check(diametre>0),
    situacio char(1) not null default 'E' check(situacio in ('I','E')),
    tipus char(1) not null default 'P' check(tipus in ('P','E')),
    superficie float check(superficie>=0),
    primary key(id),
    constraint UQ_planeta_nom unique (nom)
);

create table satelit(
    id int(10) NOT NULL AUTO_INCREMENT,
    nom varchar(20) not null,
    id_planeta int not null,
    primary key(id),
    constraint FK_planeta_satelit_01 foreign key (id_planeta) references planeta(id)
    on delete cascade on update cascade,
    constraint UQ_satelit_nom unique (nom)
);

-- trigger per a guardar la superficie
delimiter $$
create trigger INS_planeta_superficie
before insert on planeta
for each row
begin
	set NEW.superficie=round(PI()*NEW.diametre*NEW.diametre/1e6,2);
end $$

create trigger UPD_planeta_superficie
before update on planeta
for each row
begin
	set NEW.superficie=round(PI()*NEW.diametre*NEW.diametre/1e6,2);
end $$

delimiter ;

-- DML Dades ------------------------------------------------------

insert into planeta (id,nom,distancia,periode,diametre,situacio,tipus) values
(1,'Mercuri',0.38,0.241,4879.4,'I','P'),
(2,'Venus',0.72,0.615,12103.6,'I','P'),
(3,'Terra',1,1,12742,'I','P'),
(4,'Mart',1.52,1.88,6794.4,'I','P'),
(5,'Ceres',2.766,4.599,952.4,'E','E'),
(6,'Júpiter',5.2,11.86,142984,'E','P'),
(7,'Saturn',9.54,29.46,1.20536e8,'E','P'),
(8,'Urà',19.22,84.01,51118,'E','P'),
(9,'Neptú',30.06,164.79,49572,'E','P'),
(10,'Plutó',39.482,247.92,2390,'E','E'),
(11,'Haumea',43.335,285.4,1600,'E','E'),
(12,'Makemake',45.792,309.9,1600,'E','E'),
(13,'Eris',67.668,557,1300,'E','E');

insert into satelit (id,id_planeta,nom) values
(1,3,'Lluna'),
(2,4,'Fobos'),
(3,4,'Deimos'),
(4,6,'Ió'),
(5,6,'Europa'),
(6,6,'Ganimedes'),
(7,6,'Cal·listo'),
(8,7,'Mimes'),
(9,7,'Encèlad'),
(10,7,'Tetis'),
(11,7,'Dione'),
(12,7,'Rea'),
(13,7,'Tità'),
(14,7,'Hiperió'),
(15,7,'Jàpet'),
(16,7,'Febe'),
(17,8,'Titània'),
(18,8,'Oberó'),
(19,8,'Umbriel'),
(20,8,'Ariel'),
(21,8,'Miranda'),
(22,9,'Tritó'),
(23,9,'Nàiade'),
(24,9,'Nereida'),
(25,9,'Talassa'),
(26,9,'Despina'),
(27,9,'Galatea'),
(28,9,'Làrissa'),
(29,9,'Proteu'),
(30,9,'Halimedes'),
(31,9,'Sao'),
(32,9,'Laomedeia'),
(33,9,'Psàmete'),
(34,9,'Neso'),
(35,10,'Caronte'),
(36,10,'Nix'),
(37,10,'Hydra'),
(38,10,'Cèrber'),
(39,10,'Estix'),
(40,13,'Disnòmia');

-- TCL
drop user if exists 'Usrsistemasolar'@'localhost';
create user if not exists 'Usrsistemasolar'@'localhost' identified by '12345';

grant insert,update,delete,select,execute
on sistemasolar.*
to 'Usrsistemasolar'@localhost;