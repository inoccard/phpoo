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

// cria classe para manipula��o dos registros de pessoas
class Pessoa extends TRecord
{
    const TABLENAME = 'pessoa';
}

// instancia um formul�rio
$form = new TForm('form_pessoas');

// instancia uma tabela
$table = new TTable;

// define algumas propriedades da tabela
$table->bgcolor = '#f0f0f0';
$table->style    = 'border:2px solid grey';
$table->width    = 400;

// adiciona a tabela ao formul�rio
$form->add($table);

// cria os campos do formul�rio
$codigo    = new TEntry('id');
$nome      = new TEntry('nome');
$endereco  = new TEntry('endereco');
$datanasc  = new TEntry('datanasc');
$sexo      = new TRadioGroup('sexo');
$linguas   = new TCheckGroup('linguas');
$qualifica = new TText('qualifica');

// define tamanho para campo c�digo
$codigo->setSize(100);

// define como somente leitura
$codigo->setEditable(FALSE);

// cria um vetor com as op��es de sexo
$items = array();
$items['M'] = 'Masculino';
$items['F'] = 'Feminino';

// define tamanho para campo data de nascimento
$datanasc->setSize(100);

// adiciona as op��es ao radio button
$sexo->addItems($items);

// define a op��o ativa
$sexo->setValue('M');

// define a posi��o dos elementos
$sexo->setLayout('horizontal');

// cria um vetor com as op��es de idiomas
$items= array();
$items['E'] = 'Ingl�s';
$items['S'] = 'Espanhol';
$items['I'] = 'Italiano';
$items['F'] = 'Franc�s';

// adiciona as op��es ao check button
$linguas->addItems($items);

// define as op��es ativas
$linguas->setValue(array('E','I'));

// define um valor padr�o para o campo
$qualifica->setValue('<digite suas qualifica��es aqui>');
$qualifica->setSize(240);

// adiciona uma linha para o campo c�digo na tabela
$row=$table->addRow();
$row->addCell(new TLabel('C�digo:'));
$row->addCell($codigo);

// adiciona uma linha para o campo nome na tabela
$row=$table->addRow();
$row->addCell(new TLabel('Nome:'));
$row->addCell($nome);

// adiciona uma linha para o campo endere�o na tabela
$row=$table->addRow();
$row->addCell(new TLabel('Endere�o:'));
$row->addCell($endereco);

// adiciona uma linha para o campo data na tabela
$row=$table->addRow();
$row->addCell(new TLabel('Data Nascimento:'));
$row->addCell($datanasc);

// adiciona uma linha para o campo sexo na tabela
$row=$table->addRow();
$row->addCell(new TLabel('Sexo:'));
$row->addCell($sexo);

// adiciona uma linha para o campo l�nguas na tabela
$row=$table->addRow();
$row->addCell(new TLabel('L�nguas:'));
$row->addCell($linguas);

// adiciona uma linha para o campo qualifica��es na tabela
$row=$table->addRow();
$row->addCell(new TLabel('Qualifica��es:'));
$row->addCell($qualifica);

// adiciona um bot�o de a��o ao formul�rio
// ele ir� executar a fun��o onSave
$submit=new TButton('action1');
$submit->setAction(new TAction('onSave'), 'Salvar');
$row=$table->addRow();
$row->addCell(new TLabel(''));
$row->addCell($submit);

// define quais s�o os campos do formul�rio
$form->setFields(array($codigo, $nome, $endereco, $datanasc, $sexo, $linguas, $qualifica, $submit));

// instancia uma nova p�gina
$page = new TPage;

// adiciona o formul�rio na p�gina
$page->add($form);

// exibe a p�gina e seu conte�do
$page->show();

/*
 * fun��o onSave
 * obt�m os dados do formul�rio e salva na base de dados
 */
function onSave()
{
    global $form;
    $pessoa = $form->getData('Pessoa');
    
    try
    {
        // inicia transa��o com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        $pessoa->linguas = implode(' ', $pessoa->linguas);
        $pessoa->datanasc = conv_data_to_us($pessoa->datanasc);
        $pessoa->store();
        
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
 * fun��o onEdit
 * carrega os dados do registro no formul�rio
 * @param $param = par�metros passados via URL ($_GET)
 */
function onEdit($param)
{
    global $form;
    
    try
    {
        // inicia transa��o com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        
        // obt�m a pessoa a partir do par�metro ID
        $pessoa= new Pessoa($param['id']);
        $pessoa->linguas = explode(' ', $pessoa->linguas);
        $pessoa->datanasc = conv_data_to_br($pessoa->datanasc);
        $form->setData($pessoa);
        
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

/**
 * fun��o conv_data_to_us
 * converte uma data do formato brasileiro para o americano
 * @param $data = data (dd/mm/aaaa) a ser convertida
 */
function conv_data_to_us($data)
{
    $dia = substr($data,0,2);
    $mes = substr($data,3,2);
    $ano = substr($data,6,4);
    return "{$ano}-{$mes}-{$dia}";
}

/**
 * fun��o conv_data_to_br
 * converte uma data do formato americano para o brasileiro
 * @param $data = data (yyyy-mm-dd) a ser convertida
 */
function conv_data_to_br($data)
{
    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,4);
    return "{$dia}/{$mes}/{$ano}";
}
?>
