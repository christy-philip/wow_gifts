-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: wow_gifts
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES (23,45,1,'Classic Photo Pillow',1,39.99),(24,46,1,'Classic Photo Pillow',1,39.99),(25,47,3,'Rectangle Throw Pillow',1,29.99),(26,48,2,'Heart Shape Pillow',1,34.99),(27,49,12,'Alphabet Chocolate Set',1,27.99),(28,50,1,'Classic Photo Pillow',1,39.99),(29,51,1,'Classic Photo Pillow',1,39.99),(30,52,1,'Classic Photo Pillow',1,539.99),(31,53,1,'Classic Photo Pillow',1,539.99),(32,54,7,'Photo Wrap Mug',1,524.99),(33,55,11,'Gourmet Truffle Box',1,2034.99),(34,56,11,'Gourmet Truffle Box',1,2034.99),(35,57,22,'Luxury Sherpa Blanket',1,619.99),(36,58,22,'Luxury Sherpa Blanket',1,619.99),(37,58,11,'Gourmet Truffle Box',1,2034.99),(38,59,4,'Luxury Velvet Pillow',1,744.99),(39,59,11,'Gourmet Truffle Box',1,2034.99),(40,60,2,'Heart Shape Pillow',1,634.99),(41,61,2,'Heart Shape Pillow',1,634.99),(42,62,13,'Classic Round Cake',1,1549.99),(43,63,13,'Classic Round Cake',1,1549.99),(44,64,13,'Classic Round Cake',1,1549.99),(45,65,3,'Rectangle Throw Pillow',1,329.99),(46,66,1,'Classic Photo Pillow',1,539.99),(47,67,1,'Classic Photo Pillow',1,539.99),(48,68,1,'Classic Photo Pillow',1,539.99),(49,69,1,'Classic Photo Pillow',1,539.99),(50,70,3,'Rectangle Throw Pillow',1,329.99),(51,71,2,'Heart Shape Pillow',1,634.99),(52,72,1,'Classic Photo Pillow',2,539.99),(53,73,1,'Classic Photo Pillow',2,539.99),(54,74,1,'Classic Photo Pillow',1,539.99),(55,75,1,'Classic Photo Pillow',1,539.99),(56,76,1,'Classic Photo Pillow',1,539.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (45,1,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 39.99, \"quantity\": 1}]',43.99,'Pending','2025-04-30 10:04:30',NULL,NULL),(46,2,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 39.99, \"quantity\": 1}]',43.99,'Pending','2025-04-30 10:50:57',NULL,NULL),(47,3,'[{\"id\": \"3\", \"name\": \"Rectangle Throw Pillow\", \"image\": \"https://images.unsplash.com/photo-1576872381147-b9f6108c08ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 29.99, \"quantity\": 1}]',32.99,'Pending','2025-04-30 12:58:14',NULL,NULL),(48,3,'[{\"id\": \"2\", \"name\": \"Heart Shape Pillow\", \"image\": \"https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 34.99, \"quantity\": 1}]',38.49,'Pending','2025-04-30 13:02:54',NULL,NULL),(49,3,'[{\"id\": \"12\", \"name\": \"Alphabet Chocolate Set\", \"image\": \"https://images.unsplash.com/photo-1587135991058-8816a1a7e7ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80\", \"price\": 27.99, \"quantity\": 1}]',30.79,'Pending','2025-05-01 06:51:34',NULL,NULL),(50,1,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 39.99, \"quantity\": 1}]',43.99,'Pending','2025-05-01 13:06:43',NULL,NULL),(51,1,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 39.99, \"quantity\": 1}]',43.99,'Pending','2025-05-01 13:13:30',NULL,NULL),(52,1,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-01 14:05:42',NULL,NULL),(53,1,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-01 14:07:18',NULL,NULL),(54,3,'[{\"id\": \"7\", \"name\": \"Photo Wrap Mug\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 524.99, \"quantity\": 1}]',577.49,'Pending','2025-05-01 15:30:21',NULL,NULL),(55,4,'[{\"id\": \"11\", \"name\": \"Gourmet Truffle Box\", \"image\": \"https://images.unsplash.com/photo-1587135991058-8816a1a7e7ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80\", \"price\": 2034.99, \"quantity\": 1}]',2238.49,'Pending','2025-05-01 16:37:51',NULL,NULL),(56,4,'[{\"id\": \"11\", \"name\": \"Gourmet Truffle Box\", \"image\": \"https://images.unsplash.com/photo-1587135991058-8816a1a7e7ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80\", \"price\": 2034.99, \"quantity\": 1}]',2238.49,'Pending','2025-05-01 17:00:24',NULL,NULL),(57,4,'[{\"id\": \"22\", \"name\": \"Luxury Sherpa Blanket\", \"image\": \"https://images.unsplash.com/photo-1598302936620-9723f534f7a7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 619.99, \"quantity\": 1}]',681.99,'Pending','2025-05-02 05:34:10',NULL,NULL),(58,4,'[{\"id\": \"22\", \"name\": \"Luxury Sherpa Blanket\", \"image\": \"https://images.unsplash.com/photo-1598302936620-9723f534f7a7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 619.99, \"quantity\": 1}, {\"id\": \"11\", \"name\": \"Gourmet Truffle Box\", \"image\": \"https://images.unsplash.com/photo-1587135991058-8816a1a7e7ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80\", \"price\": 2034.99, \"quantity\": 1}]',2920.48,'Pending','2025-05-02 06:25:27',NULL,NULL),(59,4,'[{\"id\": \"4\", \"name\": \"Luxury Velvet Pillow\", \"image\": \"https://images.unsplash.com/photo-1576872381147-b9f6108c08ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 744.99, \"quantity\": 1}, {\"id\": \"11\", \"name\": \"Gourmet Truffle Box\", \"image\": \"https://images.unsplash.com/photo-1587135991058-8816a1a7e7ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80\", \"price\": 2034.99, \"quantity\": 1}]',3057.98,'Pending','2025-05-05 09:38:25',NULL,NULL),(60,4,'[{\"id\": \"2\", \"name\": \"Heart Shape Pillow\", \"image\": \"https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 634.99, \"quantity\": 1}]',698.49,'Pending','2025-05-05 09:50:42',NULL,NULL),(61,4,'[{\"id\": \"2\", \"name\": \"Heart Shape Pillow\", \"image\": \"https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 634.99, \"quantity\": 1}]',698.49,'Pending','2025-05-05 09:53:42',NULL,NULL),(62,4,'[{\"id\": \"13\", \"name\": \"Classic Round Cake\", \"image\": \"https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1089&q=80\", \"price\": 1549.99, \"quantity\": 1}]',1704.99,'Pending','2025-05-06 09:49:05',NULL,NULL),(63,4,'[{\"id\": \"13\", \"name\": \"Classic Round Cake\", \"image\": \"https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1089&q=80\", \"price\": 1549.99, \"quantity\": 1}]',1704.99,'Pending','2025-05-06 09:50:43',NULL,NULL),(64,4,'[{\"id\": \"13\", \"name\": \"Classic Round Cake\", \"image\": \"https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1089&q=80\", \"price\": 1549.99, \"quantity\": 1}]',1704.99,'Pending','2025-05-06 09:53:58',NULL,NULL),(65,4,'[{\"id\": \"3\", \"name\": \"Rectangle Throw Pillow\", \"image\": \"https://images.unsplash.com/photo-1576872381147-b9f6108c08ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 329.99, \"quantity\": 1}]',362.99,'Pending','2025-05-06 10:03:08',NULL,NULL),(66,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-10 12:20:51',NULL,NULL),(67,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-11 10:36:50',NULL,NULL),(68,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-11 10:40:03',NULL,NULL),(69,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-11 10:41:03',NULL,NULL),(70,4,'[{\"id\": \"3\", \"name\": \"Rectangle Throw Pillow\", \"image\": \"https://images.unsplash.com/photo-1576872381147-b9f6108c08ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 329.99, \"quantity\": 1}]',362.99,'Pending','2025-05-11 10:50:51',NULL,NULL),(71,4,'[{\"id\": \"2\", \"name\": \"Heart Shape Pillow\", \"image\": \"https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80\", \"price\": 634.99, \"quantity\": 1}]',698.49,'Pending','2025-05-11 11:04:09',NULL,NULL),(72,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 2}]',1187.98,'Pending','2025-05-11 11:12:26',NULL,'ajdoajdjasoidjaods'),(73,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 2}]',1187.98,'Pending','2025-05-11 11:46:48',NULL,'ajdoajdjasoidjaods'),(74,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-11 21:13:29',NULL,'sajdkasdasdadsad'),(75,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-12 07:58:15',NULL,'kjhawdkjaskfjanskjdnakjdsnaksd'),(76,4,'[{\"id\": \"1\", \"name\": \"Classic Photo Pillow\", \"image\": \"https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80\", \"price\": 539.99, \"quantity\": 1}]',593.99,'Pending','2025-05-12 10:45:00',NULL,'kjhawdkjaskfjanskjdnakjdsnaksd');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (33,45,1,'UPI','abin@123',43.99,'Success','2025-04-30 10:04:30'),(34,46,2,'UPI','abin@123',43.99,'Success','2025-04-30 10:50:57'),(35,47,3,'UPI','eren@oksbi',32.99,'Success','2025-04-30 12:58:14'),(36,48,3,'UPI','eren@oksbi',38.49,'Success','2025-04-30 13:02:54'),(37,49,3,'card','**** **** **** sdas',30.79,'Success','2025-05-01 06:51:34'),(38,50,1,'UPI','abin@123',43.99,'Success','2025-05-01 13:06:43'),(39,51,1,'UPI','abin@123',43.99,'Success','2025-05-01 13:13:30'),(40,52,1,'UPI','abin@123',593.99,'Success','2025-05-01 14:05:42'),(41,53,1,'card','**** **** **** 1234',593.99,'Success','2025-05-01 14:07:18'),(42,54,3,'UPI','abin@123',577.49,'Success','2025-05-01 15:30:21'),(43,55,4,'UPI','wowgiftz@123',2238.49,'Success','2025-05-01 16:37:51'),(44,56,4,'UPI','abin@123',2238.49,'Success','2025-05-01 17:00:24'),(45,57,4,'card','**** **** **** sdas',681.99,'Success','2025-05-02 05:34:10'),(46,58,4,'UPI','abin@123',2920.48,'Success','2025-05-02 06:25:27'),(47,59,4,'UPI','wowgiftz@123',3057.98,'Success','2025-05-05 09:38:25'),(48,60,4,'UPI','joseph@supermoney',698.49,'Success','2025-05-05 09:50:42'),(49,61,4,'UPI','wowgiftz@123',698.49,'Success','2025-05-05 09:53:42'),(50,62,4,'UPI','abin@123',1704.99,'Success','2025-05-06 09:49:05'),(51,63,4,'UPI','abin@123',1704.99,'Success','2025-05-06 09:50:43'),(52,64,4,'UPI','abin@123',1704.99,'Success','2025-05-06 09:53:58'),(53,65,4,'UPI','wowgiftz@123',362.99,'Success','2025-05-06 10:03:08'),(54,66,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-10 12:20:51'),(55,67,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-11 10:36:50'),(56,68,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-11 10:40:03'),(57,69,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-11 10:41:03'),(58,70,4,'UPI','wowgiftz@123',362.99,'Success','2025-05-11 10:50:51'),(59,71,4,'UPI','wowgiftz@123',698.49,'Success','2025-05-11 11:04:09'),(60,72,4,'UPI','abin@123',1187.98,'Success','2025-05-11 11:12:26'),(61,73,4,'UPI','abin@123',1187.98,'Success','2025-05-11 11:46:48'),(62,74,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-11 21:13:29'),(63,75,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-12 07:58:15'),(64,76,4,'UPI','wowgiftz@123',593.99,'Success','2025-05-12 10:45:00');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Abin S','abin@gmail.com','$2y$10$IJGtlpvhM7qnDwALOWCH/e.SpW0ljtKeqBM1dRK6XevqFa1vTKORK','2025-04-28 14:12:50',0),(2,'wowgifts','wowgifts@gmail.com','$2y$10$GNukCvilcgI0Swq2ztzVc.vkQrgK/RM8nBo6Og2rck/BSDzvwrSx.','2025-04-28 14:14:18',1),(3,'wish and wrap','123@gmail.com','$2y$10$XsehjOvkI3qfjNCNsBYHj.toCimoEabzAfLc83yRp9EqdJaktrpym','2025-04-30 12:55:09',0),(4,'roshna','roshna@gmail123.com','$2y$10$gO6YQ8w6Q.1aeTxRFFtcs.X1MDYXhaT3/yiRp6K3HBhSoh63w303G','2025-05-01 15:44:45',1),(6,'arun','arun123@gmail.com','0e35fe-bf34-4a1b-a5fc-b6ee5004c859','2025-05-02 06:54:18',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-12 16:43:38
