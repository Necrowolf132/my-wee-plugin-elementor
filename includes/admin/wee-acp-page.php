<?php

    $traer_my_extencion = My_elementor_extencion\wee_Elementor_my_Extencion::instance();
    if($traer_my_extencion::$estado=='ok'){
?> 

<div class="wrap">
 <h1>Hello!</h1>
 <p>This is my plugin's first page</p>
</div>

<?php
    } elseif($traer_my_extencion::$estado==1) {
?>

<div class="wrap">
 <h1>Hello!</h1>
 <p>EL plugins no se puede inicializar correctamente debido a que Elementor no se alla instalado</p>
</div>

<?php
    } elseif($traer_my_extencion::$estado==2) {
?>

<div class="wrap">
 <h1>Hello!</h1>
 <p>EL plugins no se puede inicializar correctamente debido a que la version actual de Elementor es muy antigua, actualice a la ultima version</p>
</div>

<?php
    } elseif($traer_my_extencion::$estado==3) {
?>

<div class="wrap">
 <h1>Hello!</h1>
 <p>EL plugins no se puede inicializar correctamente debido a que la version actual de PHP es muy antigua, actualice a la ultima version</p>
</div>

<?php
    }
?>