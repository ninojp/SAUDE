-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Out-2022 às 03:46
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_saude`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(10) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_completo` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purl` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `email`, `senha`, `nome_completo`, `endereco`, `cidade`, `telefone`, `purl`, `activo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'meu.sem@gmail.com', '$2y$10$VJ7E.M1vBxDpITQzcCm6jOE.QHnIQuBywyb6L0fTatMCUu7xXtRyK', 'Edenilson', 'sem', 'sem', '', NULL, 1, '2022-10-20 00:20:43', '2022-10-23 16:21:39', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id_encomenda` int(10) NOT NULL,
  `id_cliente` int(10) NOT NULL,
  `data_encomenda` datetime NOT NULL,
  `endereco` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_encomenda` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda_produto`
--

CREATE TABLE `encomenda_produto` (
  `id_encomenda_produto` int(11) NOT NULL,
  `id_encomenda` int(11) DEFAULT NULL,
  `designacao_produto` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preco_unidade` decimal(6,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(10) UNSIGNED NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `nome_produto` varchar(50) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `preco` decimal(6,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `visivel` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `categoria`, `nome_produto`, `descricao`, `imagem`, `preco`, `stock`, `visivel`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'masculina', 'Tshirt Vermelha', 'Ab laborum, commodi aspernatur, quas distinctio cum quae omnis autem ea, odit sint quisquam similique! Labore aliquam amet veniam ad fugiat optio.', 'tshirt_vermelha.png', '45.70', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:45:25', NULL),
(2, 'masculina', 'Tshirt Azul', 'Possimus iusto esse atque autem rem, porro officiis sapiente quos velit laboriosam id expedita odio obcaecati voluptate repudiandae dignissimos eveniet repellat blanditiis.', 'tshirt_azul.png', '55.25', 100, 1, '2021-02-06 19:45:19', '2021-02-06 19:45:25', NULL),
(3, 'masculina', 'Tshirt Verde', 'Nostrum quisquam dolorum dolor autem accusamus fugit nesciunt, atque et? Quis eum nemo quidem officia cum dolorem voluptates! Autem, earum. Similique, fugit.', 'tshirt_verde.png', '35.15', 0, 1, '2021-02-06 19:45:20', '2021-02-06 19:45:26', NULL),
(4, 'masculina', 'Tshirt Amarela', 'Molestiae quaerat distinctio, facere perferendis necessitatibus optio repellat alias commodi voluptatem velit corrupti natus exercitationem quos amet facilis sint nulla delectus.', 'tshirt_amarela.png', '32.00', 100, 1, '2021-02-06 19:45:20', '2021-02-06 19:45:27', NULL),
(5, 'feminina', 'Vestido Vermelho', 'Labore voluptatem sed in distinctio iste tempora quo assumenda impedit illo soluta repudiandae animi earum suscipit, sequi excepturi inventore magnam velit voluptatibus.', 'dress_vermelho.png', '75.20', 100, 1, '2021-02-06 19:45:21', '2021-02-06 19:45:27', NULL),
(6, 'feminina', 'Vertido Azul', 'Provident ipsum earum magnam odit in, illum nostrum est illo pariatur molestias esse delectus aliquam ullam maxime mollitia tempore, sunt officia suscipit.', 'dress_azul.png', '86.00', 100, 1, '2021-02-06 19:45:21', '2021-02-06 19:45:28', NULL),
(7, 'feminina', 'Vestido Verde', 'Qui aliquid sed quisquam autem quas recusandae labore neque laudantium iusto modi repudiandae doloremque ipsam ad omnis inventore, cum ducimus praesentium. Consectetur!', 'dress_verde.png', '48.85', 100, 1, '2021-02-06 19:45:22', '2021-02-06 19:45:28', NULL),
(8, 'feminina', 'Vestido Amarelo', 'Aspernatur labore corporis modi quis temporibus eos hic? Sed fugiat, repudiandae distinctio, labore temporibus, non magni consectetur dolorum earum amet impedit nesciunt.', 'dress_amarelo.png', '46.45', 100, 1, '2021-02-06 19:45:22', '2021-02-06 19:45:29', NULL),
(10, 'infantil_criança', 'blusa', 'sem nehuma descrição por enquanto', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id_encomenda`);

--
-- Índices para tabela `encomenda_produto`
--
ALTER TABLE `encomenda_produto`
  ADD PRIMARY KEY (`id_encomenda_produto`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id_encomenda` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `encomenda_produto`
--
ALTER TABLE `encomenda_produto`
  MODIFY `id_encomenda_produto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
