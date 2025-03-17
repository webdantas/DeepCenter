# DeepCenter

Sistema de gerenciamento de perfis com suporte a multitenancy.

## Funcionalidades

- Sistema de autenticação (42/42 testes passando)
- CRUD de perfis com multitenancy
- Upload e gerenciamento de avatares
- Validação de dados com FormRequest
- Frontend responsivo com Bootstrap e jQuery
- Suporte a dark mode
- Flash messages para feedback
- Soft deletes para exclusão segura

## Testes

- 51 testes
- 141 assertions
- 100% de cobertura

## Documentação

- API de autenticação: [docs/api/auth.md](docs/api/auth.md)
- API de perfis: [docs/api/profile.md](docs/api/profile.md)

## Requisitos

- Docker Desktop
- Docker Compose
- Git

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/webdantas/DeepCenter.git
cd DeepCenter
```

2. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Inicie os containers:
```bash
docker compose up -d
```

4. Instale as dependências:
```bash
docker compose exec app composer install
docker compose exec app npm install
```

5. Gere a chave da aplicação:
```bash
docker compose exec app php artisan key:generate
```

6. Execute as migrações:
```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Acesso

Acesse o sistema em: http://localhost:8080

Credenciais de acesso:
- Email: admin@deepcenter.com
- Senha: password

## CI/CD

- GitHub Actions configurado (.github/workflows/laravel.yml)
- Testes automatizados
- Análise de código

## Licença

Este projeto está licenciado sob a [MIT license](LICENSE).
