<?php

namespace Emercado\Model;

use Emercado\Service\ConnectionFactory;
use PDO;

class Base {
    const STAR = '*';
    protected $oConnection;
    protected $sTable;
    /**
     * @param string $sTable nome da tabela sem o esquema
     * @return $this
     * @throws RuntimeException
     */
    public function __construct($sTable)
    {
        $this->sTable = $sTable;
        $this->oConnection = ConnectionFactory::getConnection();
        $this->oConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     * @param array $aValues map with data do store
     * @return int the identifier of new inserted row
     */
    public function insert(array $aValues)
    {
        $sInsert = 'INSERT INTO ' . $this->qTable() . '(';
        $sValues = ' VALUES (';
        $sSep = '';
        $aPdoValue = [];
        foreach ($aValues as $sColumn => $sValue) {
            $sInsert .= $sSep.$this->q($sColumn);
            $sValues .= $sSep.'?';
            $sSep = ', ';
            $aPdoValue[] = $sValue;
        }
        $sInsert .= ')';
        $sValues .= ')';
        $oCommand = $this->oConnection->prepare($sInsert . $sValues);
        $oCommand->execute($aPdoValue);

        return $this->oConnection->lastInsertId();
    }

    public function update($aValues, $aWhere)
    {
        ;
    }

    public function delete($aWhere)
    {
        $sDelete = 'DELETE FROM ' . $this->qTable();
        if ($aWhere) {
            $sDelete .= ' WHERE ';
            $sSep = '';
            $aPdoValue = [];
            foreach ($aWhere as $sColumn => $sValue) {
                $sDelete .= $sSep.$this->q($sColumn) .' = ?';
                $aPdoValue[] = $sValue;
                $sSep = ' AND ';
            }
        }
        $oCommand = $this->oConnection->prepare($sDelete);
        $oCommand->execute($aPdoValue);
        return $oCommand->rowCount();
    }
    /**
     * Simple select helper for an row with basic where support(and values)
     * @return array empty array if not found
     */
    public function fetchRow(array $aWhere = [])
    {
        $sSelect = 'SELECT '.self::STAR . ' FROM ' . $this->qTable();
        if ($aWhere) {
            $sSelect .= ' WHERE ';
            $sSep = '';
            $aPdoValue = [];
            foreach ($aWhere as $sColumn => $sValue) {
                $sSelect .= $sSep.$this->q($sColumn) .' = ?';
                $aPdoValue[] = $sValue;
                $sSep = ' AND ';
            }
        }
        // println($sSelect);
        $oCommand = $this->oConnection->prepare($sSelect);
        $oCommand->execute($aPdoValue);
        return $oCommand->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Read all inspired on Laravel ORM all
     */
    public function all()
    {
        $sSelect = 'SELECT '.self::STAR . ' FROM ' . $this->qTable();
        $oCommand = $this->oConnection->prepare($sSelect);
        $oCommand->execute();
        return $oCommand->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * @param string $sAttribute an attribute to search
     * @param string $sValue value to look for
     * @return bool true is record exists
     */
    public function existsBy($sAttribute, $sValue)
    {
        return (bool) $this->fetchRow([$sAttribute => $sValue]);
    }
    /**
     * Simple select helper for all rows with basic where support(and values)
     * @return array empty array if not found
     */
    public function fetchAll(array $aWhere = [])
    {
        $sSelect = 'SELECT '.self::STAR . ' FROM ' . $this->qTable();
        if ($aWhere) {
            $sSelect .= ' WHERE ';
            $sSep = '';
            $aPdoValue = [];
            foreach ($aWhere as $sColumn => $sValue) {
                $sSelect .= $sSep.$this->q($sColumn) .' = ?';
                $aPdoValue[] = $sValue;
                $sSep = ' AND ';
            }
        }
        // println($sSelect);
        $oCommand = $this->oConnection->prepare($sSelect);
        $oCommand->execute($aPdoValue);
        return $oCommand->fetchAll(PDO::FETCH_ASSOC);
    }
    private function q($sIdentifier)
    {
        $sIdentifier = str_replace('"', '""', $sIdentifier);
        if (strtolower($sIdentifier) != $sIdentifier) {
            $sIdentifier = '"'.$sIdentifier.'"';
        }
        return $sIdentifier;
    }
    private function qTable() { return $this->q($this->sTable); }
    /**
     * Start a transaction
     */
    public function begin()
    {
        $this->oConnection->beginTransaction();
        return $this;
    }
    /**
     * Persist changes to the database
     */
    public function commit()
    {
        $this->oConnection->commit();
        return $this;
    }
}
