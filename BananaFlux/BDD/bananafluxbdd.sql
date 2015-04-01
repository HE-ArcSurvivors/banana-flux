-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 25 Mars 2015 à 11:37
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bananafluxbdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `faq_article`
--

CREATE TABLE IF NOT EXISTS `faq_article` (
  `faq_article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `faq_article_title` varchar(200) NOT NULL,
  `faq_article_content` longtext NOT NULL,
  `faq_category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`faq_article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `faq_category`
--

CREATE TABLE IF NOT EXISTS `faq_category` (
  `faq_cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `faq_cat_name` varchar(200) NOT NULL,
  PRIMARY KEY (`faq_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `feed_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_title` varchar(200) NOT NULL,
  `feed_url` varchar(200) NOT NULL,
  PRIMARY KEY (`feed_id`),
  UNIQUE KEY `feed_url` (`feed_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `feed_folder`
--

CREATE TABLE IF NOT EXISTS `feed_folder` (
  `feed_folder_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(10) unsigned NOT NULL,
  `folder_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`feed_folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `feed_folder_tag`
--

CREATE TABLE IF NOT EXISTS `feed_folder_tag` (
  `feed_folder_tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feed_folder_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`feed_folder_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `feed_tag_defaut`
--

CREATE TABLE IF NOT EXISTS `feed_tag_defaut` (
  `feed_tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) unsigned NOT NULL,
  `feed_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`feed_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `folder`
--

CREATE TABLE IF NOT EXISTS `folder` (
  `folder_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(100) NOT NULL,
  `folder_color` varchar(100) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`folder_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `readlater`
--

CREATE TABLE IF NOT EXISTS `readlater` (
  `readlater_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `readlater_url` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `feed_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`readlater_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `user_id` int(10) unsigned NOT NULL,
  `setting_readlaterfirst` tinyint(1) NOT NULL,
  `theme_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `theme_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `theme_id` (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_icon` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`,`user_email`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
