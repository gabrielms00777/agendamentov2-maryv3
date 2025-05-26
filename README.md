## 📘 Documento de Apresentação Técnica do Projeto

### Nome do Projeto

**Sistema de Agendamento Automatizado via WhatsApp (Multiempresas)**

---

### 🎯 Visão Geral

Plataforma SaaS voltada para empresas de serviços que desejam gerenciar agendamentos de forma automatizada via WhatsApp. A solução permite que clientes agendem horários com profissionais diretamente pela conversa no WhatsApp, integrando uma experiência simples para o cliente e completa para a empresa via painel administrativo.

---

### 🧩 Problemas Resolvidos

* Redução de faltas em compromissos por falta de lembrete
* Demora no retorno por atendimento humano
* Falta de controle de horários e agendamentos

---

### 👥 Tipos de Usuários

#### 1. Dono do Negócio

* Realiza o registro no sistema
* Configura os serviços, horários, profissionais e chips
* Gerencia usuários do painel (ex: atendentes)
* Pode enviar notificações manuais
* Habilita lembretes automáticos

#### 2. Atendente

* Acessa o painel com login próprio
* Cria ou cancela agendamentos
* Envia notificações manuais para clientes

#### 3. Cliente Final (usuário do WhatsApp)

* Interage com o bot
* Escolhe serviço, data e horário
* Recebe lembretes e confirmações

#### 4. Bot (automação)

* Conversa com o cliente no WhatsApp
* Consulta serviços, horários disponíveis e agenda
* Cria agendamento automaticamente
* Envia confirmações e lembretes

---

### 🔐 Fluxo de Registro e Uso Inicial

1. Dono acessa o site e clica em "Registrar"
2. Envia nome, email, telefone e senha
3. É redirecionado ao painel com onboarding
4. Cadastra o chip (número do WhatsApp conectado)
5. Cadastra serviços, profissionais e horários
6. Ativa lembretes automáticos se quiser

---

### 🖥️ Telas do Sistema (Painel Administrativo)

#### 1. Tela de Login

* Inputs:

  * Email (input type email)
  * Senha (input type password)
* Botões:

  * Entrar
  * Esqueceu a senha?

#### 2. Tela de Registro

* Inputs:

  * Nome da empresa
  * Email
  * Telefone
  * Senha e confirmação de senha
* Botão: Registrar

#### 3. Dashboard (Visão Geral)

* Cards com métricas:

  * Total de agendamentos hoje
  * Próximo horário
  * Chips conectados
  * Profissionais ativos
* Calendário (com marcações dos agendamentos)
* Lista de agendamentos do dia

#### 4. Tela de Agendamentos

* Filtros por data, profissional, serviço
* Lista em formato de tabela:

  * Nome do cliente
  * Serviço
  * Profissional
  * Data e horário
  * Status (ativo, cancelado)
  * Ações: Editar, Cancelar
* Botão de novo agendamento (abre modal ou navega)

#### 5. Formulário de Novo Agendamento

* Inputs:

  * Nome do cliente
  * Telefone do cliente
  * Serviço (select)
  * Profissional (select)
  * Data (datepicker)
  * Horário (select de horários disponíveis)
* Botões: Salvar / Cancelar

#### 6. Tela de Serviços

* Lista em cards:

  * Nome do serviço
  * Duração
  * Preço
  * Botões: Editar / Excluir
* Formulário lateral ou modal:

  * Nome (input)
  * Duração em minutos (input number)
  * Preço (input number ou masked)

#### 7. Tela de Profissionais

* Lista em tabela:

  * Nome
  * Serviços que realiza
  * Ações: Editar / Excluir
* Formulário lateral:

  * Nome
  * Serviços (multiselect)

#### 8. Tela de Chips WhatsApp

* Lista de chips conectados

  * Nome do chip
  * Número do WhatsApp vinculado
  * Status de conexão
  * Token (parcialmente mascarado)
* Botão para adicionar chip

  * Nome do chip
  * Número do telefone
  * Token de conexão (gerado via API)

#### 9. Tela de Horários de Funcionamento

* Lista por dias da semana (segunda a domingo)

  * Cada dia mostra horários configurados (ex: 08:00 às 18:00)
  * Permite adicionar múltiplos blocos
* Formulário:

  * Dia da semana
  * Hora de início
  * Hora de fim

#### 10. Tela de Bloqueios Manuais

* Escolher profissional
* Escolher data e horário
* Botão: Bloquear horário

#### 11. Tela de Notificações Manuais

* Selecionar cliente (input ou busca)
* Mensagem (textarea)
* Botão: Enviar via WhatsApp

#### 12. Tela de Lembretes Automáticos

