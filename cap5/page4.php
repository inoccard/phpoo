<?php
function __autoload($classe)
{
    if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

class Pagina extends TPage
{
    private $table;
    private $content;
    
    /**
     * m�todo __construct()
     * instancia uma nova p�gina
     */
    function __construct()
    {
        parent::__construct();
        
        // cria uma tabela
        $this->table = new TTable;
        
        // define algumas propriedades para tabela
        $this->table->border = 1;
        $this->table->width = 500;
        $this->table->style = 'border-collapse:collapse';
        
        // adiciona uma linha na tabela
        $row = $this->table->addRow();
        $row->bgcolor ='#d0d0d0';
        
        // cria tr�s a��es
        $action1 = new TAction(array($this, 'onProdutos'));
        $action2 = new TAction(array($this, 'onContato'));
        $action3 = new TAction(array($this, 'onEmpresa'));
        
        // cria tr�s links
        $link1 = new TElement('a');
        $link2 = new TElement('a');
        $link3 = new TElement('a');
        
        // define a a��o dos links
        $link1->href = $action1->serialize();
        $link2->href = $action2->serialize();
        $link3->href = $action3->serialize();
        
        // define o r�tulo de texto dos links
        $link1->add('Produtos');
        $link2->add('Contato');
        $link3->add('Empresa');
        
        // adiciona os links na linha
        $row->addCell($link1);
        $row->addCell($link2);
        $row->addCell($link3);
        
        // cria uma linha para conte�do
        $this->content = $this->table->addRow();
        
        // adiciona a tabela na p�gina
        parent::add($this->table);
    }
    
    /**
     * m�todo onProdutos()
     * executado quando o usu�rio clicar no link "Produtos"
     * @param $get = vari�vel $_GET
     */
    function onProdutos($get)
    {
        $texto = "Nesta se��o voc� vai conhecer os produtos da nossa empresa
        Temos desde pintos, frangos, porcos, bois, vacas e todo tipo de animal
        que voc� pode imaginar na nossa fazenda.";
        
        // adiciona o texto na linha de conte�do da tabela
        $celula = $this->content->addCell($texto);
        $celula->colspan = 3;
        
        // cria uma janela
        $win = new TWindow('Promo��o');
        
        // define posi��o e tamanho
        $win->setPosition(200,100);
        $win->setSize(240,100);
        
        // adiciona texto na janela
        $win->add('Temos cogumelos rec�m colhidos e tamb�m ovos de codorna fresquinhos');
        // exibe a janela
        $win->show();
    }
    
    /**
     * m�todo onContato()
     * executado quando o usu�rio clicar no link "Contato"
     * @param $get = vari�vel $_GET
     */
    function onContato($get)
    {
        $texto = "Para entrar em contato com nossa empresa,
        ligue para 0800-1234-5678 ou mande uma carta endere�ada para
        Linha alto coqueiro baixo, fazenda recanto escondido.";
        // adiciona o texto na linha de conte�do da tabela
        $celula = $this->content->addCell($texto);
        $celula->colspan = 3;
    }
    
    /**
     * m�todo onEmpresa()
     * executado quando o usu�rio clicar no link "Empresa"
     * @param $get = vari�vel $_GET
     */
    function onEmpresa($get)
    {
        $texto = "Aqui na fazenda recanto escondido fazemos eco-turismo,
        voc� vai poder conhecer nossas instala��es,
        tirar leite diretamente da vaca, recolher os ovos do galinheiro e o mais
        importante, vai poder limpar as instala��es dos su�nos, o que � o auge
        do passeio. N�o deixe de conhecer nossa fazenda, temos lindas cabanas
        equipadas com cama de casal, fog�o a lenha e banheiro";
        
        // adiciona o texto na linha de conte�do da tabela
        $celula = $this->content->addCell($texto);
        $celula->colspan = 3;
    }
}
// instancia nova p�gina
$pagina = new Pagina;

// exibe a p�gina juntamente com seu conte�do e interpreta a URL
$pagina->show();
?>