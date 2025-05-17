# POSNET PHP Challenge – Devactiva

Este proyecto es una implementación orientada a objetos de una API de POSNET que permite:

* Registrar tarjetas de crédito válidas (VISA o AMEX).
* Procesar pagos con recargos por cuotas.
* Validar límite de tarjeta disponible.
* Generar un ticket detallado con los datos del cliente y pago.
* Utilizar almacenamiento desacoplado: en archivo JSON o base de datos MySQL.

---

## 📁 Estructura del proyecto

```
posnet-api/
├── classes/
│   ├── Card.php                  # Representación y validación de tarjeta
│   ├── Client.php                # Datos del titular de la tarjeta
│   ├── Ticket.php                # Representación del resultado del pago
│   ├── Posnet.php                # Lógica principal de registro y pago (usa storage inyectado)
│   ├── CardStorageInterface.php  # Interfaz que define el contrato de almacenamiento
│   ├── JsonCardStorage.php       # Implementación que almacena tarjetas en JSON
│   └── MySQLCardStorage.php      # Implementación alternativa que usa base de datos
├── data/
│   ├── cards.json                # Base simulada si se usa JSON
│   └── schema.sql                # Script para crear tabla MySQL
├── db/
│   └── Connection.php            # Clase singleton para conexión PDO
├── test.php                      # Script de prueba completo con casos de éxito y error
├── .gitignore
├── .gitattributes
└── README.md
```

---

## 🚀 Instalación y ejecución

1. Cloná el repositorio:

```bash
git clone https://github.com/tu-usuario/posnet-php-challenge.git
cd posnet-api
```

2. Asegurate de tener **PHP 7.4 o superior** instalado.

3. Ejecutá el script:

```bash
php test.php
```

---

## 📦 Lógica de negocio

### Registro de tarjeta:

* Solo se aceptan tarjetas tipo **VISA** o **AMEX**.
* El número debe ser exactamente de **8 dígitos**.
* Se valida y guarda en el almacenamiento activo (JSON o DB).

### Proceso de pago:

* Recibe número de tarjeta, monto y cantidad de cuotas (1 a 6).
* Si hay más de una cuota, aplica **3 % por cada cuota adicional**.
* Verifica que la tarjeta tenga **límite suficiente**.
* Si es exitoso:

  * Se descuenta el total.
  * Se genera un **ticket** con nombre del cliente, total y monto por cuota.

---

## 🔁 Almacenamiento desacoplado (switch JSON / MySQL)

El sistema permite usar dos modos de almacenamiento:

### Por defecto:

```php
$storage = new JsonCardStorage();
```

### Para usar base de datos MySQL:

```php
$pdo = Connection::getInstance();
$storage = new MySQLCardStorage($pdo);
```

La clase `Posnet` no depende de dónde se almacenen las tarjetas. Esto permite escalar el sistema sin tocar la lógica principal.

---

## 📊 Base de datos

Si elegís usar MySQL, podés ejecutar el script en `data/schema.sql`:

```sql
CREATE TABLE cards (
  number CHAR(8) PRIMARY KEY,
  type VARCHAR(10) NOT NULL,
  bank VARCHAR(50) NOT NULL,
  limit_amount FLOAT NOT NULL,
  dni VARCHAR(20) NOT NULL,
  name VARCHAR(100) NOT NULL
);
```

Configurable en `db/Connection.php`:

```php
new PDO('mysql:host=localhost;dbname=posnet;charset=utf8', 'usuario', 'clave');
```

---

## 🧪 Casos cubiertos en `test.php`

* ✅ Registro exitoso
* ✅ Pago exitoso con recargo (cuotas > 1)
* ✅ Pago exitoso sin recargo (1 cuota)
* ❌ Tipo de tarjeta inválido
* ❌ Número de tarjeta inválido
* ❌ Cuotas fuera de rango
* ❌ Límite insuficiente
* ❌ Tarjeta no registrada

---

## 💡 Posibles mejoras futuras

Aunque por tiempo estas funcionalidades no fueron implementadas, el sistema está estructurado para escalar. Algunas ideas de mejora:

* Validación real del número de tarjeta con el **algoritmo de Luhn**.
* Integración con una API externa que valide el tipo de tarjeta según su BIN.
* Registro de transacciones exitosas con timestamp en una tabla/archivo adicional.
* Implementación de tests unitarios automatizados con PHPUnit.
* Autenticación básica y endpoints REST con Slim u otro microframework.
* Web UI mínima para probar visualmente el sistema.

---

## 🧠 Autor

**Leandro Villalba**
Desarrollador Fullstack

* [LinkedIn](https://www.linkedin.com/in/leandro-villalba/)
* [GitHub](https://github.com/VillalbaLeandro)

---

## ✔️ Estado del proyecto

* ✅ Funcional
* ✅ Validado
* ✅ Robusto
* ✅ Escalable
* ✅ Profesional
* 🧭 Preparado para continuar desarrollando nuevas funcionalidades
