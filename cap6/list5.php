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
    private $datagrid;
    private $loaded;
    public function __construct()
    {
        parent::__construct();
        
        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;
        
        // instancia as colunas da DataGrid
        $codigo    = new TDataGridColumn('id',      'C�digo',       'right', 50);
        $nome      = new TDataGridColumn('nome',    'Nome',         'left', 180);
        $endereco  = new TDataGridColumn('endereco', 'Endere�o',     'left', 140);
        $qualifica = new TDataGridColumn('qualifica','Qualifica��es','left', 200);
        
        $action1 = new TAction(array($this, 'onReload'));
        $action1->setParameter('order', 'id');
        $action2 = new TAction(array($this, 'onReload'));
        $action2->setParameter('order', 'nome');
        $codigo->setAction($action1);
        $nome->setAction($action2);
        
        // adiciona as colunas � DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($endereco);
        $this->datagrid->addColumn($qualifica);
        
        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();
        
        // adiciona a DataGrid � p�gina
        parent::add($this->datagrid);
    }
    
    /*
     * fun��o onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload($param = NULL)
    {
        $order = $param['order'];
        // inicia transa��o com o banco 'pg_livro'
        
        TTransaction::open('pg_livro');
        // instancia um reposit�rio para Pessoa
        
        $repository = new TRepository('Pessoa');
        // retorna todos objetos que satisfazem o crit�rio
        
        $criteria = new TCriteria;
        $criteria->setProperty('order', $order);
        $pessoas = $repository->load($criteria);
        if ($pessoas)
        {
            $this->datagrid->clear();
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
     * fun��o show()
     * Executada quando o usu�rio clicar no bot�o excluir
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