CREATE TABLE IF NOT EXISTS `QUESTION_TITLE` (
  `qid` int(9) NOT NULL,
  `q_title` varchar(200) character set utf8 NOT NULL,
  `q_url` varchar(500) NOT NULL,
  `q_intro` char(200) NOT NULL,
  `q_date` varchar(20) NOT NULL COMMENT 'Just a string like December 12, 2010',
  FULLTEXT KEY `q_title` (`q_title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

