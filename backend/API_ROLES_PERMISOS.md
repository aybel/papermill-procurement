# API de Roles y Permisos - Endpoints para Insomnia

Base URL: `http://localhost/api/v1`

## Autenticación

Todos los endpoints requieren autenticación JWT. Incluir header:
```
Authorization: Bearer {token}
```

---

## Endpoints de Permisos

### 1. Listar todos los permisos
```http
GET /permissions
```
**Requiere:** `roles.manage` permission

**Respuesta:**
```json
[
  {
    "id": 1,
    "name": "suppliers.view_any",
    "guard_name": "api"
  },
  ...
]
```

---

## Endpoints de Roles

### 2. Listar todos los roles
```http
GET /roles
```
**Requiere:** `roles.manage` permission

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Super Admin",
      "guard_name": "api",
      "permissions": [...]
    }
  ]
}
```

### 3. Ver un rol específico
```http
GET /roles/{id}
```
**Requiere:** `roles.manage` permission

### 4. Crear un nuevo rol
```http
POST /roles
```
**Requiere:** `roles.manage` permission

**Body:**
```json
{
  "name": "Nuevo Rol",
  "permissions": [
    "suppliers.view_any",
    "suppliers.view"
  ]
}
```

### 5. Actualizar un rol
```http
PUT /roles/{id}
```
**Requiere:** `roles.manage` permission

**Body:**
```json
{
  "name": "Rol Actualizado",
  "permissions": [
    "suppliers.view_any",
    "materials.view_any"
  ]
}
```

### 6. Eliminar un rol
```http
DELETE /roles/{id}
```
**Requiere:** `roles.manage` permission

**Nota:** No se puede eliminar si tiene usuarios asignados

### 7. Asignar múltiples permisos a un rol
```http
POST /roles/{id}/permissions
```
**Requiere:** `roles.manage` permission

**Body:**
```json
{
  "permissions": [
    "suppliers.view_any",
    "suppliers.view",
    "suppliers.create"
  ]
}
```

### 8. Revocar un permiso de un rol
```http
DELETE /roles/{id}/permissions
```
**Requiere:** `roles.manage` permission

**Body:**
```json
{
  "permission": "suppliers.create"
}
```

---

## Endpoints de Usuarios

### 9. Listar usuarios
```http
GET /users
```
**Requiere:** `users.manage` permission

**Query params opcionales:**
- `search` - Buscar por nombre o email
- `department_id` - Filtrar por departamento
- `role` - Filtrar por rol
- `per_page` - Resultados por página (default: 15)

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Carlos Mendoza",
      "email": "carlos.mendoza@company.com",
      "department_id": 3,
      "department": {...},
      "accessible_departments": [...],
      "roles": [...],
      "permissions": [...]
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### 10. Crear un nuevo usuario
```http
POST /users
```
**Requiere:** `users.manage` permission

**Body:**
```json
{
  "name": "Juan Pérez",
  "email": "juan.perez@company.com",
  "password": "password123",
  "department_id": 3,
  "roles": [
    "Jefe de Compras",
    "Aprobador"
  ],
  "accessible_departments": [
    {
      "department_id": 1,
      "role": "viewer"
    },
    {
      "department_id": 2,
      "role": "manager"
    }
  ]
}
```

**Campos:**
- `name` (requerido): Nombre del usuario
- `email` (requerido): Email único
- `password` (requerido): Mínimo 6 caracteres
- `department_id` (requerido): ID del departamento principal
- `roles` (requerido): Array con al menos un rol
- `accessible_departments` (opcional): Array de departamentos con sus roles (viewer, manager, approver)

**Respuesta:**
```json
{
  "message": "Usuario creado exitosamente",
  "data": {
    "id": 10,
    "name": "Juan Pérez",
    "email": "juan.perez@company.com",
    "department_id": 3,
    "department": {...},
    "accessible_departments": [...],
    "roles": ["Jefe de Compras", "Aprobador"],
    "permissions": [...]
  }
}
```

### 11. Ver un usuario específico
```http
GET /users/{id}
```
**Requiere:** `users.manage` permission

### 12. Actualizar un usuario
```http
PUT /users/{id}
```
**Requiere:** `users.manage` permission

**Body:**
```json
{
  "name": "Nombre Actualizado",
  "email": "nuevo@company.com",
  "password": "nuevapassword",
  "department_id": 5
}
```

### 13. Asignar roles a un usuario
```http
POST /users/{id}/roles
```
**Requiere:** `users.manage` permission

**Body:**
```json
{
  "roles": [
    "Jefe de Compras",
    "Aprobador"
  ]
}
```

**Respuesta:**
```json
{
  "message": "Roles asignados exitosamente",
  "data": {
    "user": {...},
    "roles": ["Jefe de Compras", "Aprobador"],
    "permissions": [...]
  }
}
```

### 14. Ver roles de un usuario
```http
GET /users/{id}/roles
```
**Requiere:** `users.manage` permission

**Respuesta:**
```json
{
  "roles": ["Jefe de Compras"],
  "permissions": [
    "suppliers.view_any",
    "suppliers.view",
    ...
  ]
}
```

### 15. Asignar departamentos accesibles a un usuario
```http
POST /users/{id}/departments
```
**Requiere:** `users.manage` permission

**Body:**
```json
{
  "departments": [
    {
      "department_id": 5,
      "role": "manager"
    },
    {
      "department_id": 7,
      "role": "viewer"
    }
  ]
}
```

**Nota:** `role` puede ser: `viewer`, `manager`, `approver`

### 16. Ver departamentos accesibles de un usuario
```http
GET /users/{id}/departments
```
**Requiere:** `users.manage` permission

**Respuesta:**
```json
{
  "department_home": {
    "id": 3,
    "name": "Compras",
    "code": "COMP"
  },
  "accessible_departments": [
    {
      "id": 5,
      "name": "Producción",
      "code": "PROD",
      "pivot": {
        "user_id": 1,
        "department_id": 5,
        "role": "manager"
      }
    }
  ]
}
```

---

## Roles Predefinidos

El sistema tiene los siguientes roles creados automáticamente:

1. **Super Admin** - Todos los permisos
2. **Jefe de Compras** - Gestión completa de compras, proveedores, materiales
3. **Comprador** - Ejecución de órdenes de compra
4. **Jefe de Departamento** - Gestión de su departamento
5. **Empleado** - Solo lectura básica
6. **Aprobador** - Aprobación de solicitudes

---

## Usuarios de Prueba

Después de ejecutar los seeders, tendrás estos usuarios:

1. **Admin Sistema**
   - Email: `admin@example.com`
   - Password: `password`
   - Rol: Super Admin
   - Department ID: 8

2. **Carlos Mendoza** (Jefe de Compras)
   - Email: `carlos.mendoza@company.com`
   - Password: `password`
   - Rol: Jefe de Compras
   - Acceso: Compras (home), Producción y Mantenimiento (manager)

3. **Ana López** (Comprador)
   - Email: `ana.lopez@company.com`
   - Password: `password`
   - Rol: Comprador
   - Acceso: Compras (home), Producción y Mantenimiento (viewer)

4. **Roberto Silva** (Jefe de Producción)
   - Email: `roberto.silva@company.com`
   - Password: `password`
   - Rol: Jefe de Departamento
   - Acceso: Solo Producción (home)

5. **10 usuarios adicionales**
   - Email: `{nombre}.{apellido}@company.com`
   - Password: `pruebas`
   - Departamento: Asignado aleatoriamente

---

## Flujo de Prueba Recomendado

1. **Login como Super Admin**
   ```http
   POST /auth/login
   Body: {"email": "admin@example.com", "password": "password"}
   ```

2. **Listar todos los permisos**
   ```http
   GET /permissions
   ```

3. **Crear un nuevo rol**
   ```http
   POST /roles
   Body: {"name": "Rol Personalizado", "permissions": ["suppliers.view_any"]}
   ```

4. **Listar usuarios**
   ```http
   GET /users
   ```

5. **Asignar rol a un usuario**
   ```http
   POST /users/2/roles
   Body: {"roles": ["Comprador"]}
   ```

6. **Ver permisos del usuario**
   ```http
   GET /users/2/roles
   ```

7. **Asignar departamentos accesibles**
   ```http
   POST /users/2/departments
   Body: {
     "departments": [
       {"department_id": 5, "role": "manager"}
     ]
   }
   ```

---

## Comandos útiles

```bash
# Ejecutar seeders (incluyendo roles y permisos)
docker exec -it papermill-php php artisan db:seed

# Ejecutar solo el seeder de permisos
docker exec -it papermill-php php artisan db:seed --class=PermissionsSeeder

# Ejecutar solo el seeder de usuarios con departamentos
docker exec -it papermill-php php artisan db:seed --class=UserDepartmentSeeder

# Limpiar cache de permisos
docker exec -it papermill-php php artisan permission:cache-reset
```
