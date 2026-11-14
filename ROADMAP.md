cat > ROADMAP.md << 'EOF'
# 🗺️ Roadmap e Status do Projeto - Obede

Este documento serve como guia de acompanhamento do desenvolvimento do sistema Obede, detalhando o que já foi implementado e quais são os próximos passos.

## 🟢 O que já foi feito (Concluído)

### Infraestrutura e Configuração Inicial
- [x] Criação e configuração do banco de dados MySQL.
- [x] Configuração do Github Actions (CI) para rodar testes em PHP 8.4 com SQLite em memória.
- [x] Criação do `RolesSeeder` para provisionamento de permissões em produção.
- [x] Encadeamento do `RolesSeeder` no `DatabaseSeeder`.
- [x] Configuração do Vite e Tailwind no GitHub Actions.

### Autenticação e Segurança
- [x] Criação do `LoginController` (Login e Logout).
- [x] Tela de Login moderna e responsiva.
- [x] Redirecionamento inteligente pós-login (Admin vai para o painel, Colaborador vai para Minha Escala).
- [x] Middleware de proteção de rotas (`role:admin` e `role:porteiro|recepcionista`).

### CRUDs Base (Totalmente implementados com TDD)
- [x] **Usuários (Colaboradores):** Listar, Criar, Editar, Ativar/Desativar.
- [x] **Postos:** Listar, Criar, Editar (com descrição).
- [x] **Turnos:** Listar, Criar, Editar (com horários, tolerância e intervalo).
- [x] **Escalas:** Criar a escala mensal, publicar e gerenciar alocações.
- [x] **Alocações:** Escalar colaborador (com bloqueio de duplicidade) e remover.

### Regras de Negócio e Funcionalidades
- [x] Colaborador pode solicitar ausência em uma alocação.
- [x] Admin pode visualizar ausências pendentes (urgentes no topo).
- [x] Admin pode efetivar substituto (bloqueando conflitos de turno, cargo e intervalo de 11h).
- [x] Sistema de notificações no banco de dados.
- [x] Geração de thumbnail (WebP 200x200) no upload de foto de perfil.
- [x] Recuperação do Calendário Visual (para o Admin visualizar as escalas do mês).

### Melhorias de Interface (UX/UI) - CONCLUÍDO
- [x] Criação de um **Layout Master** (`app.blade.php`) com Sidebar unificada.
- [x] Substituição dos estilos HTML inline por Tailwind CSS.
- [x] Refatoração de todas as telas do Admin (Usuários, Postos, Turnos, Escalas).
- [x] Refatoração de todas as telas do Colaborador (Minha Escala, Aviso de Ausência, Perfil).
- [x] Design responsivo e moderno aplicado.

---

## 🟡 O que está em andamento (Próximos Passos)

O sistema encontra-se na fase de **Homologação Local**.
- [ ] **Testes Manuais:** Navegar por todas as telas, testar o fluxo completo (Admin criar escala -> Porteiro pedir ausência -> Admin alocar substituto) e validar a experiência visual.
- [ ] **Ajustes Finos:** Corrigir eventuais bugs ou detalhes de layout que surjam durante os testes.

---

## 🔴 O que falta fazer (Backlog / Futuro)

### Deploy em Produção (Aguardando sinal do desenvolvedor)
- [ ] Configurar Hospedagem Compartilhada (HostGator).
- [ ] Criar estrutura de pastas (`laravel_app` e `public_html`) no cPanel.
- [ ] Configurar o `.env` de produção e banco de dados MySQL.
- [ ] Rodar as migrações e o `RolesSeeder` no servidor.
- [ ] Configurar SMTP real (Gmail/SendGrid) para envio de e-mails.
- [ ] Configurar rotina de backup do banco de dados.

### Funcionalidades Adicionais (Pós-MVP)
- [ ] **Relatórios:** Tela para exportar a escala do mês em PDF ou Excel.
- [ ] **Recuperação de Senha:** Fluxo de "Esqueci minha senha" via e-mail.
- [ ] Alteração de senha pelo próprio perfil do usuário.

---
**Última atualização:** Novembro de 2026. 
**Status:** MVP e UI concluídos. Aguardando homologação para Deploy.
EOF