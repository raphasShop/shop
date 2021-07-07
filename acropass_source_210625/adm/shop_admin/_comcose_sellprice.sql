-- --------------------------------------------------------

--
-- Table structure for table `comcose_sellprice_category_add`
--

CREATE TABLE IF NOT EXISTS `comcose_sellprice_category_add` (
  `cose_add_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cose_cat_add_cat_id` varchar(255) NOT NULL,
  `cose_cat_add_cat_caname` varchar(255) NOT NULL,
  `cose_cat_add_set_price_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_cat_add_set_price` int(11) NOT NULL DEFAULT '0',
  `cose_cat_add_use` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cose_add_cat_id`),
  UNIQUE KEY `cose_cat_add_cat_id` (`cose_cat_add_cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comcose_sellprice_category_except`
--

CREATE TABLE IF NOT EXISTS `comcose_sellprice_category_except` (
  `cose_except_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cose_except_add_cat_id` varchar(255) NOT NULL,
  `cose_except_add_cat_caname` varchar(255) NOT NULL,
  PRIMARY KEY (`cose_except_cat_id`),
  UNIQUE KEY `cose_except_add_cat_id` (`cose_except_add_cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comcose_sellprice_item_except`
--

CREATE TABLE IF NOT EXISTS `comcose_sellprice_item_except` (
  `cose_except_it_id` int(11) NOT NULL AUTO_INCREMENT,
  `cose_except_add_it_caid` varchar(255) NOT NULL,
  `cose_except_add_it_id` varchar(255) NOT NULL,
  `cose_except_add_it_name` varchar(255) NOT NULL,
  PRIMARY KEY (`cose_except_it_id`),
  UNIQUE KEY `cose_except_add_it_id` (`cose_except_add_it_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comcose_sellprice_level`
--

CREATE TABLE IF NOT EXISTS `comcose_sellprice_level` (
  `cose_add_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `cose_add_level_use` varchar(255) NOT NULL,
  `cose_add_level_login` varchar(255) NOT NULL,
  `cose_add_level_1_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_1` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_2_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_2` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_3_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_3` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_4_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_4` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_5_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_5` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_6_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_6` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_7_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_7` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_8_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_8` int(11) NOT NULL DEFAULT '0',
  `cose_add_level_9_type` varchar(255) NOT NULL DEFAULT '+',
  `cose_add_level_9` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cose_add_level_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `comcose_sellprice_level` 
(`cose_add_level_id`, 
`cose_add_level_use`, 
`cose_add_level_login`, 
`cose_add_level_1_type`, 
`cose_add_level_1`, 
`cose_add_level_2_type`, 
`cose_add_level_2`, 
`cose_add_level_3_type`, 
`cose_add_level_3`, 
`cose_add_level_4_type`, 
`cose_add_level_4`, 
`cose_add_level_5_type`, 
`cose_add_level_5`, 
`cose_add_level_6_type`, 
`cose_add_level_6`, 
`cose_add_level_7_type`, 
`cose_add_level_7`, 
`cose_add_level_8_type`, 
`cose_add_level_8`, 
`cose_add_level_9_type`, 
`cose_add_level_9`
) 
VALUES
(1, 
'1', 
'0', 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0, 
'+', 
0);

-- --------------------------------------------------------

--
-- Table structure for table `comcose_sellprice_item_add`
--

CREATE TABLE IF NOT EXISTS `comcose_sellprice_item_add` (
  `cose_add_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cose_item_add_it_id` varchar(255) NOT NULL,
  `cose_item_add_it_name` varchar(255) NOT NULL,
  `cose_item_add_set_price_type1` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price1` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type2` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price2` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type3` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price3` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type4` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price4` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type5` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price5` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type6` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price6` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type7` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price7` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type8` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price8` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_set_price_type9` varchar(255) NOT NULL DEFAULT '+',
  `cose_item_add_set_price9` int(11) NOT NULL DEFAULT '0',
  `cose_item_add_ca_id` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cose_add_item_id`),
  UNIQUE KEY `cose_item_add_it_id` (`cose_item_add_it_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
