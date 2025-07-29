-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29/07/2025 às 02:14
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coletas`
--

INSERT INTO `coletas` (`id`, `estabelecimento_id`, `usuario_id`, `status_id`, `data_agendamento`, `data_coleta`, `data_conclusao`, `observacoes`, `acompanhante`, `motivo_cancelamento`, `peso_total`, `numero_coleta`, `created_at`, `updated_at`) VALUES
(5, 4, 1, 3, '2025-07-28 21:00:00', '2025-07-28 20:55:30', '2025-07-28 20:55:30', NULL, 'Carlos Oliveira', NULL, 0.00, 'COL000002', '2025-07-28 23:55:15', '2025-07-28 23:55:55'),
(4, 5, 1, 3, '2025-07-28 23:00:00', '2025-07-28 20:26:00', '2025-07-28 20:26:00', NULL, 'Rafael Souza', NULL, 0.00, 'COL000001', '2025-07-28 23:25:32', '2025-07-28 23:33:09');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coleta_pecas`
--

INSERT INTO `coleta_pecas` (`id`, `coleta_id`, `tipo_id`, `quantidade`, `peso`, `quantidade_empacotada`, `peso_empacotado`, `observacoes`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 5, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 18:07:48', '2025-07-28 18:07:48'),
(3, 1, 5, 10, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 18:07:48', '2025-07-28 18:07:48'),
(4, 2, 10, 10, 0.00, 0, 0.00, NULL, '2025-07-28 20:28:02', '2025-07-28 20:28:02'),
(5, 3, 12, 5, 0.00, 0, 0.00, NULL, '2025-07-28 20:50:08', '2025-07-28 20:50:08'),
(7, 4, 9, 15, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 23:33:09', '2025-07-28 23:33:09'),
(8, 4, 13, 18, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 23:33:09', '2025-07-28 23:33:09'),
(10, 5, 13, 25, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 23:55:55', '2025-07-28 23:55:55'),
(11, 5, 7, 28, 0.00, 0, 0.00, 'Tipos definidos no empacotamento (coleta foi por peso total)', '2025-07-28 23:55:55', '2025-07-28 23:55:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `empacotamento`
--

INSERT INTO `empacotamento` (`id`, `coleta_id`, `usuario_empacotamento_id`, `motorista_id`, `status_id`, `codigo_qr`, `data_empacotamento`, `data_saida`, `data_entrega`, `data_confirmacao_recebimento`, `assinatura_recebimento`, `nome_recebedor`, `assinatura_recebedor`, `observacoes_empacotamento`, `observacoes_entrega`, `created_at`, `updated_at`, `motorista_saida_id`, `motorista_entrega_id`) VALUES
(10, 5, 1, NULL, 19, 'EMP0XESKD2F', '2025-07-28 20:55:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-28 23:55:55', '2025-07-29 00:05:33', NULL, NULL),
(9, 4, 1, NULL, 19, 'EMPTKW4DE5S', '2025-07-28 20:32:00', '2025-07-28 20:33:25', '2025-07-28 20:33:43', '2025-07-28 20:39:25', 'data:image/png;base64,test_signature', 'mattiello', 'data:image/png;base64,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', NULL, NULL, '2025-07-28 23:33:09', '2025-07-28 23:39:25', 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `entregas`
--

INSERT INTO `entregas` (`id`, `created_at`, `updated_at`, `empacotamento_id`, `motorista_saida_id`, `motorista_entrega_id`, `status_id`, `data_saida`, `data_entrega`, `data_confirmacao_recebimento`, `nome_recebedor`, `assinatura_recebedor`, `assinatura_cliente`, `observacoes_entrega`) VALUES
(1, '2025-07-28 23:45:37', '2025-07-28 23:45:37', 9, 1, 1, 19, '2025-07-28 20:33:25', '2025-07-28 20:33:43', '2025-07-28 20:39:25', 'mattiello', 'data:image/png;base64,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', 'data:image/png;base64,test_signature', NULL),
(2, '2025-07-28 23:56:06', '2025-07-29 00:05:33', 10, 1, 1, 19, '2025-07-28 20:56:06', '2025-07-28 20:59:23', '2025-07-28 21:05:33', 'Jullio', 'data:image/png;base64,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', 'data:image/png;base64,test_signature_col002', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(23, '2025_07_28_204425_migrate_delivery_data_to_entregas_table', 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pesagens`
--

INSERT INTO `pesagens` (`id`, `coleta_id`, `usuario_id`, `tipo_id`, `peso`, `quantidade`, `peso_unitario`, `data_pesagem`, `observacoes`, `local_pesagem`, `conferido`, `usuario_conferencia_id`, `data_conferencia`, `created_at`, `updated_at`) VALUES
(5, 5, 1, NULL, 25.00, 1, 25.00, '2025-07-28 20:55:00', NULL, NULL, 1, 1, '2025-07-28 23:13:47', '2025-07-28 23:55:41', '2025-07-29 02:13:47'),
(4, 4, 1, NULL, 18.00, 1, 18.00, '2025-07-28 20:26:00', NULL, NULL, 1, 1, '2025-07-28 20:26:25', '2025-07-28 23:26:13', '2025-07-28 23:26:25');

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
(7, 'Pronto para entrega', 'Empacotamento concluído, pronto para ser entregue', 'empacotamento', '#007bff', 3, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(8, 'Em trânsito', 'Empacotamento saiu para entrega', 'empacotamento', '#fd7e14', 4, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(9, 'Entregue', 'Empacotamento foi entregue ao cliente', 'empacotamento', '#28a745', 5, 1, '2025-07-28 17:37:48', '2025-07-28 17:37:48'),
(10, 'Agendada', 'Coleta foi agendada mas ainda não foi realizada', 'coleta', '#ffc107', 1, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(11, 'Em andamento', 'Coleta está sendo realizada', 'coleta', '#17a2b8', 2, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(12, 'Concluída', 'Coleta foi concluída com sucesso', 'coleta', '#28a745', 3, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(13, 'Cancelada', 'Coleta foi cancelada', 'coleta', '#dc3545', 4, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(14, 'Aguardando empacotamento', 'Peças estão aguardando para serem empacotadas', 'empacotamento', '#ffc107', 1, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(15, 'Em empacotamento', 'Peças estão sendo empacotadas', 'empacotamento', '#17a2b8', 2, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
(16, 'Pronto para entrega', 'Empacotamento concluído, pronto para ser entregue', 'empacotamento', '#007bff', 3, 1, '2025-07-28 18:07:57', '2025-07-28 18:07:57'),
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(15, 'Cortina', 'Cortina de ambiente', 'cortina', 1, '2025-07-28 17:54:10', '2025-07-28 17:54:10');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `email_verified_at`, `password`, `telefone`, `cpf`, `nivel_acesso_id`, `ativo`, `ultimo_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador do Sistema', 'admin@lavanderia.com', '2025-07-28 17:48:07', '$2y$12$VHgBPMyhGQkw8AD9XfZ37.IkatcvncObGguDCmWq1tFGtY1bFbMrS', '(11) 99999-9999', '000.000.000-00', 1, 1, '2025-07-28 23:21:15', NULL, '2025-07-28 17:48:07', '2025-07-28 23:21:15'),
(2, 'João Silva', 'joao.motorista@lavanderia.com', NULL, '$2y$12$7QsK2TuwwLkq6vAdHegA8.spqCLHiZdUEyf8dLkRaKdhwZTb3ZWJu', '(11) 99999-1111', '12345678901', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(3, 'Maria Santos', 'maria.motorista@lavanderia.com', NULL, '$2y$12$X/9QtU.8HmV9ZYPluEMZ..3CdlbzIwWQvBzVRtBjzSAf2DYKGbQ8m', '(11) 99999-2222', '12345678902', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(4, 'Carlos Oliveira', 'carlos.motorista@lavanderia.com', NULL, '$2y$12$KnsIrYHmiEJISkQnd26SlO41zopIMgcYnaQZ/lQssXH9NCA4tr6ya', '(11) 99999-3333', '12345678903', 3, 1, NULL, NULL, '2025-07-28 17:54:28', '2025-07-28 17:54:28'),
(5, 'Ana Costa', 'ana.operador@lavanderia.com', NULL, '$2y$12$VgtxK3op.t6lUee.v.A9UeP25c.tRB/I7uwt1nHd6FHisk.Ng/Dje', '(11) 98888-1111', '11111111111', 2, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(6, 'Pedro Almeida', 'pedro.operador@lavanderia.com', NULL, '$2y$12$BjGz6G/HGLlaFgL0PBFlVe5gsAQ1aoU/7v.FxOzlnMVvygRF5M4fS', '(11) 98888-2222', '22222222222', 2, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(7, 'Roberto Gerente', 'roberto.gerente@lavanderia.com', NULL, '$2y$12$OZ66HsmiY1SW2ujUOYJB2OKqfEBqYk5UsyvnI46i.2/oiSohQK1Nm', '(11) 97777-1111', '33333333333', 4, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(8, 'Lucas Pereira', 'lucas.motorista@lavanderia.com', NULL, '$2y$12$eNI4aZxEQWLJyBa2fplHse9/q6M/Itf0hMiBxh1PHdr1XsmrOaApO', '(11) 96666-1111', '44444444444', 3, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42'),
(9, 'Rafael Souza', 'rafael.motorista@lavanderia.com', NULL, '$2y$12$.cOLcUZST/d1vZl6nVoE6OPl4.e1wJCI.mXpX6hk9dcSK.b5TA9ea', '(11) 96666-2222', '55555555555', 3, 1, NULL, NULL, '2025-07-28 18:05:42', '2025-07-28 18:05:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
