-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 21/08/2025 às 03:29
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

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

DROP TABLE IF EXISTS `anotacoes`;
CREATE TABLE IF NOT EXISTS `anotacoes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `modulo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pagina` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagina_nome` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria` enum('melhorias','alteracoes','exclusoes') COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolvida` tinyint(1) NOT NULL DEFAULT '0',
  `data_resolucao` timestamp NULL DEFAULT NULL,
  `observacao_resolucao` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `anotacoes_usuario_id_modulo_index` (`usuario_id`,`modulo`),
  KEY `anotacoes_modulo_categoria_index` (`modulo`,`categoria`),
  KEY `anotacoes_resolvida_index` (`resolvida`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `coletas`
--

DROP TABLE IF EXISTS `coletas`;
CREATE TABLE IF NOT EXISTS `coletas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `data_agendamento` datetime NOT NULL,
  `data_coleta` datetime DEFAULT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `acompanhante` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_cancelamento` text COLLATE utf8mb4_unicode_ci,
  `peso_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `numero_coleta` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coletas_numero_coleta_unique` (`numero_coleta`),
  KEY `coletas_estabelecimento_id_foreign` (`estabelecimento_id`),
  KEY `coletas_usuario_id_foreign` (`usuario_id`),
  KEY `coletas_status_id_foreign` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coletas`
--

INSERT INTO `coletas` (`id`, `estabelecimento_id`, `usuario_id`, `status_id`, `data_agendamento`, `data_coleta`, `data_conclusao`, `observacoes`, `acompanhante`, `motivo_cancelamento`, `peso_total`, `numero_coleta`, `created_at`, `updated_at`) VALUES
(25, 5, 1, 3, '2025-08-20 23:54:00', '2025-08-20 23:54:47', '2025-08-20 23:54:47', NULL, NULL, NULL, 0.00, 'COL000001', '2025-08-21 02:54:00', '2025-08-21 02:54:47');

-- --------------------------------------------------------

--
-- Estrutura para tabela `coleta_pecas`
--

DROP TABLE IF EXISTS `coleta_pecas`;
CREATE TABLE IF NOT EXISTS `coleta_pecas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED NOT NULL,
  `quantidade` int NOT NULL,
  `peso` decimal(8,2) NOT NULL,
  `quantidade_empacotada` int NOT NULL DEFAULT '0',
  `peso_empacotado` decimal(8,2) NOT NULL DEFAULT '0.00',
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coleta_pecas_coleta_id_foreign` (`coleta_id`),
  KEY `coleta_pecas_tipo_id_foreign` (`tipo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coleta_pecas`
--

INSERT INTO `coleta_pecas` (`id`, `coleta_id`, `tipo_id`, `quantidade`, `peso`, `quantidade_empacotada`, `peso_empacotado`, `observacoes`, `created_at`, `updated_at`) VALUES
(55, 25, 3, 18, 0.00, 0, 0.00, NULL, '2025-08-21 02:54:44', '2025-08-21 02:54:44'),
(54, 25, 13, 25, 0.00, 0, 0.00, NULL, '2025-08-21 02:54:44', '2025-08-21 02:54:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empacotamento`
--

DROP TABLE IF EXISTS `empacotamento`;
CREATE TABLE IF NOT EXISTS `empacotamento` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `usuario_empacotamento_id` bigint UNSIGNED NOT NULL,
  `motorista_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `codigo_qr` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_empacotamento` datetime NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  `data_confirmacao_recebimento` datetime DEFAULT NULL,
  `assinatura_recebimento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_recebedor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assinatura_recebedor` text COLLATE utf8mb4_unicode_ci,
  `observacoes_empacotamento` text COLLATE utf8mb4_unicode_ci,
  `observacoes_entrega` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `motorista_saida_id` bigint UNSIGNED DEFAULT NULL,
  `motorista_entrega_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empacotamento_codigo_qr_unique` (`codigo_qr`),
  KEY `empacotamento_coleta_id_foreign` (`coleta_id`),
  KEY `empacotamento_usuario_empacotamento_id_foreign` (`usuario_empacotamento_id`),
  KEY `empacotamento_motorista_id_foreign` (`motorista_id`),
  KEY `empacotamento_status_id_foreign` (`status_id`),
  KEY `empacotamento_motorista_saida_id_foreign` (`motorista_saida_id`),
  KEY `empacotamento_motorista_entrega_id_foreign` (`motorista_entrega_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empacotamento`
--

INSERT INTO `empacotamento` (`id`, `coleta_id`, `usuario_empacotamento_id`, `motorista_id`, `status_id`, `codigo_qr`, `data_empacotamento`, `data_saida`, `data_entrega`, `data_confirmacao_recebimento`, `assinatura_recebimento`, `nome_recebedor`, `assinatura_recebedor`, `observacoes_empacotamento`, `observacoes_entrega`, `created_at`, `updated_at`, `motorista_saida_id`, `motorista_entrega_id`) VALUES
(39, 25, 1, NULL, 7, 'EMPNT9MEHVD', '2025-08-21 00:27:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-21 03:27:53', '2025-08-21 03:27:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empacotamento_pecas`
--

DROP TABLE IF EXISTS `empacotamento_pecas`;
CREATE TABLE IF NOT EXISTS `empacotamento_pecas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `empacotamento_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED NOT NULL,
  `codigo_qr` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int NOT NULL,
  `peso` decimal(8,3) NOT NULL DEFAULT '0.000',
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empacotamento_pecas_codigo_qr_unique` (`codigo_qr`),
  KEY `empacotamento_pecas_tipo_id_foreign` (`tipo_id`),
  KEY `empacotamento_pecas_empacotamento_id_tipo_id_index` (`empacotamento_id`,`tipo_id`),
  KEY `empacotamento_pecas_codigo_qr_index` (`codigo_qr`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empacotamento_pecas`
--

INSERT INTO `empacotamento_pecas` (`id`, `empacotamento_id`, `tipo_id`, `codigo_qr`, `quantidade`, `peso`, `observacoes`, `created_at`, `updated_at`) VALUES
(52, 39, 11, 'PCHZMBQNCX', 10, 0.000, 'Peça extra:', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(51, 39, 13, 'PCTKVCVDU1', 5, 0.000, 'Lote adicional - Tipo: Toalha de Mesa', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(50, 39, 13, 'PCSWZ64PQ4', 10, 0.000, 'Lote adicional - Tipo: Toalha de Mesa', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(49, 39, 3, 'PCYCJD9HID', 3, 0.000, 'Lote adicional - Tipo: Fronha', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(48, 39, 3, 'PCBK1DDR2P', 5, 0.000, 'Lote adicional - Tipo: Fronha', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(47, 39, 3, 'PCYGSXBKEG', 5, 0.000, 'Lote adicional - Tipo: Fronha', '2025-08-21 03:28:37', '2025-08-21 03:28:37'),
(46, 39, 13, 'PCHMTVRFLB', 10, 0.000, 'Lote inicial - Qtd. original da coleta: 25 peças', '2025-08-21 03:27:53', '2025-08-21 03:28:37'),
(45, 39, 3, 'PCXLZMUU0B', 5, 0.000, 'Lote inicial - Qtd. original da coleta: 18 peças', '2025-08-21 03:27:53', '2025-08-21 03:28:37');

-- --------------------------------------------------------

--
-- Estrutura para tabela `entregas`
--

DROP TABLE IF EXISTS `entregas`;
CREATE TABLE IF NOT EXISTS `entregas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `empacotamento_id` bigint UNSIGNED NOT NULL,
  `motorista_saida_id` bigint UNSIGNED DEFAULT NULL,
  `motorista_entrega_id` bigint UNSIGNED DEFAULT NULL,
  `status_id` bigint UNSIGNED NOT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_entrega` datetime DEFAULT NULL,
  `data_confirmacao_recebimento` datetime DEFAULT NULL,
  `nome_recebedor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assinatura_recebedor` text COLLATE utf8mb4_unicode_ci,
  `assinatura_cliente` text COLLATE utf8mb4_unicode_ci,
  `observacoes_entrega` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entregas_empacotamento_id_foreign` (`empacotamento_id`),
  KEY `entregas_motorista_saida_id_foreign` (`motorista_saida_id`),
  KEY `entregas_motorista_entrega_id_foreign` (`motorista_entrega_id`),
  KEY `entregas_status_id_foreign` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estabelecimentos`
--

DROP TABLE IF EXISTS `estabelecimentos`;
CREATE TABLE IF NOT EXISTS `estabelecimentos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razao_social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_fantasia` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complemento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_old` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contato_responsavel_old` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emails` json DEFAULT NULL,
  `contatos_responsaveis` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estabelecimentos_cnpj_unique` (`cnpj`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id`, `cnpj`, `razao_social`, `nome_fantasia`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`, `telefone`, `email_old`, `contato_responsavel_old`, `observacoes`, `ativo`, `created_at`, `updated_at`, `emails`, `contatos_responsaveis`) VALUES
(1, '03737166000183', 'KOCHE & DALLA COSTA LTDA.', 'HOTEL 10', '101 NORTE, CONJUNTO 01, LOTE 01', 'SN', 'AV.TEOTONIO SEGURADO', 'PLANO DIRETOR NORTE', 'PALMAS', 'TO', '77001004', '(63) 2104-1010', NULL, NULL, NULL, 1, '2025-07-28 17:52:57', '2025-07-28 17:52:57', '[]', '[]'),
(2, '11222333000144', 'Hotel Exemplo Ltda', 'Hotel Exemplo', 'Rua das Flores', '123', 'Andar 1', 'Centro', 'São Paulo', 'SP', '01234567', '(11) 99999-9999', NULL, NULL, 'Cliente VIP - prioridade nas coletas', 1, '2025-07-28 18:10:53', '2025-07-28 18:10:53', '\"[\\\"contato@hotelexemplo.com.br\\\"]\"', '\"[\\\"Jo\\\\u00e3o Silva\\\"]\"'),
(3, '22333444000155', 'Pousada Beira Mar S/A', 'Pousada Beira Mar', 'Avenida Atlântica', '456', NULL, 'Copacabana', 'Rio de Janeiro', 'RJ', '22070011', '(21) 88888-8888', NULL, NULL, 'Coletas diárias - horário preferencial: 14h às 16h', 1, '2025-07-28 18:10:53', '2025-07-28 18:10:53', '\"[\\\"reservas@pousadabeiramar.com.br\\\"]\"', '\"[\\\"Maria Santos\\\"]\"'),
(4, '33444555000166', 'Resort Tropical Eireli', 'Resort Tropical', 'Estrada da Praia', '789', 'Km 15', 'Praia do Forte', 'Mata de São João', 'BA', '48280000', '(71) 77777-7777', NULL, NULL, 'Grande volume - necessário caminhão para coleta', 1, '2025-07-28 18:10:53', '2025-07-28 18:10:53', '\"[\\\"operacoes@resorttropical.com.br\\\",\\\"gerencia@resorttropical.com.br\\\"]\"', '\"[\\\"Carlos Oliveira\\\",\\\"Ana Gerente\\\"]\"'),
(5, '44555666000177', 'Hotel Executivo Ltda ME', 'Hotel Executivo', 'Rua dos Negócios', '321', 'Sala 101', 'Funcionários', 'Belo Horizonte', 'MG', '30112000', '(31) 66666-6666', NULL, NULL, 'Foco em roupas executivas - cuidado especial com ternos', 1, '2025-07-28 18:10:53', '2025-07-28 18:10:53', '\"[\\\"gerencia@hotelexecutivo.com.br\\\"]\"', '\"[\\\"Ana Costa\\\"]\"'),
(6, '55666777000188', 'Motel Descanso Ltda', 'Motel Descanso', 'Rodovia BR-101', '1500', 'Km 25', 'Zona Rural', 'Curitiba', 'PR', '82000000', '(41) 55555-5555', NULL, NULL, 'Coletas noturnas preferenciais', 0, '2025-07-28 18:10:53', '2025-07-28 18:10:53', NULL, '\"[\\\"Pedro Souza\\\"]\"');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `niveis_acesso`;
CREATE TABLE IF NOT EXISTS `niveis_acesso` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `permissoes` json DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `niveis_acesso_nome_unique` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `niveis_acesso`
--

INSERT INTO `niveis_acesso` (`id`, `nome`, `descricao`, `permissoes`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Acesso completo a todas as funcionalidades do sistema', '[\"usuarios.criar\", \"usuarios.editar\", \"usuarios.excluir\", \"usuarios.visualizar\", \"estabelecimentos.criar\", \"estabelecimentos.editar\", \"estabelecimentos.excluir\", \"estabelecimentos.visualizar\", \"coletas.criar\", \"coletas.editar\", \"coletas.cancelar\", \"coletas.visualizar\", \"pesagem.criar\", \"pesagem.editar\", \"pesagem.visualizar\", \"empacotamento.criar\", \"empacotamento.editar\", \"empacotamento.visualizar\", \"motorista.visualizar\", \"relatorios.visualizar\", \"relatorios.exportar\", \"tipos.criar\", \"tipos.editar\", \"tipos.excluir\", \"status.criar\", \"status.editar\", \"status.excluir\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(2, 'Operador', 'Acesso às operações de coleta, pesagem e empacotamento', '[\"estabelecimentos.visualizar\", \"coletas.criar\", \"coletas.editar\", \"coletas.visualizar\", \"pesagem.criar\", \"pesagem.editar\", \"pesagem.visualizar\", \"empacotamento.criar\", \"empacotamento.editar\", \"empacotamento.visualizar\", \"motorista.visualizar\", \"relatorios.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(3, 'Motorista', 'Acesso específico para confirmação de entregas', '[\"empacotamento.visualizar\", \"empacotamento.confirmar_entrega\", \"motorista.visualizar\", \"qrcodes.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(4, 'Visualizador', 'Acesso apenas para consulta de relatórios', '[\"estabelecimentos.visualizar\", \"coletas.visualizar\", \"pesagem.visualizar\", \"empacotamento.visualizar\", \"relatorios.visualizar\"]', 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pesagens`
--

DROP TABLE IF EXISTS `pesagens`;
CREATE TABLE IF NOT EXISTS `pesagens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `coleta_id` bigint UNSIGNED NOT NULL,
  `usuario_id` bigint UNSIGNED NOT NULL,
  `tipo_id` bigint UNSIGNED DEFAULT NULL,
  `peso` decimal(8,2) NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `peso_unitario` decimal(8,2) DEFAULT NULL,
  `data_pesagem` datetime NOT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `local_pesagem` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('rascunho','concluida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'concluida',
  `conferido` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_conferencia_id` bigint UNSIGNED DEFAULT NULL,
  `data_conferencia` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesagens_tipo_id_foreign` (`tipo_id`),
  KEY `pesagens_usuario_conferencia_id_foreign` (`usuario_conferencia_id`),
  KEY `pesagens_coleta_id_tipo_id_index` (`coleta_id`,`tipo_id`),
  KEY `pesagens_data_pesagem_index` (`data_pesagem`),
  KEY `pesagens_usuario_id_index` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pesagens`
--

INSERT INTO `pesagens` (`id`, `coleta_id`, `usuario_id`, `tipo_id`, `peso`, `quantidade`, `peso_unitario`, `data_pesagem`, `observacoes`, `local_pesagem`, `status`, `conferido`, `usuario_conferencia_id`, `data_conferencia`, `created_at`, `updated_at`) VALUES
(24, 25, 1, NULL, 25.00, 1, 25.00, '2025-08-20 23:57:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-21 02:58:00', '2025-08-21 02:58:00'),
(23, 25, 1, NULL, 25.00, 1, 25.00, '2025-08-20 23:57:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-21 02:58:00', '2025-08-21 02:58:00'),
(22, 24, 1, NULL, 30.00, 1, 30.00, '2025-08-20 23:16:00', NULL, NULL, 'concluida', 0, NULL, NULL, '2025-08-21 02:16:23', '2025-08-21 02:16:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cor` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6c757d',
  `ordem` int NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `categoria` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, 'Vestido', 'Vestido feminino', 'vestuario', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(12, 'Terno/Blazer', 'Terno completo ou blazer', 'vestuario', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(13, 'Toalha de Mesa', 'Toalha de mesa', 'mesa_copa', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(14, 'Guardanapo', 'Guardanapo de tecido', 'mesa_copa', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(15, 'Cortina', 'Cortina de ambiente', 'cortina', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10'),
(16, 'Peso', 'Tipo especial para coletas realizadas por peso (kg)', 'peso', 1, '2025-08-01 02:11:15', '2025-08-01 02:11:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_acesso_id` bigint UNSIGNED NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`email`),
  UNIQUE KEY `usuarios_cpf_unique` (`cpf`),
  KEY `usuarios_nivel_acesso_id_foreign` (`nivel_acesso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `email_verified_at`, `password`, `telefone`, `cpf`, `nivel_acesso_id`, `ativo`, `ultimo_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador do Sistema', 'admin@lavanderia.com', '2025-07-28 17:48:07', '$2y$12$VHgBPMyhGQkw8AD9XfZ37.IkatcvncObGguDCmWq1tFGtY1bFbMrS', '(11) 99999-9999', '000.000.000-00', 1, 1, '2025-08-21 02:41:11', NULL, '2025-07-28 17:48:07', '2025-08-21 02:41:11'),
(2, 'João Silva', 'joao.motorista@lavanderia.com', NULL, '$2y$12$7QsK2TuwwLkq6vAdHegA8.spqCLHiZdUEyf8dLkRaKdhwZTb3ZWJu', '(11) 99999-1111', '12345678901', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(3, 'Maria Santos', 'maria.motorista@lavanderia.com', NULL, '$2y$12$X/9QtU.8HmV9ZYPluEMZ..3CdlbzIwWQvBzVRtBjzSAf2DYKGbQ8m', '(11) 99999-2222', '12345678902', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(4, 'Carlos Oliveira', 'carlos.motorista@lavanderia.com', NULL, '$2y$12$KnsIrYHmiEJISkQnd26SlO41zopIMgcYnaQZ/lQssXH9NCA4tr6ya', '(11) 99999-3333', '12345678903', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(5, 'Ana Costa', 'ana.operador@lavanderia.com', NULL, '$2y$12$VgtxK3op.t6lUee.v.A9UeP25c.tRB/I7uwt1nHd6FHisk.Ng/Dje', '(11) 98888-1111', '11111111111', 2, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(6, 'Pedro Almeida', 'pedro.operador@lavanderia.com', NULL, '$2y$12$BjGz6G/HGLlaFgL0PBFlVe5gsAQ1aoU/7v.FxOzlnMVvygRF5M4fS', '(11) 98888-2222', '22222222222', 2, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(7, 'Roberto Gerente', 'roberto.gerente@lavanderia.com', NULL, '$2y$12$OZ66HsmiY1SW2ujUOYJB2OKqfEBqYk5UsyvnI46i.2/oiSohQK1Nm', '(11) 97777-1111', '33333333333', 4, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(8, 'Lucas Pereira', 'lucas.motorista@lavanderia.com', NULL, '$2y$12$eNI4aZxEQWLJyBa2fplHse9/q6M/Itf0hMiBxh1PHdr1XsmrOaApO', '(11) 96666-1111', '44444444444', 3, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(9, 'Rafael Souza', 'rafael.motorista@lavanderia.com', NULL, '$2y$12$.cOLcUZST/d1vZl6nVoE6OPl4.e1wJCI.mXpX6hk9dcSK.b5TA9ea', '(11) 96666-2222', '55555555555', 3, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(10, 'Kauany', 'kauany@gmail.com', NULL, '$2y$12$QK7hu9E.XUsEcwAsnKoU5.iyCuoiLZ4Beq44S.6/NB23cG.Nw37wK', '(63) 98101-3088', '07886155130', 3, 1, '2025-08-07 03:27:57', NULL, '2025-08-07 03:06:33', '2025-08-07 03:27:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
