# DeepCenter - Sistema de Autenticação Laravel

## Sobre o Projeto
Sistema de autenticação desenvolvido com Laravel 10, utilizando as melhores práticas de desenvolvimento e padrões de projeto.

## Requisitos do Sistema
- Docker Desktop
- WSL2 com Arch Linux
- Git
- Composer
- Node.js

## Tecnologias Utilizadas
- Laravel 10
- PHP 8.2
- MySQL
- Vite
- Laravel Breeze
- Bootstrap
- jQuery
- Docker

## Instalação

### 1. Clone o Repositório
```bash
git clone https://github.com/webdantas/DeepCenter.git
cd DeepCenter
```

### 2. Configuração do Ambiente Docker
```bash
# Construir e iniciar os containers
docker compose up -d

# Instalar dependências do Composer
docker compose exec app composer install

# Instalar dependências do Node.js
docker compose exec app npm install
```

### 3. Configuração do Laravel
```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
docker compose exec app php artisan key:generate

# Executar migrations
docker compose exec app php artisan migrate

# Compilar assets
docker compose exec app npm run dev
```

## Estrutura de Branches
- `main`: Produção
- `develop`: Desenvolvimento
- `feature/*`: Novas funcionalidades
- `hotfix/*`: Correções urgentes
- `release/*`: Preparação para release

## Funcionalidades
- Sistema de autenticação completo
- Cadastro de usuários
- Edição de perfil
- Upload de avatar
- Dashboard personalizado

## Testes
```bash
docker compose exec app php artisan test
```

## Documentação Adicional
- [Documentação da API](./docs/api.md)
- [Guia de Desenvolvimento](./docs/development.md)
- [Padrões de Código](./docs/code-standards.md)

## Contribuição
Por favor, leia o [CONTRIBUTING.md](./CONTRIBUTING.md) para detalhes sobre nosso código de conduta e o processo para enviar pull requests.

## Licença
Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE.md](LICENSE.md) para detalhes.
