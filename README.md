# Trabajo_final_metodologia
### Dificultad: 👹 Medio

El sistema de notas está diseñado para ayudar al usuario a organizar y gestionar información de manera sencilla y eficiente. A continuación, se describen las principales funcionalidades que ofrece la aplicación:

practica 123

El usuario puede crear nuevas notas para registrar información importante, ideas, recordatorios o apuntes que desee conservar.


El usuario tiene la posibilidad de editar notas existentes, lo que le permite actualizar su contenido cuando la información cambia o necesita ser corregida.


El sistema permite eliminar notas, ayudando al usuario a mantener su espacio de trabajo ordenado y libre de información innecesaria.


Cada nota puede contar con etiquetas o categorías, facilitando la organización y el agrupamiento de notas por temas específicos.


El usuario puede visualizar un listado de todas sus notas, donde se muestra el título y la fecha de creación o última modificación, brindando una vista general del contenido almacenado.


El sistema ofrece una búsqueda por palabras clave en el título de las notas, permitiendo encontrar rápidamente una nota específica sin necesidad de revisar toda la lista.

#### Funcionalidades adicionales 

## Autenticación de usuarios

Inicio de sesión con usuario y contraseña. 
Cada usuario ve solo sus propias notas.

## Notas archivadas

Posibilidad de archivar notas en lugar de eliminarlas definitivamente.
Ayuda a conservar información sin que aparezca en la vista principal.

## Ordenamiento de notas

Ordenar por:
            Fecha de creación, Última modificación,  Título (A–Z / Z–A)

## Búsqueda avanzada

Búsqueda por: 
            Título, Contenido de la nota, Etiquetas o categorías

## Notas destacadas

Marcar una nota como “importante” o “favorita”.
Sección especial para notas destacadas.

## Fechas y recordatorios

Asignar una fecha límite o recordatorio a una nota.
Útil para tareas o pendientes.

## Aspectos técnicos

## Persistencia de datos

Uso de una base de datos Mariadb.

## Tablas sugeridas:

Usuarios
Notas
Categorías o etiquetas
se puede ampliar mas 

## Modelo CRUD

Create (crear nota)
Read (ver notas)
Update (editar nota)
Delete (eliminar nota)

## Validaciones

El título no puede estar vacío.
Longitud máxima del contenido.
Confirmación antes de eliminar una nota.

##### Requerimientos del sistema
 
## Requerimientos funcionales

El sistema permitirá crear, editar, eliminar y visualizar notas.
El sistema permitirá buscar notas por palabras clave en el título.
El sistema permitirá asignar etiquetas a las notas.

## Requerimientos no funcionales

El sistema debe ser fácil de usar.
El tiempo de respuesta debe ser menor a X segundos.
La información debe almacenarse de forma segura.

## cierre del trabajo

En conclusión, el sistema de notas propuesto brinda una solución sencilla y eficiente para la gestión de información personal, incorporando funcionalidades básicas y escalables, lo cual permite futuras mejoras según las necesidades del usuario.