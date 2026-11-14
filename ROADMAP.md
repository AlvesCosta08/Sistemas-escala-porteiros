# 🗺️ Roadmap e Status do Projeto - Obede

Este documento serve como guia de acompanhamento do desenvolvimento do sistema Obede, detalhando o que já foi implementado e quais são os próximos passos.

## 🟢 O que já foi feito (Concluído)

### Infraestrutura e Configuração Inicial
- [x] Correção do erro `RoleDoesNotExist` no comando `obede:demo`.
- [x] Criação do `RolesSeeder` para provisionamento de permissões em produção.
- [x] Encadeamento do `RolesSeeder` no `DatabaseSeeder`.
- [x] Configuração do GitHub Actions (CI) para rodar testes em PHP 8.4 com SQLite em memória.
- [x] Documentação (README.md) e `.env.example` prontos para produção.

### Autenticação
- [x] Criação do `LoginController` (Login e Logout).
- [x] Tela de Login simples e funcional.
- [x] Redirecionamento inteligente pós-login (Admin vai para o painel, Colaborador vai para Minha Escala).

### CRUDs Base (Totalmente implementados com TDD)
- [x] **Usuários (Colaboradores):** Listar, Criar, Editar, Ativar/Desativar.
- [x] **Postos:** Listar, Criar, Editar (com descrição).
- [x] **Turnos:** Listar, Criar, Editar (com horários, tolerância e intervalo).
- [x] Proteção de rotas com Middleware (`role:admin`).
- [x] Testes automatizados (Feature Tests) cobrindo regras de negócio e segurança.

### Regras de Negócio Existentes
- [x] Colaborador pode solicitar ausência em uma alocação.
- [x] Admin pode visualizar ausências pendentes (urgentes no topo).
- [x] Admin pode efetivar substituto (bloqueando conflitos de turno e cargo).
- [x] Sistema de notificações no banco de dados.
- [x] Geração de thumbnail (WebP) no upload de foto de perfil.

---

## 🟡 O que está em andamento (Próximos Passos)

O foco atual é dar autonomia total ao Administrador para montar a escala sem depender do comando de terminal `obede:demo`.

- [ ] **CRUD de Escalas (EscalaController)**
  - Criar a escala do mês (ex: Novembro/2026).
  - Listar escalas.
  - Publicar escala (mudar status para que colaboradores vejam).
- [ ] **Gestão de Alocações (AlocacaoController)**
  - Tela para o Admin escalar um colaborador.
  - Selecionar: Colaborador + Posto + Turno + Data.
  - Validação de conflitos no momento da criação da alocação.
  - Excluir uma alocação incorreta.

---

## 🔴 O que falta fazer (Backlog / Futuro)

### Melhorias de Interface (UX/UI)
- [ ] Criar um **Layout Master** (`app.blade.php`) com Navbar/Sidebar unificada.
- [ ] Substituir os estilos HTML inline atuais por Tailwind CSS ou Bootstrap.
- [ ] Melhorar a responsividade (telas mobile para porteiros).

### Funcionalidades Adicionais
- [ ] **Relatórios:** Tela para exportar a escala do mês em PDF ou Excel.
- [ ] **Recuperação de Senha:** Fluxo de "Esqueci minha senha" com envio de e-mail.
- [ ] Alteração de senha pelo próprio perfil do usuário.

### Preparação para Produção (Deploy)
- [ ] Contratar e configurar servidor VPS (Nginx + PHP 8.4 + MySQL).
- [ ] Configurar SMTP real (Gmail/SendGrid) para envio de e-mails.
- [ ] Configurar rotina de backup do banco de dados.
- [ ] Realizar o primeiro deploy e testes em ambiente real.

---
**Última atualização:** Novembro de 2026.
