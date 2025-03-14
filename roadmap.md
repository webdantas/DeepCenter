# Roadmap do Projeto DeepCenter

## Fase 1: Configuração Inicial 
- [x] Configuração do ambiente Docker
- [x] Setup do WSL Arch Linux
- [x] Instalação Laravel 10
- [x] Configuração Vite
- [x] Setup MySQL
- [x] Configuração inicial do Git

## Fase 2: Autenticação (Sprint 1)
- [x] Implementação Laravel Breeze
- [x] Customização das views de auth
- [x] Implementação de validações
- [x] Testes de autenticação
- [ ] Documentação da API de auth

## Fase 3: Perfil de Usuário (Sprint 2)
- [ ] CRUD de perfil
- [ ] Upload de avatar
- [ ] Validações de dados
- [ ] Testes de perfil
- [ ] Documentação da API de perfil

## Fase 4: Frontend (Sprint 3)
- [x] Layout responsivo
- [x] Implementação Bootstrap
- [x] Integração jQuery
- [x] Validações client-side
- [ ] Otimização de assets

## Fase 5: Testes e Qualidade (Sprint 4)
- [x] Testes unitários
- [x] Testes de feature
- [ ] Testes de integração
- [ ] Code coverage
- [ ] Análise estática

## Fase 6: DevOps (Sprint 5)
- [ ] CI/CD GitHub Actions
- [ ] Integração Azure DevOps
- [ ] Deploy automático
- [ ] Monitoramento
- [ ] Logs e métricas

## Backlog Azure DevOps

### Épicos
1. Sistema de Autenticação
2. Gerenciamento de Perfil
3. Interface do Usuário
4. Infraestrutura DevOps

### Features
1. Login e Registro
   - [x] História: Como usuário, quero me registrar no sistema
   - [x] História: Como usuário, quero fazer login no sistema
   - [x] História: Como usuário, quero recuperar minha senha

2. Perfil
   - [ ] História: Como usuário, quero editar meus dados
   - [ ] História: Como usuário, quero fazer upload de avatar
   - [ ] História: Como usuário, quero alterar minha senha

3. Dashboard
   - [x] História: Como usuário, quero ver meus dados
   - [x] História: Como usuário, quero navegar facilmente
   - [x] História: Como usuário, quero um layout responsivo

4. DevOps
   - [ ] História: Como dev, quero deploy automático
   - [ ] História: Como dev, quero testes automatizados
   - [ ] História: Como dev, quero monitoramento

## Marcos (Milestones)
1. MVP - Sistema de Autenticação (2 semanas)
   - [x] Configuração do ambiente
   - [x] Implementação do Breeze
   - [x] Customização do frontend
   - [x] Testes de autenticação
   - [ ] Documentação da API

2. Release 1.0 - Perfil Completo (2 semanas)
   - [ ] CRUD de perfil
   - [ ] Upload de avatar
   - [ ] Testes e validações

3. Release 1.1 - UI/UX Aprimorada (1 semana)
   - [x] Layout responsivo
   - [x] Integração Bootstrap/jQuery
   - [ ] Otimização final

4. Release 1.2 - DevOps Completo (1 semana)
   - [ ] CI/CD
   - [ ] Monitoramento
   - [ ] Deploy automático

## Branches Principais
- main (produção)
- develop (desenvolvimento)
- feature/* (funcionalidades)
  - [x] feature/laravel-installation
  - [x] feature/auth-system
  - [ ] feature/user-profile
- release/* (preparação)
- hotfix/* (correções)

## Próximos Passos
1. [x] Implementar testes de autenticação
2. [ ] Documentar API de autenticação
3. [ ] Iniciar desenvolvimento do CRUD de perfil
4. [ ] Configurar CI/CD com GitHub Actions

## Status Atual
- Testes de autenticação implementados e passando (40/42)
- Dois testes de validação de senha precisam ser corrigidos
- Frontend responsivo com Bootstrap e jQuery
- Sistema de autenticação funcional com Laravel Breeze

## Tarefas Imediatas
1. Corrigir os testes de validação de senha:
   - Teste de senha atual
   - Teste de senha diferente da atual
2. Documentar a API de autenticação
3. Preparar branch para feature de perfil de usuário
4. Configurar GitHub Actions para CI/CD
