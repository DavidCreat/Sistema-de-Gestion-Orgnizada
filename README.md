### SISTEMA DE GESTIÓN ORGANIZADA (S.G.O)

---

#### Descripción del Proyecto

Este proyecto, denominado **SGO (Sistema de Gestión de Tareas)**, es una aplicación web diseñada para gestionar tareas y proyectos dentro de una organización. Permite a los usuarios administrar las tareas asignadas, interactuar con otros miembros del equipo, generar informes y más.

---

#### Implementación del Proyecto

##### Prerrequisitos

Para implementar este proyecto en tu entorno local, asegúrate de tener instalado lo siguiente:

- Servidor web (por ejemplo, Apache, Nginx)
- PHP versión 7.4 o superior
- MariaDB o MySQL como sistema de gestión de base de datos
- Composer (para la gestión de dependencias de PHP)

##### Pasos para la Implementación

1. **Clonar el Repositorio:**

git clone https://github.com/DavidCreat/Sistema-de-Gestion-Orgnizada.git
cd Sistema-de-Gestion-Orgnizada


2. **Configurar la Base de Datos:**

- Importa la estructura de la base de datos y los datos desde el archivo SQL proporcionado (`task_management_sgo.sql`).

3. **Configurar la Conexión a la Base de Datos:**

- Encuentra el archivo de conexión a la base de datos, generalmente ubicado en `recursos/funcionalidad/php/db_connection.php`.
- Modifica las credenciales de conexión (`$servername`, `$username`, `$password`, `$dbname`) según tu configuración local.

4. **Instalar Dependencias de PHP:**

- Ejecuta el siguiente comando para instalar las dependencias necesarias de PHP (si las hay):

  ```
  composer install
  ```

5. **Configurar el Servidor Web:**

- Configura tu servidor web para que apunte la raíz del documento al directorio donde clonaste el repositorio (`sgo/public` o similar).
- Asegúrate de que el servidor web tenga los permisos adecuados para acceder y ejecutar archivos en ese directorio.

6. **Acceder a la Aplicación:**

- Abre tu navegador web y accede a la URL local configurada para el proyecto.

7. **Inicio de Sesión:**

- Utiliza las credenciales proporcionadas o crea una nueva cuenta según sea necesario para acceder al sistema.

---

#### Licencia

Este proyecto está bajo la **Licencia Creative Commons Atribución-NoComercial-CompartirIgual 4.0 Internacional**. Esto significa:

- **Atribución:** Debes dar el crédito correspondiente, proporcionar un enlace a la licencia e indicar si se han realizado cambios. Puedes hacerlo de cualquier manera razonable, pero no de una manera que sugiera que el licenciante te respalda a ti o al uso que haces del trabajo.

- **NoComercial:** No puedes utilizar el material con fines comerciales.

- **CompartirIgual:** Si remezclas, transformas o creas a partir del material, debes distribuir tus contribuciones bajo la misma licencia que el original.

---

#### Contribuciones y Problemas

- Si encuentras problemas con el proyecto o deseas contribuir, por favor abre un issue o envía un pull request en GitHub.

- ¡Tus contribuciones son bienvenidas para mejorar este proyecto y hacerlo más útil para la comunidad!

---

#### Contacto

- Para preguntas o más información, contáctanos por [correo electrónico](mailto:david.fonseca12p@gmail.com).

---

#### Autor

- Desarrollado por [DavidCreat](https://github.com/DavidCreat).

---
**VISTA PREVIA**
![6317758](https://github.com/DavidCreat/Sistema-de-Gestion-Orgnizada/assets/80436092/4d8db93b-7fe1-415f-abf2-3a12cbc86f67)
