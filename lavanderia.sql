-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05/09/2025 às 13:57
-- Versão do servidor: 8.4.5-5
-- Versão do PHP: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lavanderia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacoes`
--

CREATE TABLE `anotacoes` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `modulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pagina` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagina_nome` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria` enum('melhorias','alteracoes','exclusoes') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolvida` tinyint(1) NOT NULL DEFAULT '0',
  `data_resolucao` timestamp NULL DEFAULT NULL,
  `observacao_resolucao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `anotacoes`
--

INSERT INTO `anotacoes` (`id`, `usuario_id`, `modulo`, `pagina`, `pagina_nome`, `categoria`, `texto`, `resolvida`, `data_resolucao`, `observacao_resolucao`, `created_at`, `updated_at`) VALUES
(1, 13, 'empacotamento', '/empacotamento/20', 'Detalhes (#20) do Empacotamento', 'melhorias', 'Ao editar o empacotamento, as etiquetas que já foram impressas devem ficas desabilitadas para impressao. Teria apenas a opção de reimprimir qrcode no qr desabilitado. Evita que sejam impressas novamente.', 0, NULL, NULL, '2025-08-31 15:43:29', '2025-08-31 15:43:29'),
(2, 13, 'empacotamento', '/empacotamento/20', 'Detalhes (#20) do Empacotamento', 'melhorias', 'NO qr code devem ser impressas as seguintes informações:\nnome do hote.\ntipo de peça.\nquantidade de peças, não precisa especificar \"roupa de banho\" etc.', 0, NULL, NULL, '2025-08-31 15:47:15', '2025-08-31 15:47:15'),
(3, 13, 'empacotamento', '/empacotamento/20/editar', 'Edição - Empacotamento', 'melhorias', 'No empacotamento, após criar os lotes a barra deve mudar de cor, do azul clarinho para uma verde.\n\nno progresso do empacotamento, ele deve ir avançando conforme cada tipo de enxoval for sendo finalizado seu empacotamento. Atualmente esta como progresso dos lotes, deve ficar como progresso de empacotamento e   se tiver 7 tipos de peças o progresso deve ir avançado com a finalização de cada tipo de peça empacotada.', 0, NULL, NULL, '2025-08-31 15:52:58', '2025-08-31 15:52:58'),
(4, 13, 'empacotamento', '/empacotamento/20/editar', 'Edição - Empacotamento', 'melhorias', 'Ao adicionar PEÇA EXTRA você insere mas não há botõa de ok. ou seja não dá para ir finalizando cada tipo de peças, apenas quando clicar em salvar alteraçõe.', 0, NULL, NULL, '2025-08-31 15:58:59', '2025-08-31 15:58:59'),
(5, 13, 'empacotamento', '/empacotamento/20', 'Detalhes (#20) do Empacotamento', 'melhorias', 'NO qr code devem ser impressas as seguintes informações: nome do hotel. tipo de peça. quantidade de peças, data, nome do responsável\nnão precisa especificar \"roupa de banho\" etc.', 0, NULL, NULL, '2025-08-31 16:08:48', '2025-08-31 16:08:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `coletas`
--

CREATE TABLE `coletas` (
  `id` bigint UNSIGNED NOT NULL,
  `estabelecimento_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `data_agendamento` datetime NOT NULL,
  `data_coleta` datetime DEFAULT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `acompanhante` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_cancelamento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `peso_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `numero_coleta` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coletas`
--

