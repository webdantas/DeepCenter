# Regras Globais do Projeto

## Padrões de Código

### PHP/Laravel
- PSR-12 para estilo de código
- Documentação PHPDoc em todas as classes e métodos
- Utilização de type hints e return types
- Injeção de dependência via construtor
- Repository Pattern para acesso a dados
- Service Layer para lógica de negócios
- Form Requests para validação
- Resources para transformação de dados
- Policies para autorização
- Gates para permissões
- Observers para eventos do modelo
- Jobs para processamento em background

### JavaScript/jQuery
- ESLint para padronização
- Uso de ES6+
- jQuery para manipulação DOM e AJAX
- Modularização de código
- Evitar código inline
- Usar eventos delegados
- Minimizar requisições AJAX

### CSS/SASS
- BEM (Block Element Modifier)
- Mobile First
- Variáveis CSS
- Componentização
- Evitar !important
- Evitar seletores profundos

## Arquitetura

### MVC
- Controllers magros
- Models com relacionamentos e scopes
- Views com componentes Blade
- Helpers para funções utilitárias
- Traits para código compartilhado
- Interfaces para contratos
- DTOs para transferência de dados

### API
- RESTful
- Versionamento
- Rate Limiting
- Autenticação via Sanctum
- Documentação OpenAPI/Swagger
- Respostas padronizadas
- Tratamento de erros consistente

## Segurança
- CSRF Protection
- XSS Prevention
- SQL Injection Protection
- Sanitização de inputs
- Validação de dados
- Logs de auditoria
- Backup automático
- HTTPS forçado

## DevOps
- CI/CD via GitHub Actions
- Testes automatizados
- Code coverage mínimo de 80%
- Análise estática de código
- Versionamento semântico
- Branches protegidas
- Code review obrigatório
- Deploy automatizado

## Banco de Dados
- Migrations documentadas
- Seeds para dados iniciais
- Factories para testes
- Índices otimizados
- Foreign keys
- Soft deletes
- Timestamps automáticos
- Backup diário

## Git
- Commits semânticos
- Pull requests descritivos
- Code review obrigatório
- Não commitar env
- Não commitar vendor
- Não commitar node_modules
- Changelog automático
- Tags para releases
