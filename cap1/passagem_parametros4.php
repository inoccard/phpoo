<?php
function Ola()
{
    $argumentos = func_get_args();
    $quantidade = func_num_args();
    for($n=0; $n<$quantidade; $n++)
    {
        echo 'Ol� ' . $argumentos[$n] . "<br>\n";
    }
}
Ola('Jo�o', 'Maria', 'Jos�', 'Pedro');
?>