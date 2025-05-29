
# 🛠️ Sistema de Gestión de Citas

Este es un sistema web para la gestión de citas entre clientes y técnicos con especialidades, desarrollado con **CodeIgniter 4** como backend, **Bootstrap 5** en frontend y contenedores **Docker** para despliegue.

---

## 📦 Tecnologías utilizadas

- PHP 8.1+
- CodeIgniter 4.x
- MySQL 8.x
- Docker + Docker Compose
- Bootstrap 5
- WhatsApp Web.js (para funcionalidad futura de recordatorios)
- JQuery

---

## 🚀 Instalación y ejecución

### 🔧 Requisitos previos

- Docker y Docker Compose instalados
- Git instalado

### 📥 Clonar el repositorio

```bash
git clone https://github.com/tu_usuario/gestion-citas.git
cd gestion-citas
```

### ▶️ Levantar el entorno

```bash
docker compose up -d --build
```

Esto iniciará:

- Backend en: `http://localhost:8090`
- Base de datos MySQL en el puerto `3307`
- phpMyAdmin en: `http://localhost:8081`

### ⚙️ Variables de entorno

Editar el archivo `.env` dentro del contenedor o en `app/Config/Database.php` para conexión MySQL:

```php
public $default = [
    'hostname' => 'mysql',
    'username' => 'root',
    'password' => 'secret',
    'database' => 'gestion_citas',
    'DBDriver' => 'MySQLi',
    ...
];
```

---

## 🧱 Estructura del Proyecto

```
gestion-citas/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Filters/
│   ├── Config/
│   └── Helpers/
├── public/
├── writable/
├── docker-compose.yml
├── Dockerfile
├── .env
└── README.md
```

---

## 👤 Roles del sistema

- **Administrador:** Gestiona usuarios, técnicos, especialidades y visualiza todas las citas.
- **Técnico:** Visualiza y marca como completadas las citas asignadas del día.
- **Cliente:** Solicita citas según disponibilidad.

---

## 📚 Casos de Uso (Historias de Usuario)

- HU-01 – Registro y Login de Usuario
- HU-02 - CRUD Roles de sistema
- HU-03 - Alta de Técnicos con especialidad
- HU-04 - Solicitar cita (calendario + slot)
- HU-05 - Ver citas del día (Técnico)
- HU-06 - Enviar confirmaciones / recordatorios

---

## 🧰 Comandos útiles

### Ver logs de la aplicación:

```bash
docker logs -f <nombre_contenedor_app>
```

### Acceder a la base de datos MySQL:

```bash
docker exec -it <contenedor_mysql> mysql -uroot -p
```

---

## ✅ Checklist de funcionalidades

- [x] Login y sesión por roles
- [x] Panel administrativo completo
- [x] Vista de citas por técnico
- [x] Evitar solapamiento de citas (cliente y técnico)
- [x] Validaciones de fecha y hora futuras
- [x] CRUD de técnicos, usuarios y servicios
- [ ] Notificaciones vía WhatsApp (en proceso)


---

## 📜 Licencia

Este proyecto está bajo la licencia MIT.
