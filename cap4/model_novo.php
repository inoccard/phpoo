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

// insere novos objetos no banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log1.txt'));
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo alunos");
    
    // instancia um novo objeto Aluno
    $daline= new Aluno;
    $daline->nome     = 'Daline Dall Oglio';
    $daline->endereco = 'Rua da Concei��o';
    $daline->telefone = '(51) 1111-2222';
    $daline->cidade   = 'Cruzeiro do Sul';
    $daline->store(); // armazena o objeto
    
    // instancia um novo objeto Aluno
    $william= new Aluno;
    $william->nome     = 'William Scatolla';
    $william->endereco = 'Rua de F�tima';
    $william->telefone = '(51) 1111-4444';
    $william->cidade   = 'Encantado';
    $william->store(); // armazena o objeto
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo cursos");
    
    // instancia um novo objeto Curso
    $curso = new Curso;
    $curso->descricao = 'Orienta��o a Objetos com PHP';
    $curso->duracao   = 24;
    $curso->store(); // armazena o objeto
    
    // instancia um novo objeto Curso
    $curso = new Curso;
    $curso->descricao = 'Desenvolvendo em PHP-GTK';
    $curso->duracao   = 32;
    $curso->store(); // armazena o objeto
    
    // finaliza a transa��o
    TTransaction::close();
    echo "Registros inseridos com Sucesso<br>\n";
}
catch (Exception $e) // em caso de exce��o
{
    // exibe a mensagem gerada pela exce��o
    echo '<b>Erro</b>' . $e->getMessage();
    
    // desfaz todas altera��es no banco de dados
    TTransaction::rollback();
}
?>