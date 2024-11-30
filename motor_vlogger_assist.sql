-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 09:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motor_vlogger_assist`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `event_description` varchar(500) NOT NULL,
  `min_participants` int(10) NOT NULL,
  `max_participants` int(10) NOT NULL,
  `event_location` varchar(50) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `user_id`, `event_name`, `event_type`, `event_description`, `min_participants`, `max_participants`, `event_location`, `event_date`, `start_time`, `end_time`) VALUES
(15, 22, 'Rally Road Adventure', 'Rally', 'one of the largest and most famous motor bike rallies', 50, 100, 'colombo', '2024-08-08', '05:30:00', '18:00:00'),
(17, 22, 'Charity Toy Run', 'Charity Rides', 'Collect and deliver toys with children in need ', 5, 30, 'galle', '2024-08-29', '23:47:00', '01:00:00'),
(19, 22, 'Fun Races', 'Races', 'Not all races has to be serious.', 15, 35, 'Colombo', '2024-08-22', '10:00:00', '16:00:00'),
(23, 22, 'Cancer Awareness Rally', 'Rally', 'Rally to raise awareness about cancer', 50, 100, 'Kegalle', '2024-11-30', '12:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_signup`
--

CREATE TABLE `event_signup` (
  `event_signup_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_signup`
--

INSERT INTO `event_signup` (`event_signup_id`, `event_id`, `user_id`, `email`) VALUES
(19, 15, 22, 'mohamedilsam2018@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(200) NOT NULL,
  `place_name` varchar(200) NOT NULL,
  `place_description` text NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(200) NOT NULL,
  `image_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `place_name`, `place_description`, `location`, `type`, `image_url`) VALUES
(7, 'Nine Arches Bridge', 'Ride through the picturesque landscapes to the Nine Arches Bridge, an iconic marvel of engineering nestled amidst lush greenery. Capture the charm of this stunning viaduct, renowned for its graceful arches and scenic backdrop. The combination of natural beauty and historical significance makes it a fantastic subject for your vlog.', '{\"lat\": 6.876990835942234, \"lng\":  81.06087332287113}', 'Architectural', 'https://images.convertbox.com/users/3008/1b522bf48d0fbe3f12d01b1a068698c4.jpg'),
(8, 'Sigiriya Rock', 'Ride to the majestic Sigiriya Rock, an ancient fortress rising dramatically from the landscape. Capture the awe-inspiring views from the top, the intricate frescoes, and the sprawling ruins of this UNESCO World Heritage Site. With its striking appearance and rich history, Sigiriya Rock offers a perfect blend of adventure and cultural depth for your vlog.', '{\"lat\": 7.959098426331559, \"lng\":  80.76037156911447}', 'Historical', 'https://h2.gifposter.com/bingImages/LionRock_EN-US3384136847_1920x1080.jpg'),
(9, 'Sinharaja Forest', 'Venture into the heart of Sinharaja Forest, a UNESCO World Heritage Site renowned for its rich biodiversity and lush rainforests. Capture the vibrant flora and fauna, along with the serene atmosphere of this tropical paradise. The journey through winding roads to this pristine wilderness offers a perfect mix of adventure and natural beauty for your vlog.', '{\"lat\": 6.4444991725047345 , \"lng\": 80.41990823058738}\r\n\r\n', 'Rainforest', 'https://groundviews.org/wp-content/uploads/2021/04/IMG_20210411_144601-1-1200x550.jpg'),
(10, 'Arthur\'s Seat', 'Ride to Arthur\'s Seat for panoramic views and breathtaking vistas from this iconic vantage point. Capture the sweeping landscapes, rolling hills, and the vibrant atmosphere as you ascend to one of the best viewpoints in the region. It\'s a perfect destination for adding awe-inspiring scenery and a touch of adventure to your vlog.', '{\"lat\": 7.289146880206802 , \"lng\": 80.6397623547278}', 'View Point', 'https://static.wanderon.in/wp-content/uploads/2024/04/kandy-lake.jpg'),
(12, 'Nuwera Eliya', 'Experience the thrill of conquering winding roads and steep climbs as you ride through scenic hills. Feel the fresh mountain air, witness breathtaking views, and enjoy the challenge of navigating sharp turns. Whether you\'re seeking adventure or tranquility, a hill ride offers an exhilarating journey that connects you with nature and the open road.', '{\"lat\": 6.950171617200722, \"lng\":  80.7903871816178}\r\n', 'Mountain', 'https://rb.gy/c2pitv'),
(13, 'Bentota Beach', 'Ride along the stunning coastal roads to Bentota Beach, where golden sands meet the sparkling blue waters of the Indian Ocean. Enjoy the breeze as you cruise through palm-lined paths and immerse yourself in the tranquil beauty of this tropical paradise. A perfect destination for riders seeking relaxation and a taste of Sri Lanka\'s serene coastline.', '{\"lat\": 6.425367129677265, \"lng\":  79.99515033752971}\r\n', 'Beach', 'https://rb.gy/j76kba'),
(14, 'Sacred City of Polonnaruwa ', 'Ride through the ancient ruins of Polonnaruwa, a UNESCO World Heritage Site, where history and culture come alive. Capture the grandeur of ancient temples, royal palaces, and intricate stone carvings as you explore this sacred city on two wheels. The tranquil roads and rich historical backdrop make it a perfect destination for moto vloggers seeking a blend of adventure and heritage.', '{\"lat\": 7.952974287084377 , \"lng\": 81.00503248761483 }', 'Historical', 'https://rb.gy/w63tpf'),
(15, 'Pinnawala Elephant Orphanage', 'Embark on a memorable ride to Pinnawala Elephant Orphanage, where you can witness the majestic beauty of rescued elephants in their natural habitat. Capture unique moments as these gentle giants roam freely, bathe in the river, and interact with their caretakers. For moto vloggers, this is a perfect spot to blend wildlife, nature, and a scenic journey into your content.', '{\"lat\": 7.301046045986843 , \"lng\": 80.38890863938242 }\r\n', 'Wildlife', 'https://rb.gy/4w41qc'),
(16, 'Old Town of Galle and its Fortifications', 'Explore the charm of Galle\'s Old Town and its historic fortifications on your ride. Capture the stunning blend of colonial architecture, ancient ramparts, and vibrant streets set against a backdrop of picturesque beaches. With its rich history and coastal beauty, this destination offers a perfect mix of scenic views and cultural heritage for your vlog.', '{\"lat\": 6.026707795289849, \"lng\":  80.21740911878362}', 'Historical / beach', 'https://rb.gy/pdow1f'),
(17, 'Bambarakanda Waterfalls', 'Journey to Bambarakanda Waterfalls, Sri Lanka\'s highest waterfall, and capture the stunning natural beauty of its cascading waters surrounded by lush greenery. The scenic ride through mountainous terrain leads to a breathtaking view, perfect for adding dramatic and serene elements to your vlog. Ideal for those seeking adventure and nature’s grandeur on their two-wheeled exploration.', '{\"lat\": 6.773734746823226, \"lng\":  80.83116013624131}', 'Natural / Waterfalls', 'https://rb.gy/hsiz49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`) VALUES
(22, 'Ilsham', 'mohamedilsam2018@gmail.com', '$2y$10$pI9QV2skDyBTfypsyuNlZ.Wlc6FzmNZKfKDRiqSnXo3SFUBf8Q1IC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);
ALTER TABLE `event` ADD FULLTEXT KEY `event_name` (`event_name`,`event_type`,`event_description`,`event_location`);

--
-- Indexes for table `event_signup`
--
ALTER TABLE `event_signup`
  ADD PRIMARY KEY (`event_signup_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);
ALTER TABLE `places` ADD FULLTEXT KEY `place_name` (`place_name`,`place_description`,`type`,`image_url`);
ALTER TABLE `places` ADD FULLTEXT KEY `image_url` (`image_url`);
ALTER TABLE `places` ADD FULLTEXT KEY `location` (`location`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);
ALTER TABLE `user` ADD FULLTEXT KEY `name` (`name`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `event_signup`
--
ALTER TABLE `event_signup`
  MODIFY `event_signup_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
