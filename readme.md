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
- user api para os dados do esabelecimento como CNPJ, Razão Social, Endereço, Telefone e E-mail
##DADOS API ##
Exemplo de requisição usando o curl
$ curl https://minhareceita.org/33683111000280
Exemplo de resposta válida
{
    "cnpj": "33683111000280",
    "identificador_matriz_filial": 2,
    "descricao_identificador_matriz_filial": "FILIAL",
    "nome_fantasia": "REGIONAL BRASILIA-DF",
    "situacao_cadastral": 2,
    "descricao_situacao_cadastral": "ATIVA",
    "data_situacao_cadastral": "2004-05-22",
    "motivo_situacao_cadastral": 0,
    "descricao_motivo_situacao_cadastral": "SEM MOTIVO",
    "nome_cidade_no_exterior": "",
    "codigo_pais": null,
    "pais": null,
    "data_inicio_atividade": "1967-06-30",
    "cnae_fiscal": 6204000,
    "cnae_fiscal_descricao": "Consultoria em tecnologia da informação",
    "descricao_tipo_de_logradouro": "AVENIDA",
    "logradouro": "L2 SGAN",
    "numero": "601",
    "complemento": "MODULO G",
    "bairro": "ASA NORTE",
    "cep": "70836900",
    "uf": "DF",
    "codigo_municipio": 9701,
    "codigo_municipio_ibge": 5300108,
    "municipio": "BRASILIA",
    "ddd_telefone_1": "",
    "ddd_telefone_2": "",
    "ddd_fax": "",
    "situacao_especial": "",
    "data_situacao_especial": null,
    "opcao_pelo_simples": null,
    "data_opcao_pelo_simples": null,
    "data_exclusao_do_simples": null,
    "opcao_pelo_mei": null,
    "data_opcao_pelo_mei": null,
    "data_exclusao_do_mei": null,
    "razao_social": "SERVICO FEDERAL DE PROCESSAMENTO DE DADOS (SERPRO)",
    "codigo_natureza_juridica": 2011,
    "natureza_juridica": "Empresa Pública",
    "qualificacao_do_responsavel": 16,
    "capital_social": 1061004800,
    "codigo_porte": 5,
    "porte": "DEMAIS",
    "ente_federativo_responsavel": null,
    "regime_tributario": null,
    "qsa": [
        {
            "identificador_de_socio": 2,
            "nome_socio": "ANDRE DE CESERO",
            "cnpj_cpf_do_socio": "***220050**",
            "codigo_qualificacao_socio": 10,
            "qualificacao_socio": "Diretor",
            "data_entrada_sociedade": "2016-06-16",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 6,
            "faixa_etaria": "Entre 51 a 60 anos"
        },
        {
            "identificador_de_socio": 2,
            "nome_socio": "ANTONIO DE PADUA FERREIRA PASSOS",
            "cnpj_cpf_do_socio": "***595901**",
            "codigo_qualificacao_socio": 10,
            "qualificacao_socio": "Diretor",
            "data_entrada_sociedade": "2016-12-08",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 7,
            "faixa_etaria": "Entre 61 a 70 anos"
        },
        {
            "identificador_de_socio": 2,
            "nome_socio": "WILSON BIANCARDI COURY",
            "cnpj_cpf_do_socio": "***414127**",
            "codigo_qualificacao_socio": 10,
            "qualificacao_socio": "Diretor",
            "data_entrada_sociedade": "2019-06-18",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 8,
            "faixa_etaria": "Entre 71 a 80 anos"
        },
        {
            "identificador_de_socio": 2,
            "nome_socio": "GILENO GURJAO BARRETO",
            "cnpj_cpf_do_socio": "***099595**",
            "codigo_qualificacao_socio": 16,
            "qualificacao_socio": "Presidente",
            "data_entrada_sociedade": "2020-02-03",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 5,
            "faixa_etaria": "Entre 41 a 50 anos"
        },
        {
            "identificador_de_socio": 2,
            "nome_socio": "RICARDO CEZAR DE MOURA JUCA",
            "cnpj_cpf_do_socio": "***989951**",
            "codigo_qualificacao_socio": 10,
            "qualificacao_socio": "Diretor",
            "data_entrada_sociedade": "2020-05-12",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 5,
            "faixa_etaria": "Entre 41 a 50 anos"
        },
        {
            "identificador_de_socio": 2,
            "nome_socio": "ANTONINO DOS SANTOS GUERRA NETO",
            "cnpj_cpf_do_socio": "***073447**",
            "codigo_qualificacao_socio": 5,
            "qualificacao_socio": "Administrador",
            "data_entrada_sociedade": "2019-02-11",
            "codigo_pais": null,
            "pais": null,
            "cpf_representante_legal": "***000000**",
            "nome_representante_legal": "",
            "codigo_qualificacao_representante_legal": 0,
            "qualificacao_representante_legal": null,
            "codigo_faixa_etaria": 7,
            "faixa_etaria": "Entre 61 a 70 anos"
        }
    ],
    "cnaes_secundarios": [
        {
            "codigo": 6201501,
            "descricao": "Desenvolvimento de programas de computador sob encomenda"
        },
        {
            "codigo": 6202300,
            "descricao": "Desenvolvimento e licenciamento de programas de computador customizáveis"
        },
        {
            "codigo": 6203100,
            "descricao": "Desenvolvimento e licenciamento de programas de computador não-customizáveis"
        },
        {
            "codigo": 6209100,
            "descricao": "Suporte técnico, manutenção e outros serviços em tecnologia da informação"
        },
        {
            "codigo": 6311900,
            "descricao": "Tratamento de dados, provedores de serviços de aplicação e serviços de hospedagem na internet"
        }
    ]
}

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