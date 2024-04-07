<?php

namespace app\models;

use core\Connect;

abstract class Model
{   
    /** @var object|null */
    protected $data;

    /** @var \PDOException|null */
    protected $fail;

    /** @var string|null */
    protected $message;

    protected static $safe;


    /**
     *  PT-BR # Interceptar valores e atribuir ao data do model.
     *  EN # Intercept values and assign to model data.
     */
    public function __set($name, $value)
    {
        if(empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     *  PT-BR # Verificando a existência de propriedades.
     *  EN # Checking for the existence of properties.
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

     /**
     *  PT-BR # Interceptando dados.
     *  EN # Intercepting data.
     */
     public function __get($name)
     {
        return ($this->data->$name ?? null);
     }

    /**
     *  PT-BR # Retornando dados.
     *  EN # Return data.
     *  @return object|null
     */
    public function data(): object|null
    {
        return $this->data;
    }

    /**
     *  PT-BR # Exceção que captura os erros.
     *  EN # Exception that catches errors.
     *  @return \PDOException|null
     */
    public function fail(): \PDOException|null
    {
        return $this->fail;
    }

    /**
     *  PT-BR # Retorno de mensagens.
     *  EN # Message return.
     *  @return string|null
     */
    public function message(): string|null
    {
        return $this->message;
    }

    /**
     *  PT-BR # Criando usuário com base nos dados informados.
     *  EN # Creating user based on the data entered.
     *  @param string $entity
     *  @param array $data
     *  @return int|null
     */
    protected function create(string $entity, array $data): int|null
    {

        try {

            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::load()->prepare("INSERT INTO {$entity} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));

            return Connect::load()->lastInsertId();

        } catch (\PDOException $exception) {
         
            $this->fail = $exception;
            return null;
            
        }

    }

    /**
     *  PT-BR # Consulta na base de dados.
     *  EN # Database query.
     *  @param string $query
     *  @param string|array $params
     *  @return \PDOStatement|null
     */
    protected function read(string $query, string|array $params = null): \PDOStatement|null
    {

        try {

            $stmt = Connect::load()->prepare($query);

            if($params) {

                parse_str($params, $params);
                
                foreach ($params as $key => $value) {
                    $type = (is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                    $stmt->bindValue(":{$key}", $value, $type);
                }

            }

            $stmt->execute();
            return $stmt;

        } catch (\PDOException $exception) {
            
            $this->fail = $exception;
            return null;

        }

    }

    /**
     *  PT-BR # Atualização na base de dados.
     *  EN # Database update.
     *  @param string $entity
     *  @param int $id
     *  @param array $data
     *  @param array $params
     *  @return int|null Retorna um número inteiro ou nulo
     */
    protected function update(string $entity, int $id, array $data, array $params): int|null
    {
        try {

            $dataSet = [];
            foreach ($data as $bind => $value) {
                $dataSet[] = "{$bind} = :{$bind}";
            }
            
            $dataSet = implode(", ", $dataSet);
            
            $stmt = Connect::load()->prepare("UPDATE {$entity} SET {$dataSet} WHERE id = {$id}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            
            return ($stmt->rowCount() ?? 1); 


        } catch (\PDOException $exception) {
            
            $this->fail = $exception;
            return null;

        }
    }

    /**
     *  PT-BR # Apaga uma informação na base de dados.
     *  EN # Deletes information from the database.
     *  @param string $entity
     *  @param string $terms
     *  @param string|array $params
     *  @return int|null
     */
    protected function delete(string $entity, string $terms, string|array $params): int|null
    {

        try {

            $stmt = Connect::load()->prepare("DELETE FROM {$entity} WHERE {$terms}");
            parse_str($params, $params);
            $stmt->execute($params);

            return ($stmt->rowCount() ?? 1);
            
        } catch (\PDOException $exception) {
            
            $this->fail = $exception;
            return null;

        }

    }
    
    /**
     *  PT-BR # Dados que não podem ser alterados.
     *  EN # Data that cannot be changed.
     *  @return array|null Retorna um array ou um nulo
     */
    public function safe(): array|null
    {
        $safe = (array) $this->data;
        foreach (static::$safe as $unset) {
            unset($safe[$unset]);
        }

        return $safe;
    }

    /**
     *  PT-BR # Filtro para recebimento de dados externos.
     *  EN # Filter for receiving external data.
     *  @param array $data
     *  @return array|null Retorna um array ou um nulo
     */
    private function filter(array $data): array|null
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }

        return $filter;
    }
}
