
# Table User Types:
Create Table usertypes (
    userTypeId BIGINT(20) NOT NULL ,
    userTypeName VARCHAR( 128 ) NOT NULL,
    Primary Key (userTypeId)
) ENGINE=InnoDB;

insert into usertypes (userTypeId, userTypeName) values (1, 'Admin'), (2, 'Sub-Admin'), (3, 'Trainee');


#Table Users:
Create Table users (
    id_user BIGINT(20) NOT NULL AUTO_INCREMENT ,
    name VARCHAR( 128 ) NOT NULL ,
    email VARCHAR( 64 ) NOT NULL ,
    phone_number VARCHAR( 16 ) NOT NULL ,
    username VARCHAR( 16 ) NOT NULL ,
    password VARCHAR( 32 ) NOT NULL ,
    confirmcode VARCHAR(32) ,
    userTypeId BIGINT(20),
    PRIMARY KEY ( id_user ),
    FOREIGN KEY (userTypeId)
        REFERENCES usertypes(userTypeId)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;


#Table Notice:
CREATE  TABLE notices (
  id_notice BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  notice_title VARCHAR(45) NULL ,
  notice_text VARCHAR(45) NULL ,
  creationdatetime DATE NOT NULL,
  lastupdatedatetime DATE NOT NULL,
  PRIMARY KEY ( id_notice )
)ENGINE=InnoDB;

#Table Files:
CREATE  TABLE files (
  id_file BIGINT NOT NULL ,
  name VARCHAR(45) NULL ,
  type TINYTEXT NULL ,
  size BIGINT NULL ,
  location VARCHAR(120) NULL ,
  upload_date_time DATETIME NOT NULL ,
  PRIMARY KEY (id_file)
)ENGINE=InnoDB;

ALTER TABLE `crtdb`.`researches` ADD COLUMN `enddate` DATE NULL  AFTER `startdate` , CHANGE COLUMN `status` `startdate` DATE NULL  ;


#Table Researches:
CREATE  TABLE researches (
    id  BIGINT NOT NULL AUTO_INCREMENT,
    title  VARCHAR(45) NULL,
    description  TEXT NULL,
    startdate  DATE NULL,
    enddate  DATE NULL,
    creationdatetime  DATETIME NULL,
    lastupdatetime  DATETIME NULL,
    PRIMARY KEY ( id ) 
)ENGINE=InnoDB;


#Table Training:
CREATE  TABLE trainings (
    id  BIGINT NOT NULL AUTO_INCREMENT,
    title  VARCHAR(45) NULL,
    description  TEXT NULL,
    startdate  DATE NULL,
    enddate  DATE NULL,
    creationdatetime  DATETIME NULL,
    lastupdatetime  DATETIME NULL,
    PRIMARY KEY ( id ) 
)ENGINE=InnoDB;