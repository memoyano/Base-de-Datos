# Sistema CRUD de Ventas - PHP y MySQL

Este proyecto es una aplicación web desarrollada en PHP que permite gestionar un sistema de ventas. Incluye la administración de vendedores, productos y el registro de ventas. Utiliza MySQL como base de datos y Bootstrap para mejorar la interfaz.

## 📌 Funcionalidades

- Gestión de **vendedores** (crear, editar, eliminar, listar)
- Gestión de **productos**
- Registro de **ventas**, cálculo automático del total
- Dashboard visual para acceder a los tres módulos

## ⚙️ Tecnologías utilizadas

- PHP 8+
- MySQL 
- HTML
- XAMPP (entorno local)

## 🛠️ Instalación y uso

1. **Clona o descarga** este repositorio:
   ```bash
   git clone https://github.com/memoyano/Base-de-Datos.git
   ```

2. **Importa la base de datos** en `phpMyAdmin`:
   - Crear una base de datos llamada `ventas`
   - Importar el archivo `base_de_datos.sql` incluido en el proyecto

3. **Configura el entorno local:**
   - Coloca el proyecto en la carpeta `htdocs` de XAMPP
   - Asegúrate de que el archivo `conexion.php` esté apuntando a `localhost`, usuario `root` sin contraseña

4. **Ejecuta el sistema:**
   - Abre en el navegador:  
     `http://localhost/crud_ventas/dashboard.php`

## 🧑‍💻 Autor

Proyecto desarrollado por Kevin Jiménez  

## 🗃️ Estructura del Proyecto

```
crud_ventas/
├── conexion.php
├── base_de_datos.sql
├── dashboard.php
├── crud_vendedores/
├── crud_productos/
├── crud_ventas/
└── README.md
```