SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `trost` DEFAULT CHARACTER SET utf8 ;
USE `trost` ;

-- -----------------------------------------------------
-- Table `trost`.`experiments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`experiments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `startdate` DATE NULL ,
  `project` VARCHAR(45) NULL ,
  `study` VARCHAR(45) NULL ,
  `protocol` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`cultures`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`cultures` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `condition` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `description` TEXT NULL ,
  `experiment_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cultures_experiments` (`experiment_id` ASC) ,
  CONSTRAINT `fk_cultures_experiments`
    FOREIGN KEY (`experiment_id` )
    REFERENCES `trost`.`experiments` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`samples`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`samples` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `supplier` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `created_by` VARCHAR(45) NULL ,
  `mag` VARCHAR(45) NULL ,
  `alias` VARCHAR(45) NULL ,
  `description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`plants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`plants` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `aliquot` VARCHAR(45) NULL ,
  `culture_id` INT NOT NULL ,
  `created` DATETIME NULL ,
  `sample_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_plants_cultures1` (`culture_id` ASC) ,
  INDEX `fk_plants_samples1` (`sample_id` ASC) ,
  CONSTRAINT `fk_plants_cultures1`
    FOREIGN KEY (`culture_id` )
    REFERENCES `trost`.`cultures` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_plants_samples1`
    FOREIGN KEY (`sample_id` )
    REFERENCES `trost`.`samples` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`species`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`species` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`bbches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`bbches` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `bbch` INT NULL ,
  `name` VARCHAR(45) NULL ,
  `species_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_bbchs_species1` (`species_id` ASC) ,
  CONSTRAINT `fk_bbchs_species1`
    FOREIGN KEY (`species_id` )
    REFERENCES `trost`.`species` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`entities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`entities` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `PO` VARCHAR(45) NULL ,
  `definition` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`values` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `attribute` VARCHAR(45) NOT NULL ,
  `value` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`programs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`programs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`phenotypes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`phenotypes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `version` VARCHAR(45) NULL ,
  `object` VARCHAR(45) NULL ,
  `program_id` INT NOT NULL ,
  `date` DATE NULL ,
  `time` TIME NULL ,
  `plant_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotypes_plants1` (`plant_id` ASC) ,
  INDEX `fk_phenotypes_programs1` (`program_id` ASC) ,
  CONSTRAINT `fk_phenotypes_plants1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `trost`.`plants` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotypes_programs1`
    FOREIGN KEY (`program_id` )
    REFERENCES `trost`.`programs` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`phenotype_entities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`phenotype_entities` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT NOT NULL ,
  `entity_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_entities_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_entities_entities1` (`entity_id` ASC) ,
  CONSTRAINT `fk_phenotype_entities_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_entities_entities1`
    FOREIGN KEY (`entity_id` )
    REFERENCES `trost`.`entities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`phenotype_values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`phenotype_values` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `value_id` INT NOT NULL ,
  `phenotype_id` INT NOT NULL ,
  `number` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_attributes_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_values_values1` (`value_id` ASC) ,
  CONSTRAINT `fk_phenotype_attributes_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_values_values1`
    FOREIGN KEY (`value_id` )
    REFERENCES `trost`.`values` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`phenotype_bbches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`phenotype_bbches` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT NOT NULL ,
  `bbch_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_bbchs_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_bbchs_bbchs1` (`bbch_id` ASC) ,
  CONSTRAINT `fk_phenotype_bbchs_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_bbchs_bbchs1`
    FOREIGN KEY (`bbch_id` )
    REFERENCES `trost`.`bbches` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`raws`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`raws` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` BLOB NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `trost`.`phenotype_raws`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost`.`phenotype_raws` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT NOT NULL ,
  `raw_id` INT NOT NULL ,
  `line_nr` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_raws_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_raws_raws1` (`raw_id` ASC) ,
  CONSTRAINT `fk_phenotype_raws_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_raws_raws1`
    FOREIGN KEY (`raw_id` )
    REFERENCES `trost`.`raws` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
