<?php
// inclui as classes necess�rias
include_once 'app.widgets/TElement.class.php';
include_once 'app.widgets/TParagraph.class.php';

// instancia objeto par�grafo
$texto1= new TParagraph('teste1<br>teste1<br>teste1');
$texto1->setAlign('left');

// exibe objeto
$texto1->show();

// instancia objeto par�grafo
$texto2= new TParagraph('teste2<br>teste2<br>teste2');
$texto2->setAlign('right');

// exibe objeto
$texto2->show();
?>