CREATE TABLE `orders` (
 `order_id` int NOT NULL AUTO_INCREMENT,
 `user_id` int NOT NULL,
 `items` json NOT NULL,
 `total` decimal(10,2) NOT NULL,
 `status` varchar(50) DEFAULT 'Pending',
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `estimated_delivery` date DEFAULT NULL,
 `address` text,
 PRIMARY KEY (`order_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `order_items` (
 `id` int NOT NULL AUTO_INCREMENT,
 `order_id` int NOT NULL,
 `product_id` int NOT NULL,
 `product_name` varchar(255) NOT NULL,
 `quantity` int NOT NULL,
 `price` decimal(10,2) NOT NULL,
 `total_price` decimal(10,2) GENERATED ALWAYS AS ((`quantity` * `price`)) STORED,
 PRIMARY KEY (`id`),
 KEY `order_id` (`order_id`),
 CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `payments` (
 `payment_id` int NOT NULL AUTO_INCREMENT,
 `order_id` int NOT NULL,
 `user_id` int NOT NULL,
 `payment_method` varchar(255) DEFAULT NULL,
 `payment_details` varchar(255) DEFAULT NULL,
 `amount` decimal(10,2) NOT NULL,
 `status` varchar(50) DEFAULT 'Success',
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`payment_id`),
 KEY `order_id` (`order_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
 CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `users` (
 `id` int NOT NULL AUTO_INCREMENT,
 `username` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `is_admin` tinyint(1) DEFAULT '0',
 PRIMARY KEY (`id`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci