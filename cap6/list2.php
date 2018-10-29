<?php
/*
 * fun��o __autoload()
 * carrega uma classe quando ela � necess�ria,
 * ou seja, quando ela � instancia pela primeira vez.
 */
function __autoload($classe)
{
    if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

class PessoasList extends TPage
{
    private $datagrid;
    public function __construct()
    {
        parent::__construct();
        
        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;
        
        // instancia as colunas da DataGrid
        $codigo   = new TDataGridColumn('codigo',   'C�digo',   'left',    50);
        $nome     = new TDataGridColumn('nome',     'Nome',     'left',   180);
        $endereco = new TDataGridColumn('endereco', 'Endere�o', 'left',   140);
        $telefone = new TDataGridColumn('fone',     'Fone',     'center', 100);
        
        // adiciona as colunas � DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($endereco);
        $this->datagrid->addColumn($telefone);
        
        // instancia duas a��es da DataGrid
        $action1 = new TDataGridAction(array($this, 'onDelete'));
        $action1->setLabel('Deletar');
        $action1->setImage('ico_delete.png');
        $action1->setField('codigo');
        
        $action2 = new TDataGridAction(array($this, 'onView'));
        $action2->setLabel('Visualizar');
        $action2->setImage('ico_view.png');
        $action2->setField('nome');
        
        // adiciona as a��es � DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();
        
        // adiciona a DataGrid � p�gina
        parent::add($this->datagrid);
    }
    
    function show()
    {
        $this->datagrid->clear();
        
        // adiciona um objeto padr�o � DataGrid
        $item = new StdClass;
        $item->codigo   = '1';
        $item->nome     = 'Daline DallOglio';
        $item->endereco = 'Rua Concei��o';
        $item->fone     = '1111-1111';
        $this->datagrid->addItem($item);
        
        // adiciona um objeto padr�o � DataGrid
        $item = new StdClass;
        $item->codigo   = '2';
        $item->nome     = 'William Scatola';
        $item->endereco = 'Rua Concei��o';
        $item->fone     = '2222-2222';
        $this->datagrid->addItem($item);
        
        // adiciona um objeto padr�o � DataGrid
        $item = new StdClass;
        $item->codigo   = '3';
        $item->nome     = 'S�mara Petter';
        $item->endereco = 'Rua Oliveira';
        $item->fone     = '3333-3333';
        $this->datagrid->addItem($item);
        
        // adiciona um objeto padr�o � DataGrid
        $item = new StdClass;
        $item->codigo   = '4';
        $item->nome     = 'Ana Am�lia Petter';
        $item->endereco = 'Rua Oliveira';
        $item->fone     = '4444-4444';
        $this->datagrid->addItem($item);
        parent::show();
    }
    
    /*
     * fun��o onDelete()
     * executada quando o usu�rio clicar no bot�o excluir
     */
    function onDelete($param)
    {
        // obt�m o par�metro e exibe mensagem
        $key=$param['key'];
        new TMessage('error', "O registro $key <br> n�o pode ser exclu�do");
    }
    
    /*
     * fun��o onView()
     * executada quando o usu�rio clicar no bot�o visualizar
     */
    function onView($param)
    {
        // obt�m o par�metro e exibe mensagem
        $key=$param['key'];
        new TMessage('info', "O nome �: <br> $key");
    }
}
$page = new PessoasList;
$page->show();
?>