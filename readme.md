# Sistema de Gestão de Lavanderia

## 📋 Descrição do Projeto

O Sistema de Gestão de Lavanderia é uma aplicação web desenvolvida em PHP que permite o gerenciamento completo de serviços de lavanderia para hotéis e estabelecimentos. O sistema oferece controle desde a coleta das peças até a entrega final, incluindo pesagem, empacotamento e rastreamento através de QR Codes.

## 🚀 Funcionalidades Principais

- *Autenticação e Controle de Acesso*: Sistema de login seguro com diferentes níveis de acesso
- *Gestão de Estabelecimentos*: Cadastro e gerenciamento de hotéis e clientes
- *Controle de Coletas*: Agendamento e acompanhamento de coletas de roupas
- *Sistema de Pesagem*: Registro do peso das peças coletadas
- *Empacotamento*: Organização e preparação das peças para entrega
- *Rastreamento por QR Code*: Geração e leitura de códigos QR para rastreamento
- *Relatórios*: Geração de relatórios detalhados de operações
- *Dashboard*: Painel de controle com estatísticas em tempo real

## 🏗️ Estrutura do Projeto

### Arquivos Principais
- index.php - Página inicial que redireciona para o login
- login.php - Interface de autenticação do usuário
- painel.php - Dashboard principal com estatísticas do dia
- cadastro.php - Formulário de cadastro de novos usuários
- validar_login.php - Processamento da autenticação
- logout.php - Encerramento da sessão

### 📁 Módulos do Sistema

#### 🏢 Módulo de Estabelecimentos (/view/estabelecimento/)
Gerenciamento completo de hotéis e estabelecimentos clientes.

*Funcionalidades:*
- cadastro.php - Cadastro de novos estabelecimentos
- lista.php - Listagem de todos os estabelecimentos
- editar.php - Edição de dados dos estabelecimentos
- excluir.php - Remoção de estabelecimentos
- validar_cadastro.php - Validação dos dados de cadastro

*Campos gerenciados:*
- CNPJ
- Razão Social
- Endereço
- Telefone
- E-mail

#### 🚚 Módulo de Coletas (/view/coleta/)
Controle do processo de coleta de roupas nos estabelecimentos.

*Funcionalidades:*
- coleta.php - Interface principal para registro de coletas
- lista_coletas.php - Visualização de todas as coletas
- processa_coleta.php - Processamento dos dados de coleta
- cancelar_coleta.php - Cancelamento de coletas

*Status de coleta:*
- Em andamento
- Concluída
- Cancelada (com motivo)

#### ⚖️ Módulo de Pesagem (/view/pesagem/)
Registro e controle do peso das peças coletadas.

*Funcionalidades:*
- cadastrar.php - Registro de pesagem das peças
- lista.php - Listagem de todas as pesagens
- editar_pesagem.php - Edição de dados de pesagem

*Informações registradas:*
- Peso das peças por tipo
- Data e hora da pesagem
- Responsável pela pesagem

#### 📦 Módulo de Empacotamento (/view/empacotamento/)
Gestão do processo de empacotamento e entrega das peças.

*Funcionalidades:*
- index.php - Interface principal de empacotamento
- empacotamento_detalhes.php - Detalhes específicos do empacotamento
- lista_empacotamentos.php - Listagem de empacotamentos
- listar_empacotamentos_motorista.php - Visualização para motoristas
- processa_empacotamento.php - Processamento do empacotamento
- reimprimir_qrcode.php - Reimpressão de códigos QR
- get_coletas.php - API para obter dados de coletas
- get_coleta_pecas.php - API para obter peças da coleta
- get_detalhes_coleta.php - API para detalhes da coleta

*Controles de status:*
- Status do motorista
- Status de recebimento
- Assinatura de recebimento
- Datas de confirmação

#### 📊 Módulo de Relatórios (/view/relatorios/)
Geração de relatórios detalhados das operações.

*Tipos de relatórios:*
- Relatórios de coletas por período
- Relatórios de empacotamentos
- Estatísticas de produtividade
- Relatórios por estabelecimento

#### 🏷️ Módulo de Tipos (/view/tipo/)
Gerenciamento dos tipos de peças e serviços.

