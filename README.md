# scanditest
 
 This is a work application work done for Scandiweb

 original code has been also saved in Github: https://github.com/OROBA5/scanditest

 The database SQL for the project: 

 Database name: juniordev.liga.lomakina

 Database structure:
 
 # Book table:

 CREATE TABLE `book` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `product_id` int(11) NOT NULL,
 `weight` decimal(10,2) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `product_id` (`product_id`),
 CONSTRAINT `book_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

# dvd table:

CREATE TABLE `dvd` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `product_id` int(11) NOT NULL,
 `size` decimal(10,2) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `product_id` (`product_id`),
 CONSTRAINT `dvd_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

# furniture table:

CREATE TABLE `furniture` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `product_id` int(11) NOT NULL,
 `height` decimal(10,2) DEFAULT NULL,
 `width` decimal(10,2) DEFAULT NULL,
 `length` decimal(10,2) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `product_id` (`product_id`),
 CONSTRAINT `furniture_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

# product table: 

	CREATE TABLE `product` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `sku` varchar(255) NOT NULL,
 `name` varchar(255) NOT NULL,
 `price` decimal(10,2) NOT NULL,
 `product_type_id` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `product_type_id` (`product_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci