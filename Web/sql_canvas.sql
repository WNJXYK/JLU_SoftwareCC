-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-10-29 09:15:05
-- 服务器版本： 5.5.41-log
-- PHP Version: 5.5.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sql_canvas`
--

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `content` text NOT NULL,
  `author` int(11) NOT NULL,
  `last` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `post`, `content`, `author`, `last`, `reply`) VALUES
(0, 0, 'Leave for black.', 19260817, '2019-10-26 06:08:11', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `home` int(11) NOT NULL,
  `syllabus` int(11) NOT NULL DEFAULT '0',
  `assignment` int(11) NOT NULL,
  `module` text NOT NULL,
  `info` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `name`, `home`, `syllabus`, `assignment`, `module`, `info`) VALUES
(0, 'None', 0, 0, 0, '{"Modules": []}', '{"Start":[],"Repeat": 1}'),
(1, 'Canvas', 1, 2, 0, '{"Modules":[{"Name":"文件模块","Unit":[{"Name":"如何上传/管理文件","ID":"7","Type":0}]},{"Name":"课程模块","Unit":[]},{"Name":"考试模块","Unit":[]},{"Name":"讨论模块","Unit":[{"Name":"尝试评论与回复","ID":"8","Type":1}]},{"Name":"其他","Unit":[]}]}', '{"Start":[],"Repeat": 0, "Extra": "Teacher: Canvas Developer" }'),
(2, 'Software Development', 3, 4, 0, '{"Modules": []}', '{"Start":[1572275041115, 1572361441115],"Repeat": 2, "Extra": "CS Building B110" }'),
(3, 'Compter English', 5, 6, 0, '{"Modules": []}', '{"Start":[1572447988320],"Repeat": 5, "Extra": "English is important." }');

-- --------------------------------------------------------

--
-- 表的结构 `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `path` text NOT NULL,
  `size` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `file`
--

INSERT INTO `file` (`id`, `name`, `path`, `size`, `user`) VALUES
(23, 'ccpc-harbin-2019-problemset.pdf', 'http://canvas-app.smartgslb.com/uploads/01572311650-ccpc-harbin-2019-problemset.pdf', 414, 0);

-- --------------------------------------------------------

--
-- 表的结构 `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `markdown`
--

CREATE TABLE IF NOT EXISTS `markdown` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `course` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `markdown`
--

INSERT INTO `markdown` (`id`, `content`, `course`) VALUES
(0, 'Leave for blank.', 0),
(1, '# 课程简介\n\n你可以在这里学习如何使用 Canvas 在线教学系统', 1),
(2, '# 本周计划\n本周无计划', 1),
(3, '# Home', 2),
(4, '# Syllabus', 2),
(5, '# Home', 3),
(6, '# Syllabus', 3),
(7, '# 如何上传文件\n\n在 Dashboard 左上角点击用户头像即可看到 File 菜单，单击 File 菜单进入文件管页面。\n\n![](http://canvas-app.smartgslb.com/uploads/01572275749-文件模块.PNG)', 1),
(8, '你可以在这个帖子下面尝试评论并回去其他人的评论。\n', 1);

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

CREATE TABLE IF NOT EXISTS `problem` (
  `id` int(11) NOT NULL,
  `statement` text NOT NULL,
  `content` text NOT NULL,
  `answer` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '5',
  `quiz` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `course` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `quiz`
--

INSERT INTO `quiz` (`id`, `name`, `content`, `course`) VALUES
(0, 'Leave For Blank', '{"Problem":[],"Score":0,"Time":"0"}', 0);

-- --------------------------------------------------------

--
-- 表的结构 `record`
--

CREATE TABLE IF NOT EXISTS `record` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `answer` text NOT NULL,
  `score` text NOT NULL,
  `tot` int(11) NOT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `password` varchar(32) NOT NULL COMMENT 'Password',
  `nickname` varchar(32) NOT NULL COMMENT 'Nickname',
  `id` int(11) NOT NULL COMMENT 'School ID',
  `type` enum('Admin','Teacher','Student','') NOT NULL DEFAULT 'Student' COMMENT 'Type of User',
  `token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`password`, `nickname`, `id`, `type`, `token`) VALUES
('cfcd208495d565ef66e7dff9f98764da', 'Teacher', 0, 'Teacher', 'ebad9b4d5c55b304ffc986a148450708'),
('21232f297a57a5a743894a0e4a801fc3', 'Administrator', 19260817, 'Admin', '1fa8b3d356c7d1609da6881e6e3ea24c'),
('82aa5a813e91f845fd225233fb44fc1f', 'u049', 21161607, 'Student', ''),
('2af9b1ba42dc5eb01743e6b3759b6e4b', 'WNJXYK', 21161608, 'Student', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markdown`
--
ALTER TABLE `markdown`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `markdown`
--
ALTER TABLE `markdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `record`
--
ALTER TABLE `record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
