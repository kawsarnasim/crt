
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
  PRIMARY KEY (`id_notice`)
)ENGINE=InnoDB;