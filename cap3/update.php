<?php
/*
 * fun��o __autoload()
 * Carrega uma classe quando ela � necess�ria, ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
}

// cria crit�rio de sele��o de dados
$criteria = new TCriteria;
$criteria->add(new TFilter('id', '=', '3'));

// cria instru��o de UPDATE
$sql = new TSqlUpdate;

// define a entidade
$sql->setEntity('aluno');

// atribui o valor de cada coluna
$sql->setRowData('nome',     'Pedro Cardoso da Silva');
$sql->setRowData('rua',      'Machado de Assis');
$sql->setRowData('fone',     '(88) 5555');

// define o crit�rio de sele��o de dados
$sql->setCriteria($criteria);

// processa a instru��o SQL
echo $sql->getInstruction();
echo "<br>\n";
?>