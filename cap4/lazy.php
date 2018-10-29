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
 * classe Inscricao, filha de TRecord
 * persiste uma Inscricao no banco de dados
 */
class Inscricao extends TRecord
{
    const TABLENAME = 'inscricao';
    
    /*
     * m�todo get_aluno()
     * executado sempre se for acessada a propriedade "aluno"
     */
    function get_aluno()
    {
        // instancia Aluno, carrega
        // na mem�ria o aluno de c�digo $this->ref_aluno
        $aluno = new Aluno($this->ref_aluno);
        
        // retorna o objeto instanciado
        return $aluno;
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
     * m�todo get_inscricoes()
     * executado sempre se for acessada a propriedade "inscricoes"
     */
    function get_inscricoes()
    {
        // cria um crit�rio de sele��o
        $criteria = new TCriteria;
        
        // filtra por codigo do aluno
        $criteria->add(new TFilter('ref_aluno', '=', $this->id));
        
        // instancia reposit�rio de Inscri��es
        $repository = new TRepository('Inscricao');
        
        // retorna todas inscri��es que satisfazem o crit�rio
        return $repository->load($criteria);
    }
}

try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log11.txt'));
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** obtendo o aluno de uma inscri��o");
    
    // instancia a Inscri��o cujo ID � "2"
    $inscricao = new Inscricao(2);
    
    // exibe os dados relacionados de aluno (associa��o)
    echo "Dados da inscri��o<br>\n";
    echo "==================<br>\n";
    echo 'Nome     : ' . $inscricao->aluno->nome     . "<br>\n";
    echo 'Endere�o : ' . $inscricao->aluno->endereco . "<br>\n";
    echo 'Cidade   : ' . $inscricao->aluno->cidade   . "<br>\n";
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** obtendo as inscri��es de um aluno");
    
    // instancia o Aluno cujo ID � "2"
    $aluno = new Aluno(2);
    
    echo "<br>\n";
    echo "Inscri��es do Aluno<br>\n";
    echo "===================<br>\n";
    
    // exibe os dados relacionados de inscri��es (agrega��o)
    foreach ($aluno->inscricoes as $inscricao)
    {
        echo ' ID    : ' . $inscricao->id;
        echo ' Turma : ' . $inscricao->ref_turma;
        echo ' Nota : ' . $inscricao->nota;
        echo ' Freq. : ' . $inscricao->frequencia;
        echo "<br>\n";
    }
    
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