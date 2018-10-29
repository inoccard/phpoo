<?php
function __autoload($classe)
{
    if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

/*
 * classe Pagina
 * demonstra o funcionamento de um di�logo de quest�o
 */
class Pagina extends TPage
{
    private $panel;
    
    /**
     * m�todo construtor
     * instancia uma nova p�gina
     */
    function __construct()
    {
        parent::__construct();
        
        // cria um novo painel
        $this->panel = new TPanel(400,200);
        
        // coloca um novo texto na coluna:10 linha:10
        $this->panel->put(new TParagraph('Responda a quest�o'), 10, 10);
        
        // cria duas a��es
        $action1 = new TAction(array($this, 'onYes'));
        $action2 = new TAction(array($this, 'onNo'));
        
        // exibe a pergunta ao usu�rio
        new TQuestion('Deseja realmente excluir o registro?', $action1, $action2);
        
        // adiciona o painel � janela
        parent::add($this->panel);
    }
    
    /**
     * m�todo onYes
     * executado caso o usu�rio responda SIM para pergunta
     */
    function onYes()
    {
        $this->panel->put(new TParagraph('Voc� escolheu a op��o sim'), 10, 40);
    }
    
    /**
     * m�todo onYes
     * executado caso o usu�rio responda N�O para pergunta
     */
    function onNo()
    {
        $this->panel->put(new TParagraph('Voc� escolheu a op��o n�o'), 10, 40);
    }
}

// instancia a p�gina
$pagina = new Pagina;

// exibe a p�gina
$pagina->show();
?>