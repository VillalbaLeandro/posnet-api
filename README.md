# POSNET PHP Challenge – Devactiva

Este proyecto es una implementación orientada a objetos de una API POSNET que permite:

* Registrar tarjetas de crédito válidas (VISA o AMEX).
* Procesar pagos con recargos por cuotas.
* Validar límite de tarjeta disponible.
* Generar un ticket con los datos del cliente y el pago.
* Usar almacenamiento desacoplado: archivo JSON o base de datos MySQL.

---

## 📁 Estructura del proyecto

```
posnet-api/
├── classes/                   # Lógica de negocio y modelos
├── data/                      # Almacenamiento en JSON y SQL schema
├── db/                        # Conexion PDO a MySQL
├── api/                       # Endpoints HTTP (API REST)
├── test.php                   # Tests en consola
```

---

## 🚀 Instalación y ejecución local

Requiere PHP 7.4 o superior.

1. Cloná el repo:

```bash
git clone https://github.com/TU_USUARIO/posnet-php-challenge.git
cd posnet-api
```

2. Ejecutá servidor local:

```bash
php -S localhost:8000
```

3. Accedé a los endpoints desde Postman o `curl`:

---

## 📂 Endpoints disponibles

### ➕ `POST /api/index.php?action=register`

Registra una tarjeta.

**Body JSON:**

```json
{
  "type": "VISA",
  "bank": "Banco Nación",
  "number": "12345678",
  "limit": 50000,
  "dni": "12345678",
  "first_name": "Leandro",
  "last_name": "Villalba"
}
```

**Respuesta:**

```json
{
  "message": "Card registered successfully"
}
```

---

### 💳 `POST /api/index.php?action=pay`

Procesa un pago con una tarjeta ya registrada.

**Body JSON:**

```json
{
  "number": "12345678",
  "amount": 10000,
  "installments": 3
}
```

**Respuesta:**

```json
{
  "client": "Leandro Villalba",
  "total_amount": 10600.0,
  "installments": 3,
  "installment_amount": 3533.33
}
```

---

## 📊 Almacenamiento desacoplado

La clase `Posnet` funciona con cualquier implementación de `CardStorageInterface`. Se puede usar:

### JSON (por defecto):

```php
$storage = new JsonCardStorage();
```

### MySQL:

```php
$pdo = Connection::getInstance();
$storage = new MySQLCardStorage($pdo);
```

Script SQL: `data/schema.sql`

```sql
CREATE TABLE cards (
  number CHAR(8) PRIMARY KEY,
  type VARCHAR(10),
  bank VARCHAR(50),
  limit_amount FLOAT,
  dni VARCHAR(20),
  name VARCHAR(100)
);
```

---

## 💡 Ideas para mejoras futuras

* Validación de número de tarjeta con algoritmo de Luhn.
* Detectar automáticamente la marca con una API externa (e.g. binlist.net).
* Registro de transacciones con fecha.
* Tests automatizados con PHPUnit.
* Implementación de un microframework (Slim).

---

## 🧐 Autor

**Leandro Villalba**
Desarrollador Fullstack

* [LinkedIn](https://www.linkedin.com/in/leandro-villalba/)
* [GitHub](https://github.com/VillalbaLeandro)

---

## ✔️ Estado del proyecto

* ✅ Funcional
* ✅ API REST
* ✅ Validado
* ✅ Robusto
* ✅ Escalable
