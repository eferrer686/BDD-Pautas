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
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `invTotal` VARCHAR(45) NULL DEFAULT 0,
  `tipo` VARCHAR(45) NULL,
  `presupuesto` VARCHAR(45) NULL DEFAULT 0,
  `universo` VARCHAR(45) NULL DEFAULT '1',
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
-- Table `bddpautas`.`television`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`television` (
  `idTelevision` INT(11) NOT NULL AUTO_INCREMENT,
  `Proveedor_idProveedor` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `canal` VARCHAR(45) NULL,
  `siglas` VARCHAR(45) NULL,
  `ciudad` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
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
-- Table `bddpautas`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`estado` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(45) NULL,
  `user_iduser` INT(11) NOT NULL,
  PRIMARY KEY (`idEstado`, `user_iduser`),
  INDEX `fk_estado_user1_idx` (`user_iduser` ASC),
  CONSTRAINT `fk_estado_user1`
    FOREIGN KEY (`user_iduser`)
    REFERENCES `bddpautas`.`user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bddpautas`.`ciudad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`ciudad` (
  `idciudad` INT NOT NULL AUTO_INCREMENT,
  `ciudad` VARCHAR(45) NULL,
  `estado_idestado` INT NOT NULL,
  PRIMARY KEY (`idciudad`),
  INDEX `fk_ciudad_estado1_idx` (`estado_idestado` ASC),
  CONSTRAINT `fk_ciudad_estado1`
    FOREIGN KEY (`estado_idestado`)
    REFERENCES `bddpautas`.`estado` (`idEstado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bddpautas`.`radio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`radio` (
  `idRadio` INT(11) NOT NULL AUTO_INCREMENT,
  `Proveedor_idProveedor` INT(11) NOT NULL,
  `estacion` VARCHAR(45) NULL DEFAULT NULL,
  `frecuencia` VARCHAR(45) NULL DEFAULT NULL,
  `siglas` VARCHAR(45) NULL DEFAULT NULL,
  `ciudad_idciudad` INT NOT NULL,
  PRIMARY KEY (`idRadio`),
  INDEX `fk_Radio_Proveedor_idx` (`Proveedor_idProveedor` ASC),
  INDEX `fk_radio_ciudad1_idx` (`ciudad_idciudad` ASC),
  CONSTRAINT `fk_Radio_Proveedor`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `bddpautas`.`proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_radio_ciudad1`
    FOREIGN KEY (`ciudad_idciudad`)
    REFERENCES `bddpautas`.`ciudad` (`idciudad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`tarifaRadio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`tarifaRadio` (
  `idTarifa` INT(11) NOT NULL AUTO_INCREMENT,
  `Radio_idRadio` INT(11) NOT NULL,
  `duracion` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaGeneral` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaEspecifica` VARCHAR(45) NULL DEFAULT NULL,
  `descuento` VARCHAR(45) NULL DEFAULT NULL,
  `horaInicio` TIME NULL DEFAULT NULL,
  `horaFin` TIME NULL DEFAULT NULL,
  PRIMARY KEY (`idTarifa`),
  INDEX `fk_ServicioRadio_Radio1_idx` (`Radio_idRadio` ASC),
  CONSTRAINT `fk_ServicioRadio_Radio1`
    FOREIGN KEY (`Radio_idRadio`)
    REFERENCES `bddpautas`.`radio` (`idRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bddpautas`.`pautaRadio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`pautaRadio` (
  `idPautaRadio` INT NOT NULL AUTO_INCREMENT,
  `pauta_idPauta` INT(11) NOT NULL,
  `radio_idRadio` INT(11) NOT NULL,
  `rating` VARCHAR(45) NULL DEFAULT 0,
  INDEX `fk_renglonPauta_pauta1_idx` (`pauta_idPauta` ASC),
  INDEX `fk_renglonPauta_radio1_idx` (`radio_idRadio` ASC),
  PRIMARY KEY (`idPautaRadio`),
  CONSTRAINT `fk_renglonPauta_pauta1`
    FOREIGN KEY (`pauta_idPauta`)
    REFERENCES `bddpautas`.`pauta` (`idPauta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_renglonPauta_radio1`
    FOREIGN KEY (`radio_idRadio`)
    REFERENCES `bddpautas`.`radio` (`idRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bddpautas`.`spot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`spot` (
  `idSpot` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `cantidad` VARCHAR(45) NULL DEFAULT NULL,
  `renglonPauta_idRenglonPauta` INT NOT NULL,
  `tarifaRadio_idTarifa` INT(11) NOT NULL,
  PRIMARY KEY (`idSpot`),
  INDEX `fk_spot_renglonPauta1_idx` (`renglonPauta_idRenglonPauta` ASC),
  INDEX `fk_spot_tarifaRadio1_idx` (`tarifaRadio_idTarifa` ASC),
  CONSTRAINT `fk_spot_renglonPauta1`
    FOREIGN KEY (`renglonPauta_idRenglonPauta`)
    REFERENCES `bddpautas`.`pautaRadio` (`idPautaRadio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_spot_tarifaRadio1`
    FOREIGN KEY (`tarifaRadio_idTarifa`)
    REFERENCES `bddpautas`.`tarifaRadio` (`idTarifa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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


-- -----------------------------------------------------
-- Table `bddpautas`.`tarifaTelevision`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bddpautas`.`tarifaTelevision` (
  `idTarifa` INT(11) NOT NULL AUTO_INCREMENT,
  `duracion` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaGeneral` VARCHAR(45) NULL DEFAULT NULL,
  `tarifaEspecifica` VARCHAR(45) NULL DEFAULT NULL,
  `descuento` VARCHAR(45) NULL DEFAULT NULL,
  `horaInicio` TIME NULL DEFAULT NULL,
  `horaFin` TIME NULL DEFAULT NULL,
  `programa` VARCHAR(45) NULL,
  `television_idTelevision` INT(11) NOT NULL,
  PRIMARY KEY (`idTarifa`),
  INDEX `fk_tarifaTelevision_television1_idx` (`television_idTelevision` ASC),
  CONSTRAINT `fk_tarifaTelevision_television1`
    FOREIGN KEY (`television_idTelevision`)
    REFERENCES `bddpautas`.`television` (`idTelevision`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE USER 'webuser';

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `bddpautas`.* TO 'webuser';
GRANT SELECT, INSERT, TRIGGER ON TABLE `bddpautas`.* TO 'webuser';
GRANT SELECT ON TABLE `bddpautas`.* TO 'webuser';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- View `bddpautas`.`proveedores`
-- -----------------------------------------------------

CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bddpautas`.`proveedores` AS
    SELECT
        `p`.`idProveedor` AS `idProveedor`,
        `p`.`nombre` AS `nombre`,
        `p`.`telefono` AS `telefono`,
        `p`.`direccion` AS `direccion`,
        `p`.`comision` AS `comision`,
        `u`.`iduser` AS `iduser`
    FROM
        ((`bddpautas`.`proveedor` `p`
        JOIN `bddpautas`.`user` `u`)
        JOIN `bddpautas`.`user_has_proveedor` `up`)
    WHERE
        ((`u`.`iduser` LIKE `up`.`user_iduser`)
            AND (`p`.`idProveedor` LIKE `up`.`Proveedor_idProveedor`));

-- -----------------------------------------------------
-- View `bddpautas`.`radios`
-- -----------------------------------------------------
CREATE VIEW `bddpautas`.`radios` AS
   SELECT
    idRadio,
    idestado,
    idciudad,
    iduser,
    idProveedor,
    nombre,
    estacion,
    frecuencia,
    siglas,
    estado,
    ciudad,
    comision
FROM
    proveedores AS p
        JOIN
    radio AS r
        JOIN
    estado AS e
        JOIN
    ciudad AS c
WHERE
    p.idProveedor = r.Proveedor_idProveedor
        AND r.ciudad_idciudad = c.idciudad
        AND c.estado_idestado = e.idestado
        AND e.idestado = c.estado_idestado;
-- -----------------------------------------------------
-- View `bddpautas`.`tarifasRadio`
-- -----------------------------------------------------
CREATE VIEW `tarifasRadio` AS
   SELECT
        r.idRadio,
        s.idTarifa,
        s.duracion,
        s.tarifaGeneral,
        s.tarifaEspecifica,
        s.descuento,
        TIME_FORMAT(s.horaInicio, '%H:%i') AS horaInicio,
        TIME_FORMAT(s.horaFin, '%H:%i') AS horaFin,
        r.iduser
    FROM
        radios AS r
            JOIN
        tarifaRadio AS s
    WHERE
        r.idRadio = s.Radio_idRadio;
-- -----------------------------------------------------
-- View `bddpautas`.`televisiones`
-- -----------------------------------------------------
CREATE VIEW `televisiones` AS
    SELECT
        p.iduser,
        t.canal,
        t.ciudad,
        t.estado,
        t.nombre,
        t.siglas,
        t.idTelevision,
        p.idProveedor
    FROM
        proveedores as p
        JOIN  television as t
    WHERE
        p.idProveedor = t.Proveedor_idProveedor;
-- -----------------------------------------------------
-- View `bddpautas`.`tarifasTelevision`
-- -----------------------------------------------------
CREATE VIEW `tarifasTelevision` AS
  SELECT
        r.idTelevision,
        s.idTarifa,
        s.duracion,
        s.tarifaGeneral,
        s.tarifaEspecifica,
        s.descuento,
        s.programa,
        TIME_FORMAT(s.horaInicio, '%H:%i') AS horaInicio,
        TIME_FORMAT(s.horaFin, '%H:%i') AS horaFin,
        r.iduser
    FROM
        televisiones AS r
            JOIN
        tarifaTelevision AS s
    WHERE
        r.idTelevision = s.television_idTelevision;

-- -----------------------------------------------------
-- View `bddpautas`.`estados`
-- -----------------------------------------------------
CREATE VIEW `estados` AS
  SELECT
      e.idestado, e.estado, e.user_iduser AS idUser
  FROM
      estado AS e;

-- -----------------------------------------------------
-- View `bddpautas`.`ciudades`
-- -----------------------------------------------------

CREATE VIEW `ciudades` AS
  SELECT
      e.idestado,
      e.estado,
      c.idciudad,
      c.ciudad,
      e.user_iduser AS idUser
  FROM
      estado AS e
          JOIN
      ciudad AS c
  WHERE
      e.idEstado = c.estado_idestado;

-- -----------------------------------------------------
-- View `bddpautas`.`countpautas`
-- -----------------------------------------------------
CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bddpautas`.`countpautas` AS
    SELECT
        `c`.`idCliente` AS `idCliente`,
        COUNT(`p`.`idPauta`) AS `numPautas`
    FROM
        (`bddpautas`.`cliente` `c`
        LEFT JOIN `bddpautas`.`pauta` `p` ON ((`p`.`Cliente_idCliente` LIKE `c`.`idCliente`)))
    GROUP BY `c`.`idCliente`;

-- -----------------------------------------------------
-- View `bddpautas`.`clientes`
-- -----------------------------------------------------
CREATE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bddpautas`.`clientes` AS
    SELECT
        `c`.`idCliente` AS `idCliente`,
        `c`.`nombre` AS `nombre`,
        `c`.`direccion` AS `direccion`,
        `c`.`contacto` AS `contacto`,
        `c`.`mail` AS `mail`,
        `c`.`rfc` AS `rfc`,
        `c`.`telefono` AS `telefono`,
        `u`.`iduser` AS `idUser`,
        `cp`.`numPautas` AS `numPautas`
    FROM
        (((`bddpautas`.`cliente` `c`
        JOIN `bddpautas`.`user` `u`)
        JOIN `bddpautas`.`user_has_cliente` `uc`)
        JOIN `bddpautas`.`countpautas` `cp`)
    WHERE
        ((`c`.`idCliente` LIKE `uc`.`Cliente_idCliente`)
            AND (`u`.`iduser` LIKE `uc`.`user_iduser`)
            AND (`c`.`idCliente` LIKE `cp`.`idCliente`));

-- -----------------------------------------------------
-- View `bddpautas`.`pautas`
-- -----------------------------------------------------
CREATE VIEW `pautas` AS
    SELECT
        p.idPauta,
        p.nombre,
        c.idUser,
        p.tipo,
        p.invTotal,
        p.presupuesto,
        p.Cliente_idCliente
    FROM
        clientes AS c
            JOIN
        pauta AS p
    WHERE
        c.idCliente = p.Cliente_idCliente;

-- -----------------------------------------------------
-- View `bddpautas`.`pautasRadio`
-- -----------------------------------------------------
CREATE OR REPLACE VIEW `pautasRadio` AS
    SELECT
        p.idPauta AS idPauta,
        p.idUser,
        p.nombre,
        p.presupuesto,
        p.invTotal,
        r.idRadio,
        r.estacion,
        r.frecuencia,
        r.idestado,
        r.idciudad,
        r.siglas,
        pr.idPautaRadio
    FROM
        pautas AS p
            JOIN
        pautaRadio AS pr
            JOIN
        radios AS r
    WHERE
        p.idPauta = pr.Pauta_idPauta
            AND pr.Radio_idRadio = r.idRadio;

-- -----------------------------------------------------
-- View `bddpautas`.`pautasRadioIdPautas`
-- -----------------------------------------------------
CREATE VIEW `pautasRadioIdPautas` AS
    SELECT DISTINCT
        idPauta,
        idUser
    FROM
        pautasRadio;

-- -----------------------------------------------------
-- View `bddpautas`.`spotsRadio`
-- -----------------------------------------------------
CREATE VIEW `spotsRadio` AS
    SELECT
        s.idSpot,
        p.idPautaRadio,
        p.pauta_idPauta as idPauta,
        p.radio_idRadio as idRadio,
        p.rating,
        tarifaRadio_idTarifa AS idTarifa,
        fecha,
        hora,
        cantidad,
        duracion,
        tarifaGeneral,
        tarifaEspecifica,
        descuento
    FROM
        pautaradio AS p
            JOIN
        spot AS s
            JOIN
        tarifasradio AS t
    WHERE
        p.idPautaRadio = s.renglonPauta_idRenglonPauta
            AND s.tarifaRadio_idTarifa = t.idTarifa
;

-- -----------------------------------------------------
-- View `bddpautas`.`spotsRadio`
-- -----------------------------------------------------
CREATE VIEW `tarifasPautasRadio` AS

SELECT
iduser,
idPautaRadio,
pauta_idPauta as idPauta,
idRadio,
Proveedor_idProveedor as idProveedor,
ciudad_idciudad as idCiudad,
idTarifa,
estacion,
frecuencia,
siglas,
duracion,
tarifaGeneral,
tarifaEspecifica,
descuento,
horaInicio,
horaFin
FROM
pautas as pa
join
pautaRadio p
  JOIN
radio AS r
  JOIN
tarifaradio AS tr
WHERE
pa.idPauta = p.pauta_idPauta
and p.radio_idRadio = r.idRadio
  AND r.idRadio = tr.Radio_idRadio;
