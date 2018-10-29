<?php
/*
 * classe TTransaction
 * esta classe provê os métodos necessários manipular transações
 */
final class TTransaction
{
    private static $conn;   // conexão ativa
    private static $logger; // objeto de LOG
    
    /*
     * método __construct()
     * Está declarado como private para impedir que se crie inst�ncias de TTransaction
     */
    private function __construct() {}
    
    /*
     * m�todo open()
     * Abre uma transação e uma conexão ao BD
     * @param $database = nome do banco de dados
     */
    public static function open($database)
    {
        // abre uma conexão e armazena na propriedade estática $conn
        if (empty(self::$conn))
        {
            self::$conn = TConnection::open($database);
            // inicia a transação
            self::$conn->beginTransaction();
            // desliga o log de SQL
            self::$logger = NULL;
        }
    }
    
    /*
     * m�todo get()
     * retorna a conex�o ativa da transa��o
     */
    public static function get()
    {
        // retorna a conex�o ativa
        return self::$conn;
    }
    
    /*
     * m�todo rollback()
     * desfaz todas opera��es realizadas na transa��o
     */
    public static function rollback()
    {
        if (self::$conn)
        {
            // desfaz as opera��es realizadas durante a transa��o
            self::$conn->rollback();
            self::$conn = NULL;
        }
    }
    
    /*
     * m�todo close()
     * Aplica todas opera��es realizadas e fecha a transa��o
     */
    public static function close()
    {
        if (self::$conn)
        {
            // aplica as opera��es realizadas
            // durante a transa��o
            self::$conn->commit();
            self::$conn = NULL;
        }
    }
    
    /*
     * m�todo setLogger()
     * define qual estrat�gia (algoritmo de LOG ser� usado)
     */
    public static function setLogger(TLogger $logger)
    {
        self::$logger = $logger;
    }
    
    /*
     * m�todo log()
     * armazena uma mensagem no arquivo de LOG
     * baseada na estrat�gia ($logger) atual
     */
    public static function log($message)
    {
        // verifica existe um logger
        if (self::$logger)
        {
            self::$logger->write($message);
        }
    }
}
?>