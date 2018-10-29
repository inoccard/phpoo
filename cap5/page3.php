<?php
function __autoload($classe)
{
    if (file_exists("app.widgets/{$classe}.class.php"))
    {
        include_once "app.widgets/{$classe}.class.php";
    }
}

/**
 * m�todo onProdutos()
 * executado quando o usu�rio clicar no link "Produtos"
 * @param $get = vari�vel $_GET
 */
function onProdutos($get)
{
    echo "Nesta se��o voc� vai conhecer os produtos da nossa empresa
    Temos desde pintos, frangos, porcos, bois, vacas e todo tipo de animal
    que voc� pode imaginar na nossa fazenda.";
}

/**
 * m�todo onContato()
 * executado quando o usu�rio clicar no link "Contato"
 * @param $get = vari�vel $_GET
 */
function onContato($get)
{
    echo "Para entrar em contato com nossa empresa,
    ligue para 0800-1234-5678 ou mande uma carta endere�ada para
    Linha alto coqueiro baixo, fazenda recanto escondido.";
}

/**
 * m�todo onEmpresa()
 * executado quando o usu�rio clicar no link "Empresa"
 * @param $get = vari�vel $_GET
 */
function onEmpresa($get)
{
    echo "Aqui na fazenda recanto escondido fazemos eco-turismo,
    voc� vai poder conhecer nossas instala��es,
    tirar leite diretamente da vaca, recolher os ovos do galinheiro e o mais
    importante, vai poder limpar as instala��es dos su�nos, o que � o auge
    do passeio. N�o deixe de conhecer nossa fazenda, temos lindas cabanas
    equipadas com cama de casal, fog�o a lenha e banheiro.";
}

// exibe alguns links
echo "<a href='?method=onProdutos'>Produtos</a><br>";
echo "<a href='?method=onContato'>Contato</a><br>";
echo "<a href='?method=onEmpresa'>Empresa</a><br>";

// interpreta a p�gina
$pagina = new TPage;
$pagina->show();
?>