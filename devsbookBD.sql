-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Out-2020 às 00:00
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devsbookmvc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `postlikes`
--

INSERT INTO `postlikes` (`id`, `id_post`, `id_user`, `created_at`) VALUES
(9, 20, 13, '2020-10-27 19:18:25'),
(10, 20, 14, '2020-10-27 19:20:05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
(13, 13, 'photo', '2020-10-17 01:10:03', '1.jpg'),
(14, 13, 'text', '2020-10-17 01:10:14', 'Testando novo post mvc.\r\n\r\n\r\n\r\n\r\ndessa vez com quebra de linnha'),
(15, 13, 'text', '2020-10-17 01:10:41', '     a       '),
(16, 13, 'text', '2020-10-17 01:10:21', 'a'),
(17, 13, 'text', '2020-10-17 20:10:46', 'Mais uma postagem;\r\n\r\n\r\nCom multiplas linhas\r\n\r\n\r\npara testar a contagem'),
(18, 13, 'text', '2020-10-17 21:10:15', 'Mais um post para ver se aumenta o numero de pagins na contagem'),
(19, 13, 'text', '2020-10-17 21:10:48', 'Numero de paginas nao esta aumentando'),
(20, 13, 'text', '2020-10-25 02:10:33', 'boa noite!!!!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(7, 14, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) NOT NULL,
  `work` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
(1, 'cristian@cristian.com', '$2y$10$gCTodOQSxhrnSmOqZVPncuaHrh2PeNJjw19Of0Nzfo.uqpbNzuPvq', 'Cristian Visentini', '1997-09-14', 'Silveira Martins', 'Recepcionista', 'c57ad9b6e5fe65fa5097a743db261e06', 'db4fa76084fde01ef441ee6995bdc037', '9520e2940af3f43d15cfafe1806f97ad'),
(11, 'charlie@charlie.com', '$2y$10$ftOWRf.v1JZeZn7zz9KrIe7CdzmvwHI915Ek3CgiWGLrZtkyW4Vem', 'charlie', '2000-02-12', 'Florianopolis', '', 'default.jpg', 'cover.jpg', '684f23567fb1fb02f0066346b872b770'),
(12, 'newuser@user.com', '$2y$10$EbV4z3Ie/1bx9k.BGeNuW.8NzZFw1DYD3PlNOxpcC6Hy/hvje6EJG', 'novo usuario', '2004-03-20', '', '', 'default.jpg', 'cover.jpg', '3cf1039401b096460611f3393ab3bbbd'),
(13, 'cristian@teste.com', '$2y$10$UMVUxag.W7VnJSEK/QrbfODqNPZ0Eg0gxQMB/98T6VqJBpS83ZZ62', 'Cristian Visentini', '1997-09-14', 'santa maria', 'cristian corp', '214bf479bd8104e9857b54369f79c2df.jpg', '7bfd56ad6c9e564ceb39a439f040d23c.jpg', '839d330cce55f22ebd699d1b33a8d573'),
(14, 'pedro@hotmail.com', '$2y$10$GMTVAy6TsjLaGtEfjByazuaqITklG4F.yotmoTueuD34CXqPldJx.', 'Pedro Pet', '1986-04-20', '', '', 'default.jpg', 'cover.jpg', '1a79c8db3725b699de4ccc5eb0338984');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
