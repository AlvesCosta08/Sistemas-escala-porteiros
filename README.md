# Obede — Sistema de Escala de Plantão

Sistema web para gestão de escalas de porteiros e recepcionistas de condomínio.
Permite cadastrar postos e turnos, montar escalas mensais, registrar ausências
e efetivar substituições com validação de conflitos.

## Funcionalidades

- **Autenticação** com três perfis: `admin`, `porteiro`, `recepcionista`
  (via [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission))
- **Cadastro** de postos e turnos (diurno/noturno, tolerância, intervalo)
- **Escala mensal** com alocações por posto/turno/colaborador
- **Minha Escala** — colaborador vê apenas suas alocações
- **Aviso de ausência** — colaborador sinaliza que não poderá comparecer;
  avisos com menos de 24h são marcados como **urgentes**
- **Painel de ausências** — admin vê avisos pendentes, urgentes primeiro
- **Efetivar substituição** — admin aloca substituto da mesma função,
  com bloqueios de backend para conflito de turno, intervalo mínimo de 11h
  e auto-substituição
- **Notificações** para admin (nova ausência), substituto (alocado) e
  solicitante (substituto definido)
- **Calendário admin** mensal com foto e nome dos alocados
- **Upload de foto de perfil** com thumbnail WebP 200×200
- **MCP tools** para consulta de escala e ausências via IA
  ([Model Context Protocol](https://modelcontextprotocol.io))

## Stack

| Camada | Tecnologia |
|---|---|
| Linguagem | PHP 8.3 |
| Framework | Laravel |
| Permissões | Spatie Laravel Permission |
| Banco (dev) | SQLite (via `.env` local) |
| Banco (prod) | MySQL 8 |
| Banco (CI) | SQLite em memória |
| Imagens | GD (thumbnails WebP) |
| Testes | PHPUnit (40 testes, 93 assertions) |
| CI | GitHub Actions |

## Requisitos

- PHP 8.3+ com extensões: `ctype`, `curl`, `dom`, `fileinfo`, `filter`,
  `gd`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_sqlite` (dev/CI)
  ou `pdo_mysql` (prod), `session`, `tokenizer`, `xml`
- Composer 2
- Node.js 20+ (se for usar Vite para assets)
- MySQL 8 (apenas para produção; dev usa SQLite)

## Instalação (desenvolvimento)

```bash
# 1. Clonar e instalar dependências
git clone <url-do-repo> obede
cd obede
composer install

# 2. Configurar ambiente
cp .env.example .env
# Editar .env: DB_CONNECTION=sqlite, DB_DATABASE=/caminho/absoluto/database.sqlite
# (ou descomentar as linhas de MySQL e apontar para o banco local)
php artisan key:generate

# 3. Criar banco SQLite (se for usar SQLite em dev)
touch database/database.sqlite

# 4. Rodar migrations
php artisan migrate

# 5. Popular com dados de demonstração
php artisan obede:demo

# 6. Linkar storage público (fotos de perfil)
php artisan storage:link

# 7. Subir o servidor
php artisan serve
