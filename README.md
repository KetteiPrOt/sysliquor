# LiquorStore
El objetivo de este proyecto es crear una solucion.

Que solucion?

Tengo un problema con el inventario del negocio El Licenciado.
Nesecito un programa que me ayude a registrarlo mucho mas rapido para ahorrar tiempo.

Ok cuentame los detalles

Tengo una lista de productos identificados por nombres, algunos en distintas presentaciones.
Estos productos estan fisicamente almacenados en la Bodega del negocio.
La Bodega consiste en un conjunto de perchas con varios pisos cada una donde se almacenan los productos en cajas.

Que deberia hacer el programa?

El programa deberia permitirme hacer un registro de cuantas unidades tenemos almacenadas en la Bodega cada vez que voy a hacer una captura de inventario.
Hago las capturas de inventario semanalmente y lo que obtengo es una lista con todos los productos que hay en la Bodega y su numero de unidades almacenadas.
Esta lista la llamare Estado de Bodega.

>> El programa me deberia permitir guardar Estados de Bodega identificados por una fecha en la que fueron hechos.

>> Un Estado de Bodega debe guardar Registros.
Cada Registro contiene un producto con:
    sus unidades en el deposito (Bodega A),
    sus unidades en la licoreria (Bodega B),
    sus unidades totales (suma de Bodega A + B),
    el numero de unidades Pedidas (opcional),
    sus unidades totales en el anterior Estado de Bodega,
    y las ventas consegidas [und. actuales - (und. anteriores + und pedidas)].


Ok La aplicacion va a tener tres recursos:
    Productos
    Estados de Bodega
    Registros