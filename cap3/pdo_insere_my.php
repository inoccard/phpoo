<?php
try
{
    // instancia objeto PDO, conectando no mysql
    $conn = new PDO('mysql:host=localhost;port=3307;dbname=livro', 'root', 'mysql');
    
    // executa uma s�rie de instru��es SQL
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (1, '�rico Ver�ssimo')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (2, 'John Lennon')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (3, 'Mahatma Gandhi')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (4, 'Ayrton Senna')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (5, 'Charlie Chaplin')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (6, 'Anita Garibaldi')");
    $conn->exec("INSERT INTO famosos (codigo, nome) VALUES (7, 'M�rio Quintana')");
    
    // fecha a conex�o
    $conn = null;
}
catch (PDOException $e)
{
    // caso ocorra uma exce��o, exibe na tela
    print "Erro!: " . $e->getMessage() . "\n";
    die();
}
?>