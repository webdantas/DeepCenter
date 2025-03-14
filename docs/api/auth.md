# Documentação da API de Autenticação

## Visão Geral
A API de autenticação do DeepCenter fornece endpoints para registro, login, recuperação de senha e gerenciamento de perfil de usuário. Implementada usando Laravel Breeze, a API segue as melhores práticas de segurança e autenticação.

## Base URL
```
http://localhost:8000/api
```

## Endpoints

### 1. Registro de Usuário
**Endpoint:** `POST /register`

**Headers:**
```
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}
```

**Request Body:**
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
```

**Validações:**
- `name`: Obrigatório, string
- `email`: Obrigatório, email válido, único
- `password`: Obrigatório, mínimo 8 caracteres
- `password_confirmation`: Deve corresponder ao password

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "message": "User registered successfully",
    "user": {
        "id": "integer",
        "name": "string",
        "email": "string",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
}
```

### 2. Login
**Endpoint:** `POST /login`

**Headers:**
```
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}
```

**Request Body:**
```json
{
    "email": "string",
    "password": "string",
    "remember": "boolean"
}
```

**Validações:**
- `email`: Obrigatório, email válido
- `password`: Obrigatório
- `remember`: Opcional, boolean

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "message": "Logged in successfully",
    "user": {
        "id": "integer",
        "name": "string",
        "email": "string"
    }
}
```

### 3. Logout
**Endpoint:** `POST /logout`

**Headers:**
```
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}
Authorization: Bearer {token}
```

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "message": "Logged out successfully"
}
```

### 4. Recuperação de Senha
**Endpoint:** `POST /forgot-password`

**Headers:**
```
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}
```

**Request Body:**
```json
{
    "email": "string"
}
```

**Validações:**
- `email`: Obrigatório, email válido, deve existir no sistema

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "message": "Password reset link sent"
}
```

### 5. Reset de Senha
**Endpoint:** `POST /reset-password`

**Headers:**
```
Content-Type: application/json
Accept: application/json
X-CSRF-TOKEN: {token}
```

**Request Body:**
```json
{
    "token": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
```

**Validações:**
- `token`: Obrigatório, token válido
- `email`: Obrigatório, email válido
- `password`: Obrigatório, mínimo 8 caracteres
- `password_confirmation`: Deve corresponder ao password

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "message": "Password reset successfully"
}
```

## Tratamento de Erros

### Erro de Validação (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field": [
            "Mensagem de erro"
        ]
    }
}
```

### Erro de Autenticação (401)
```json
{
    "message": "Unauthenticated"
}
```

### Erro de Autorização (403)
```json
{
    "message": "Forbidden"
}
```

## Throttling e Rate Limiting
- Máximo de 60 tentativas por minuto por IP
- Máximo de 5 tentativas de login por minuto por email
- Máximo de 3 tentativas de recuperação de senha por hora por email

## Segurança
- Todas as senhas são hasheadas usando Bcrypt
- Tokens CSRF são necessários para todas as requisições
- Sessões são invalidadas após o logout
- Suporte a autenticação de dois fatores (2FA)
- Proteção contra ataques de força bruta
- Headers de segurança configurados (XSS, CSRF, etc.)

## Testes
Os endpoints foram testados usando PHPUnit com os seguintes cenários:
- Registro com dados válidos e inválidos
- Login com credenciais corretas e incorretas
- Logout
- Recuperação de senha
- Reset de senha
- Validações de campos
- Rate limiting
- Proteção CSRF

## Exemplos de Uso

### Registro de Usuário
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: {token}" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: {token}" \
  -d '{
    "email": "john@example.com",
    "password": "password123",
    "remember": true
  }'
```

## Notas de Implementação
- Implementado usando Laravel Breeze
- Validações server-side e client-side
- Integração com jQuery para validações no frontend
- Layout responsivo com Bootstrap
- Testes automatizados para todos os endpoints
- Documentação gerada com base nos testes e implementação
