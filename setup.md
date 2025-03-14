# Setup do Ambiente de Desenvolvimento

## Pré-requisitos no WSL Arch Linux

### 1. Atualizar o sistema
```bash
sudo pacman -Syu
```

### 2. Instalar dependências básicas
```bash
sudo pacman -S git base-devel docker docker-compose
```

### 3. Configurar Docker
```bash
# Iniciar serviço do Docker
sudo systemctl start docker
sudo systemctl enable docker

# Adicionar usuário ao grupo docker
sudo usermod -aG docker $USER
```

### 4. Instalar PHP 8.2 e extensões
```bash
sudo pacman -S php php-fpm php-gd php-pgsql php-sqlite php-mysqlnd php-redis php-memcached
```

### 5. Instalar Composer
```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

### 6. Instalar Node.js e npm
```bash
sudo pacman -S nodejs npm
```

## Instalação do Projeto

### 1. Clonar o repositório
```bash
git clone https://github.com/webdantas/DeepCenter.git
cd DeepCenter
```

### 2. Criar nova branch de desenvolvimento
```bash
git checkout -b develop
git push origin develop
```

### 3. Instalar Laravel via Composer
```bash
composer create-project laravel/laravel . "10.*"
```

### 4. Configurar ambiente
```bash
cp .env.example .env
```

### 5. Instalar dependências do projeto
```bash
composer require laravel/breeze
php artisan breeze:install
npm install
```

### 6. Configurar Docker
```bash
# Construir e iniciar containers
docker compose up -d --build

# Instalar dependências dentro do container
docker compose exec app composer install
docker compose exec app npm install
```

### 7. Configurar banco de dados
```bash
docker compose exec app php artisan migrate
```

### 8. Compilar assets
```bash
docker compose exec app npm run dev
```

## Estrutura de Branches

- `main`: Produção
- `develop`: Desenvolvimento
- `feature/auth`: Sistema de autenticação
- `feature/profile`: Perfil de usuário
- `feature/tests`: Implementação de testes
- `feature/ui`: Interface do usuário

## Comandos Úteis

### Artisan
```bash
# Criar controller
docker compose exec app php artisan make:controller ProfileController

# Criar model
docker compose exec app php artisan make:model Profile -m

# Criar request
docker compose exec app php artisan make:request UpdateProfileRequest
```

### Testes
```bash
# Executar testes
docker compose exec app php artisan test

# Criar teste
docker compose exec app php artisan make:test ProfileTest
```

### NPM
```bash
# Compilar assets em desenvolvimento
docker compose exec app npm run dev

# Compilar assets para produção
docker compose exec app npm run build
```

## Acessando a Aplicação

- Frontend: http://localhost:8000
- API: http://localhost:8000/api
- Banco de dados: localhost:3306

## Troubleshooting

### Permissões
```bash
# Corrigir permissões de storage
docker compose exec app chmod -R 777 storage bootstrap/cache
```

### Limpar Cache
```bash
docker compose exec app php artisan config:clear
docker compose exec app php artisan cache:clear
docker compose exec app php artisan view:clear
```
