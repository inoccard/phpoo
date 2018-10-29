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

// cria o formul�rio
$form = new TForm('form_pessoas');

// cria a tabela para organizar o layout
$table = new TTable;
$table->border = 1;
$table->bgcolor ='#f2f2f2';

// adiciona a tabela no formul�rio
$form->add($table);

// cria um r�tulo de texto para o t�tulo
$titulo = new TLabel('Exemplo de Formul�rio');
$titulo->setFontFace('Arial');
$titulo->setFontColor('red');
$titulo->setFontSize(18);

// adiciona uma linha � tabela
$row=$table->addRow();
$titulo = $row->addCell($titulo);
$titulo->colspan = 2;

// cria duas outras tabelas
$table1 = new TTable;
$table2 = new TTable;

// cria uma s�rie de campos de entrada de dados
$codigo      = new TEntry('codigo');
$nome        = new TEntry('nome');
$endereco    = new TEntry('endereco');
$telefone    = new TEntry('telefone');
$cidade      = new TCombo('cidade');
$items= array();
$items['1'] = 'Porto Alegre';
$items['2'] = 'Lajeado';
$cidade->addItems($items);

// ajusta o tamanho destes campos
$codigo->setSize(70);
$nome->setSize(140);
$endereco->setSize(140);
$telefone->setSize(140);
$cidade->setSize(140);

// cria uma s�rie de r�tulos de texto
$label1=new TLabel('C�digo');
$label2=new TLabel('Nome');
$label3=new TLabel('Cidade');
$label4=new TLabel('Endere�o');
$label5=new TLabel('Telefone');

// adiciona linha na tabela para o c�digo
$row=$table1->addRow();
$row->addCell($label1);
$row->addCell($codigo);

// adiciona linha na tabela para o nome
$row=$table1->addRow();
$row->addCell($label2);
$row->addCell($nome);

// adiciona linha na tabela para a cidade
$row=$table1->addRow();
$row->addCell($label3);
$row->addCell($cidade);

// adiciona linha na tabela para o endere�o
$row=$table2->addRow();
$row->addCell($label4);
$row->addCell($endereco);

// adiciona linha na tabela para o telefone
$row=$table2->addRow();
$row->addCell($label5);
$row->addCell($telefone);

// adiciona as tabelas lado-a-lado da tabela principal
$row=$table->addRow();
$row->addCell($table1);
$row->addCell($table2);

// exibe o formul�rio
$form->show();
?>