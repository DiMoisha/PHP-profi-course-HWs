<?php
namespace App\Models\Abstracts;

use App\Lib as lib;
use Exception;

/**
 * Created by PhpStorm.
 * User: Dmitrii Karasev
 * Date: 02.03.2022
 */
abstract class Model {
    protected static $table;
    protected static $properties = [
        'id' => [
            'type' => 'int',
            'autoincrement' => true,
            'readonly' => true,
            'unsigned' => true
        ],
        'created_at' => [
            'type' => 'datetime',
            'readonly' => true,
        ],
        'updated_at' => [
            'type' => 'datetime',
            'readonly' => true,
        ],
        'status' => [
            'type' => 'int',
            'size' => 2,
            'unsigned' => true
        ]
    ];

    public function __construct(array $values)
    {
        static :: setProperties();

        foreach ($values as $key => $value) {
            $this -> $key = $value;
        }
    }

    /**
     * Вызывается в конструкторе и при генерации, чтобы дополнить базовый набор свойств
     */
    protected static function setProperties()
    {
        return true;
    }

    /**
     * @throws Exception
     */
    public final static function generate()
    {
        if (self :: tableExists()) throw new Exception('Table already exists');
        static :: setProperties();
        $query = 'CREATE TABLE ' . static :: $table . ' (';
        foreach (static::$properties as $property => $params) {
            if (!isset($params['type'])) {
                throw new Exception('Property ' . $property . 'has no type');
            }
            $query .= ' `' . $property . '`';

            $query .= ' ' . $params['type'];
            if ( isset($params['size'])) {
                $query .= '(' .$params['size'] .')';
            }

            if( isset ($params['unsigned']) && $params['unsigned']) {
                $query .= ' UNSIGNED';
            }

            if( isset ($params['autoincrement']) && $params['autoincrement']) {
                $query .= ' AUTO_INCREMENT';
            }
            $query .= ',' . "\n";

        }
        $query .= ' PRIMARY KEY (`id`))';
        lib\DBContext :: getInstance() -> Query($query);
        return true;
    }

    /**
     * @throws Exception
     */
    public function __get($name)
    {
        $this->checkProperty($name);
        $return = null;

        switch(static :: $properties['type']) {
            case 'int' :
                return (int)$this -> $name;
            // break;
            default :
                return (string)$this -> $name;
            // break;
        }
    }

    /**
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $this -> checkProperty($name);
        switch(static :: $properties[$name]['type']) {
            case 'int' :
                $this -> $name = (int)$value;
                break;
            default :
                $this -> $name = (string)$value;
                break;
        }
        if (isset(static :: $properties[$name]['size'])) {
            $this -> $name = mb_substr($this -> $name, 0, static :: $properties[$name]['size']);
        }
    }

    protected final static function tableExists() : bool
    {
        return count(lib\DBContext :: getInstance() -> select('SHOW TABLES LIKE "' . static::$table . '"')) > 0;
    }

    /**
     * @throws Exception
     */
    protected final function checkProperty($name)
    {
        if (!isset(static :: $properties[$name])) {
            throw new Exception('Undefined property ' . $name);
        }
        if (!isset(static :: $properties[$name]['type'])) {
            throw new Exception('Undefined type for property ' . $name);
        }
    }
}