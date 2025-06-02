# ¡Buenas, bienvenidos a mi proyecto XHOSTING!

- Como he mencionado anteriormente este se trata de un proyecto escolar en el cual realizo una simulación de empresa de que se dedica al Hosting de máquinas virtuales para que los clientes puedan utilizarlas con los servicios deseados
- Este proyecto cuenta con una página web, la cual és funcional y está formada mediante:
    - HTML  <img src="https://upload.wikimedia.org/wikipedia/commons/6/61/HTML5_logo_and_wordmark.svg" alt="HTML5 Logo" width="20"/>
    - CSS   <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/CSS3_logo_and_wordmark.svg" alt="CSS Logo" width="15"/>
    - PHP   <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP Logo" width="30"/>
    - JS   <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png" alt="JS Logo" width="15"/>

- La página contiene un sistema de Login funcional que ingresa los datos en la Base de Datos del servidor principal el cual hace uso de MySQL.
  <br>
  <img src="/img/Crear_maquinas.png" alt="HTML5" width="150"/>
- También contiene un apartado el cual sirve para comprar las máquinas y es el apartado realizado con JS, también ingresa los valores en la BD.
  IMAGEN
- Y un apartado para encender / apagar / reiniciar las máquinas de los clientes. Para que lleven su propia gestión.
  IMAGEN


# Conexión a las máquinas clientes

- Los clientes una vez tienen las máquinas, para conectarse disponen de dos metodos para conectarse:
      - Linux: SSH
      - Windows: RDP o SSH

# Redirecciones

- En mi caso el proyecto se ha realizado en mi PC el cual hacia de Servidor usando una VM de Linux mediante VirtualBox, dentro de el se alojan los dos clientes también con VirtualBox, 1 Windows - 1 Linux
- Por la razón de estar el servidor en una VM y los clientes otra VM dentro de ella no podían salir a internet con normalidad, ya que no se les llegaba a asignar una IP del router debido a la virtualización.
- Por ello los clientes salian a internet mediante el servidor principal pero a ellos no podían llegar directamente, usamos una red interna creada para poder comunicar los clientes con el servidor.
- Una vez la red interna creada haciendo uso de Reverse Proxy con el servico Nginx se pudo llegar a hacer que las páginas web de los clientes saliesen al exterior.
- Para la conexión por SSH o RDP usamos redireccionamiento de puertos atraves del servidor principal, el cual movia todo el tráfico para llegar al destino final.
- EN EL DOCUMENTO <a href="https://github.com/ikerth05/Hosting-VM/blob/main/Copia%20de%20Esquema-Infraestructura.pptx.pdf">ESQUEMA</a> SE PUEDE OBSERVAR DE FORMA GRÁFICA PARA MEJOR EXPLICACIÓN.

# ZABBIX

# También contiene una parte de documentos de legislación la cual no está subida al repositorio

