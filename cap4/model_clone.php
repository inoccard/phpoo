<?php
/*
 * fun��o __autoload()
 * carrega uma classe quando ela � necess�ria,
 * ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.ado/{$classe}.class.php"))
    {
        include_once "app.ado/{$classe}.class.php";
    }
}

/*
 * classe Aluno, filha de TRecord
 * persiste um Aluno no banco de dados
 */
class Aluno extends TRecord
{
    const TABLENAME = 'aluno';
}

/*
 * classe Curso, filha de TRecord
 * persiste um Curso no banco de dados
 */
class Curso extends TRecord
{
    const TABLENAME = 'curso';
}

// instancia objeto Aluno
$fabio = new Aluno;

// define algumas propriedades
$fabio->nome     = 'F�bio Locatelli';
$fabio->endereco = 'Rua Merlin';
$fabio->telefone = '(51) 2222-1111';
$fabio->cidade   = 'Lajeado';

// clona o objeto $fabio
$julia = clone $fabio;

// altera algumas propriedades
$julia->nome     = 'J�lia Haubert';
$julia->telefone = '(51) 2222-2222';
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log4.txt'));
    
    // armazena o objeto $fabio
    TTransaction::log("** persistindo o aluno \$fabio");
    $fabio->store();
    
    // armazena o objeto $julia
    TTransaction::log("** persistindo o aluno \$julia");
    $julia->store();
    
    // finaliza a transa��o
    TTransaction::close();
    echo "clonagem realizada com sucesso <br>\n";
}
catch (Exception $e) // em caso de exce��o
{
    // exibe a mensagem gerada pela exce��o
    echo '<b>Erro</b>' . $e->getMessage();
    
    // desfaz todas altera��es no banco de dados
    TTransaction::rollback();
}
?>