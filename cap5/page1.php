<?php
include_once 'app.widgets/TElement.class.php';
include_once 'app.widgets/TPage.class.php';

function ola_mundo($param)
{
    echo 'Ol� meu amigo ' . $param['nome'];
}

$pagina = new TPage;
$pagina->show();
?>