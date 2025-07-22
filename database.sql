-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS lavanderia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lavanderia;

-- Tabela de níveis de acesso
CREATE TABLE niveis_acesso (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    descricao TEXT,
    permissoes JSON,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de usuários
CREATE TABLE usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    cpf VARCHAR(14) UNIQUE,
    nivel_acesso_id BIGINT UNSIGNED NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    ultimo_login TIMESTAMP NULL DEFAULT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (nivel_acesso_id) REFERENCES niveis_acesso(id)
);

-- Tabela de estabelecimentos
CREATE TABLE estabelecimentos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    razao_social VARCHAR(255) NOT NULL,
    nome_fantasia VARCHAR(255),
    endereco VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(255),
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(255),
    contato_responsavel VARCHAR(255),
    observacoes TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de tipos
CREATE TABLE tipos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco_kg DECIMAL(8,2) DEFAULT 0.00,
    categoria VARCHAR(255),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de status
CREATE TABLE status (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    tipo VARCHAR(255) NOT NULL,
    cor VARCHAR(7) DEFAULT '#6c757d',
    ordem INT DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de coletas
CREATE TABLE coletas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    estabelecimento_id BIGINT UNSIGNED NOT NULL,
    usuario_id BIGINT UNSIGNED NOT NULL,
    status_id BIGINT UNSIGNED NOT NULL,
    data_agendamento DATETIME NOT NULL,
    data_coleta DATETIME,
    data_conclusao DATETIME,
    observacoes TEXT,
    motivo_cancelamento TEXT,
    peso_total DECIMAL(8,2) DEFAULT 0.00,
    valor_total DECIMAL(10,2) DEFAULT 0.00,
    numero_coleta VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (estabelecimento_id) REFERENCES estabelecimentos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (status_id) REFERENCES status(id)
);

-- Tabela de peças da coleta
CREATE TABLE coleta_pecas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    coleta_id BIGINT UNSIGNED NOT NULL,
    tipo_id BIGINT UNSIGNED NOT NULL,
    quantidade INT NOT NULL,
    peso DECIMAL(8,2) NOT NULL,
    preco_unitario DECIMAL(8,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    observacoes TEXT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (coleta_id) REFERENCES coletas(id) ON DELETE CASCADE,
    FOREIGN KEY (tipo_id) REFERENCES tipos(id)
);

-- Tabela de empacotamento
CREATE TABLE empacotamento (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    coleta_id BIGINT UNSIGNED NOT NULL,
    usuario_empacotamento_id BIGINT UNSIGNED NOT NULL,
    motorista_id BIGINT UNSIGNED,
    status_id BIGINT UNSIGNED NOT NULL,
    codigo_qr VARCHAR(255) NOT NULL UNIQUE,
    data_empacotamento DATETIME NOT NULL,
    data_saida DATETIME,
    data_entrega DATETIME,
    data_confirmacao_recebimento DATETIME,
    assinatura_recebimento VARCHAR(255),
    nome_recebedor VARCHAR(255),
    observacoes_empacotamento TEXT,
    observacoes_entrega TEXT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (coleta_id) REFERENCES coletas(id),
    FOREIGN KEY (usuario_empacotamento_id) REFERENCES usuarios(id),
    FOREIGN KEY (motorista_id) REFERENCES usuarios(id),
    FOREIGN KEY (status_id) REFERENCES status(id)
);

-- Tabela de migrations (Laravel)
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

-- Inserção de dados iniciais

-- Níveis de acesso
INSERT INTO niveis_acesso (nome, descricao, permissoes, ativo, created_at, updated_at) VALUES
('Administrador', 'Acesso total ao sistema', '{"all": true}', TRUE, NOW(), NOW()),
('Gerente', 'Gerenciamento de operações e relatórios', '{"coletas": true, "empacotamento": true, "relatorios": true, "estabelecimentos": true}', TRUE, NOW(), NOW()),
('Operador', 'Operações básicas de coleta e empacotamento', '{"coletas": true, "empacotamento": true}', TRUE, NOW(), NOW()),
('Motorista', 'Acesso para entrega e coleta', '{"coletas": "read", "empacotamento": "delivery"}', TRUE, NOW(), NOW());

-- Status para coletas
INSERT INTO status (nome, descricao, tipo, cor, ordem, ativo, created_at, updated_at) VALUES
('Agendada', 'Coleta agendada', 'coleta', '#17a2b8', 1, TRUE, NOW(), NOW()),
('Em Andamento', 'Coleta em andamento', 'coleta', '#ffc107', 2, TRUE, NOW(), NOW()),
('Concluída', 'Coleta concluída', 'coleta', '#28a745', 3, TRUE, NOW(), NOW()),
('Cancelada', 'Coleta cancelada', 'coleta', '#dc3545', 4, TRUE, NOW(), NOW());

-- Status para empacotamento
INSERT INTO status (nome, descricao, tipo, cor, ordem, ativo, created_at, updated_at) VALUES
('Empacotado', 'Peças empacotadas', 'empacotamento', '#17a2b8', 1, TRUE, NOW(), NOW()),
('Em Trânsito', 'Em trânsito para entrega', 'empacotamento', '#ffc107', 2, TRUE, NOW(), NOW()),
('Entregue', 'Entregue ao cliente', 'empacotamento', '#28a745', 3, TRUE, NOW(), NOW()),
('Devolvido', 'Devolvido sem entrega', 'empacotamento', '#dc3545', 4, TRUE, NOW(), NOW());

-- Tipos de peças
INSERT INTO tipos (nome, descricao, preco_kg, categoria, ativo, created_at, updated_at) VALUES
('Camisa Social', 'Camisa social masculina/feminina', 15.00, 'Roupas Sociais', TRUE, NOW(), NOW()),
('Calça Social', 'Calça social masculina/feminina', 18.00, 'Roupas Sociais', TRUE, NOW(), NOW()),
('Terno Completo', 'Terno completo (paletó + calça)', 35.00, 'Roupas Sociais', TRUE, NOW(), NOW()),
('Vestido', 'Vestido casual ou social', 20.00, 'Roupas Femininas', TRUE, NOW(), NOW()),
('Blusa', 'Blusa feminina', 12.00, 'Roupas Casuais', TRUE, NOW(), NOW()),
('Camiseta', 'Camiseta masculina/feminina', 8.00, 'Roupas Casuais', TRUE, NOW(), NOW()),
('Jeans', 'Calça jeans', 15.00, 'Roupas Casuais', TRUE, NOW(), NOW()),
('Casaco', 'Casaco ou jaqueta', 25.00, 'Roupas de Inverno', TRUE, NOW(), NOW()),
('Cobertor', 'Cobertor ou edredom', 30.00, 'Cama e Banho', TRUE, NOW(), NOW()),
('Lençol', 'Jogo de lençol', 20.00, 'Cama e Banho', TRUE, NOW(), NOW());

-- Usuário administrador padrão
INSERT INTO usuarios (nome, email, password, telefone, cpf, nivel_acesso_id, ativo, created_at, updated_at) VALUES
('Administrador', 'admin@lavanderia.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '(63) 99999-9999', '000.000.000-00', 1, TRUE, NOW(), NOW());
