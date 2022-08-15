<?php
namespace Emercado\Service;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Cria a conexao com a base de dados, conforme a config da aplicação.
 * @throws RuntimeException
 * - caso falha na conexao
 */
class ConnectionFactory {
    /**
     * Retornar a conexão com o banco da aplicação.
     * @param string $sName (opcional) padrão db nome da config de conexão.
     * @throws RuntimeException
     */
    public static function getConnection($sName = 'db')
    {
        $aDb = ConfigReader::getConfig($sName);
        if (! $aDb) {
            throw new RuntimeException('Erro de configuração!');
        }
        // TODO adicionar suporte a diversos drivers
        try {
            return new PDO("pgsql:host={$aDb['host']};port={$aDb['port']};dbname={$aDb['db']};user={$aDb['user']};password={$aDb['password']}");
        } catch (PDOException $e) {
            throw new RuntimeException('Erro de configuração com a base! '. $e->getMessage());
        }
    }
}
