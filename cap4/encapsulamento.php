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
 * classe Turma, filha de TRecord
 * persiste uma Turma no banco de dados
 */
class Turma extends TRecord
{
    const TABLENAME = 'turma';
    
    /*
     * m�todo set_dia_semana()
     * executado sempre que h� uma atribui��o para "dia_semana"
     * @param $valor = valor atribu�do
     */
    function set_dia_semana($valor)
    {
        // verifica se o dia da semana est� entre 1 e 7 e � n�mero
        if (is_int($valor) and ($valor>=1) and ($valor <=7))
        {
            // atribui o valor � propriedade
            $this->data['dia_semana'] = $valor;
        }
        else
        {
            // exibe mensagem de erro
            echo "Tentou atribuir '{$valor}' em dia_semana <br>\n";
        }
    }
    
    /*
     * m�todo set_turno()
     * executado sempre que h� uma atribui��o para "turno"
     * @param $valor = valor atribu�do
     */
    function set_turno($valor)
    {
        // verifica se o valor � 'M', 'T' ou 'N'
        if (($valor=='M') or ($valor =='T') or ($valor =='N'))
        {
            // atribui o valor � propriedade
            $this->data['turno'] = $valor;
        }
        else
        {
            // exibe mensagem de erro
            echo "Tentou atribuir '{$valor}' em turno <br>\n";
        }
    }
}

// insere novos objetos no banco de dados
try
{
    // inicia transa��o com o banco 'pg_livro'
    TTransaction::open('pg_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('/tmp/log10.txt'));
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo turma 1");
    
    // instancia um novo objeto Turma
    $turma = new Turma;
    $turma->dia_semana = 1;
    $turma->turno       = 'M';
    $turma->professor   = 'Carlo Bellini';
    $turma->sala        = '100';
    $turma->data_inicio = '2002-09-01';
    $turma->encerrada   = FALSE;
    $turma->ref_curso   = 2;
    $turma->store(); // armazena o objeto
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo turma 2");
    $turma= new Turma;
    $turma->dia_semana = 'Segunda';
    $turma->turno       = 'Manh�';
    $turma->professor   = 'S�rgio Crespo';
    $turma->sala        = '200';
    $turma->data_inicio = '2004-09-01';
    $turma->encerrada   = FALSE;
    $turma->ref_curso   = 3;
    $turma->store(); // armazena o objeto
    
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