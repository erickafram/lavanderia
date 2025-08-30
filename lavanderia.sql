-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 30/08/2025 às 05:43
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
(2, 2, 1, 3, '2025-08-29 13:03:47', '2025-08-29 13:05:07', '2025-08-29 13:05:07', NULL, 'LUCAS MATTIELLO', NULL, 0.00, 'COL000002', '2025-08-29 13:03:47', '2025-08-29 13:05:07');

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
(5, 2, 3, 159, 0.00, 0, 0.00, NULL, '2025-08-29 13:04:50', '2025-08-29 13:04:50');

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
(2, 2, 1, NULL, 9, 'EMPQGW4CFGO', '2025-08-29 13:09:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-29 13:09:50', '2025-08-29 13:20:42', NULL, NULL),
(3, 1, 1, NULL, 7, 'EMPGGBYLQRU', '2025-08-29 13:22:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-29 13:22:05', '2025-08-29 13:22:05', NULL, NULL);

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
(3, 1, 1, NULL, 12.00, 1, 12.00, '2025-08-29 13:06:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-29 13:06:19', '2025-08-29 13:06:19');

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
(1, 'Administrador do Sistema', 'admin@lavanderia.com', '2025-07-28 17:48:07', '$2y$12$VHgBPMyhGQkw8AD9XfZ37.IkatcvncObGguDCmWq1tFGtY1bFbMrS', '(11) 99999-9999', '000.000.000-00', 1, 1, '2025-08-29 11:04:35', '2r2PdaSgF76Yvo8vLX7Vbm8i3yy5wHva1vfeBfP2zfJRolqbPpymAQSABnJF', '2025-07-28 17:48:07', '2025-08-29 11:04:35'),
(11, 'LUCAS MATTIELLO', 'mattiello.to@gmail.com', NULL, '$2y$12$0un/374eif177rZmP5gnnevNjRPUvVQEnBB7XgdEPvzUhhTGBS4lW', '(63) 98400-0070', '02698744113', 3, 1, NULL, NULL, '2025-08-29 11:14:56', '2025-08-29 11:14:56');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `coletas`
--
ALTER TABLE `coletas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `coleta_pecas`
--
ALTER TABLE `coleta_pecas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `empacotamento`
--
ALTER TABLE `empacotamento`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `empacotamento_pecas`
--
ALTER TABLE `empacotamento_pecas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
