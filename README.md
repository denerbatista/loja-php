# 🛒 Loja PHP (Laravel + MySQL + Docker)

Projeto desenvolvido conforme o exercício **Desenvolvedor PHP (Web + Banco de Dados)**.

Implementa duas telas:
1. **Lista de produtos** (com busca e paginação)
2. **Carrinho de compras** (com cupons, totais e checkout)

---

## 🚀 Tecnologias

- **PHP 8.2 + Laravel 11**
- **MySQL 8**
- **Bootstrap 5**
- **Docker + Docker Compose**

---

## 📦 Estrutura de Pastas

```
loja-php/
├── docker-compose.yml
├── docker/
│   ├── php/Dockerfile
│   └── nginx/default.conf
├── app/                      ← Projeto Laravel
│   ├── app/Http/Controllers/ ← Controllers
│   ├── app/Models/           ← Models Produto e Cupom
│   ├── database/migrations/  ← Estrutura das tabelas
│   ├── database/seeders/     ← Seed de produtos e cupons
│   ├── resources/views/      ← Layouts e telas (Blade)
│   └── public/               ← Pasta pública do Laravel
```

---

## ⚙️ Como subir o projeto

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/SEU_USUARIO/loja-php.git
cd loja-php
```

### 2️⃣ Subir com Docker
```bash
docker compose up -d --build
```

### 3️⃣ Instalar dependências e configurar Laravel
```bash
docker compose run --rm composer install
docker compose exec app php artisan key:generate
```

### 4️⃣ Criar banco e rodar migrations + seeders
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 5️⃣ Acessar no navegador
```
http://localhost:8080
```

---

## 💡 Funcionalidades

### 🧾 Produtos
- Busca por nome (`input` simples)
- Paginação de 6 itens por página
- Botão “Adicionar ao carrinho” (bloqueado se estoque = 0)
- Estoque é reduzido automaticamente no checkout

### 🛍️ Carrinho
- Listagem de produtos adicionados
- Quantidade editável
- Cálculo de **subtotal**, **desconto** e **total**
- Aplicação de **cupom de desconto**
- Finalização da compra (valida estoque, cupons e salva transação)
- Mensagens visuais de sucesso/erro via sessão

---

## 🎟️ Cupons de Desconto

O sistema possui **cupons configuráveis** com as seguintes propriedades:

| Campo | Tipo | Descrição |
|--------|------|-----------|
| **codigo** | `VARCHAR(50)` | Código que o usuário digita (ex: `PROMO10`, `VALE50`) |
| **tipo** | `ENUM('percentual','valor')` | Tipo do desconto (`percentual` ou `valor` fixo em R$) |
| **valor** | `DECIMAL(10,2)` | Valor do desconto. Ex: 10.00 = 10% ou R$10.00 |
| **validade** | `DATETIME NULL` | Data e hora limite para o uso do cupom |
| **limite_usos** | `INT NULL` | Quantidade máxima de vezes que o cupom pode ser usado (pode ser `NULL` = ilimitado) |
| **usos** | `INT` | Contador automático de quantas vezes o cupom foi utilizado |
| **created_at / updated_at** | `TIMESTAMP` | Campos automáticos do Laravel |

### 🔒 Regras de Validação

1. **Validade:** só é aceito se `validade >= NOW()`.
2. **Limite de usos:** respeita `limite_usos`, incrementando `usos` a cada compra.
3. **Tipo:** `percentual` ou `valor` fixo.
4. **Desconto máximo:** nunca ultrapassa o subtotal.
5. **Cupom único por sessão.**
6. **Validação:** método `estaValidoAgora()` no model `Cupom` garante todas as regras.

### 🧪 Cupons do Seed

| Código | Tipo | Valor | Validade | Limite | Descrição |
|---------|------|--------|-----------|----------|------------|
| `PROMO10` | percentual | 10% | +30 dias | ilimitado | Desconto de 10% |
| `VALE50` | valor | R$50 | +30 dias | ilimitado | Vale de R$50 |
| `DESCONTO15` | percentual | 15% | +45 dias | 100 usos | Campanha promocional |
| `FLASH20` | valor | R$20 | +20 dias | 50 usos | Cupom relâmpago |
| `ESPECIAL25` | percentual | 25% | +7 dias | 10 usos | Oferta especial |

---

## 💾 Banco de Dados

**Tabelas:**

### produtos
| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | int | PK |
| nome | varchar(120) | nome do produto |
| preco | decimal(10,2) | preço unitário |
| estoque | int | quantidade disponível |
| timestamps | auto |

### cupons
| Campo | Tipo | Descrição |
|--------|------|-----------|
| id | int | PK |
| codigo | varchar(50) | código único |
| tipo | enum('percentual','valor') | tipo do desconto |
| valor | decimal(10,2) | valor ou percentual |
| validade | datetime | data de expiração |
| limite_usos | int | máximo de usos |
| usos | int | contador atual |
| timestamps | auto |

---

## 🧩 Decisões Técnicas

- Utilizado **Laravel** pela estrutura organizada e suporte a migrations/seeders.  
- Interface construída com **Bootstrap 5** para rapidez e compatibilidade.  
- **Carrinho em sessão**: simples, leve e sem necessidade de login.  
- **Regras de negócio** centralizadas nos Controllers.  
- **Docker Compose** orquestra `nginx`, `php-fpm`, `mysql` e `composer`.  

---

## 🧰 Comandos úteis

```bash
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan tinker
docker compose exec app php artisan route:list
docker compose exec app php artisan optimize:clear
docker compose logs -f web
```

---

## ✅ Checklist (requisitos atendidos)

- [x] PHP 8+  
- [x] MySQL  
- [x] UI com Bootstrap  
- [x] 2 telas: produtos e carrinho  
- [x] Carrinho em sessão  
- [x] Busca e paginação  
- [x] Cupons com validade e limite de usos  
- [x] Migrations + Seeders  
- [x] Mensagens de feedback  
- [x] README completo e detalhado  
- [x] Docker funcional (nginx + php-fpm + mysql)

---

## 👨‍💻 Autor

**Dener Batista**  
📧 denerbatista@icloud.com  
💼 Desenvolvedor PHP / Instrutor Técnico – SENAI / Findes
