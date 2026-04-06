# GymApp

Aplicación web para la gestión de un gimnasio: usuarios con distintos perfiles, fichas médicas, ejercicios y rutinas, planes nutricionales, clases grupales, seguimiento de asistencia (calendario y QR), control de peso e IMC, y recomendaciones del entrenador.

**Stack:** Laravel 10, PHP 8.1+, Breeze (autenticación), Sanctum, Spatie Laravel Permission, generación de códigos QR.

---

## Roles

| Rol | Descripción |
|-----|-------------|
| `usuario` | Socio: ficha médica, rutinas asignadas, clases, calendario de asistencia, registro de peso, escaneo QR. |
| `entrenador` | Gestiona ejercicios, rutinas, clases, recomendaciones, planes nutricionales y sesiones QR. |
| `superadmin` | Permisos ampliados (p. ej. recomendaciones junto con entrenador). |

El acceso a rutas sensibles se controla con middleware de rol (`CheckRole`) y, donde aplica, Spatie Permission.

---

## Casos de uso por tabla

Cada sección describe **para qué sirve la tabla** en el dominio del gimnasio y **qué hace el sistema** con esos datos.

### `users`

- Registrar una cuenta nueva y autenticarse (login / logout).
- Almacenar nombre, correo, contraseña y **rol** (`usuario`, `entrenador`, `superadmin`).
- Ser el dueño de fichas médicas, ejercicios, rutinas, planes, inscripciones a clases y registros de peso y asistencia.
- Actuar como **creador** de clases y sesiones QR (entrenador) o como **destinatario** de recomendaciones.

### `password_reset_tokens`

- Permitir el flujo de **recuperación de contraseña** (Laravel): solicitud por email y restablecimiento seguro del acceso.

### `failed_jobs`

- Registrar trabajos en **cola** que fallaron para inspección y reintento (infraestructura Laravel).

### `personal_access_tokens`

- Almacenar **tokens de API** (Laravel Sanctum) si se usan para autenticación stateless o clientes externos.

### `ficha_medicas`

- Registrar datos personales, contacto, grupo sanguíneo, lateralidad e **historial de salud** (lesiones, alergias, enfermedades, actividad previa).
- Vincular la información médica a un usuario concreto; al eliminarse el usuario, se eliminan sus fichas (cascade).

### `ejercicios`

- Definir ejercicios con nombre, descripción, **nivel de dificultad**, grupo muscular, series, repeticiones, calorías aproximadas, duración y multimedia (foto/video).
- Asociar cada ejercicio al usuario (típicamente quien lo crea o a quien se asigna según la lógica de negocio).
- Componer rutinas vía la tabla pivote y referenciar asistencias puntuales.

### `rutinas`

- Crear **planes de entrenamiento** con nombre, descripción, días de la semana (JSON), fechas e intervalos horarios, estado, objetivo e intensidad.
- Llevar notas y fechas de inicio/fin para seguimiento del programa.

### `ejercicio_rutina` (pivote)

- **Incluir** varios ejercicios en una misma rutina y reutilizar un ejercicio en varias rutinas.
- Mantener el orden lógico de la rutina según la aplicación (relación muchos a muchos).

### `clases`

- Programar **clases grupales**: título, descripción, objetivos, fecha, hora, nivel, cupo máximo e imagen.
- Activar o desactivar la clase (`is_active`) y asociarla al entrenador que la crea (`user_id`).

### `clase_user` (pivote)

- **Inscribir** a un socio en una clase y **dar de baja** la inscripción sin duplicar la misma pareja clase–usuario.

### `plan_nutricionals`

- Definir **planes nutricionales** por usuario: nombre, descripción, calorías diarias y texto de recomendaciones.

### `recomendacions`

- Que un entrenador o administrador deje **mensajes o indicaciones** a un socio (`user_id`), con registro de quién las creó (`creado_por`) y la fecha.

### `asistencias`

- Registrar **un día de asistencia** por usuario (único por `user_id` + `fecha`).
- Opcionalmente vincular la asistencia a una **rutina** y/o un **ejercicio** concreto para trazabilidad en el calendario.

### `entradas_peso`

- Registrar **peso actual**, peso ideal opcional, altura, **IMC calculado**, clasificación (`estado_peso`) y fecha del control.
- Permitir seguimiento evolutivo del peso y composición corporal del socio.

### `qr_code_sessions`

- Que el entrenador cree una **sesión de asistencia** con nombre, actividad, código QR único e imagen generada.
- Activar o desactivar la sesión y restringir la administración a rol entrenador.

### `qr_scans`

- Registrar que un **usuario escaneó** (o ingresó) un código válido: sesión asociada, carrera/dato adicional y fecha.
- Completar el flujo de asistencia presencial sin depender solo del calendario manual.

### `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions` (Spatie)

- Gestionar **permisos y roles** a nivel de paquete Spatie: asignar roles a modelos (p. ej. `User`) y permisos granulares o a roles.
- Complementar el campo `role` de `users` cuando la aplicación use `HasRoles` / políticas basadas en permisos.

---

## Requisitos e instalación (resumen)

- PHP ≥ 8.1, Composer, extensiones habituales de Laravel.
- Copiar `.env`, configurar base de datos y ejecutar `php artisan migrate` (y seeders si aplica).
- `php artisan key:generate` y `php artisan serve` para desarrollo.

Consulta la [documentación oficial de Laravel](https://laravel.com/docs) para detalles de despliegue y entorno.

## Licencia

Este proyecto utiliza el framework Laravel, publicado bajo la [licencia MIT](https://opensource.org/licenses/MIT).
