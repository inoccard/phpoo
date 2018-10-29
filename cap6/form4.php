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

// Active Record para tabela Livro
class Livro extends TRecord
{
    const TABLENAME = 'livro';
}

class LivrosForm extends TPage
{
    private $form;
    function __construct()
    {
        parent::__construct();
        
        // instancia o formul�rio
        $this->form = new TForm;
        $this->form->setName('form_livros');
        
        // instancia o pain�l
        $panel= new TPanel(400,300);
        $this->form->add($panel);
        
        // coloca o campo id no formul�rio
        $panel->put(new TLabel('ID'), 10, 10);
        $panel->put($id = new TEntry('id'), 100,10);
        $id->setSize(100);
        $id->setEditable(FALSE);
        
        // coloca a imagem de um livro
        $panel->put(new TImage('book.png'), 320, 20);
        
        // coloca o campo t�tulo no formul�rio
        $panel->put(new TLabel('T�tulo'), 10, 40);
        $panel->put($titulo = new TEntry('titulo'), 100,40);
        
        // coloca o campo autor no formul�rio
        $panel->put(new TLabel('Autor'), 10, 70);
        $panel->put($autor = new TEntry('autor'), 100,70);
        
        // coloca o campo tema no formul�rio
        $panel->put(new TLabel('Tema'), 10, 100);
        $panel->put($tema= new TCombo('tema'), 100,100);
        
        // cria um vetor com as op��es da combo tema
        $items= array();
        $items['1'] = 'Administra��o';
        $items['2'] = 'Inform�tica';
        $items['3'] = 'Economia';
        $items['4'] = 'Matem�tica';
        
        // adiciona os itens na combo
        $tema->addItems($items);
        
        // coloca o campo editora no formul�rio
        $editora = new TEntry('editora');
        $panel->put(new TLabel('Editora'), 10,130);
        $panel->put($editora, 100, 130);
        
        // coloca o campo ano no formul�rio
        $panel->put(new TLabel('Ano'), 210, 130);
        $panel->put($ano    = new TEntry('ano'), 260, 130);
        $editora->setSize(100);
        $ano->setSize(40);
        
        // coloca o campo resumo no formul�rio
        $panel->put(new TLabel('Resumo'), 10, 160);
        $panel->put($resumo = new TText('resumo'), 100, 160);
        
        // cria uma a��o
        $panel->put($acao = new TButton('action1'), 320, 240);
        $acao->setAction(new TAction(array($this, 'onSave')), 'Salvar');
        
        // define quais s�o os campos do formul�rio
        $this->form->setFields(array($id, $titulo, $autor, $tema, $editora, $ano, $resumo, $acao));
        parent::add($this->form);
    }
    
    /*
     * m�todo onSave
     * obt�m os dados do formul�rio e salva na base de dados
     */
    function onSave()
    {
        try
        {
            // inicia transa��o com o banco 'pg_livro'
            TTransaction::open('pg_livro');
            
            // obt�m dados
            $livro = $this->form->getData('Livro');
            
            // armazena registro
            $livro->store();
            
            // joga os dados de volta ao formul�rio
            $this->form->setData($livro);
            
            // define o formul�rio como n�o-edit�vel
            $this->form->setEditable(FALSE);
            
            // finaliza a transa��o
            TTransaction::close();
            new TMessage('info', 'Dados armazenados com sucesso');
        }
        catch (Exception $e) // em caso de exce��o
        {
            // exibe a mensagem gerada pela exce��o
            new TMessage('error', '<b>Erro</b>' . $e->getMessage());
            
            // desfaz todas altera��es no banco de dados
            TTransaction::rollback();
        }
    }
    
    /**
     * m�todo onEdit
     * carrega os dados do registro no formul�rio
     * @param $param = par�metros passados via URL ($_GET)
     */
    function onEdit($param)
    {
        try
        {
            // inicia transa��o com o banco 'pg_livro'
            TTransaction::open('pg_livro');
            
            // obt�m o livro pelo ID
            $livro= new Livro($param['id']);
            
            // joga os dados no formul�rio
            $this->form->setData($livro);
            
            // finaliza a transa��o
            TTransaction::close();
        }
        catch (Exception $e) // em caso de exce��o
        {
            // exibe a mensagem gerada pela exce��o
            new TMessage('error', '<b>Erro</b>' . $e->getMessage());
            
            // desfaz todas altera��es no banco de dados
            TTransaction::rollback();
        }
    }
}

// instancia e exibe a p�gina
$page = new LivrosForm;
$page->show();
?>