* Switch: Ativar lembretes automáticos
* Input number: Quantas horas antes
* Preview da mensagem enviada

#### 13. Tela de Usuários do Painel

* Lista:

  * Nome
  * Email
  * Papel (admin/atendente)
  * Ações: Editar, Excluir
* Formulário:

  * Nome
  * Email
  * Senha (opcional na edição)
  * Papel (select)

#### 14. Tela de Configurações da Empresa

* Nome da empresa
* Email
* Telefone
* Logo (upload)
* Domínio personalizado (se aplicável)

---

### 🗃️ Estrutura do Banco (resumo por entidade)

* **companies** (id, name, email, phone, password)
* **users** (id, company\_id, name, email, password, role)
* **whatsapp\_chips** (id, company\_id, name, phone\_number, token)
* **services** (id, company\_id, name, duration, price)
* **professionals** (id, company\_id, name)
* **professional\_service** (professional\_id, service\_id)
* **business\_hours** (id, company\_id, weekday, start\_time, end\_time)
* **appointments** (id, company\_id, client\_name, client\_phone, date, time, service\_id, professional\_id)
* **blocked\_slots** (id, professional\_id, date, time)
* **reminder\_settings** (company\_id, enabled, hours\_before)

---

### 🔁 Fluxos Técnicos

#### A. Agendamento via WhatsApp

1. Cliente envia mensagem → bot responde com lista de serviços
2. Cliente escolhe serviço → bot pede data
3. Bot consulta horários livres (com duração do serviço)
4. Cliente escolhe horário → agendamento é criado
5. Bot envia confirmação

#### B. Agendamento via painel

1. Atendente escolhe cliente e serviço
2. Painel mostra horários disponíveis
3. Atendente seleciona e confirma
4. Sistema envia notificação opcional

#### C. Lembretes automáticos

1. CRON diário busca agendamentos futuros (ex: 24h antes)
2. Verifica se a empresa ativou lembretes
3. Envia notificação automática via WhatsApp

---

### 📡 Endpoints da API (resumo)

**Autenticação**

* POST `/auth/register`
* POST `/auth/login`

**Configuração geral**

* GET `/me`
* PATCH `/settings/reminders`

**Chips**

* POST `/whatsapp/chips`
* GET `/whatsapp/chips`

**Serviços**

* POST `/services`
* GET `/services`

**Profissionais**

* POST `/professionals`
* GET `/professionals`

**Horários de Funcionamento**

* POST `/business-hours`
* GET `/business-hours`

**Agendamentos**

* GET `/appointments`
* GET `/appointments/available-slots`
* POST `/appointments`
* DELETE `/appointments/{id}`

**Bloqueios**

* POST `/blocked-slots`

**Notificações**

* POST `/notifications/send`

**Usuários do painel**

* POST `/users`
* GET `/users`

**CRON de lembretes automáticos (interno)**

* GET `/cron/send-reminders`

---

### 📬 Padrão de Resposta da API

```json
{
  "success": true,
  "message": "Operação realizada com sucesso.",
  "data": { ... }
}
```

Em erros:

```json
{
  "success": false,
  "message": "Serviço não encontrado.",
  "errors": ["service_id inválido"]
}
```

---

### 🔐 Padrões Técnicos e Boas Práticas

* **Autenticação:** JWT + Middleware para roles (admin/atendente)
* **Erros padronizados:** sempre com `success`, `message` e `errors`
* **Log:** logs de falha com contexto da empresa e rota
* **Segurança:** validação de input, rate limiting em bots
* **Automação:** CRON Jobs separados para lembretes

---

### 🛠 Tecnologias Sugeridas

**Backend:** Laravel ou Node.js (Fastify ou Express) com Prisma **Frontend:** Next.js ou Astro com FlyonUI ou Tailwind UI **Bot:** API personalizada que interage com WhatsApp (via chip vinculado)

---

### 📅 Cronograma Técnico (resumo)

* Infraestrutura backend e banco: ✅ pronto
* Integração WhatsApp + bot: 🔄 andamento
* Painel administrativo: 🕓 em breve
* Lembretes automáticos: 🕓 em breve

---

### 📈 Oportunidades Comerciais e de Produto

* Período gratuito para entrada de leads
* Integração com link do WhatsApp no Instagram e Google
* Parcerias com influenciadores de nicho (beleza, saúde, etc)

---

### ✅ Conclusão

Este documento serve como guia técnico e funcional completo do projeto. Toda dúvida sobre regras de negócio, estrutura de dados, rotas ou fluxos pode ser respondida por ele.

Se novas regras forem adicionadas, ele será atualizado como referência central do time.
