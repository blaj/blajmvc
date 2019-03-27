<?php

namespace Blaj\BlajMVC\Core;

use Blaj\BlajMVC\Core\DB;
use Blaj\BlajMVC\Core\IModel;
use PDO;
use ReflectionClass;

abstract class Repository
{
    protected $tableName;

    protected $modelName;

    public function __construct()
    {
        $class = new ReflectionClass($this);

        if (empty($this->tableName))
            $this->tableName = substr(strtolower($class->getShortName()), 0, -10);

        if (empty($this->modelName))
            $this->modelName = substr($class->getShortName(), 0, -10) . 'Model';
    }

    public function __call($name, $arguments)
    {
        $class = new ReflectionClass(get_called_class());
        $properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            if ($property->getName() == 'tableName')
                continue;

            if ($property->getName() == 'modelName')
                continue;

            if (substr($name, 0, 6) == 'findBy' && strlen($name) > 6) {
                if (ucfirst($property->getName()) == substr($name, 6, strlen($name))) {
                    $key = substr($name, 6, strlen($name));
                    return $this->findBy([$key => $arguments[0]]);
                }
            } else if (substr($name, 0, 9) == 'findOneBy' && strlen($name) > 9) {
                if (ucfirst($property->getName()) == substr($name, 9, strlen($name))) {
                    $key = substr($name, 9, strlen($name));
                    return $this->findOneBy([$key => $arguments[0]]);
                }
            } else if (substr($name, 0, 11) == 'findCountBy' && strlen($name) > 11) {
                if (ucfirst($property->getName()) == substr($name, 11, strlen($name))) {
                    $key = substr($name, 11, strlen($name));
                    return $this->countBy([$key => $arguments[0]]);
                }
            }
        }

        return null;
    }

    private function mapToModel(array $object): IModel
    {
        $className = 'Blaj\\BlajMVC\\Model\\'. $this->modelName;
        $class = new $className;

        foreach ($object as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($class, $setter))
                $class->{$setter}($value);
        }

        return $class;
    }

    public function findBy(array $options)
    {
        $result = [];

        $whereClause = '';;
        $whereConditions = [];

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`'.$key.'` = "'.$value.'"';
            }
            $whereClause = " WHERE ".implode(' AND ', $whereConditions);
        }

        $queryStatement = 'SELECT * FROM ' . $this->tableName . $whereClause;

        $query = DB::getInstance()->query($queryStatement);
        $items = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $result[] = $this->mapToModel($item);
        }

        return $result;
    }

    public function findOneBy(array $options)
    {
        $result = $this->findBy($options);

        return $result[0];
    }

    public function findAll()
    {
        return $this->findBy([]);
    }

    public function countBy(array $options)
    {
        return null;
    }

    public function countAll()
    {
        return $this->countBy([]);
    }

    public function remove(Imodel $model)
    {
        $class = new ReflectionClass($model);

        $sqlQuery = 'DELETE FROM ' . $this->tableName . ' WHERE id = :id';
        $stmt = $this->bindValue($sqlQuery, $class, $model);

        $result = $stmt->execute();

        return $result;
    }

    public function update(IModel $model)
    {
        $columnNames = '';

        $setConditions = [];

        $class = new ReflectionClass($model);
        $properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if (!empty($property->getValue($model))) {
                $setConditions[] = $property->getName() . ' = :' . $property->getName();
            }

            $columnNames = implode(', ', $setConditions);
        }

        $sqlQuery = 'UPDATE ' . $this->tableName . ' SET ' . $columnNames . ' WHERE id = :id';
        $stmt = $this->bindValue($sqlQuery, $class, $model);
        $result = $stmt->execute();

        return $result;
    }

    public function add(IModel $model)
    {
        $columnNames = '';
        $values = '';

        $setConditions = [];
        $valuesConditions = [];

        $class = new ReflectionClass($model);
        $properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE);

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if (!empty($property->getValue($model))) {
                $setConditions[] = $property->getName();
                $valuesConditions[] = ':' . $property->getName();
            }

            $columnNames = implode(', ', $setConditions);
            $values = implode(', ', $valuesConditions);
        }

        $sqlQuery = 'INSERT INTO `'. $this->tableName .'` ('. $columnNames.') VALUES ('. $values. ');';
        $stmt = $this->bindValue($sqlQuery, $class, $model);
        $result = $stmt->execute();

        return $result;
    }

    private function bindValue(string $sqlQuery, ReflectionClass $class, $model)
    {
        $properties = $class->getProperties(\ReflectionProperty::IS_PRIVATE);
        $stmt = DB::getInstance()->prepare($sqlQuery);

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if (!empty($property->getValue($model))) {
                $valueType = gettype($property->getValue($model));

                switch ($valueType) {
                    case 'boolean':
                        $type = PDO::PARAM_BOOL;
                        break;
                    case 'integer':
                        $type = PDO::PARAM_INT;
                        break;
                    case 'null':
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }

                $stmt->bindValue(':' . $property->getName(), $property->getValue($model), $type);
            }
        }

        return $stmt;
    }
}
