# Projecte 3

Este proyecto es un proyecto

## Preparar repositorio

### Preparando la clave SSH

Debes poner esto en un cmd

```ssh-keygen -t rsa -b 4096 -C "tu@correo.aqui"```

Posteriormente abre un editor de texto para copiar el contenido de

```C:\Users\Usuari\.ssh\id_rsa.pub```

Esta llave debes meterla en tu perfil de [GitHub](https://github.com/settings/ssh/new), en tu perfil, settings, SSH keys and GPG keys y finalmente a new SSH Key.

Como nombre pondrás el que quieras, algo que sa descriptivo, y en Key, pones el contenido del archivo anterior

### Iniciar repositorio

Para empezar a usar Git, necesitas poner los siguientes comandos

```git config --gloal user.email "tu@correo.aqui"```

```git config --gloal user.name "Tu nomrbe"```

Y para empezar con el repositorio solamente hay que poner el siguiente comando en la carpeta deseada

```git clone git@github.com:ngarrido777/Projecte3.git```

## Preparación del entorno

### Instalar extensión de GitHub
En el VisualStudio de los ordenadores de clase, instala la extensión ````GitHub Pull Requests```.
Abre el directorio del repositorio clonado con el VSCode.

### Funcionamiento de la Extensión
Aparece un nuevo icono en el menú de la izquierda, ahí se mustran los cambios y tienes que añadirlos.
Una ves añadidos todos los cambios, clic en commit, aparecerá un fichero de texto donde debes poner el texto del commit.
Arriba a la derecha hay un tic para guardar el commit. Posteriormente sale Sync Changes, que es basicamente un Push.