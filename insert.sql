-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14-Jul-2016 às 00:45
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookcase`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `books_users_idx` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `price`, `user`) VALUES
(1, 'Orgulho e Preconceito', 'Jane Austen', 50.58, 1),
(2, 'Toda luz que não podemos ver', 'Anthony Doerr', 40.99, 1),
(3, 'O lado bom da vida', 'Matthew Quick', 21.52, 2),
(4, 'O Extraordinário', 'R. J. Palacio', 12.99, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `pages` int(11) NOT NULL DEFAULT '1',
  `book` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chapters_book_idx` (`book`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `chapters`
--

INSERT INTO `chapters` (`id`, `title`, `pages`, `book`) VALUES
(1, 'Cap. I', 49, 2),
(2, 'Cap. II', 150, 2),
(3, 'Cap. 1', 150, 1),
(4, 'Cap. 2', 150, 1),
(5, 'Cap. I', 122, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'framework', '$2y$10$YwwnM44EaNNX28D/VVq/5.tPQ6hDCGg0awW8gUT1FglyLFAJqLmGO'),
(2, 'framework2', '$2y$10$PSk.yFfuHtKCNSr4h5q29.9JIxa.Lx5UFmXpwaqa6JrGcSNz8TJW6');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_book` FOREIGN KEY (`book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
