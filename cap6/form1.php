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

// instancia um formul�rio
$form = new TForm('form_email');

// instancia uma tabela
$table = new TTable;

// adiciona a tabela ao formul�rio
$form->add($table);

// cria os campos do formul�rio
$nome      = new TEntry('nome');
$email     = new TEntry('email');
$titulo    = new TEntry('titulo');
$mensagem = new TText('mensagem');

// adiciona uma linha para o campo nome
$row=$table->addRow();
$row->addCell(new TLabel('Nome:'));
$row->addCell($nome);

// adiciona uma linha para o campo email
$row=$table->addRow();
$row->addCell(new TLabel('Email:'));
$row->addCell($email);

// adiciona uma linha para o campo t�tulo
$row=$table->addRow();
$row->addCell(new TLabel('T�tulo:'));
$row->addCell($titulo);

// adiciona uma linha para o campo mensagem
$row=$table->addRow();
$row->addCell(new TLabel('Mensagem:'));
$row->addCell($mensagem);

// cria dois bot�es de a��o para o formul�riop
$action1=new TButton('action1');
$action2=new TButton('action2');

// define as a��es dos bot�es
$action1->setAction(new TAction('onSend'), 'Enviar');
$action2->setAction(new TAction('onView'), 'Visualizar');

// adiciona uma linha para as a��es do formul�rio
$row=$table->addRow();
$row->addCell($action1);
$row->addCell($action2);

// define quais s�o os campos do formul�rio
$form->setFields(array($nome, $email, $titulo, $mensagem, $action1, $action2));

/*
 * fun��o onView
 * visualiza os dados do formul�rio
 */
function onView()
{
    global $form;
    
    // obt�m os dados do formul�rio
    $data = $form->getData();
    
    // atribui os dados de volta ao formul�rio
    $form->setData($data);
    
    // cria uma janela
    $window = new TWindow('Dados do Form');
    
    // define posi��o e tamanho em pixels
    $window->setPosition(300, 70);
    $window->setSize(300,150);
    
    // monta o texto a ser exibido
    $output = "Nome:     {$data->nome}\n";
    $output.= "Email:    {$data->email}\n";
    $output.= "T�tulo:   {$data->titulo}\n";
    $output.= "Mensagem: \n{$data->mensagem}";
    
    // cria um objeto de texto
    $text = new TText('texto', 300);
    $text->setSize(290,120);
    $text->setValue($output);
    
    // adiciona o objeto � janela
    $window->add($text);
    $window->show();
}

/*
 * fun��o onSend
 * exibe mensagem "Enviando dados..."
 */
function onSend()
{
    global $form;
    
    // obt�m os dados do formul�rio
    $data = $form->getData();
    
    // atribui os dados de volta ao formul�rio
    $form->setData($data);
    
    // torna o formul�rio n�o-edit�vel
    $form->setEditable(FALSE);
    
    // exibe mensagem ao usu�rio
    new TMessage('info', 'Enviando dados...');
}
$page = new TPage;
$page->add($form);
$page->show();
?>