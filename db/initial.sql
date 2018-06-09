CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `time_stamp` datetime DEFAULT NULL,
  `point` int(11) NOT NULL DEFAULT 0,
  `user_img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `time_stamp` datetime NOT NULL,
  `point` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE `following_user` (
  `user_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`following_id`),
  KEY `following_id` (`following_id`),
  CONSTRAINT `following_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `following_user_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reaction` (
  `id` int(11) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `reaction_tag` (
  `article_id` int(11) NOT NULL,
  `reaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`reaction_id`,`user_id`),
  KEY `reaction_id` (`reaction_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reaction_tag_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `reaction_tag_ibfk_2` FOREIGN KEY (`reaction_id`) REFERENCES `reaction` (`id`),
  CONSTRAINT `reaction_tag_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reaction` VALUES (1, "like");
INSERT INTO `reaction` VALUES (2, "surprise");
INSERT INTO `reaction` VALUES (3, "laugh");
INSERT INTO `reaction` VALUES (4, "dislike");
