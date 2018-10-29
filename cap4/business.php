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
    
    /*
     * m�todo Inscrever
     * cria uma inscri��o para este aluno
     * @param $turma = n�mero da turma
     */
    function Inscrever($turma)
    {
        // instancia uma inscri��o
        $inscricao = new Inscricao;
        
        // define algumas propriedades
        $inscricao->ref_aluno = $this->id;
        $inscricao->ref_turma = $turma;
        
        // persiste a inscri��o
        $inscricao->store();
    }
}

/*
 * classe Inscricao, filha de TRecord
 * persiste uma Inscricao no banco de dados
 */
class Inscricao extends TRecord
{
    const TABLENAME = 'inscricao';
}

// insere novos objetos no banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log12.txt'));
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo o aluno \$carlos");
    
    // instancia um aluno novo
    $carlos= new Aluno;
    $carlos->nome     = "Carlos Ranzi";
    $carlos->endereco = "Rua Francisco Oscar";
    $carlos->telefone = "(51) 1234-5678";
    $carlos->cidade   = "Lajeado";
    
    // persiste o objeto aluno
    $carlos->store();
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inscrevendo o aluno nas turmas");
    
    // executa o m�todo Inscrever (na turma 1 e 2)
    $carlos->Inscrever(1);
    $carlos->Inscrever(2);
    
    // finaliza a transa��o
    TTransaction::close();
}

catch (Exception $e) // em caso de exce��o
{
    // exibe a mensagem gerada pela exce��o
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas altera��es no banco de dados
    TTransaction::rollback();
}
?>