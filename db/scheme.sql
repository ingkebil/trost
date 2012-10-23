-- Adminer 3.0.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `aliquots`;
CREATE TABLE `aliquots` (
  `id` int(11) NOT NULL auto_increment,
  `aliquot` int(11) default NULL,
  `plantid` int(11) default NULL,
  `sample_date` date default NULL,
  `amount` int(11) default NULL,
  `amount_unit` varchar(20) default NULL,
  `organ` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13475 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bbches`;
CREATE TABLE `bbches` (
  `id` int(11) NOT NULL auto_increment,
  `bbch` int(11) default NULL,
  `name` varchar(45) default NULL,
  `species_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_bbch_id` (`bbch`,`species_id`),
  KEY `fk_bbchs_species1` (`species_id`),
  CONSTRAINT `fk_bbchs_species1` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cultures`;
CREATE TABLE `cultures` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `limsstudyid` int(11) default NULL,
  `condition` varchar(45) default NULL,
  `created` datetime default NULL,
  `description` text,
  `experiment_id` int(11) default NULL,
  `plantspparcelle` int(11) default NULL,
  `location_id` int(11) default NULL,
  `planted` date default NULL,
  `terminated` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `entities`;
CREATE TABLE `entities` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `PO` varchar(45) default NULL,
  `definition` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=810 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `experiments`;
CREATE TABLE `experiments` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `startdate` date default NULL,
  `project` varchar(45) default NULL,
  `study` varchar(45) default NULL,
  `protocol` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `i18n`;
CREATE TABLE `i18n` (
  `id` int(10) NOT NULL auto_increment,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=2407 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `irrigation`;
CREATE TABLE `irrigation` (
  `id` int(11) NOT NULL auto_increment,
  `date` date default NULL,
  `treatment_id` int(11) default NULL,
  `location_id` int(11) default NULL,
  `value` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=579 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL auto_increment,
  `limsid` int(11) default NULL,
  `name` varchar(45) default NULL,
  `elevation` float default NULL,
  `gridref_north` float default NULL,
  `gridref_east` float default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `location_id` int(11) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(10) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_people_locations1` (`location_id`),
  CONSTRAINT `fk_people_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_bbches`;
CREATE TABLE `phenotype_bbches` (
  `id` int(11) NOT NULL auto_increment,
  `phenotype_id` int(11) NOT NULL,
  `bbch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_phenotype_bbchs_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_bbchs_bbchs1` (`bbch_id`),
  CONSTRAINT `fk_phenotype_bbchs_bbchs1` FOREIGN KEY (`bbch_id`) REFERENCES `bbches` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_bbchs_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28258 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_entities`;
CREATE TABLE `phenotype_entities` (
  `id` int(11) NOT NULL auto_increment,
  `phenotype_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_phenotype_entities_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_entities_entities1` (`entity_id`),
  CONSTRAINT `fk_phenotype_entities_entities1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_entities_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187241 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_raws`;
CREATE TABLE `phenotype_raws` (
  `id` int(11) NOT NULL auto_increment,
  `phenotype_id` int(11) NOT NULL,
  `raw_id` int(11) NOT NULL,
  `line_nr` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_phenotype_raws_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_raws_raws1` (`raw_id`),
  CONSTRAINT `fk_phenotype_raws_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_raws_raws1` FOREIGN KEY (`raw_id`) REFERENCES `raws` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=215532 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotype_values`;
CREATE TABLE `phenotype_values` (
  `id` int(11) NOT NULL auto_increment,
  `value_id` int(11) NOT NULL,
  `phenotype_id` int(11) NOT NULL,
  `number` varchar(45) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_phenotype_attributes_phenotypes1` (`phenotype_id`),
  KEY `fk_phenotype_values_values1` (`value_id`),
  CONSTRAINT `fk_phenotype_attributes_phenotypes1` FOREIGN KEY (`phenotype_id`) REFERENCES `phenotypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotype_values_values1` FOREIGN KEY (`value_id`) REFERENCES `values` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187635 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `phenotypes`;
CREATE TABLE `phenotypes` (
  `id` int(11) NOT NULL auto_increment,
  `version` varchar(45) default NULL,
  `object` varchar(45) default NULL,
  `program_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `sample_id` int(11) NOT NULL,
  `invalid` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_phenotypes_programs1` (`program_id`),
  KEY `fk_phenotypes_samples1` (`sample_id`),
  CONSTRAINT `fk_phenotypes_programs1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_phenotypes_samples1` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=215938 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `plants`;
CREATE TABLE `plants` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `aliquot` int(11) NOT NULL,
  `culture_id` int(11) NOT NULL,
  `subspecies_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `lineid` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `fk_plants_cultures1` (`culture_id`),
  KEY `aliquot` (`aliquot`),
  CONSTRAINT `fk_plants_cultures1` FOREIGN KEY (`culture_id`) REFERENCES `cultures` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17833 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `programs`;
CREATE TABLE `programs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `raws`;
CREATE TABLE `raws` (
  `id` int(11) NOT NULL auto_increment,
  `data` blob NOT NULL,
  `filename` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1096 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `samples`;
CREATE TABLE `samples` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `created` datetime default NULL,
  `plant_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_samples_plants1` (`plant_id`),
  CONSTRAINT `fk_samples_plants1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48502 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `species`;
CREATE TABLE `species` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `starch_yield`;
CREATE TABLE `starch_yield` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `aliquotid` int(11) NOT NULL,
  `parzellennr` int(11) default NULL,
  `location_id` int(11) NOT NULL,
  `cultivar` varchar(45) default NULL,
  `pflanzen_parzelle` int(11) default NULL,
  `knollenmasse_kgfw_parzelle` double NOT NULL,
  `staerkegehalt_g_kg` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1765 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `subspecies`;
CREATE TABLE `subspecies` (
  `id` int(11) NOT NULL auto_increment,
  `limsid` int(11) default NULL,
  `species_id` int(11) default NULL,
  `cultivar` varchar(45) default NULL,
  `breeder` varchar(45) default NULL,
  `reifegruppe` varchar(10) default NULL,
  `reifegrclass` int(11) default NULL,
  `krautfl` int(11) default NULL,
  `verwendung` varchar(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `temps`;
CREATE TABLE `temps` (
  `id` int(11) NOT NULL auto_increment,
  `datum` date NOT NULL,
  `precipitation` float default NULL,
  `irrigation` float default NULL,
  `tmin` float default NULL,
  `tmax` float default NULL,
  `location_id` int(11) NOT NULL,
  `invalid` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_temps_locations1` (`location_id`),
  CONSTRAINT `fk_temps_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3007 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `treatments`;
CREATE TABLE `treatments` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `aliquotid` int(11) NOT NULL,
  `alias` varchar(45) default NULL,
  `value_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2300 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ufilekeywords`;
CREATE TABLE `ufilekeywords` (
  `id` int(11) NOT NULL auto_increment,
  `ufile_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_ufilekeywords_1` (`ufile_id`),
  KEY `fk_ufilekeywords_2` (`keyword_id`),
  CONSTRAINT `fk_ufilekeywords_1` FOREIGN KEY (`ufile_id`) REFERENCES `ufiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ufilekeywords_2` FOREIGN KEY (`keyword_id`) REFERENCES `keywords` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ufiles`;
CREATE TABLE `ufiles` (
  `id` int(11) NOT NULL auto_increment,
  `person_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime default NULL,
  `description` varchar(45) default NULL,
  `invalid` tinyint(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_ufiles_people1` (`person_id`),
  CONSTRAINT `fk_ufiles_people1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `values`;
CREATE TABLE `values` (
  `id` int(11) NOT NULL auto_increment,
  `attribute` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8;


