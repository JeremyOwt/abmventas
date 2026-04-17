# ABM Ventas (PHP + MySQL)

Sistema de gestión de clientes, productos, tipos de producto, ventas y usuarios.

## Requisitos

- PHP 8.2+
- Extensión `mysqli`
- MySQL/MariaDB

## Configuración local

1. Crear base de datos `abmventas`.
2. Configurar credenciales en `config.php`.
3. Importar catálogos:
   - `provincias.sql`
   - `localidades.sql`
4. Crear tablas de negocio (`usuarios`, `clientes`, `productos`, `tipo_productos`, `ventas`) según el modelo utilizado por las entidades en `entidades/*.php`.
5. Levantar Apache/PHP apuntando al directorio del proyecto.

## Producción

- Variables soportadas por `config_override.php`:
  - `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASS`, `DB_NAME`
  - `IS_PRODUCTION` (para usar override de conexión)
- Instalador (`instalar.php`) deshabilitado por defecto.
  - Para habilitarlo temporalmente: `ENABLE_INSTALLER=1`.

## Seguridad básica implementada

- Token CSRF para formularios y cierre de sesión.
- Validación de sesión en páginas internas (vía `header.php`).
- Regeneración de sesión al login.

## Notas

- `register.html` y `forgot-password.html` son plantillas visuales; no implementan lógica backend.
