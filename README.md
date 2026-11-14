<div align="center">

# Obede

**Sistema de gestão de escalas de plantão para condomínios**

[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-11+-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
[![Tests](https://img.shields.io/badge/tests-40%20passed-2ea44f?style=flat-square&logo=githubactions&logoColor=white)](.github/workflows/tests.yml)
[![License](https://img.shields.io/badge/license-Proprietary-red?style=flat-square)](LICENSE)

</div>

---

## Sobre o projeto

**Obede** é uma aplicação web para gerenciar escalas de porteiros e recepcionistas de condomínios. Cobre o ciclo completo — do cadastro de postos e turnos até a efetivação de substituições em caso de ausência — com validação de conflitos, notificações e calendário visual.

Foi projetado para resolver três dores operacionais típicas:

- **Escala dispersa** — antes em planilhas, hoje em um calendário único e consultável por cada colaborador.
- **Ausências descoordenadas** — colaborador sinaliza indisponibilidade; admin vê avisos urgentes primeiro e aloca substituto com bloqueio automático de conflitos.
- **Falta de rastreabilidade** — cada alocação e substituição é registrada com status e notificação aos envolvidos.

---

## Sumário

- [Funcionalidades](#funcionalidades)
- [Stack tecnológico](#stack-tecnológico)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Usuários de demonstração](#usuários-de-demonstração)
- [Comandos Artisan](#comandos-artisan)
- [Testes](#testes)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Matriz de permissões](#matriz-de-permissões)
- [Deploy em produção](#deploy-em-produção)
- [CI/CD](#cicd)
- [Licença](#licença)

---

## Funcionalidades

### Para administradores

- **Painel de ausências pendentes** — avisos urgentes (menos de 24h) destacados no topo
- **Calendário mensal** com foto, nome e posto dos colaboradores alocados
- **Efetivar substituição** — aloca substituto com validação de:
  - mesma função (`cargo`) do ausente
  - ausência de conflito de turno no mesmo dia
  - intervalo mínimo de 11h entre turnos
  - bloqueio de auto-substituição
- **Notificação automática** ao substituto e ao solicitante quando a substituição é efetivada

### Para colaboradores (porteiro / recepcionista)

- **Minha Escala** — visualização filtrada apenas das próprias alocações
- **Aviso de ausência** — sinaliza que não poderá comparecer, com motivo e observação
  - Avisos com menos de 24h de antecedência são classificados como **urgentes**
- **Upload de foto de perfil** com thumbnail WebP 200×200 gerada automaticamente
- **Notificações** de alocação e substituição

### Integração com IA (MCP)

Duas *tools* expostas via [Model Context Protocol](https://modelcontextprotocol.io) para consulta em linguagem natural:

| Tool | Descrição | Autorização |
|---|---|---|
| `consultar_escala` | Retorna alocações do colaborador autenticado | colaborador |
| `listar_ausencias_pendentes` | Lista avisos de ausência pendentes | admin |

---

## Stack tecnológico

| Camada | Tecnologia |
|---|---|
| Linguagem | PHP 8.3 |
| Framework | Laravel 11+ |
| Permissões | [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) |
| Banco (dev) | SQLite |
| Banco (prod) | MySQL 8 |
| Banco (CI) | SQLite em memória |
| Imagens | GD (thumbnails WebP) |
| Testes | PHPUnit |
| CI | GitHub Actions |
| Integração IA | Model Context Protocol (MCP) |

---

## Pré-requisitos

- **PHP 8.3+** com extensões:
  `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `gd`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_sqlite`, `session`, `tokenizer`, `xml`
- **Composer 2**
- **Node.js 20+** (apenas se for compilar assets com Vite)
- **MySQL 8** (apenas produção; dev e CI usam SQLite)

---

## Instalação

### Setup rápido

```bash
git clone <url-do-repositório> obede
cd obede

composer install
cp .env.example .env
php artisan key:generate

# Ajuste o .env para dev (SQLite):
#   DB_CONNECTION=sqlite
#   DB_DATABASE=/caminho/absoluto/para/database/database.sqlite
touch database/database.sqlite

php artisan migrate
php artisan obede:demo        # popula com dados de demonstração
php artisan storage:link      # linka storage público (fotos de perfil)
php artisan serve