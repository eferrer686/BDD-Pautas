-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bddpautas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bddpautas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bddpautas` DEFAULT CHARACTER SET utf8 ;
USE `bddpautas` ;

-- -----------------------------------------------------
-- Table `bddpautas`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`cliente` (
  `idCliente` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `contacto` VARCHAR(45) NULL DEFAULT NULL,
  `mail` VARCHAR(45) NULL DEFAULT NULL,
  `telefono` VARCHAR(45) NULL DEFAULT NULL,
  `rfc` VARCHAR(45) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  ` marca` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idCliente`))
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`pauta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`pauta` (
  `idPauta` INT(11) NOT NULL AUTO_INCREMENT,
  `Cliente_idCliente` INT(11) NOT NULL,
  `programa` VARCHAR(45) NULL DEFAULT NULL,
  `inversion` VARCHAR(45) NULL DEFAULT NULL,
  `rating` VARCHAR(45) NULL DEFAULT NULL,
  `total` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idPauta`),
  INDEX `fk_Propuesta_Cliente1_idx` (`Cliente_idCliente` ASC),
  CONSTRAINT `fk_Propuesta_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `bddpautas`.`cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`proveedor` (
  `idProveedor` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `comision` VARCHAR(45) NULL DEFAULT NULL,
  `telefono` VARCHAR(45) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idProveedor`))
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`radio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`radio` (
  `idRadio` INT(11) NOT NULL AUTO_INCREMENT,
  `Proveedor_idProveedor` INT(11) NOT NULL,
  `estacion` VARCHAR(45) NULL DEFAULT NULL,
  `frecuencia` VARCHAR(45) NULL DEFAULT NULL,
  `siglas` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idRadio`),
  INDEX `fk_Radio_Proveedor_idx` (`Proveedor_idProveedor` ASC),
  CONSTRAINT `fk_Radio_Proveedor`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `bddpautas`.`proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`pauta_has_radio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`pauta_has_radio` (
  `Pauta_idPauta` INT(11) NOT NULL,
  `Radio_idRadio` INT(11) NOT NULL,
  PRIMARY KEY (`Pauta_idPauta`, `Radio_idRadio`),
  INDEX `fk_Propuesta_has_Radio_Radio1_idx` (`Radio_idRadio` ASC),
  INDEX `fk_Propuesta_has_Radio_Propuesta1_idx` (`Pauta_idPauta` ASC),
  CONSTRAINT `fk_Propuesta_has_Radio_Propuesta1`
    FOREIGN KEY (`Pauta_idPauta`)
    REFERENCES `bddpautas`.`pauta` (`idPauta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Propuesta_has_Radio_Radio1`
    FOREIGN KEY (`Radio_idRadio`)
    REFERENCES `bddpautas`.`radio` (`idRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`television`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`television` (
  `idTelevision` INT(11) NOT NULL AUTO_INCREMENT,
  `Proveedor_idProveedor` INT(11) NOT NULL,
  PRIMARY KEY (`idTelevision`),
  INDEX `fk_Television_Proveedor1_idx` (`Proveedor_idProveedor` ASC),
  CONSTRAINT `fk_Television_Proveedor1`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `bddpautas`.`proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`pauta_has_television`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`pauta_has_television` (
  `Pauta_idPauta` INT(11) NOT NULL,
  `Television_idTelevision` INT(11) NOT NULL,
  PRIMARY KEY (`Pauta_idPauta`, `Television_idTelevision`),
  INDEX `fk_Propuesta_has_Television_Television1_idx` (`Television_idTelevision` ASC),
  INDEX `fk_Propuesta_has_Television_Propuesta1_idx` (`Pauta_idPauta` ASC),
  CONSTRAINT `fk_Propuesta_has_Television_Propuesta1`
    FOREIGN KEY (`Pauta_idPauta`)
    REFERENCES `bddpautas`.`pauta` (`idPauta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Propuesta_has_Television_Television1`
    FOREIGN KEY (`Television_idTelevision`)
    REFERENCES `bddpautas`.`television` (`idTelevision`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`servicioradio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`servicioradio` (
  `idServicio` INT(11) NOT NULL AUTO_INCREMENT,
  `Radio_idRadio` INT(11) NOT NULL,
  `tipo` VARCHAR(45) NULL DEFAULT NULL,
  `ciudad` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaGeneral` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaEspecifica` VARCHAR(45) NULL DEFAULT NULL,
  `descuento` VARCHAR(45) NULL DEFAULT NULL,
  `hora` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idServicio`),
  INDEX `fk_ServicioRadio_Radio1_idx` (`Radio_idRadio` ASC),
  CONSTRAINT `fk_ServicioRadio_Radio1`
    FOREIGN KEY (`Radio_idRadio`)
    REFERENCES `bddpautas`.`radio` (`idRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`spot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`spot` (
  `idSpot` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `cantidad` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idSpot`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`spot_has_radio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`spot_has_radio` (
  `Spot_idSpot` INT(11) NOT NULL,
  `Radio_idRadio` INT(11) NOT NULL,
  PRIMARY KEY (`Spot_idSpot`, `Radio_idRadio`),
  INDEX `fk_Spot_has_Radio_Radio1_idx` (`Radio_idRadio` ASC),
  INDEX `fk_Spot_has_Radio_Spot1_idx` (`Spot_idSpot` ASC),
  CONSTRAINT `fk_Spot_has_Radio_Radio1`
    FOREIGN KEY (`Radio_idRadio`)
    REFERENCES `bddpautas`.`radio` (`idRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Spot_has_Radio_Spot1`
    FOREIGN KEY (`Spot_idSpot`)
    REFERENCES `bddpautas`.`spot` (`idSpot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`user` (
  `iduser` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`user_has_cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`user_has_cliente` (
  `user_iduser` INT(11) NOT NULL,
  `Cliente_idCliente` INT(11) NOT NULL,
  PRIMARY KEY (`user_iduser`, `Cliente_idCliente`),
  INDEX `fk_user_has_Cliente_Cliente1_idx` (`Cliente_idCliente` ASC),
  INDEX `fk_user_has_Cliente_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_user_has_Cliente_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `bddpautas`.`cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_Cliente_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `bddpautas`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`user_has_proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`user_has_proveedor` (
  `user_iduser` INT(11) NOT NULL,
  `Proveedor_idProveedor` INT(11) NOT NULL,
  PRIMARY KEY (`user_iduser`, `Proveedor_idProveedor`),
  INDEX `fk_user_has_Proveedor_Proveedor1_idx` (`Proveedor_idProveedor` ASC),
  INDEX `fk_user_has_Proveedor_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_user_has_Proveedor_Proveedor1`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `bddpautas`.`proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_Proveedor_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `bddpautas`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `bddpautas` ;

-- -----------------------------------------------------
-- Placeholder table for view `bddpautas`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`clientes` (`idCliente` INT, `nombre` INT, `direccion` INT, `contacto` INT, `mail` INT, `rfc` INT, `telefono` INT, `idUser` INT, `numPautas` INT);

-- -----------------------------------------------------
-- Placeholder table for view `bddpautas`.`countpautas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`countpautas` (`idCliente` INT, `numPautas` INT);

-- -----------------------------------------------------
-- Placeholder table for view `bddpautas`.`proveedores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`proveedores` (`idProveedor` INT, `nombre` INT, `telefono` INT, `direccion` INT, `comision` INT, `iduser` INT);

-- -----------------------------------------------------
-- Placeholder table for view `bddpautas`.`radios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`radios` (`estacion` INT, `frecuencia` INT, `idRadio` INT, `siglas` INT, `iduser` INT, `idProveedor` INT);

-- -----------------------------------------------------
-- View `bddpautas`.`clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bddpautas`.`clientes`;
USE `bddpautas`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bddpautas`.`clientes` AS select `c`.`idCliente` AS `idCliente`,`c`.`nombre` AS `nombre`,`c`.`direccion` AS `direccion`,`c`.`contacto` AS `contacto`,`c`.`mail` AS `mail`,`c`.`rfc` AS `rfc`,`c`.`telefono` AS `telefono`,`u`.`iduser` AS `idUser`,`cp`.`numPautas` AS `numPautas` from (((`bddpautas`.`cliente` `c` join `bddpautas`.`user` `u`) join `bddpautas`.`user_has_cliente` `uc`) join `bddpautas`.`countpautas` `cp`) where ((`c`.`idCliente` like `uc`.`Cliente_idCliente`) and (`u`.`iduser` like `uc`.`user_iduser`) and (`c`.`idCliente` like `cp`.`idCliente`));

-- -----------------------------------------------------
-- View `bddpautas`.`countpautas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bddpautas`.`countpautas`;
USE `bddpautas`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bddpautas`.`countpautas` AS select `c`.`idCliente` AS `idCliente`,count(`p`.`idPauta`) AS `numPautas` from (`bddpautas`.`cliente` `c` left join `bddpautas`.`pauta` `p` on((`p`.`Cliente_idCliente` like `c`.`idCliente`))) group by `c`.`idCliente`;

-- -----------------------------------------------------
-- View `bddpautas`.`proveedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bddpautas`.`proveedores`;
USE `bddpautas`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bddpautas`.`proveedores` AS select `p`.`idProveedor` AS `idProveedor`,`p`.`nombre` AS `nombre`,`p`.`telefono` AS `telefono`,`p`.`direccion` AS `direccion`,`p`.`comision` AS `comision`,`u`.`iduser` AS `iduser` from ((`bddpautas`.`proveedor` `p` join `bddpautas`.`user` `u`) join `bddpautas`.`user_has_proveedor` `up`) where ((`u`.`iduser` like `up`.`user_iduser`) and (`p`.`idProveedor` like `up`.`Proveedor_idProveedor`));

-- -----------------------------------------------------
-- View `bddpautas`.`radios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bddpautas`.`radios`;
USE `bddpautas`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bddpautas`.`radios` AS select `r`.`estacion` AS `estacion`,`r`.`frecuencia` AS `frecuencia`,`r`.`idRadio` AS `idRadio`,`r`.`siglas` AS `siglas`,`p`.`iduser` AS `iduser`,`p`.`idProveedor` AS `idProveedor` from (`bddpautas`.`proveedores` `p` join `bddpautas`.`radio` `r`) where (`p`.`idProveedor` = `r`.`Proveedor_idProveedor`);
CREATE USER 'webuser';

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `bddpautas`.* TO 'webuser';
GRANT SELECT, INSERT, TRIGGER ON TABLE `bddpautas`.* TO 'webuser';
GRANT SELECT ON TABLE `bddpautas`.* TO 'webuser';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
