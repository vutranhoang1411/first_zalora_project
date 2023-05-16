DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL unique,
  `number` varchar(20) NOT NULL,
  `total_stock` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (1, 'Dr. Mariana Walker DVM', 'witting.loyce@example.com', '05475910818', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (2, 'Eveline Okuneva', 'johann73@example.net', '576.689.8709', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (3, 'Rosie Jenkins', 'dolly99@example.com', '224-628-1387', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (4, 'Ferne Kunze', 'mona80@example.com', '(178)882-8632x149', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (5, 'Melba Kilback DVM', 'arvel.dickinson@example.org', '070.240.5682x0503',  'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (6, 'Marc Parker', 'cweber@example.com', '961.600.9948x337', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (7, 'Sunny Kiehn', 'xschaden@example.org', '669-795-2497x81880', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (8, 'Daisy Monahan', 'hester.terry@example.net', '1-385-091-9463', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (9, 'Mona Treutel', 'daisy51@example.org', '1-929-767-6100', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (10, 'Kenyatta Adams I', 'ohara.verona@example.com', '403-323-9516x68063', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (11, 'Adella Bednar', 'beatty.mikayla@example.com', '(415)047-1706x11270', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (12, 'Barney Tremblay Sr.', 'ccollier@example.org', '09503762410', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (13, 'Mr. Vernon Fay MD', 'hilll.sydnie@example.com', '+15(2)6412099134', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (14, 'Mr. Faustino Kilback', 'kailee.marks@example.com', '671-938-0734', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (15, 'Rowena Haley', 'kassulke.athena@example.org', '906-712-1752x1186', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (16, 'Dr. Nola Maggio', 'grolfson@example.org', '1-421-463-6731', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (17, 'Vickie Hackett', 'arvid49@example.com', '+25(0)9273510315', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (18, 'Mr. Clint Hauck DVM', 'kemmer.vito@example.net', '537-323-5022x455', 'active');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (19, 'Manuela Nicolas', 'pkunze@example.org', '1-335-271-9020x4396', 'inactive');
INSERT INTO `supplier` (`id`, `name`, `email`, `number`, `status`) VALUES (20, 'Joaquin Monahan', 'deanna21@example.net', '637.586.8111', 'inactive');


DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `sku` varchar(20) NOT NULL,
  `size` varchar(5) NOT NULL,
  `color` varchar(20) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `total_stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (1, 'shoe', 'Kaley', '5617715849746', '3', 'silver', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (2, 'shirt', 'Dameon', '6035200183646', '9', 'gray', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (3, 'shoe', 'Vinnie', '0821220275999', '7', 'silver', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (4, 'pant', 'Zechariah', '2993024971921', '6', 'green', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (5, 'shoe', 'Davion', '0270062999769', '7', 'gray', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (6, 'pant', 'Forrest', '7042744203074', '7', 'black', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (7, 'pant', 'Maverick', '4111581845525', '1', 'purple', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (8, 'shirt', 'Efrain', '0928119367718', '2', 'yellow', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (9, 'shoe', 'Chester', '8223761820775', '1', 'black', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (10, 'shirt', 'Jimmy', '4329294348114', '6', 'teal', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (11, 'shoe', 'Jaquan', '4006346382653', '4', 'blue', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (12, 'shoe', 'Blair', '9041427350072', '9', 'white', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (13, 'pant', 'Chaim', '1701812572042', '4', 'olive', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (14, 'shoe', 'Bradly', '6420157692899', '4', 'blue', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (15, 'pant', 'Merle', '7931743947495', '8', 'green', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (16, 'pant', 'Dillon', '9612888705222', '8', 'purple', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (17, 'shoe', 'Ewell', '2920751681007', '1', 'lime', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (18, 'pant', 'Joshua', '0295894672161', '6', 'olive', 'active');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (19, 'shirt', 'Aiden', '0651018851827', '1', 'yellow', 'inactive');
INSERT INTO `product` (`id`, `name`, `brand`, `sku`, `size`, `color`, `status`) VALUES (20, 'shoe', 'Jerrold', '0527434536481', '8', 'green', 'inactive');




DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addr` varchar(100) NOT NULL,
  `type` enum('office','warehouse','headquater') NOT NULL,
  `supplierid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `supplierid` (`supplierid`),
  CONSTRAINT `address_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`id`) on delete cascade
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('3943 Crist Ramp Suite 868', 'office', 1);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('074 Myrtle Viaduct', 'office', 2);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('70850 Delbert Stravenue Suite 536', 'office', 3);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('5096 Eda Locks Apt. 279', 'office', 4);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('8763 OConner Gardens Suite 717', 'office', 5);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('243 Schaefer Harbor', 'office', 6);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('068 Mayert Parks Apt. 227', 'office', 7);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('91807 Victoria Trafficway', 'office', 8);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ('065 Runte Centers Suite 692', 'office', 9);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '3418 Beatty Views', 'office', 10);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '181 Muller Alley Apt. 819', 'office', 11);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '9719 Della Motorway', 'office', 12);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '2874 Gaylord Branch', 'office', 13);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '3157 Harmony Knolls Suite 366', 'office', 14);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '137 Windler Dale', 'office', 15);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '83245 Wilber Trail Suite 420', 'office', 16);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '343 Olson Plaza Apt. 110', 'office', 17);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '47664 Borer Grove Suite 571', 'office', 18);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '3922 Lavina Valley', 'office', 19);
INSERT INTO `address` (`addr`, `type`, `supplierid`) VALUES ( '38613 Lucio Well', 'office', 20);


DROP TABLE IF EXISTS `productsupply`;

CREATE TABLE `productsupply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `productid` (`productid`),
  KEY `supplierid` (`supplierid`),
  CONSTRAINT `productsupply_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `product` (`id`) on delete cascade,
  CONSTRAINT `productsupply_ibfk_2` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`id`) on delete cascade
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (1, 17, 11, 10);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (2, 3, 20, 12);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (3, 18, 19, 21);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (4, 4, 15, 5);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (5, 1, 19, 37);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (6, 14, 12, 6);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (7, 5, 13, 4);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (8, 12, 18, 41);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (9, 11, 17, 41);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (10, 17, 7, 50);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (11, 4, 12, 8);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (12, 4, 9, 15);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (13, 15, 11, 9);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (14, 11, 12, 0);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (15, 15, 14, 40);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (16, 9, 19, 19);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (17, 9, 7, 25);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (18, 20, 3, 10);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (19, 3, 10, 46);
INSERT INTO `productsupply` (`id`, `productid`, `supplierid`, `stock`) VALUES (20, 2, 5, 45);
