SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `bacheca` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `testo` text COLLATE utf8_unicode_ci NOT NULL,
  `data` int(13) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `banca` (
  `userid` smallint(4) unsigned NOT NULL,
  `conto` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `interessi` int(13) unsigned NOT NULL,
  `prestito` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `lotteria` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vincitore` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `incprestito` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `dataincprestito` int(13) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `battle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attid` smallint(5) unsigned NOT NULL,
  `difid` smallint(5) unsigned NOT NULL,
  `tatatt` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tatatt2` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tatdif` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tatdif2` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `difcpu` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `exp` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `battlereport` (
  `id` int(10) unsigned NOT NULL,
  `data` int(13) unsigned NOT NULL,
  `attid` smallint(5) unsigned NOT NULL,
  `difid` smallint(5) unsigned NOT NULL,
  `cpuid` smallint(5) unsigned NOT NULL,
  `finito` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cachequest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `questid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `secondi` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cacheuserid` (
  `userid` smallint(5) unsigned NOT NULL,
  `data` int(13) unsigned NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `caratteristiche` (
  `userid` smallint(4) unsigned NOT NULL,
  `salute` mediumint(8) unsigned NOT NULL DEFAULT '100',
  `saluteattuale` mediumint(8) unsigned NOT NULL DEFAULT '100',
  `livello` smallint(5) unsigned NOT NULL DEFAULT '1',
  `exp` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `energia` mediumint(8) unsigned NOT NULL DEFAULT '1000',
  `energiamax` mediumint(8) unsigned NOT NULL DEFAULT '1000',
  `razza` smallint(5) unsigned NOT NULL,
  `classe` smallint(5) unsigned NOT NULL,
  `agilita` mediumint(8) unsigned NOT NULL,
  `attfisico` mediumint(8) unsigned NOT NULL,
  `attmagico` mediumint(8) unsigned NOT NULL,
  `diffisica` mediumint(8) unsigned NOT NULL,
  `difmagica` mediumint(8) unsigned NOT NULL,
  `mana` mediumint(8) unsigned NOT NULL,
  `recuperosalute` int(13) unsigned NOT NULL,
  `recuperoenergia` int(13) unsigned NOT NULL,
  `minatore` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expminatore` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `alchimista` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expalchimista` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sesso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `manarimasto` mediumint(8) unsigned NOT NULL,
  `fede` mediumint(8) unsigned NOT NULL DEFAULT '1000',
  `decfede` int(13) unsigned NOT NULL,
  `velocita` mediumint(8) unsigned NOT NULL,
  `intelligenza` mediumint(8) unsigned NOT NULL,
  `destrezza` mediumint(8) unsigned NOT NULL,
  `fabbro` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expfabbro` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `magica` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `expmagica` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `expelmagico1` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `expelmagico2` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `expelmagico3` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `expelmagico4` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reputazione` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `carcpu` (
  `cpuid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL,
  `livello` smallint(5) unsigned NOT NULL,
  `salute` mediumint(8) unsigned NOT NULL,
  `saluteattuale` mediumint(8) unsigned NOT NULL,
  `energia` mediumint(8) unsigned NOT NULL,
  `energiamax` mediumint(8) unsigned NOT NULL,
  `mana` mediumint(8) unsigned NOT NULL,
  `manarimasto` mediumint(8) unsigned NOT NULL,
  `attfisico` mediumint(8) unsigned NOT NULL,
  `attmagico` mediumint(8) unsigned NOT NULL,
  `diffisica` mediumint(8) unsigned NOT NULL,
  `difmagica` mediumint(8) unsigned NOT NULL,
  `agilita` mediumint(8) unsigned NOT NULL,
  `velocita` mediumint(8) unsigned NOT NULL,
  `intelligenza` mediumint(8) unsigned NOT NULL,
  `destrezza` mediumint(8) unsigned NOT NULL,
  `monete` smallint(5) unsigned NOT NULL,
  `inuso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cpuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `config` (
  `id` smallint(4) unsigned NOT NULL,
  `maxutenti` smallint(4) unsigned NOT NULL,
  `utenti` smallint(4) unsigned NOT NULL,
  `chiuso` tinyint(1) unsigned NOT NULL,
  `banca` int(10) unsigned NOT NULL DEFAULT '0',
  `news` text COLLATE utf8_unicode_ci,
  `comunicazione` text COLLATE utf8_unicode_ci,
  `language` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'it',
  `lotteria` int(13) unsigned NOT NULL DEFAULT '0',
  `version` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `crimine` tinyint(3) unsigned NOT NULL DEFAULT '10',
  `atticriminali` int(13) unsigned NOT NULL DEFAULT '0',
  `ottimizzazioni` int(13) unsigned NOT NULL,
  `cancellazioni` int(13) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `config` (`id`, `maxutenti`, `utenti`, `chiuso`, `banca`, `news`, `comunicazione`, `language`, `lotteria`, `version`, `crimine`, `atticriminali`, `ottimizzazioni`, `cancellazioni`) VALUES
(0, 100, 0, 1, 1000, NULL, NULL, 'it', 0, '0.8.1', 10, 0, 0, 0);

CREATE TABLE IF NOT EXISTS `equip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oggid` smallint(5) unsigned NOT NULL,
  `userid` smallint(5) unsigned NOT NULL,
  `usura` smallint(5) unsigned NOT NULL DEFAULT '0',
  `inuso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `equipagcpu` (
  `cpuid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cac` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arm` smallint(5) unsigned NOT NULL DEFAULT '0',
  `scu` smallint(5) unsigned NOT NULL DEFAULT '0',
  `poz` smallint(5) unsigned NOT NULL DEFAULT '0',
  `adi` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cpuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `equipaggiamento` (
  `userid` smallint(5) unsigned NOT NULL,
  `cac` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arm` smallint(5) unsigned NOT NULL DEFAULT '0',
  `scu` smallint(5) unsigned NOT NULL DEFAULT '0',
  `poz` smallint(5) unsigned NOT NULL DEFAULT '0',
  `adi` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `equipcpu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oggid` smallint(5) unsigned NOT NULL,
  `cpuid` smallint(5) unsigned NOT NULL,
  `usura` smallint(5) unsigned NOT NULL DEFAULT '0',
  `inuso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eventi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(5) unsigned NOT NULL,
  `datainizio` int(13) unsigned NOT NULL,
  `secondi` mediumint(8) unsigned NOT NULL,
  `dettagli` tinyint(3) unsigned NOT NULL,
  `tipo` tinyint(3) unsigned NOT NULL,
  `lavoro` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `oggid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ore` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `battleid` int(10) unsigned NOT NULL DEFAULT '0',
  `turni` tinyint(4) NOT NULL DEFAULT '0',
  `questid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `inuso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `inmagia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `magid` tinyint(3) unsigned NOT NULL,
  `userid` smallint(5) unsigned NOT NULL,
  `stato` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `inoggetti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oggid` smallint(5) unsigned NOT NULL,
  `userid` smallint(5) unsigned NOT NULL,
  `usura` smallint(5) unsigned NOT NULL DEFAULT '0',
  `inuso` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `logsistema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `data` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `logutenti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(4) unsigned NOT NULL,
  `msg` smallint(3) unsigned NOT NULL,
  `parametri` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `magia` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(1) unsigned NOT NULL,
  `elemento` tinyint(1) unsigned NOT NULL,
  `abilitanec` tinyint(3) unsigned NOT NULL,
  `expnec` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

INSERT INTO `magia` (`id`, `tipo`, `elemento`, `abilitanec`, `expnec`) VALUES
(1, 1, 1, 1, 200),
(2, 2, 1, 1, 200),
(3, 1, 2, 1, 200),
(4, 2, 2, 1, 200),
(5, 1, 3, 1, 200),
(6, 2, 3, 1, 200),
(7, 1, 4, 1, 200),
(8, 2, 4, 1, 200);

CREATE TABLE IF NOT EXISTS `messaggi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(5) unsigned NOT NULL,
  `titolo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `letto` tinyint(1) unsigned NOT NULL,
  `testo` varchar(11000) COLLATE utf8_unicode_ci NOT NULL,
  `mittenteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `data` int(13) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `msginviati` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` smallint(5) unsigned NOT NULL,
  `titolo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(11000) COLLATE utf8_unicode_ci NOT NULL,
  `riceventeid` smallint(5) unsigned NOT NULL,
  `data` int(13) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `oggetti` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(1) unsigned NOT NULL,
  `categoria` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `probrottura` smallint(5) unsigned NOT NULL DEFAULT '0',
  `costo` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `energia` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `usura` smallint(5) unsigned NOT NULL DEFAULT '0',
  `bonuseff` smallint(5) unsigned NOT NULL DEFAULT '0',
  `forzafisica` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `destrezza` smallint(5) unsigned NOT NULL DEFAULT '0',
  `probtrovare` smallint(5) unsigned NOT NULL DEFAULT '0',
  `recsalute` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `recenergia` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `abilitanec` smallint(5) unsigned NOT NULL DEFAULT '0',
  `materiale` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `danno` smallint(5) unsigned NOT NULL DEFAULT '0',
  `difesafisica` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=105 ;

INSERT INTO `oggetti` (`id`, `tipo`, `categoria`, `probrottura`, `costo`, `energia`, `usura`, `bonuseff`, `forzafisica`, `destrezza`, `probtrovare`, `recsalute`, `recenergia`, `abilitanec`, `materiale`, `danno`, `difesafisica`) VALUES
(1, 3, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 1, 0, 1, 0, 1, 0, 0, 0, 10000, 0, 0, 0, 0, 0, 0),
(3, 1, 1, 0, 2, 0, 1, 0, 0, 0, 8000, 0, 0, 0, 0, 0, 0),
(4, 1, 1, 0, 3, 0, 1, 0, 0, 0, 6000, 0, 0, 0, 0, 0, 0),
(5, 1, 1, 0, 10, 0, 1, 0, 0, 0, 1000, 0, 0, 0, 0, 0, 0),
(6, 1, 1, 0, 20, 0, 1, 0, 0, 0, 500, 0, 0, 0, 0, 0, 0),
(7, 1, 1, 0, 30, 0, 1, 0, 0, 0, 200, 0, 0, 0, 0, 0, 0),
(8, 1, 1, 0, 40, 0, 1, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0),
(9, 1, 1, 0, 50, 0, 1, 0, 0, 0, 50, 0, 0, 0, 0, 0, 0),
(10, 1, 1, 0, 100, 0, 1, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0),
(12, 2, 1, 3000, 3, 25, 10, 0, 25, 0, 0, 0, 0, 1, 1, 0, 0),
(13, 2, 1, 1000, 5, 25, 20, 1, 25, 0, 0, 0, 0, 2, 1, 0, 0),
(69, 2, 1, 20, 500, 70, 1000, 100, 75, 0, 0, 0, 0, 6, 4, 0, 0),
(15, 2, 1, 1000, 10, 50, 25, 2, 50, 0, 0, 0, 0, 1, 2, 0, 0),
(16, 2, 1, 500, 15, 50, 40, 3, 50, 0, 0, 0, 0, 2, 2, 0, 0),
(17, 2, 1, 500, 15, 25, 40, 2, 25, 0, 0, 0, 0, 3, 1, 0, 0),
(18, 2, 1, 250, 30, 50, 100, 5, 50, 0, 0, 0, 0, 3, 2, 0, 0),
(68, 2, 1, 50, 100, 75, 400, 15, 60, 0, 0, 0, 0, 1, 4, 0, 0),
(20, 2, 1, 900, 20, 100, 50, 5, 100, 0, 0, 0, 0, 1, 3, 0, 0),
(21, 2, 1, 400, 40, 100, 100, 10, 100, 0, 0, 0, 0, 2, 3, 0, 0),
(22, 2, 1, 150, 80, 100, 200, 20, 100, 0, 0, 0, 0, 3, 3, 0, 0),
(23, 2, 1, 250, 30, 25, 80, 5, 25, 0, 0, 0, 0, 5, 1, 0, 0),
(24, 2, 1, 100, 60, 50, 200, 10, 50, 0, 0, 0, 0, 5, 2, 0, 0),
(25, 2, 1, 50, 200, 100, 500, 50, 100, 0, 0, 0, 0, 6, 3, 0, 0),
(26, 4, 1, 0, 5, 0, 1, 0, 0, 0, 0, 10, 0, 1, 0, 0, 0),
(27, 4, 1, 0, 10, 0, 1, 0, 0, 0, 0, 25, 0, 2, 0, 0, 0),
(28, 4, 1, 0, 20, 0, 1, 0, 0, 0, 0, 50, 0, 2, 0, 0, 0),
(29, 4, 1, 0, 30, 0, 1, 0, 0, 0, 0, 75, 0, 3, 0, 0, 0),
(30, 4, 1, 0, 40, 0, 1, 0, 0, 0, 0, 100, 0, 3, 0, 0, 0),
(31, 4, 2, 0, 5, 0, 1, 0, 0, 0, 0, 0, 100, 1, 0, 0, 0),
(32, 4, 2, 0, 10, 0, 1, 0, 0, 0, 0, 0, 250, 2, 0, 0, 0),
(33, 4, 2, 0, 20, 0, 1, 0, 0, 0, 0, 0, 500, 2, 0, 0, 0),
(34, 4, 2, 0, 30, 0, 1, 0, 0, 0, 0, 0, 750, 3, 0, 0, 0),
(35, 4, 2, 0, 40, 0, 1, 0, 0, 0, 0, 0, 1000, 3, 0, 0, 0),
(36, 3, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 5, 1, 250, 5, 10, 15, 0, 10, 0, 0, 0, 0, 1, 1, 5, 0),
(38, 5, 1, 200, 10, 10, 30, 0, 10, 0, 0, 0, 0, 3, 1, 6, 0),
(39, 5, 1, 100, 20, 10, 75, 0, 10, 0, 0, 0, 0, 5, 1, 7, 0),
(40, 5, 1, 200, 10, 20, 30, 0, 30, 0, 0, 0, 0, 1, 2, 6, 0),
(41, 5, 1, 100, 20, 20, 60, 0, 30, 0, 0, 0, 0, 3, 2, 7, 0),
(42, 5, 1, 50, 40, 20, 120, 0, 30, 0, 0, 0, 0, 5, 2, 8, 0),
(43, 5, 1, 100, 15, 30, 37, 0, 40, 0, 0, 0, 0, 1, 3, 7, 0),
(44, 5, 1, 50, 30, 30, 75, 0, 40, 0, 0, 0, 0, 3, 3, 8, 0),
(45, 5, 1, 25, 60, 30, 150, 0, 40, 0, 0, 0, 0, 5, 3, 9, 0),
(46, 5, 2, 250, 10, 30, 15, 0, 50, 0, 0, 0, 0, 1, 1, 7, 0),
(47, 5, 2, 200, 20, 30, 30, 0, 50, 0, 0, 0, 0, 3, 1, 8, 0),
(48, 5, 2, 100, 30, 30, 75, 0, 50, 0, 0, 0, 0, 5, 1, 9, 0),
(49, 5, 2, 200, 20, 50, 30, 0, 80, 0, 0, 0, 0, 1, 2, 11, 0),
(50, 5, 2, 100, 40, 50, 60, 0, 80, 0, 0, 0, 0, 3, 2, 13, 0),
(51, 5, 2, 50, 60, 50, 120, 1, 80, 0, 0, 0, 0, 5, 2, 16, 0),
(52, 5, 2, 100, 30, 60, 60, 0, 100, 0, 0, 0, 0, 1, 3, 14, 0),
(53, 5, 2, 50, 80, 60, 75, 1, 100, 0, 0, 0, 0, 3, 3, 17, 0),
(54, 5, 2, 25, 120, 60, 240, 3, 100, 0, 0, 0, 0, 6, 3, 21, 0),
(55, 6, 1, 200, 10, 5, 30, 0, 10, 0, 0, 0, 0, 0, 0, 0, 5),
(56, 6, 1, 150, 20, 6, 60, 0, 8, 0, 0, 0, 0, 0, 0, 0, 8),
(57, 6, 2, 200, 10, 9, 30, 0, 22, 0, 0, 0, 0, 0, 0, 0, 8),
(58, 6, 2, 150, 20, 10, 60, 0, 26, 0, 0, 0, 0, 0, 0, 0, 12),
(59, 5, 3, 200, 15, 50, 30, 0, 100, 0, 0, 0, 0, 1, 1, 10, 0),
(60, 5, 3, 150, 30, 50, 60, 1, 100, 0, 0, 0, 0, 3, 1, 12, 0),
(61, 5, 3, 100, 60, 50, 150, 2, 100, 0, 0, 0, 0, 5, 1, 15, 0),
(62, 5, 4, 250, 20, 80, 30, 0, 150, 0, 0, 0, 0, 1, 1, 12, 0),
(63, 5, 4, 200, 40, 80, 60, 0, 150, 0, 0, 0, 0, 3, 1, 15, 0),
(64, 5, 4, 150, 78, 80, 120, 0, 150, 0, 0, 0, 0, 5, 1, 19, 0),
(65, 5, 5, 150, 15, 60, 45, 0, 100, 0, 0, 0, 0, 1, 1, 9, 0),
(66, 5, 5, 120, 30, 60, 90, 0, 100, 0, 0, 0, 0, 3, 1, 11, 0),
(67, 5, 5, 90, 60, 60, 225, 1, 100, 0, 0, 0, 0, 5, 1, 13, 0),
(70, 5, 1, 40, 100, 30, 300, 0, 35, 0, 0, 0, 0, 1, 4, 8, 0),
(71, 5, 1, 20, 250, 35, 750, 1, 35, 0, 0, 0, 0, 5, 4, 11, 0),
(72, 6, 1, 180, 15, 5, 30, 0, 20, 0, 0, 0, 0, 1, 1, 0, 6),
(73, 6, 1, 150, 25, 7, 60, 0, 40, 0, 0, 0, 0, 1, 2, 0, 7),
(74, 6, 1, 120, 35, 8, 100, 0, 60, 0, 0, 0, 0, 1, 3, 0, 8),
(75, 6, 2, 180, 15, 12, 30, 0, 35, 0, 0, 0, 0, 1, 1, 0, 9),
(76, 6, 2, 150, 25, 14, 60, 0, 70, 0, 0, 0, 0, 1, 2, 0, 11),
(77, 6, 2, 120, 35, 16, 100, 0, 90, 0, 0, 0, 0, 1, 3, 0, 12),
(78, 5, 2, 40, 150, 60, 450, 2, 90, 0, 0, 0, 0, 1, 4, 18, 0),
(79, 5, 2, 20, 400, 60, 1000, 5, 90, 0, 0, 0, 0, 6, 4, 22, 0),
(80, 7, 1, 0, 5, 10, 10, 0, 10, 50, 0, 0, 0, 0, 0, 6, 0),
(81, 7, 1, 0, 7, 13, 10, 0, 25, 50, 0, 0, 0, 0, 0, 8, 0),
(82, 7, 1, 0, 8, 15, 10, 0, 35, 50, 0, 0, 0, 0, 0, 9, 0),
(83, 7, 1, 0, 11, 14, 10, 1, 30, 50, 0, 0, 0, 0, 0, 10, 0),
(84, 6, 1, 90, 40, 6, 70, 0, 20, 0, 0, 0, 0, 3, 1, 0, 8),
(85, 6, 1, 75, 60, 8, 135, 0, 40, 0, 0, 0, 0, 3, 2, 0, 9),
(86, 6, 1, 60, 85, 9, 240, 0, 60, 0, 0, 0, 0, 3, 3, 0, 11),
(87, 6, 2, 90, 40, 13, 70, 0, 35, 0, 0, 0, 0, 3, 1, 0, 11),
(88, 6, 2, 75, 60, 15, 135, 0, 70, 0, 0, 0, 0, 3, 2, 0, 13),
(89, 6, 2, 60, 85, 18, 240, 0, 90, 0, 0, 0, 0, 3, 3, 0, 16),
(90, 5, 3, 175, 30, 55, 70, 0, 140, 0, 0, 0, 0, 1, 2, 12, 0),
(91, 5, 3, 125, 60, 55, 140, 2, 140, 0, 0, 0, 0, 3, 2, 14, 0),
(92, 5, 3, 75, 120, 55, 300, 5, 140, 0, 0, 0, 0, 6, 2, 17, 0),
(93, 5, 4, 230, 40, 100, 70, 0, 210, 0, 0, 0, 0, 1, 2, 15, 0),
(94, 5, 4, 180, 80, 100, 140, 0, 210, 0, 0, 0, 0, 3, 2, 18, 0),
(95, 5, 4, 120, 160, 100, 300, 1, 210, 0, 0, 0, 0, 6, 2, 22, 0),
(96, 5, 5, 75, 30, 70, 100, 0, 140, 0, 0, 0, 0, 1, 2, 11, 0),
(97, 5, 5, 60, 60, 70, 200, 1, 140, 0, 0, 0, 0, 3, 2, 13, 0),
(98, 5, 5, 45, 120, 70, 450, 2, 140, 0, 0, 0, 0, 6, 2, 15, 0),
(99, 6, 1, 45, 80, 7, 150, 0, 20, 0, 0, 0, 0, 6, 1, 0, 10),
(100, 6, 1, 37, 120, 9, 290, 0, 40, 0, 0, 0, 0, 6, 2, 0, 11),
(101, 6, 1, 30, 200, 10, 550, 0, 60, 0, 0, 0, 0, 6, 3, 0, 15),
(102, 6, 2, 45, 80, 14, 150, 0, 35, 0, 0, 0, 0, 6, 1, 0, 13),
(103, 6, 2, 37, 120, 16, 290, 0, 70, 0, 0, 0, 0, 6, 2, 0, 15),
(104, 6, 2, 30, 200, 20, 550, 0, 90, 0, 0, 0, 0, 6, 3, 0, 20);

CREATE TABLE IF NOT EXISTS `pcpudata` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `quest` smallint(5) unsigned NOT NULL,
  `salute` mediumint(8) unsigned NOT NULL,
  `energia` mediumint(8) unsigned NOT NULL,
  `mana` mediumint(8) unsigned NOT NULL,
  `attfisico` mediumint(8) unsigned NOT NULL,
  `attmagico` mediumint(8) unsigned NOT NULL,
  `diffisica` mediumint(8) unsigned NOT NULL,
  `difmagica` mediumint(8) unsigned NOT NULL,
  `agilita` mediumint(8) unsigned NOT NULL,
  `velocita` mediumint(8) unsigned NOT NULL,
  `intelligenza` mediumint(8) unsigned NOT NULL,
  `destrezza` mediumint(8) unsigned NOT NULL,
  `livello` smallint(5) unsigned NOT NULL,
  `eqcac` smallint(5) unsigned NOT NULL DEFAULT '0',
  `eqadi` smallint(5) unsigned NOT NULL DEFAULT '0',
  `eqarm` smallint(5) unsigned NOT NULL DEFAULT '0',
  `eqscu` smallint(5) unsigned NOT NULL DEFAULT '0',
  `eqpoz` smallint(5) unsigned NOT NULL DEFAULT '0',
  `monete` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

INSERT INTO `pcpudata` (`id`, `quest`, `salute`, `energia`, `mana`, `attfisico`, `attmagico`, `diffisica`, `difmagica`, `agilita`, `velocita`, `intelligenza`, `destrezza`, `livello`, `eqcac`, `eqadi`, `eqarm`, `eqscu`, `eqpoz`, `monete`) VALUES
(1, 0, 100, 1000, 50, 200, 50, 50, 200, 150, 150, 100, 100, 1, 64, 0, 56, 58, 0, 20),
(2, 1, 100, 1000, 50, 100, 25, 100, 25, 150, 150, 100, 100, 1, 65, 0, 55, 57, 0, 10),
(3, 1, 105, 1050, 50, 200, 25, 200, 25, 160, 160, 100, 150, 2, 60, 0, 56, 57, 0, 15),
(4, 1, 115, 1150, 50, 300, 30, 300, 30, 180, 180, 120, 200, 4, 61, 82, 85, 88, 0, 20),
(5, 1, 100, 1200, 50, 200, 50, 200, 50, 200, 200, 50, 50, 3, 65, 0, 0, 0, 0, 10),
(6, 1, 150, 1500, 50, 500, 50, 500, 50, 150, 150, 100, 150, 10, 64, 0, 86, 0, 0, 60),
(7, 1, 100, 1000, 300, 50, 150, 50, 150, 60, 60, 190, 50, 1, 71, 0, 56, 58, 27, 15),
(8, 1, 105, 1050, 50, 120, 50, 120, 50, 220, 210, 150, 100, 2, 70, 83, 84, 0, 0, 14);

CREATE TABLE IF NOT EXISTS `sessione` (
  `id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `userid` smallint(5) unsigned NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `utenti` (
  `userid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `codice` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dataiscrizione` int(13) unsigned NOT NULL,
  `ipreg` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `conferma` tinyint(1) NOT NULL DEFAULT '0',
  `ultimologin` int(13) unsigned NOT NULL DEFAULT '0',
  `personaggio` tinyint(1) NOT NULL DEFAULT '0',
  `monete` mediumint(8) unsigned NOT NULL DEFAULT '50',
  `ultimazione` int(13) unsigned NOT NULL,
  `resuscita` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `plus` int(13) unsigned NOT NULL DEFAULT '0',
  `puntiplus` smallint(5) unsigned NOT NULL DEFAULT '3',
  `refer` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `refertime` int(13) unsigned NOT NULL DEFAULT '0',
  `avvinattivo` int(13) unsigned NOT NULL DEFAULT '0',
  `mailnews` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `vacanza` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