*Funcionalidades:*
- Cadastro de tipos de peças (camisas, calças, etc.)
- Definição de preços por tipo
- Categorização de serviços

#### 📱 Sistema de QR Codes (/view/qrcodes/)
Geração e gerenciamento de códigos QR para rastreamento.

*Funcionalidades:*
- Geração automática de QR Codes
- Rastreamento de peças
- Histórico de movimentações

#### 📈 Módulo de Status (/view/status/)
Controle dos diferentes status do sistema.

*Status disponíveis:*
- Status de coletas
- Status de empacotamentos
- Status de entregas

## 🗄️ Estrutura do Banco de Dados

### Principais Tabelas

#### usuarios
- Controle de acesso e autenticação
- Níveis de permissão diferenciados

#### estabelecimentos
- Dados dos hotéis e clientes
- Informações de contato e localização

#### coletas
- Registro de todas as coletas realizadas
- Status e datas de execução

#### coleta_pecas
- Detalhamento das peças por coleta
- Quantidades e tipos

#### empacotamento
- Controle do processo de empacotamento
- Rastreamento de entregas

#### niveis_acesso
- Definição de permissões do sistema
- Controle de funcionalidades por usuário

## 🛠️ Tecnologias Utilizadas

- *Backend*: PHP 8.3+
- *Banco de Dados*: MySQL 8.3+
- *Frontend*: HTML5, CSS3, JavaScript
- *Framework CSS*: Bootstrap 5.3.3
- *Ícones*: Font Awesome 6.0
- *Servidor Web*: Apache (WAMP)
- *Gerenciador de Dependências*: Composer

## 📋 Pré-requisitos

- PHP 8.3 ou superior
- MySQL 8.3 ou superior
- Servidor Apache
- Extensões PHP necessárias:
  - mysqli
  - session
  - gd (para geração de QR Codes)

## 🚀 Instalação

1. *Clone ou baixe o projeto* para o diretório do seu servidor web
2. *Configure o banco de dados* importando o arquivo lavanderia.sql
3. *Configure a conexão* com o banco no arquivo includes/db_config.php
4. *Instale as dependências* via Composer:
   bash
   composer install
   
5. *Configure as permissões* adequadas para os diretórios de upload e QR codes

## 🔧 Configuração

### Configuração do Banco de Dados
Edite o arquivo includes/db_config.php com suas credenciais:

php
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "lavanderia";


### Estrutura de Diretórios

lavanderia/
├── assets/              # Recursos estáticos (CSS, JS, imagens)
├── includes/            # Arquivos de configuração e includes
├── qrcodes/            # Códigos QR gerados
├── view/               # Módulos da aplicação
│   ├── coleta/         # Gestão de coletas
│   ├── empacotamento/  # Controle de empacotamento
│   ├── estabelecimento/# Gestão de estabelecimentos
│   ├── pesagem/        # Controle de pesagem
│   ├── relatorios/     # Relatórios do sistema
│   ├── status/         # Controle de status
│   └── tipo/           # Gestão de tipos
└── vendor/             # Dependências do Composer


## 👥 Níveis de Acesso

O sistema possui diferentes níveis de acesso:

1. *Administrador*: Acesso completo a todas as funcionalidades
2. *Operador*: Acesso às operações de coleta e empacotamento
3. *Motorista*: Acesso específico para confirmação de entregas
4. *Visualizador*: Acesso apenas para consulta de relatórios

## 📱 Funcionalidades Mobile

- Interface responsiva para dispositivos móveis
- Leitura de QR Codes via câmera
- Assinatura digital para confirmação de recebimento

## 🔒 Segurança

- Sistema de autenticação por sessão
- Validação de dados de entrada
- Proteção contra SQL Injection
- Controle de acesso baseado em níveis

## 📞 Suporte

Para suporte técnico ou dúvidas sobre o sistema, entre em contato com a equipe de desenvolvimento.

## 📄 Licença

Este projeto é propriedade privada. Todos os direitos reservados.

---

*Desenvolvido para otimizar a gestão de lavanderias e melhorar a experiência do cliente.*