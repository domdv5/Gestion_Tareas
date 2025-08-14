# Sistema de Gestión de Tareas

Sistema completo con React (Frontend) + PHP (Backend) + PostgreSQL.

## 📋 Requisitos

- **Laragon** (recomendado para Windows) o XAMPP
- **Node.js >= 16** ([descargar aquí](https://nodejs.org/))
- **PostgreSQL** (incluido en Laragon)

## 🚀 Instalación Rápida

### 1. Preparar Entorno

1. Instalar y abrir **Laragon**
2. Clic en **"Start All"** (Apache + PostgreSQL)
3. Instalar **Node.js** si no lo tienes

### 2. Configurar Base de Datos

```sql
-- Abrir terminal y ejecutar:
psql -U postgres

-- Crear base de datos:
CREATE DATABASE gestion_tareas;
\c gestion_tareas;

-- Crear tabla:
CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Datos de prueba:
INSERT INTO tasks (title, description) VALUES
('Tarea de ejemplo 1', 'Esta es una tarea de prueba'),
('Tarea de ejemplo 2', 'Esta es otra tarea de prueba');
```

### 3. Configurar Backend

1. **Copiar archivo de configuración:**

```bash
# Copiar el archivo de ejemplo
copy backend\.env.example backend\.env
```

2. **Editar `backend/.env`** con tus credenciales:

```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=gestion_tareas
DB_USERNAME=postgres
DB_PASSWORD=admin  # Tu contraseña de PostgreSQL
```

### 4. Configurar Frontend

```bash
# Ir a la carpeta frontend
cd frontend

# Instalar dependencias
npm install
```

## ▶️ Ejecutar Proyecto

### 1. Backend

- Asegurate que Laragon esté corriendo
- Backend automático en: `http://localhost/Gestion_tareas/backend/public/api/tasks`

### 2. Frontend

```bash
cd frontend
npm run dev
```

- Frontend en: `http://localhost:5173`

## ✅ Verificar

1. Abre `http://localhost:5173`
2. Deberías ver las tareas de ejemplo
3. Prueba crear, editar y eliminar tareas

## 🐛 Si hay Problemas

**Backend no funciona:**

- Verificar que Laragon esté corriendo
- Verificar contraseña en `Database.php`
- Probar la URL directamente: `http://localhost/Gestion_tareas/backend/public/api/tasks`

**Frontend no conecta:**

- Verificar que el backend responda en `/public/api/tasks`
- Verificar que `npm install` se ejecutó correctamente

**Base de datos:**

- Verificar que PostgreSQL esté corriendo en Laragon
- Verificar que la base de datos `gestion_tareas` existe

**Archivo de prueba:**

- Abre `http://localhost/Gestion_tareas/test_api.html` para probar la conexión
