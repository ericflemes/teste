-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 07-Ago-2015 às 02:09
-- Versão do servidor: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `levelup`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE IF NOT EXISTS `tb_produto` (
  `cod_produto` int(11) NOT NULL,
  `cod_produto_tipo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `img` varchar(50) NOT NULL,
  `fl_status` varchar(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`cod_produto`, `cod_produto_tipo`, `nome`, `descricao`, `preco`, `img`, `fl_status`) VALUES
(1, 1, 'ROPs ', '100.000 ROPs ', '149.00', 'images/jogos/ragnarok/produtos/100000.png', 'S'),
(2, 1, 'ROPs ', '100.000 ROPs ', '149.90', 'images/jogos/ragnarok/produtos/50000.png', 'S'),
(3, 1, 'ROPs', 'ROPs', '27.00', 'images/jogos/ragnarok/produtos/25000.png', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto_tipo`
--

CREATE TABLE IF NOT EXISTS `tb_produto_tipo` (
  `cod_produto_tipo` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fl_status` char(1) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_produto_tipo`
--

INSERT INTO `tb_produto_tipo` (`cod_produto_tipo`, `tipo`, `fl_status`) VALUES
(1, 'Ragnarok', 'S'),
(2, 'Outros', 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`cod_produto`), ADD KEY `tb_produto_tipo` (`cod_produto_tipo`), ADD KEY `cod_produto_tipo` (`cod_produto_tipo`);

--
-- Indexes for table `tb_produto_tipo`
--
ALTER TABLE `tb_produto_tipo`
  ADD PRIMARY KEY (`cod_produto_tipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_produto_tipo`
--
ALTER TABLE `tb_produto_tipo`
  MODIFY `cod_produto_tipo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_produto`
--
ALTER TABLE `tb_produto`
ADD CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`cod_produto_tipo`) REFERENCES `tb_produto_tipo` (`cod_produto_tipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
