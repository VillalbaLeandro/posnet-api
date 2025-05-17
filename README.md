# POSNET PHP Challenge – Devactiva

Este proyecto es una implementación orientada a objetos de una API de POSNET que permite:

- Registrar tarjetas de crédito válidas (VISA o AMEX).
- Procesar pagos con recargos por cuotas.
- Validar límite de tarjeta disponible.
- Generar un ticket detallado con los datos del cliente y pago.

---

## 📁 Estructura del proyecto

```plaintext
posnet-api/
├── classes/
│   ├── Client.php         # Datos del titular de la tarjeta
│   ├── Card.php           # Representación y validación de tarjeta
│   ├── Posnet.php         # Lógica principal de registro y pago
│   ├── Ticket.php         # Representación del resultado de un pago exitoso
├── data/
│   └── cards.json         # Base de datos simulada en JSON
├── test.php               # Script para probar funcionamiento completo
├── README.md
```
---

## 🚀 Instalación y ejecución

Cloná el repositorio:

```bash
git clone https://github.com/tu-usuario/posnet-php-challenge.git
cd posnet-api
```

Asegurate de tener PHP 7.4 o superior instalado.

Ejecutá el script de prueba:
```bash
php test.php
```

## 📦 Lógica de negocio

### Registro de tarjetas
- Solo VISA y AMEX.
- Número de tarjeta de 8 dígitos.
- Almacena datos en `data/cards.json`.


### Proceso de pago
1. Recibe número de tarjeta, monto y cuotas (1–6).
2. Aplica recargo de 3 % por cada cuota extra.
3. Valida que el límite sea suficiente.
4. Si es exitoso:
   - Resta el monto al límite.
   - Genera un ticket con cliente, total y monto por cuota.

---

## 🧪 Test Unitario
- Pago con tarjeta inexistente.
- Cuotas inválidas.
- Límite insuficiente.
- Tipo de tarjeta inválido.

---

## 🧠 Autor
**Leandro Villalba**  
Desarrollador Fullstack

- [LinkedIn](https://www.linkedin.com/in/leandro-villalba/)
- [GitHub](https://github.com/VillalbaLeandro)

---

## ✔️ Estado del proyecto
- ✅ Funcional
- ✅ Validado
- ✅ Robusto
- ✅ Escalable

