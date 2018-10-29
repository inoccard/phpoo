<?php
/*
 * fun��o __autoload()
 * carrega uma classe quando ela � necess�ria,
 * ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    $pastas = array('app.widgets', 'app.ado');
    foreach ($pastas as $pasta)
    {
        if (file_exists("{$pasta}/{$classe}.class.php"))
        {
            include_once "{$pasta}/{$classe}.class.php";
        }
    }
}

// declara a classe Pessoa
class Pessoa extends TRecord
{
    const TABLENAME = 'pessoa';
}

/*
 * classe PessoasList
 */
class PessoasList extends TPage
{
    private $loaded;
    private $datagrid;
    public function __construct()
    {
        parent::__construct();
        
        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;
        
        // instancia as colunas da DataGrid
        $codigo   = new TDataGridColumn('id',       'C�digo',       'left', 50);
        $nome     = new TDataGridColumn('nome',     'Nome',         'left', 180);
        $endereco = new TDataGridColumn('endereco', 'Endere�o',     'left', 140);
        $qualifica= new TDataGridColumn('qualifica','Qualifica��es','left', 200);
        
        // adiciona as colunas � DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($endereco);
        $this->datagrid->addColumn($qualifica);
        
        // instancia duas a��es da DataGrid
        $action1 = new TDataGridAction(array($this, 'onDelete'));
        $action1->setLabel('Deletar');
        $action1->setImage('ico_delete.png');
        $action1->setField('id');
        
        $action2 = new TDataGridAction(array($this, 'onView'));
        $action2->setLabel('Visualizar');
        $action2->setImage('ico_view.png');
        $action2->setField('id');
        
        // adiciona as a��es � DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();
        
        // adiciona a DataGrid � p�gina
        parent::add($this->datagrid);
    }
    
    /*
     * fun��o onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload()
    {
        // inicia transa��o com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        
        // instancia um reposit�rio para Pessoa
        $repository = new TRepository('Pessoa');
        
        // cria um crit�rio, definindo a ordena��o
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');
        
        // carrega os objetos $pessoas
        $pessoas = $repository->load($criteria);
        $this->datagrid->clear();
        if ($pessoas)
        {
            foreach ($pessoas as $pessoa)
            {
                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($pessoa);
            }
        }
        
        // finaliza a transa��o
        TTransaction::close();
        $this->loaded = true;
    }
    
    /*
     * fun��o onDelete()
     * executada quando o usu�rio clicar no bot�o excluir
     */
    function onDelete($param)
    {
        // obt�m o par�metro e exibe mensagem
        $key=$param['key'];
        $action1 = new TAction(array($this, 'Delete'));
        $action2 = new TAction(array($this, 'teste'));
        $action1->setParameter('key', $key);
        $action2->setParameter('key', $key);
        new TQuestion('Deseja realmente excluir o registro?', $action1, $action2);
    }
    
    /*
     * fun��o Delete()
     * exclui um registro
     */
    function Delete($param)
    {
        // obt�m o par�metro e exibe mensagem
        $key=$param['key'];
        
        // inicia transa��o com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        $pessoa = new Pessoa($key);
        $pessoa->delete();
        
        // finaliza a transa��o
        TTransaction::close();
        new TMessage('info', "Registro exclu�do com sucesso");
        $this->onReload();
    }
    
    /*
     * fun��o onView()
     * Executada quando o usu�rio clicar no bot�o visualizar
     */
    function onView($param)
    {
        // obt�m o par�metro e exibe mensagem
        $key=$param['key'];
        
        // inicia transa��o com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        $pessoa = new Pessoa($key);
        
        // finaliza a transa��o
        TTransaction::close();
        $mensagem = "O nome �: $pessoa->nome<br>";
        $mensagem.= "O Endere�o � $pessoa->endereco";
        
        new TMessage('info', $mensagem);
        $this->onReload();
    }
    
    /*
     * fun��o show()
     * executada quando o usu�rio clicar no bot�o excluir
     */
    function show()
    {
        if (!$this->loaded)
        {
            $this->onReload();
        }
        parent::show();
    }
}
$page = new PessoasList;
$page->show();
?>