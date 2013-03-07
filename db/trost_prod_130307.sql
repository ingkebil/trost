-- Adminer 3.0.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `aliquot_plants`;
CREATE TABLE `aliquot_plants` (
  `aliquot_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  PRIMARY KEY (`aliquot_id`,`plant_id`),
  KEY `plant_id` (`plant_id`),
  CONSTRAINT `aliquot_plants_ibfk_1` FOREIGN KEY (`aliquot_id`) REFERENCES `aliquots` (`id`),
  CONSTRAINT `aliquot_plants_ibfk_2` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `aliquots`;
CREATE TABLE `aliquots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_date` date DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `amount_unit` varchar(20) DEFAULT NULL,
  `organ` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1353041 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bbches`;
CREATE TABLE `bbches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `species_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bbchs_species1` (`species_id`),
  CONSTRAINT `fk_bbchs_species1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cultures`;
CREATE TABLE `cultures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `condition` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `experiment_id` int(11) DEFAULT NULL,
  `plantspparcelle` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `planted` date DEFAULT NULL,
  `terminated` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cultures_experiments1` (`experiment_id`),
  KEY `fk_cultures_locations1` (`location_id`),
  CONSTRAINT `fk_cultures_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cultures_experiments1` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=60320 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dead_plants`;
CREATE TABLE `dead_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `culture_id` int(11) NOT NULL,
  `subspecies_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lineid` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_dead_plants_cultures1` (`culture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1173778 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `entities`;
CREATE TABLE `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `PO` varchar(45) DEFAULT NULL,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=811 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `experiments`;
CREATE TABLE `experiments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `project` varchar(45) DEFAULT NULL,
  `study` varchar(45) DEFAULT NULL,
  `protocol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `i18n`;
CREATE TABLE `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=2420 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `id_dummy`;
CREATE TABLE `id_dummy` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `irrigation`;
CREATE TABLE `irrigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `treatment_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `value` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=579 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `live_plants`;
CREATE TABLE `live_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `culture_id` int(11) NOT NULL,
  `subspecies_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lineid` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_live_plants_cultures1` (`culture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1282773 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `elevation` float DEFAULT NULL,
  `gridref_north` float DEFAULT NULL,
  `gridref_east` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6021 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `location_id` int(11) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_people_locations1` (`location_id`),
  CONSTRAINT `fk_people_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pheno_dummy`;
CREATE TABLE `pheno_dummy` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `plant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `phenotype_aliquots`;
CREATE TABLE `phenotype_aliquots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aliquot_id` int(11) NOT NULL,
  `phenotype_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotype_aliquots_aliquots1` (`aliquot_id`),
  KEY `fk_phenotype_aliquots_phenotypes1` (`phenotype_id`),
  CONSTRAINT `fk_phenotype_aliquots_aliquots1` FOREIGN KEY (`aliquot_id`) REFERENCES `aliquots` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_aliquots_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3653 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `phenotype_bbches`;
CREATE TABLE `phenotype_bbches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phenotype_id` int(11) NOT NULL,
  `bbch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotype_bbchs_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_bbchs_bbchs1` (`bbch_id`),
  CONSTRAINT `fk_phenotype_bbchs_bbchs1` FOREIGN KEY (`bbch_id`) REFERENCES `bbches` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_bbchs_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5214 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_plants`;
CREATE TABLE `phenotype_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) NOT NULL,
  `phenotype_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotype_plants_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_plants_plants1` (`plant_id`),
  CONSTRAINT `fk_phenotype_plants_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_plants_plants1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42544 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_raws`;
CREATE TABLE `phenotype_raws` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phenotype_id` int(11) NOT NULL,
  `raw_id` int(11) NOT NULL,
  `line_nr` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotype_raws_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_raws_raws1` (`raw_id`),
  CONSTRAINT `fk_phenotype_raws_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_raws_raws1` FOREIGN KEY (`raw_id`) REFERENCES `raws` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37296 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_samples`;
CREATE TABLE `phenotype_samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `phenotype_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotype_samples_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_samples_samples1` (`sample_id`),
  CONSTRAINT `fk_phenotype_samples_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_samples_samples1` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23288 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotypes`;
CREATE TABLE `phenotypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(45) DEFAULT NULL,
  `object` varchar(45) DEFAULT NULL,
  `program_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `invalid` tinyint(4) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `value_id` int(11) DEFAULT NULL,
  `number` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phenotypes_programs1` (`program_id`),
  KEY `fk_phenotypes_entities1` (`entity_id`),
  KEY `fk_phenotypes_values1` (`value_id`),
  CONSTRAINT `fk_phenotypes_entities1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotypes_programs1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotypes_values1` FOREIGN KEY (`value_id`) REFERENCES `values` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=69346 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `plants`;
CREATE TABLE `plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `culture_id` int(11) NOT NULL,
  `subspecies_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lineid` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_plants_cultures1` (`culture_id`),
  CONSTRAINT `fk_plants_cultures1` FOREIGN KEY (`culture_id`) REFERENCES `cultures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1350126 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `programs`;
CREATE TABLE `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=667 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pw_codes`;
CREATE TABLE `pw_codes` (
  `person_id` int(11) NOT NULL,
  `code` char(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `raws`;
CREATE TABLE `raws` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longblob NOT NULL,
  `filename` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sample_plants`;
CREATE TABLE `sample_plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sample_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sample_plants_samples1` (`sample_id`),
  KEY `fk_sample_plants_plants1` (`plant_id`),
  CONSTRAINT `fk_sample_plants_plants1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sample_plants_samples1` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56649 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `samples`;
CREATE TABLE `samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=895707 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `shirt`;
CREATE TABLE `shirt` (
  `item` char(20) COLLATE latin1_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;


DROP TABLE IF EXISTS `species`;
CREATE TABLE `species` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `starch_yield`;
CREATE TABLE `starch_yield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `aliquotid` int(11) NOT NULL,
  `parzellennr` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `cultivar` varchar(45) DEFAULT NULL,
  `pflanzen_parzelle` int(11) DEFAULT NULL,
  `knollenmasse_kgfw_parzelle` double NOT NULL,
  `staerkegehalt_g_kg` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1765 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `subspecies`;
CREATE TABLE `subspecies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species_id` int(11) DEFAULT NULL,
  `cultivar` varchar(45) DEFAULT NULL,
  `breeder` varchar(45) DEFAULT NULL,
  `reifegruppe` varchar(10) DEFAULT NULL,
  `reifegrclass` int(11) DEFAULT NULL,
  `krautfl` int(11) DEFAULT NULL,
  `verwendung` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subspecies_species1` (`species_id`),
  CONSTRAINT `fk_subspecies_species1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2883 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `temps`;
CREATE TABLE `temps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `precipitation` float DEFAULT NULL,
  `irrigation` float DEFAULT NULL,
  `tmin` float DEFAULT NULL,
  `tmax` float DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `invalid` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_temps_locations1` (`location_id`),
  CONSTRAINT `fk_temps_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4952 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `treatments`;
CREATE TABLE `treatments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `aliquotid` int(11) NOT NULL,
  `alias` varchar(45) DEFAULT NULL,
  `value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2300 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ufilekeywords`;
CREATE TABLE `ufilekeywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ufile_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ufilekeywords_1` (`ufile_id`),
  KEY `fk_ufilekeywords_2` (`keyword_id`),
  CONSTRAINT `fk_ufilekeywords_1` FOREIGN KEY (`ufile_id`) REFERENCES `ufiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ufilekeywords_2` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=455 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ufiles`;
CREATE TABLE `ufiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `invalid` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ufiles_people1` (`person_id`),
  CONSTRAINT `fk_ufiles_people1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ufiletemps`;
CREATE TABLE `ufiletemps` (
  `ufile_id` int(11) NOT NULL,
  `temp_id` int(11) NOT NULL,
  PRIMARY KEY (`ufile_id`,`temp_id`),
  KEY `temp_id` (`temp_id`),
  CONSTRAINT `ufiletemps_ibfk_1` FOREIGN KEY (`ufile_id`) REFERENCES `ufiles` (`id`),
  CONSTRAINT `ufiletemps_ibfk_2` FOREIGN KEY (`temp_id`) REFERENCES `temps` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `values`;
CREATE TABLE `values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;