INSERT INTO `coletas` (`id`, `estabelecimento_id`, `usuario_id`, `status_id`, `data_agendamento`, `data_coleta`, `data_conclusao`, `observacoes`, `acompanhante`, `motivo_cancelamento`, `peso_total`, `numero_coleta`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '2025-08-29 11:15:24', '2025-08-29 12:58:44', '2025-08-29 12:58:44', NULL, 'LUCAS MATTIELLO', NULL, 15.00, 'COL000001', '2025-08-29 11:15:24', '2025-08-29 12:58:44'),
(2, 2, 1, 3, '2025-08-29 13:03:47', '2025-08-29 13:05:07', '2025-08-29 13:05:07', NULL, 'LUCAS MATTIELLO', NULL, 0.00, 'COL000002', '2025-08-29 13:03:47', '2025-08-29 13:05:07'),
(3, 1, 1, 3, '2025-08-30 15:33:28', '2025-08-30 15:35:40', '2025-08-30 15:35:40', 'teste testando', 'LUCAS MATTIELLO', NULL, 0.00, 'COL000003', '2025-08-30 15:33:28', '2025-08-30 15:35:40'),
(4, 2, 1, 3, '2025-08-30 15:49:00', '2025-08-30 15:46:14', '2025-08-30 15:46:14', 'terste testando', 'LUCAS MATTIELLO', NULL, 0.00, 'COL000004', '2025-08-30 15:43:18', '2025-08-30 15:46:14'),
(5, 1, 1, 3, '2025-08-30 16:05:50', '2025-08-30 16:08:15', '2025-08-30 16:08:15', NULL, 'Ines rodrigues', NULL, 0.00, 'COL000005', '2025-08-30 16:05:50', '2025-08-30 16:08:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `coleta_pecas`
--

CREATE TABLE `coleta_pecas` (
  `id` bigint UNSIGNED NOT NULL,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED NOT NULL,
  `quantidade` int NOT NULL,
  `peso` decimal(8,2) NOT NULL,
  `quantidade_empacotada` int NOT NULL DEFAULT '0',
  `peso_empacotado` decimal(8,2) NOT NULL DEFAULT '0.00',
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coleta_pecas`
--

INSERT INTO `coleta_pecas` (`id`, `coleta_id`, `tipo_id`, `quantidade`, `peso`, `quantidade_empacotada`, `peso_empacotado`, `observacoes`, `created_at`, `updated_at`) VALUES
(1, 1, 16, 0, 15.00, 0, 0.00, NULL, '2025-08-29 12:58:41', '2025-08-29 12:58:41'),
(2, 2, 10, 25, 0.00, 0, 0.00, NULL, '2025-08-29 13:04:50', '2025-08-29 13:04:50'),
(3, 2, 9, 15, 0.00, 0, 0.00, NULL, '2025-08-29 13:04:50', '2025-08-29 13:04:50'),
(4, 2, 2, 18, 0.00, 0, 0.00, NULL, '2025-08-29 13:04:50', '2025-08-29 13:04:50'),
(5, 2, 3, 159, 0.00, 0, 0.00, NULL, '2025-08-29 13:04:50', '2025-08-29 13:04:50'),
(6, 3, 2, 10, 0.00, 0, 0.00, NULL, '2025-08-30 15:35:33', '2025-08-30 15:35:33'),
(7, 3, 2, 10, 0.00, 0, 0.00, NULL, '2025-08-30 15:35:33', '2025-08-30 15:35:33'),
(19, 4, 4, 10, 0.00, 0, 0.00, NULL, '2025-08-30 15:45:54', '2025-08-30 15:45:54'),
(18, 4, 7, 20, 0.00, 0, 0.00, NULL, '2025-08-30 15:45:54', '2025-08-30 15:45:54'),
(17, 4, 1, 30, 0.00, 0, 0.00, NULL, '2025-08-30 15:45:54', '2025-08-30 15:45:54'),
(16, 4, 3, 60, 0.00, 0, 0.00, NULL, '2025-08-30 15:45:54', '2025-08-30 15:45:54'),
(28, 5, 5, 12, 0.00, 0, 0.00, NULL, '2025-08-30 16:08:04', '2025-08-30 16:08:04'),
(27, 5, 7, 100, 0.00, 0, 0.00, NULL, '2025-08-30 16:08:04', '2025-08-30 16:08:04'),
(26, 5, 3, 100, 0.00, 0, 0.00, NULL, '2025-08-30 16:08:04', '2025-08-30 16:08:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empacotamento`
--

CREATE TABLE `empacotamento` (
  `id` bigint UNSIGNED NOT NULL,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `usuario_empacotamento_id` bigint UNSIGNED NOT NULL,
  `motorista_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `codigo_qr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_empacotamento` datetime NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  `data_confirmacao_recebimento` datetime DEFAULT NULL,
  `assinatura_recebimento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_recebedor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assinatura_recebedor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observacoes_empacotamento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observacoes_entrega` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `motorista_saida_id` bigint UNSIGNED DEFAULT NULL,
  `motorista_entrega_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empacotamento`
--

INSERT INTO `empacotamento` (`id`, `coleta_id`, `usuario_empacotamento_id`, `motorista_id`, `status_id`, `codigo_qr`, `data_empacotamento`, `data_saida`, `data_entrega`, `data_confirmacao_recebimento`, `assinatura_recebimento`, `nome_recebedor`, `assinatura_recebedor`, `observacoes_empacotamento`, `observacoes_entrega`, `created_at`, `updated_at`, `motorista_saida_id`, `motorista_entrega_id`) VALUES
(16, 2, 1, NULL, 9, 'EMPMEJV8FF8', '2025-08-30 12:29:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 12:29:45', '2025-08-30 15:32:29', NULL, NULL),
(17, 3, 1, NULL, 8, 'EMPFDDIHSHA', '2025-08-30 15:37:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 15:37:52', '2025-08-30 15:40:35', NULL, NULL),
(18, 1, 1, NULL, 8, 'EMPPWPQBQJP', '2025-08-30 15:47:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:53:00', NULL, NULL),
(19, 4, 1, NULL, 9, 'EMPRCEHDKC8', '2025-08-30 16:09:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 16:09:54', '2025-08-30 17:04:58', NULL, NULL),
(20, 5, 13, NULL, 9, 'EMPFA4SBK3C', '2025-08-31 15:34:00', NULL, NULL, NULL, NULL, NULL, NULL, 'njj', NULL, '2025-08-31 15:35:06', '2025-08-31 16:22:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empacotamento_pecas`
--

CREATE TABLE `empacotamento_pecas` (
  `id` bigint UNSIGNED NOT NULL,
  `empacotamento_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED NOT NULL,
  `codigo_qr` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int NOT NULL,
  `peso` decimal(8,3) NOT NULL DEFAULT '0.000',
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_saida` enum('pronto','em_transito','entregue') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pronto',
  `data_saida` timestamp NULL DEFAULT NULL,
  `motorista_saida_id` bigint UNSIGNED DEFAULT NULL,
  `data_entrega` timestamp NULL DEFAULT NULL,
  `motorista_entrega_id` bigint UNSIGNED DEFAULT NULL,
  `nome_recebedor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assinatura_recebedor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empacotamento_pecas`
--

INSERT INTO `empacotamento_pecas` (`id`, `empacotamento_id`, `tipo_id`, `codigo_qr`, `quantidade`, `peso`, `observacoes`, `status_saida`, `data_saida`, `motorista_saida_id`, `data_entrega`, `motorista_entrega_id`, `nome_recebedor`, `assinatura_recebedor`, `created_at`, `updated_at`) VALUES
(55, 18, 2, 'PCGEPZKV3T', 12, 0.000, 'Peça extra - Não estava na coleta original', 'em_transito', '2025-08-30 15:53:00', 1, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:53:00'),
(54, 18, 5, 'PCMSLEHEO9', 20, 0.000, 'Peça extra - Não estava na coleta original', 'em_transito', '2025-08-30 15:52:50', 1, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:52:50'),
(52, 18, 10, 'PCSRFTA5UX', 10, 0.000, 'Peça extra - Não estava na coleta original', 'em_transito', '2025-08-30 15:52:28', 1, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:52:28'),
(53, 18, 9, 'PCEJIW5SWG', 15, 0.000, 'Peça extra - Não estava na coleta original', 'em_transito', '2025-08-30 15:52:34', 1, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:52:34'),
(51, 17, 10, 'PCPG8I7VAM', 10, 0.000, 'Peça extra: relave', 'pronto', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 15:39:21', '2025-08-30 15:39:21'),
(50, 16, 10, 'PCOUQZUWY9', 25, 0.000, 'Lote adicional - Tipo: Calça', 'em_transito', '2025-08-30 12:30:56', 1, NULL, NULL, NULL, NULL, '2025-08-30 12:29:57', '2025-08-30 12:30:56'),
(56, 18, 12, 'PCAKYNFCDJ', 18, 0.000, 'Peça extra - Não estava na coleta original', 'em_transito', '2025-08-30 15:52:07', 1, NULL, NULL, NULL, NULL, '2025-08-30 15:49:21', '2025-08-30 15:52:07'),
(57, 19, 4, 'PCQKFURZKW', 5, 0.000, 'Lote adicional - Tipo: Edredom', 'em_transito', '2025-08-30 16:58:55', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:58:55'),
(58, 19, 4, 'PCCZOJUK7W', 5, 0.000, 'Lote adicional - Tipo: Edredom', 'em_transito', '2025-08-30 16:59:44', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:59:44'),
(59, 19, 7, 'PCJNMP4B9Q', 5, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-30 17:03:09', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 17:03:09'),
(60, 19, 7, 'PCPDAWM0CC', 5, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-30 16:59:31', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:59:31'),
(61, 19, 7, 'PCC7GWSEUR', 5, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-30 16:59:19', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:59:19'),
(62, 19, 7, 'PCTLHU1F02', 5, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-30 16:59:52', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:59:52'),
(63, 19, 1, 'PCARENXAAJ', 10, 0.000, 'Lote adicional - Tipo: Lençol Solteiro', 'em_transito', '2025-08-30 16:45:56', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:45:56'),
(64, 19, 1, 'PCTFSEKOZ1', 10, 0.000, 'Lote adicional - Tipo: Lençol Solteiro', 'em_transito', '2025-08-30 16:46:05', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:46:05'),
(65, 19, 1, 'PCXD2NDGYE', 10, 0.000, 'Lote adicional - Tipo: Lençol Solteiro', 'em_transito', '2025-08-30 16:46:23', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:46:23'),
(66, 19, 3, 'PCHJ0UHQIE', 30, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-30 16:46:33', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:46:33'),
(67, 19, 3, 'PCYHST8YR4', 31, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-30 16:58:48', 12, NULL, NULL, NULL, NULL, '2025-08-30 16:13:19', '2025-08-30 16:58:48'),
(68, 20, 5, 'PCOTTDZUBS', 7, 0.000, 'Lote adicional - Tipo: Colcha', 'em_transito', '2025-08-31 16:17:22', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:36:30', '2025-08-31 16:17:22'),
(69, 20, 5, 'PCFYLKHMSJ', 6, 0.000, 'Lote adicional - Tipo: Colcha', 'em_transito', '2025-08-31 16:19:15', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:36:30', '2025-08-31 16:19:15'),
(70, 20, 7, 'PCZVTFXH3M', 10, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:17:30', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:17:30'),
(71, 20, 7, 'PCRZ3WXGPS', 12, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:17:37', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:17:37'),
(72, 20, 7, 'PCPIEKUGOG', 10, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:17:43', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:17:43'),
(73, 20, 7, 'PC7S6AZTF4', 9, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:17:51', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:17:51'),
(74, 20, 7, 'PCTFQJBUKD', 8, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'pronto', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 15:40:42'),
(75, 20, 7, 'PCIGUD8V7J', 20, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:18:07', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:18:07'),
(76, 20, 7, 'PCL64Z8F3N', 20, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'pronto', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 15:40:42'),
(77, 20, 7, 'PCTITNQJLN', 16, 0.000, 'Lote adicional - Tipo: Toalha de Rosto', 'em_transito', '2025-08-31 16:18:12', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:40:42', '2025-08-31 16:18:12'),
(78, 20, 3, 'PC7NKJKEUL', 20, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-31 16:16:22', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 16:16:22'),
(79, 20, 3, 'PC1UZPKXJJ', 20, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-31 16:16:40', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 16:16:40'),
(80, 20, 3, 'PCABUX8OA1', 20, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-31 16:17:00', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 16:17:00'),
(81, 20, 3, 'PCKNVDV0NJ', 20, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-31 16:17:05', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 16:17:05'),
(82, 20, 3, 'PCYBX1XXIV', 20, 0.000, 'Lote adicional - Tipo: Fronha', 'em_transito', '2025-08-31 16:17:16', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 16:17:16'),
(83, 20, 8, 'PCKNCJA3AE', 7, 0.000, 'Peça extra: relave', 'pronto', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-31 15:55:18', '2025-08-31 15:55:18'),
(84, 20, 9, 'PCKETAV6BA', 1, 0.000, 'Peça extra: relave', 'em_transito', '2025-08-31 16:18:17', 11, NULL, NULL, NULL, NULL, '2025-08-31 15:59:06', '2025-08-31 16:18:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entregas`
--

CREATE TABLE `entregas` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `empacotamento_id` bigint UNSIGNED NOT NULL,
  `motorista_saida_id` bigint UNSIGNED DEFAULT NULL,
  `motorista_entrega_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  `data_confirmacao_recebimento` datetime DEFAULT NULL,
  `nome_recebedor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assinatura_recebedor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `assinatura_cliente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observacoes_entrega` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `entregas`
--

INSERT INTO `entregas` (`id`, `created_at`, `updated_at`, `empacotamento_id`, `motorista_saida_id`, `motorista_entrega_id`, `status_id`, `data_saida`, `data_entrega`, `data_confirmacao_recebimento`, `nome_recebedor`, `assinatura_recebedor`, `assinatura_cliente`, `observacoes_entrega`) VALUES
(2, '2025-08-30 03:23:08', '2025-08-30 03:23:08', 9, 1, NULL, 8, '2025-08-30 03:23:08', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2025-08-30 03:26:51', '2025-08-30 03:26:51', 10, 1, NULL, 8, '2025-08-30 03:26:51', NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2025-08-30 11:55:36', '2025-08-30 11:55:36', 11, 1, NULL, 8, '2025-08-30 11:55:36', NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2025-08-30 12:05:40', '2025-08-30 12:05:40', 12, 1, NULL, 8, '2025-08-30 12:05:40', NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2025-08-30 12:15:20', '2025-08-30 12:15:20', 13, 1, NULL, 8, '2025-08-30 12:15:20', NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2025-08-30 12:18:50', '2025-08-30 12:18:50', 14, 1, NULL, 8, '2025-08-30 12:18:50', NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2025-08-30 12:30:56', '2025-08-31 15:33:12', 16, 1, 11, 9, '2025-08-30 12:30:56', '2025-08-31 15:33:12', NULL, 'Uh', 'data:image/png;base64,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', NULL, NULL),
(12, '2025-08-31 16:19:47', '2025-08-31 16:24:09', 20, 11, 13, 9, '2025-08-31 16:19:47', '2025-08-31 16:24:09', NULL, 'tereza', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAB4CAYAAABIFc8gAAAKwElEQVR4AeydScg0xRnH35h9IWQjELIcspBcAiEJJJDkEJJASEgCISskOSTEm6DeRD0p3hT0pqgHd0VBRHBBRUQRERXEgyvuoogb7rv//+DzWt98M9Mz09Pdtfyk6q2nq7qrnudX3f+vu6ZnPGSP/yAAAQgUQgDBKmSicBMCENjbQ7A4CyAAgWIIIFjFTFV/R+kBAqUTQLBKn0H8h0BDBBCshiabUCFQOgEEq/QZxH8ILCJQaR2CVenEEhYEaiSAYNU4q8QEgUoJIFiVTixhQaBGAgjWolmlDgIQyJIAgpXltOAUBCCwiACCtYgKdRCAQJYEEKwspwWnxiPASCURQLBKmi18hUDjBBCsxk8AwodASQQQrJJmC18h0DiBnoLVOD3ChwAERiWAYI2Km8EgAIE+BBCsPvQ4FgIQGJUAgjUq7qIHw3kITE4AwZp8CnAAAhBYlwCCtS4p9oMABCYngGBNPgU4AIH8COTqEYKV68zgFwQgcBABBOsgJFRAAAK5EkCwcp0Z/IIABA4igGAdhKR/BT1AAALDEECwhuFKrxCAwAAEEKwBoNIlBCAwDAEEaxiu9NoKAeIclQCCNSpuBoMABPoQQLD60ONYCEBgVAII1qi4GQwCEOhDYFrB6uM5x0IAAs0RQLCam3IChkC5BBCscucOzyHQHAEEq7kpnypgxoVAfwIIVn+G9AABCIxEAMEaCTTDQAAC/QkgWP0Z0gMEIHAggcG2EKzB0NIxBCCwawII1q6J0h8EIDAYAQRrMLR0DAEI7JoAgrVrov37owcIQGAJAQRrCRiqIQCB/AggWPnNCR5BAAJLCCBYS8BQDYExCDDGZgQQrM14sTcEIDAhAQRrQvgMDQEIbEYAwdqMF3tDAAITEihasCbkxtAQgMAEBBCsCaAzJAQgsB0BBGs7bhwFAQhMQADBmgA6Q25BgEMgIAIIliCQIACBMgggWGXME15CAAIigGAJAgkCEMiJwHJfEKzlbGiBAAQyI4BgZTYhuAMBCCwngGAtZ0MLBCCQGQEEK7MJ6e8OPUCgXgIIVr1zS2QQqI4AglXdlBIQBOolgGDVO7dEVj+B5iJEsJqbcgKGQLkEEKxy5w7PIdAcAQSruSknYAiUS6BlwSp31vAcAo0SQLAanXjChkCJBBCsEmcNnyHQKAEEq9GJby1s4q2DAIJVxzwSBQSaIIBgNTHNBAmBOgggWHXMI1FAoAkCawlWEyQIEgIQyJ4AgpX9FOEgBCAQBBCsIEEJAQhkTwDByn6KRnaQ4SCQMQEEK+PJydS1f8uvd5Q/pEyCwKgEEKxRcRc/2EcVwVnKFiuLlkwSBMYjgGCNx7qGkd5IgkCwEhhlmuV5jWCVN2dTeZwK1Lty4sPKJAiMSgDBGhV3sYM9I8/9GKhilmo7b25QVC8rP6V8h/Jpyl9VJmVGoLYTLzO8VbjzpqL4gnKkks+ZmxXE68q+W/RdYuRfqO5Tyl9W/oHy/5UfU472VaX7ivyWjnlN+XJl0gAESj75BsCxSZdN7OsL8SNJpL+T7YtXRdbpMHnn9Tb7b38j/1T1H1NO7xa12Su5r8h+TP64evu9cozp0n68rTpSTwIIVk+AFR/ui8wXYoRo+4rYyLC8Vz7ZZwvEKbL9iaZ9lrkweb9X1HKusvdblP0Kx2Vqv1/5eeVFd2eq7kzu29eax/xb597ssJSAIS5tpKFJAr9R1L6wfJHJ3Ettb+eSvylHXlW2f87fkR0+y9xPbvN+l6jG7ZF97n9adf9SXpbOUcOflN3351V+Qtl3UT42cvSXlr4rfUD7hoDK3E8XynpEmbQFAUPf4jAOqZjA1UlsvthzOkdOlW9+tLJfFgQLiKoOSG67SDUhIPbf61N/Ud22adPj7OO3dVCIm33x3ZmqZunr+uv1LhWkTQh4MjfZn33rJuA7gojQdg7nx41yyL5YiA6Vvcgnr1d9X20WBrf/XXZuyeJ6e+KUxcxxJVWYXQQ8uV370N4GgZcUpi94FbPHQF9QtqfIT2hQC5Tzz2SHXzJnyfVPy3K9sxe679J27ulHctD+qpgl245ltsGfbgIIVjejFvbwupXXcyLWsc+Lb2jgF5V98Tp/RfZ88mPWBar0RW7//AqCNotMjsFxhvPcaQWJjtIT37FL72Y6yJ9Aum7li2kMj4/QIH6U84X7sOzPKM8nv8wZdyVeyP7n/A4Fb/vac+wOYSzmHqvobGhFB4DzvQmk/7qndu+OF3RwpOp8p+QL9STZfvVAxX5yvV8h8AXsbBFL1332d6zEeLySOEYLA8EaDXWWA/kxzMJg5ywWQ61bHa0B3P+JKufPOb9Jf7Lq7Yfb/AqBNptI/rQwAn0yDMrlBHyCLG+lpXYCvoOJGHdyLkRn75fHqLRQHa8yTX4J0+tUFim/eX542tioXfKa3GhTNsRJOprzDNSLgIUkOrgpjB2VcUd13Fx/12rbIuWXMLmjEIwkDf04ngxVrolglTt3fTxPLw4L18/7dJYca4Fyf/N3VNdoHwvVr1WSPiDw0Afmnj9USDYxFxFAsBZRqbvOn7xZPBylxWUX58BR6sx9+RFQ5n66XpbH8msTMklzBPw6x1xVQZsTuLqLk3UCtxlySwKeb39NJQ73dtjblv7KyQlzB1+nbQvVL1WSlhMwI7da7F2SOwjs4oTtGILmjAj4lYJwx18IDnub0q8f+ELzonkcf5UMX4S/UklaTeDSpPnWxMZcQQDBWgGnsqb5dav0Tms+VH8vb74utr8lw0LlUuYsPau/FqrfqiStR+CPyW4/SWzMFQQQrBVwBm0at/PnNJwFRcUsrZr307XHncrprxv4DXP/dpSFyndWap4li6CF74uzLf6sS+B87RjzYabaJK1DYNWJu87x7FMGgc8lbsaFklQdYP75/a3/qPySsr8+c57KTyqn6Wxt+EXTvo+W6qa59I8k4hcSG7ODAILVAaiC5vR3l3xH1BVSfLz+B+3oX0SIr8/4TuA21VnwnC1o2iRtSMAc4xDPh99Ji23KDgIIVgegCpp9FxRhpHbUzZf+3aa0zgv1fq/K58qP0wbsdQns72eBig0L1zrzEftTioBPQhWkSgmkd1epvSpcr1X5MdD/5xevT/mO69hVB9C2FgELv+9MY2euvSCxQQm0DWAVuGv6L3g82nWF4fUu/yCeHwlZn+qitV77fdotvdZS4VITaV0CKcR1j2G/Mgj4VxDCU7/cGTbluAS+q+H8++4qZul7s7/82YpAAYK1VVwctHfAd9Pm16XgMx6Bu5Oh/if7HmXSlgQO2fI4DsubQHp39VrerlbtnRfWI8AHZZypTOpBAMHqAS/jQ71QHu7Nvz8V9ZTDEkg/EfSHGP7/KA47YgO9I1j1TXK6UF7a3VUts+E1w1hY912WP8SoJbZJ40CwJsU/yODpehV3V4MgXtnpGWpNvxDONSYgu0rA3BXJPPrxb12FJ/699rApxyHwqIb5r3KkuMuKbcqeBBCsngAzO9wveoZLnw2DchQCfjH3a8lIf01szAUEtqlCsLahlv8xXjfJ38t6PPQCe/qS7g8V2sXKpB0TQLB2DDST7l7KxI8W3PA/Dumjn9cQ72gh8CliRLCmoD78mPyG+vCMPYLFymVkC5c/IYxtyh0TQLB2DHSs7haM459+iepbwqAchMCV6jUVK9sWK1WThiTwHgAAAP//Xha21gAAAAZJREFUAwB+m/BvBXV2pAAAAABJRU5ErkJggg==', NULL, NULL),
(9, '2025-08-30 15:40:35', '2025-08-30 15:40:35', 17, 1, NULL, 8, '2025-08-30 15:40:35', NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2025-08-30 15:53:00', '2025-08-30 15:53:00', 18, 1, NULL, 8, '2025-08-30 15:53:00', NULL, NULL, NULL, NULL, NULL, NULL),
(11, '2025-08-30 17:03:09', '2025-08-31 15:18:09', 19, 12, 1, 9, '2025-08-30 17:03:09', '2025-08-31 15:18:09', NULL, 'tito', 'data:image/png;base64,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', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estabelecimentos`
--

CREATE TABLE `estabelecimentos` (
  `id` bigint UNSIGNED NOT NULL,
  `cnpj` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_fantasia` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complemento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_old` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contato_responsavel_old` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emails` json DEFAULT NULL,
  `contatos_responsaveis` json DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id`, `cnpj`, `razao_social`, `nome_fantasia`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `telefone`, `email_old`, `contato_responsavel_old`, `observacoes`, `ativo`, `created_at`, `updated_at`, `emails`, `contatos_responsaveis`) VALUES
(1, '03737166000183', 'KOCHE & DALLA COSTA LTDA.', 'HOTEL 10', '101 NORTE, CONJUNTO 01, LOTE 01', 'SN', 'AV.TEOTONIO SEGURADO', 'PLANO DIRETOR NORTE', 'PALMAS', 'TO', '77001004', '(63) 2104-1010', NULL, NULL, NULL, 1, '2025-08-29 11:13:07', '2025-08-29 11:13:07', '[\"hotel10palmas@hotel10.com.br\", \"financeiropalmas@hotel10.com.br\"]', '[{\"nome\": \"FABIANA\", \"telefone\": \"(63) 99248-4601\"}]'),
(2, '04037547000112', 'FAIXA EMPREENDIMENTOS TURISTICOS LTDA', '103 HOTEL & FLATS', '103 SUL RUA SO 1', '36', 'QUADRAACSO 1 CONJ 02 LOTE 13', 'PLANO DIRETOR SUL', 'PALMAS', 'TO', '77015014', '(63) 3215-3036', NULL, NULL, NULL, 1, '2025-08-29 11:13:45', '2025-08-29 11:13:45', '[]', '[]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000001_create_niveis_acesso_table', 1),
(3, '2024_01_01_000002_create_usuarios_table', 1),
(4, '2024_01_01_000003_create_estabelecimentos_table', 1),
(5, '2024_01_01_000004_create_tipos_table', 1),
(6, '2024_01_01_000005_create_status_table', 1),
(7, '2024_01_01_000006_create_coletas_table', 1),
(8, '2024_01_01_000007_create_coleta_pecas_table', 1),
(9, '2024_01_01_000008_create_empacotamento_table', 1),
(10, '2024_01_01_000009_update_estabelecimentos_multiple_contacts', 1),
(11, '2024_01_01_000010_create_anotacoes_table', 1),
(12, '2024_01_01_000011_create_pesagens_table', 1),
(13, '2025_07_28_101253_add_acompanhante_to_coletas_table', 1),
(14, '2025_07_28_101421_remove_price_fields_from_tipos_table', 1),
(15, '2025_07_28_101535_remove_price_fields_from_coleta_pecas_table', 1),
(16, '2025_07_28_102036_remove_valor_total_from_coletas_table', 1),
(17, '2025_07_28_121436_add_empacotamento_columns_to_coleta_pecas_table', 1),
(18, '2025_07_28_125820_allow_null_tipo_id_in_pesagens_table', 1),
(19, '2025_07_28_133602_create_entregas_table', 1),
(20, '2025_07_28_154235_add_motorista_fields_to_empacotamento_table', 2),
(21, '2025_07_28_174311_add_confirmado_cliente_status', 3),
(22, '2025_07_28_204033_update_entregas_table_structure', 4),
(23, '2025_07_28_204425_migrate_delivery_data_to_entregas_table', 5),
(24, '2025_08_01_000001_add_peso_tipo', 6),
(25, '2025_08_08_102406_add_status_to_pesagens_table', 7),
(26, '2025_08_08_103218_add_pronto_para_motorista_status', 8),
(27, '2025_08_09_133743_create_sessions_table', 9),
(28, '2025_08_20_093301_create_empacotamento_pecas_table', 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `niveis_acesso`
--

CREATE TABLE `niveis_acesso` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `permissoes` json DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `niveis_acesso`
--

INSERT INTO `niveis_acesso` (`id`, `nome`, `descricao`, `permissoes`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Acesso completo a todas as funcionalidades do sistema', '[\"usuarios.criar\", \"usuarios.editar\", \"usuarios.excluir\", \"usuarios.visualizar\", \"estabelecimentos.criar\", \"estabelecimentos.editar\", \"estabelecimentos.excluir\", \"estabelecimentos.visualizar\", \"coletas.criar\", \"coletas.editar\", \"coletas.cancelar\", \"coletas.visualizar\", \"pesagem.criar\", \"pesagem.editar\", \"pesagem.visualizar\", \"empacotamento.criar\", \"empacotamento.editar\", \"empacotamento.visualizar\", \"motorista.visualizar\", \"relatorios.visualizar\", \"relatorios.exportar\", \"tipos.visualizar\", \"tipos.criar\", \"tipos.editar\", \"tipos.excluir\", \"status.criar\", \"status.editar\", \"status.excluir\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(2, 'Operador', 'Acesso às operações de coleta, pesagem e empacotamento', '[\"estabelecimentos.visualizar\", \"coletas.criar\", \"coletas.editar\", \"coletas.visualizar\", \"pesagem.criar\", \"pesagem.editar\", \"pesagem.visualizar\", \"empacotamento.criar\", \"empacotamento.editar\", \"empacotamento.visualizar\", \"motorista.visualizar\", \"relatorios.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(3, 'Motorista', 'Acesso específico para confirmação de entregas', '[\"empacotamento.visualizar\", \"empacotamento.confirmar_entrega\", \"motorista.visualizar\", \"qrcodes.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(4, 'Visualizador', 'Acesso apenas para consulta de relatórios', '[\"estabelecimentos.visualizar\", \"coletas.visualizar\", \"pesagem.visualizar\", \"empacotamento.visualizar\", \"relatorios.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pesagens`
--

CREATE TABLE `pesagens` (
  `id` bigint UNSIGNED NOT NULL,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED DEFAULT NULL,
  `peso` decimal(8,2) NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `peso_unitario` decimal(8,2) DEFAULT NULL,
  `data_pesagem` datetime NOT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `local_pesagem` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('rascunho','concluida') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'concluida',
  `conferido` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_conferencia_id` bigint UNSIGNED DEFAULT NULL,
  `data_conferencia` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pesagens`
--

INSERT INTO `pesagens` (`id`, `coleta_id`, `usuario_id`, `tipo_id`, `peso`, `quantidade`, `peso_unitario`, `data_pesagem`, `observacoes`, `local_pesagem`, `status`, `conferido`, `usuario_conferencia_id`, `data_conferencia`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, 69.50, 1, 69.50, '2025-08-29 13:05:00', NULL, NULL, 'rascunho', 0, NULL, NULL, '2025-08-29 13:06:01', '2025-08-29 13:06:01'),
(3, 1, 1, NULL, 12.00, 1, 12.00, '2025-08-29 13:06:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-29 13:06:19', '2025-08-29 13:06:19'),
(4, 3, 1, NULL, 125.00, 1, 125.00, '2025-08-30 15:36:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-30 15:37:05', '2025-08-30 15:37:05'),
(5, 4, 1, NULL, 185.00, 1, 185.00, '2025-08-30 15:46:00', 'tudo pesado', 'certa', 'concluida', 0, NULL, NULL, '2025-08-30 15:46:54', '2025-08-30 15:46:54'),
(6, 5, 1, NULL, 75.30, 1, 75.30, '2025-08-30 16:08:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-30 16:09:10', '2025-08-30 16:09:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cor` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6c757d',
  `ordem` int NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `status`
--

INSERT INTO `status` (`id`, `nome`, `descricao`, `tipo`, `cor`, `ordem`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Agendada', 'Coleta foi agendada mas ainda não foi realizada', 'coleta', '#ffc107', 1, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(2, 'Em andamento', 'Coleta está sendo realizada', 'coleta', '#17a2b8', 2, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(3, 'Concluída', 'Coleta foi concluída com sucesso', 'coleta', '#28a745', 3, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(4, 'Cancelada', 'Coleta foi cancelada', 'coleta', '#dc3545', 4, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(5, 'Aguardando empacotamento', 'Peças estão aguardando para serem empacotadas', 'empacotamento', '#ffc107', 1, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(6, 'Em empacotamento', 'Peças estão sendo empacotadas', 'empacotamento', '#17a2b8', 2, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(7, 'Pronto para motorista', 'Empacotamento concluído, aguardando confirmação do motorista para saída', 'empacotamento', '#007bff', 3, 1, '2025-07-28 17:37:48', '2025-08-08 13:32:41'),
(8, 'Em trânsito', 'Empacotamento saiu para entrega', 'empacotamento', '#fd7e14', 4, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(9, 'Entregue', 'Empacotamento foi entregue ao cliente', 'empacotamento', '#28a745', 5, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(10, 'Agendada', 'Coleta foi agendada mas ainda não foi realizada', 'coleta', '#ffc107', 1, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(11, 'Em andamento', 'Coleta está sendo realizada', 'coleta', '#17a2b8', 2, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(12, 'Concluída', 'Coleta foi concluída com sucesso', 'coleta', '#28a745', 3, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(13, 'Cancelada', 'Coleta foi cancelada', 'coleta', '#dc3545', 4, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(14, 'Aguardando empacotamento', 'Peças estão aguardando para serem empacotadas', 'empacotamento', '#ffc107', 1, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(15, 'Em empacotamento', 'Peças estão sendo empacotadas', 'empacotamento', '#17a2b8', 2, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(16, 'Pronto para motorista', 'Empacotamento concluído, aguardando confirmação do motorista para saída', 'empacotamento', '#007bff', 3, 1, '2025-07-28 18:07:57', '2025-08-08 13:32:41'),
(17, 'Em trânsito', 'Empacotamento saiu para entrega', 'empacotamento', '#fd7e14', 4, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(18, 'Entregue', 'Empacotamento foi entregue ao cliente', 'empacotamento', '#28a745', 5, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(19, 'Confirmado pelo Cliente', 'Entrega foi confirmada e assinada pelo cliente', 'empacotamento', '#198754', 6, 1, '2025-07-28 20:43:48', '2025-07-28 20:43:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos`
--

CREATE TABLE `tipos` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `categoria` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tipos`
--

INSERT INTO `tipos` (`id`, `nome`, `descricao`, `categoria`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Lençol Solteiro', 'Lençol para cama de solteiro', 'roupa_cama', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(2, 'Lençol Casal', 'Lençol para cama de casal', 'roupa_cama', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(3, 'Fronha', 'Fronha para travesseiro', 'roupa_cama', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(4, 'Edredom', 'Edredom/cobertor', 'roupa_cama', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(5, 'Colcha', 'Colcha de cama', 'roupa_cama', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(6, 'Toalha de Banho', 'Toalha de banho grande', 'roupa_banho', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(7, 'Toalha de Rosto', 'Toalha de rosto pequena', 'roupa_banho', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(8, 'Roupão', 'Roupão de banho', 'roupa_banho', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(9, 'Camisa', 'Camisa social ou casual', 'vestuario', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(10, 'Calça', 'Calça social ou casual', 'vestuario', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(12, 'Terno/Blazer', 'Terno completo ou blazer', 'vestuario', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(13, 'Toalha de Mesa', 'Toalha de mesa', 'mesa_copa', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(16, 'Peso', 'Tipo especial para coletas realizadas por peso (kg)', 'peso', 1, '2025-08-01 02:11:15', '2025-08-01 02:11:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint UNSIGNED NOT NULL,
  `nome` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_acesso_id` bigint UNSIGNED NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `email_verified_at`, `password`, `telefone`, `cpf`, `nivel_acesso_id`, `ativo`, `ultimo_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador do Sistema', 'admin@lavanderia.com', '2025-07-28 17:48:07', '$2y$12$VHgBPMyhGQkw8AD9XfZ37.IkatcvncObGguDCmWq1tFGtY1bFbMrS', '(11) 99999-9999', '000.000.000-00', 1, 1, '2025-09-02 12:45:46', 'ENJDAFepFDBLgYTyKwQsqdxU0khxHuiU0nioEQLUEBAxQU6DN8zKDFD4jmSX', '2025-07-28 17:48:07', '2025-09-02 12:45:46'),
(11, 'LUCAS MATTIELLO', 'mattiello.to@gmail.com', NULL, '$2y$12$2siFk564Kn0bhsiky746A.o82mSKwiMyjZcnIhEcOiKlYFkH8gN8S', '(63) 98400-0070', '02698744113', 3, 1, '2025-08-31 15:31:29', NULL, '2025-08-29 11:14:56', '2025-08-31 15:31:29'),
(12, 'Ines rodrigues', 'inesmattiello.to@gmail.com', NULL, '$2y$12$sbKIRBRdSDMfnvVZBJnrN.vlEKocCaY0J9JL0vp/0FFrnrRmcdulK', '(63) 99994-0202', '67970192068', 3, 1, '2025-08-31 16:12:26', NULL, '2025-08-30 16:00:37', '2025-08-31 16:12:26'),
(13, 'Teste', 'mattiello1@gmail.com', NULL, '$2y$12$zTJ99ontRv089P5Oz1K94.49IsAgNEUOFGkE7tqMzfQDfITbSaB6G', NULL, '02698711111', 2, 1, '2025-08-31 15:29:06', NULL, '2025-08-31 15:27:11', '2025-08-31 15:29:06');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anotacoes_usuario_id_modulo_index` (`usuario_id`,`modulo`),
  ADD KEY `anotacoes_modulo_categoria_index` (`modulo`,`categoria`),
  ADD KEY `anotacoes_resolvida_index` (`resolvida`);

--
-- Índices de tabela `coletas`
--
ALTER TABLE `coletas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coletas_numero_coleta_unique` (`numero_coleta`),
  ADD KEY `coletas_estabelecimento_id_foreign` (`estabelecimento_id`),
  ADD KEY `coletas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `coletas_status_id_foreign` (`status_id`);

--
-- Índices de tabela `coleta_pecas`
--
ALTER TABLE `coleta_pecas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coleta_pecas_coleta_id_foreign` (`coleta_id`),
  ADD KEY `coleta_pecas_tipo_id_foreign` (`tipo_id`);

--
-- Índices de tabela `empacotamento`
--
ALTER TABLE `empacotamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empacotamento_codigo_qr_unique` (`codigo_qr`),
  ADD KEY `empacotamento_coleta_id_foreign` (`coleta_id`),
  ADD KEY `empacotamento_usuario_empacotamento_id_foreign` (`usuario_empacotamento_id`),
  ADD KEY `empacotamento_motorista_id_foreign` (`motorista_id`),
  ADD KEY `empacotamento_status_id_foreign` (`status_id`),
  ADD KEY `empacotamento_motorista_saida_id_foreign` (`motorista_saida_id`),
  ADD KEY `empacotamento_motorista_entrega_id_foreign` (`motorista_entrega_id`);

--
-- Índices de tabela `empacotamento_pecas`
--
ALTER TABLE `empacotamento_pecas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empacotamento_pecas_codigo_qr_unique` (`codigo_qr`),
  ADD KEY `empacotamento_pecas_tipo_id_foreign` (`tipo_id`),
  ADD KEY `empacotamento_pecas_empacotamento_id_tipo_id_index` (`empacotamento_id`,`tipo_id`),
  ADD KEY `empacotamento_pecas_codigo_qr_index` (`codigo_qr`),
  ADD KEY `idx_status_empacotamento` (`status_saida`,`empacotamento_id`),
  ADD KEY `idx_data_saida_motorista` (`data_saida`,`motorista_saida_id`);

--
-- Índices de tabela `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entregas_empacotamento_id_foreign` (`empacotamento_id`),
  ADD KEY `entregas_motorista_saida_id_foreign` (`motorista_saida_id`),
  ADD KEY `entregas_motorista_entrega_id_foreign` (`motorista_entrega_id`),
  ADD KEY `entregas_status_id_foreign` (`status_id`);

--
-- Índices de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estabelecimentos_cnpj_unique` (`cnpj`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `niveis_acesso`
--
ALTER TABLE `niveis_acesso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `niveis_acesso_nome_unique` (`nome`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `pesagens`
--
ALTER TABLE `pesagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesagens_tipo_id_foreign` (`tipo_id`),
  ADD KEY `pesagens_usuario_conferencia_id_foreign` (`usuario_conferencia_id`),
  ADD KEY `pesagens_coleta_id_tipo_id_index` (`coleta_id`,`tipo_id`),
  ADD KEY `pesagens_data_pesagem_index` (`data_pesagem`),
  ADD KEY `pesagens_usuario_id_index` (`usuario_id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`),
  ADD UNIQUE KEY `usuarios_cpf_unique` (`cpf`),
  ADD KEY `usuarios_nivel_acesso_id_foreign` (`nivel_acesso_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `coletas`
--
ALTER TABLE `coletas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `coleta_pecas`
--
ALTER TABLE `coleta_pecas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `empacotamento`
--
ALTER TABLE `empacotamento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `empacotamento_pecas`
--
ALTER TABLE `empacotamento_pecas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `niveis_acesso`
--
ALTER TABLE `niveis_acesso`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pesagens`
--
ALTER TABLE `pesagens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
