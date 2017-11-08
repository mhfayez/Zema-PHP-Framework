CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
   PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`menu_id`, `menu`, `path`) VALUES
(1, 'Articles', '/articles'),
(2, 'About', '/about'),
(3, 'Contact', '/contact'),
(4, 'Tutorials', '/tutorials'),
(5, 'Docs', '/docs'),
(6, 'Home', '/home');

CREATE TABLE IF NOT EXISTS `articles` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` tinytext,
  `body` mediumtext NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'placeholder.png',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `articles` (`id`, `title`, `summary`, `body`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Zema PHP framework', '', 'Zema PHP Framework is an easy to use  PHP framework created  by Homayoon Fayez.\r\nIt is written in PHP and uses PDO\r\n', 'php_framework.png', '2017-06-05 19:06:31', '2017-09-07 15:20:53'),
(2, 'Ruby on Rails', '', 'Ruby on rails is the web Framework of Ruby.\r\n', 'ruby_on_rails.jpg', '2017-06-05 19:06:31', '2017-08-20 19:43:44'),
(3, 'AngularJS', '', ' AngularJS is a JavaScript-based open-source front-end web application framework mainly maintained by Google.\r\n', 'angular.png', '2017-06-05 19:06:31', '2017-09-14 21:11:21'),
(4, 'Concrete5 ', '', 'Concrete5 is another innovative PHP Framework. It  has an inline editor \r\n                ', 'concreate5.jpg', '2017-06-05 19:06:31', '2017-09-14 21:12:31'),
(5, 'Python', '', '<h3>This is <b>Python </b> </h3>\r\n', 'python-logo.png', '2017-06-05 19:06:31', '2017-09-14 21:13:55'),
(6, 'JS Injection', '', '<script>alert(\'you are bugged\')</script>\r\n<p style="color: red">I leave it up to you! If you wish you can allow tags </p>\r\notherwise you can call htmlspecialchars() on it, when displaying or strip the tags when saving to DB\r\n', 'placeholder.png', '2017-06-05 19:06:31', '2017-09-14 21:03:28'),
(7, 'Router', '', '<h4> creating a router is a pain in the Nick.</h4>\r\n', 'router.jpg', '2017-06-05 19:06:31', '2017-09-14 21:15:08');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `avatar` text,
  `email` varchar(150) NOT NULL,
  `role_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `user_name`, `password`, `first_name`, `last_name`, `avatar`, `email`, `role_id`, `updated_at`, `created_at`) VALUES
(5, 'user', '$2y$10$MYykEc7teVPbjhC1ajKvc..CyJ05Nfc1QVAfxiMP/VPLKMG4ZqoFK', 'Userfirstname', 'Userlastname', 'user.png', 'user@gmail.com', 2, '2017-06-14 12:11:45', '2017-06-14 12:11:45');

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(150) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'Author');

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);
