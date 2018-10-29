<?php
/*
 * fun��o __autoload()
 * Carrega uma classe quando ela � necess�ria,
 * ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
}

try
{
    // abre uma transa��o
    TTransaction::open('pg_livro');
    
    // define a estrat�gia de LOG
    TTransaction::setLogger(new TLoggerHTML('/tmp/arquivo.html'));
    
    // escreve mensagem de LOG
    TTransaction::log("Inserindo registro William Wallace");
    
    // cria uma instru��o de INSERT
    $sql = new TSqlInsert;
    
    // define o nome da entidade
    $sql->setEntity('famosos');
    
    // atribui o valor de cada coluna
    $sql->setRowData('codigo', 9);
    $sql->setRowData('nome', 'William Wallace');
    
    // obt�m a conex�o ativa
    $conn = TTransaction::get();
    
    // executa a instru��o SQL
    $result = $conn->Query($sql->getInstruction());
    
    // escreve mensagem de LOG
    TTransaction::log($sql->getInstruction());
    
    // define a estrat�gia de LOG
    TTransaction::setLogger(new TLoggerXML('/tmp/arquivo.xml'));
    
    // escreve mensagem de LOG
    TTransaction::log("Inserindo registro Albert Einstein");
    
    // cria uma instru��o de INSERT
    $sql = new TSqlInsert;
    
    // define o nome da entidade
    $sql->setEntity('famosos');
    
    // atribui o valor de cada coluna
    $sql->setRowData('codigo', 10);
    $sql->setRowData('nome', 'Albert Einstein');
    
    // obt�m a conex�o ativa
    $conn = TTransaction::get();
    
    // executa a instru��o SQL
    $result = $conn->Query($sql->getInstruction());
    
    // escreve mensagem de LOG
    TTransaction::log($sql->getInstruction());
    
    // fecha a transa��o, aplicando todas as opera��es
    TTransaction::close();
}
catch (Exception $e)
{
    // exibe a mensagem de erro
    echo $e->getMessage();
    // desfaz opera��es realizadas durante a transa��o
    TTransaction::rollback();
}
?>