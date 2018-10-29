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

// instancia objeto DataGrid
$datagrid = new TDataGrid;

// instancia as colunas da DataGrid
$codigo   = new TDataGridColumn('codigo',   'C�digo',   'left',    50);
$nome     = new TDataGridColumn('nome',     'Nome',     'left',   180);
$endereco = new TDataGridColumn('endereco', 'Endere�o', 'left',   140);
$telefone = new TDataGridColumn('fone',     'Fone',     'center', 100);

// adiciona as colunas � DataGrid
$datagrid->addColumn($codigo);
$datagrid->addColumn($nome);
$datagrid->addColumn($endereco);
$datagrid->addColumn($telefone);

// instancia duas a��es da DataGrid
$action1 = new TDataGridAction('onDelete');
$action1->setLabel('Deletar');
$action1->setImage('ico_delete.png');
$action1->setField('codigo');

$action2 = new TDataGridAction('onView');
$action2->setLabel('Visualizar');
$action2->setImage('ico_view.png');
$action2->setField('nome');

// adiciona as a��es � DataGrid
$datagrid->addAction($action1);
$datagrid->addAction($action2);

// cria o modelo da DataGrid, montando sua estrutura
$datagrid->createModel();

// adiciona um objeto padr�o � DataGrid
$item = new StdClass;
$item->codigo   = '1';
$item->nome     = 'Daline DallOglio';
$item->endereco = 'Rua Concei��o';
$item->fone     = '1111-1111';
$datagrid->addItem($item);

// adiciona um objeto padr�o � DataGrid
$item = new StdClass;
$item->codigo   = '2';
$item->nome     = 'William Scatola';
$item->endereco = 'Rua Concei��o';
$item->fone     = '2222-2222';
$datagrid->addItem($item);

// adiciona um objeto padr�o � DataGrid
$item = new StdClass;
$item->codigo   = '3';
$item->nome     = 'S�mara Petter';
$item->endereco = 'Rua Oliveira';
$item->fone     = '3333-3333';
$datagrid->addItem($item);

// adiciona um objeto padr�o � DataGrid
$item = new StdClass;
$item->codigo   = '4';
$item->nome     = 'Ana Am�lia Petter';
$item->endereco = 'Rua Oliveira';
$item->fone     = '4444-4444';
$datagrid->addItem($item);

// instancia uma p�gina TPage
$page = new TPage;

// adiciona a DataGrid � p�gina
$page->add($datagrid);

// exibe a p�gina
$page->show();

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
 * Executada quando o usu�rio clicar no bot�o visualizar
 */
function onView($param)
{
    // obt�m o par�metro e exibe mensagem
    $key=$param['key'];
    new TMessage('info', "O nome �: <br> $key");
}
?>