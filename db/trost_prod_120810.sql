SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `trost_prod` DEFAULT CHARACTER SET latin1 ;
USE `trost_prod` ;

-- -----------------------------------------------------
-- Table `trost_prod`.`aliquots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`aliquots` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `aliquot` INT(11) NULL DEFAULT NULL ,
  `plantid` INT(11) NULL DEFAULT NULL ,
  `sample_date` DATE NULL DEFAULT NULL ,
  `amount` INT(11) NULL DEFAULT NULL ,
  `amount_unit` VARCHAR(20) NULL DEFAULT NULL ,
  `organ` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 13475
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`species`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`species` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`bbches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`bbches` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `bbch` INT(11) NULL DEFAULT NULL ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `species_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `unique_bbch_id` (`bbch` ASC, `species_id` ASC) ,
  INDEX `fk_bbchs_species1` (`species_id` ASC) ,
  CONSTRAINT `fk_bbchs_species1`
    FOREIGN KEY (`species_id` )
    REFERENCES `trost_prod`.`species` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 103
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`cultures`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`cultures` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `limsstudyid` INT(11) NULL DEFAULT NULL ,
  `condition` VARCHAR(45) NULL DEFAULT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `experiment_id` INT(11) NULL DEFAULT NULL ,
  `plantspparcelle` INT(11) NULL DEFAULT NULL ,
  `location_id` INT(11) NULL DEFAULT NULL ,
  `planted` DATE NULL DEFAULT NULL ,
  `terminated` DATE NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`entities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`entities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `PO` VARCHAR(45) NULL DEFAULT NULL ,
  `definition` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 810
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`experiments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`experiments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `startdate` DATE NULL DEFAULT NULL ,
  `project` VARCHAR(45) NULL DEFAULT NULL ,
  `study` VARCHAR(45) NULL DEFAULT NULL ,
  `protocol` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`i18n`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`i18n` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `locale` VARCHAR(6) NOT NULL ,
  `model` VARCHAR(255) NOT NULL ,
  `foreign_key` INT(10) NOT NULL ,
  `field` VARCHAR(255) NOT NULL ,
  `content` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `locale` (`locale` ASC) ,
  INDEX `model` (`model` ASC) ,
  INDEX `row_id` (`foreign_key` ASC) ,
  INDEX `field` (`field` ASC) )
ENGINE = MyISAM
AUTO_INCREMENT = 2415
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`irrigation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`irrigation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `date` DATE NULL DEFAULT NULL ,
  `treatment_id` INT(11) NULL DEFAULT NULL ,
  `location_id` INT(11) NULL DEFAULT NULL ,
  `value` FLOAT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 579
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`keywords`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`keywords` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 50
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`locations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`locations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `limsid` INT(11) NULL DEFAULT NULL ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `elevation` FLOAT NULL DEFAULT NULL ,
  `gridref_north` FLOAT NULL DEFAULT NULL ,
  `gridref_east` FLOAT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`people`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`people` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `location_id` INT(11) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `role` VARCHAR(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_people_locations1` (`location_id` ASC) ,
  CONSTRAINT `fk_people_locations1`
    FOREIGN KEY (`location_id` )
    REFERENCES `trost_prod`.`locations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 131
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`programs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`programs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`phenotypes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`phenotypes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `version` VARCHAR(45) NULL DEFAULT NULL ,
  `object` VARCHAR(45) NULL DEFAULT NULL ,
  `program_id` INT(11) NOT NULL ,
  `date` DATE NOT NULL ,
  `time` TIME NOT NULL ,
  `sample_id` INT(11) NOT NULL ,
  `invalid` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotypes_programs1` (`program_id` ASC) ,
  INDEX `fk_phenotypes_samples1` (`sample_id` ASC) ,
  CONSTRAINT `fk_phenotypes_programs1`
    FOREIGN KEY (`program_id` )
    REFERENCES `trost_prod`.`programs` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 227184
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`phenotype_bbches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`phenotype_bbches` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT(11) NOT NULL ,
  `bbch_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_bbchs_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_bbchs_bbchs1` (`bbch_id` ASC) ,
  CONSTRAINT `fk_phenotype_bbchs_bbchs1`
    FOREIGN KEY (`bbch_id` )
    REFERENCES `trost_prod`.`bbches` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_bbchs_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost_prod`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 29074
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`phenotype_entities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`phenotype_entities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT(11) NOT NULL ,
  `entity_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_entities_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_entities_entities1` (`entity_id` ASC) ,
  CONSTRAINT `fk_phenotype_entities_entities1`
    FOREIGN KEY (`entity_id` )
    REFERENCES `trost_prod`.`entities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_entities_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost_prod`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 193471
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`raws`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`raws` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `data` BLOB NOT NULL ,
  `filename` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1129
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`phenotype_raws`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`phenotype_raws` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `phenotype_id` INT(11) NOT NULL ,
  `raw_id` INT(11) NOT NULL ,
  `line_nr` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_raws_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_raws_raws1` (`raw_id` ASC) ,
  CONSTRAINT `fk_phenotype_raws_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost_prod`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_raws_raws1`
    FOREIGN KEY (`raw_id` )
    REFERENCES `trost_prod`.`raws` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 222578
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`values` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `attribute` VARCHAR(45) NOT NULL ,
  `value` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 228
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`phenotype_values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`phenotype_values` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `value_id` INT(11) NOT NULL ,
  `phenotype_id` INT(11) NOT NULL ,
  `number` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phenotype_attributes_phenotypes1` (`phenotype_id` ASC) ,
  INDEX `fk_phenotype_values_values1` (`value_id` ASC) ,
  CONSTRAINT `fk_phenotype_attributes_phenotypes1`
    FOREIGN KEY (`phenotype_id` )
    REFERENCES `trost_prod`.`phenotypes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_values_values1`
    FOREIGN KEY (`value_id` )
    REFERENCES `trost_prod`.`values` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 198065
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`plants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`plants` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `aliquot` INT(11) NOT NULL ,
  `culture_id` INT(11) NOT NULL ,
  `subspecies_id` INT(11) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `lineid` INT(11) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_plants_cultures1` (`culture_id` ASC) ,
  INDEX `aliquot` (`aliquot` ASC) ,
  CONSTRAINT `fk_plants_cultures1`
    FOREIGN KEY (`culture_id` )
    REFERENCES `trost_prod`.`cultures` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 18749
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`samples`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`samples` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `plant_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_samples_plants1` (`plant_id` ASC) ,
  CONSTRAINT `fk_samples_plants1`
    FOREIGN KEY (`plant_id` )
    REFERENCES `trost_prod`.`plants` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 50861
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`starch_yield`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`starch_yield` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `aliquotid` INT(11) NOT NULL ,
  `parzellennr` INT(11) NULL DEFAULT NULL ,
  `location_id` INT(11) NOT NULL ,
  `cultivar` VARCHAR(45) NULL DEFAULT NULL ,
  `pflanzen_parzelle` INT(11) NULL DEFAULT NULL ,
  `knollenmasse_kgfw_parzelle` DOUBLE NOT NULL ,
  `staerkegehalt_g_kg` DOUBLE NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1765
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`subspecies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`subspecies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `limsid` INT(11) NULL DEFAULT NULL ,
  `species_id` INT(11) NULL DEFAULT NULL ,
  `cultivar` VARCHAR(45) NULL DEFAULT NULL ,
  `breeder` VARCHAR(45) NULL DEFAULT NULL ,
  `reifegruppe` VARCHAR(10) NULL DEFAULT NULL ,
  `reifegrclass` INT(11) NULL DEFAULT NULL ,
  `krautfl` INT(11) NULL DEFAULT NULL ,
  `verwendung` VARCHAR(10) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 39
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`temps`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`temps` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `datum` DATE NOT NULL ,
  `precipitation` FLOAT NULL DEFAULT NULL ,
  `irrigation` FLOAT NULL DEFAULT NULL ,
  `tmin` FLOAT NULL DEFAULT NULL ,
  `tmax` FLOAT NULL DEFAULT NULL ,
  `location_id` INT(11) NOT NULL ,
  `invalid` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_temps_locations1` (`location_id` ASC) ,
  CONSTRAINT `fk_temps_locations1`
    FOREIGN KEY (`location_id` )
    REFERENCES `trost_prod`.`locations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3007
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`treatments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`treatments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `aliquotid` INT(11) NOT NULL ,
  `alias` VARCHAR(45) NULL DEFAULT NULL ,
  `value_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2300
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`ufiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`ufiles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `person_id` INT(11) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `description` VARCHAR(45) NULL DEFAULT NULL ,
  `invalid` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ufiles_people1` (`person_id` ASC) ,
  CONSTRAINT `fk_ufiles_people1`
    FOREIGN KEY (`person_id` )
    REFERENCES `trost_prod`.`people` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 81
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `trost_prod`.`ufilekeywords`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `trost_prod`.`ufilekeywords` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ufile_id` INT(11) NOT NULL ,
  `keyword_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ufilekeywords_1` (`ufile_id` ASC) ,
  INDEX `fk_ufilekeywords_2` (`keyword_id` ASC) ,
  CONSTRAINT `fk_ufilekeywords_1`
    FOREIGN KEY (`ufile_id` )
    REFERENCES `trost_prod`.`ufiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ufilekeywords_2`
    FOREIGN KEY (`keyword_id` )
    REFERENCES `trost_prod`.`keywords` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 230
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
