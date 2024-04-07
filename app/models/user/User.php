<?php

namespace app\models\user;

use app\models\Model;

class User extends Model
{

    /** @var array $safe sem atualizar ou criar */
    protected static $safe = ['id', 'created_at', 'updated_at'];

    /** @var string $entity tabela de banco de dados */
    protected static $entity = 'users';

    /**
     *  PT-BR # Recebe valores padrões necessarios para criar um usuário.
     *  EN # Receives default values needed to create a user.
     *  @param string $firstName
     *  @param string $lastName
     *  @param string $email
     *  @param string $document
     *  @return User|null Retorna um objeto user ou nulo
     */
    public function bootstrap(string $firstName, string $lastName, string $email, string $document): User|null
    {  
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->document = $document;
        return $this;
    }

    /**
     *  PT-BR # Busca na base de dados com o parametro de id com ou sem colunas específica.
     *  EN # Database search with the id parameter with or without specific columns.
     *  @param int $id
     *  @param string $columns
     *  @return null|User Retorna um objeto do tipo user com a consulta ou retorna um nulo 
     */
    public function load(int $id, string $columns = '*'): User|null
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id = :id", "id={$id}");
        
        
        if ($this->fail() || ! $load->rowCount()) {
            
            $this->message = 'Usuário não encontrado com base no ID informado!';
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    /**
     *  PT-BR # Busca na base de dados com o parametro de email com ou sem colunas específica.
     *  EN # Search in the database with the email parameter with or without specific columns.
     *  @param string $email
     *  @param string $columns
     *  @return null|User Retorna um objeto do tipo user com a consulta ou retorna um nulo
     */
    public function find(string $email, string $columns = '*'): User|null
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE email = :email", "email={$email}");
        
        if ($this->fail() || ! $find->rowCount()) {

            $this->message = 'Usuário não encontrado com base no email informado!';
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    /**
     *  PT-BR # Retorna uma busca na base de dados com limites, offset e colunas se setado.
     *  EN # Returns a search in the database with limits, offset and columns if set.
     *  @param int $limit
     *  @param int $offset
     *  @param string $columns
     *  @return null|array Retorna um array com a consulta ou um nulo caso não encontra nada
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = '*'): array|null
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :l OFFSET :o", "l={$limit}&o={$offset}");
        
        if ($this->fail() || ! $all->rowCount()) {

            $this->message = 'Nenhum usuário encontrado com base na sua consulta!';
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     *  PT-BR # Modificar um usuário na base de dados.
     *  EN # Modify a user in the database.
     *  @param array $params
     *  @param string $email
     *  @return User|null Retornar um objeto do usuáriou ou nulo
     */
    public function modify(string $email, array $params): User|null
    {

        $findUser = $this->find($email);

        if ($this->fail() || $findUser == null) {
            $this->message = 'Nenhum usuário com o e-mail informado encontrado!';
            return null;
        }

        $update = $this->update($this::$entity, $findUser->id, $findUser->safe(), $params);
        $this->message = 'Usuário atualizado com sucesso';
        return $this;
    }

    /**
     *  PT-BR # Tenta cadastrar um novo usuário na base de dados.
     *  EN # Try to register a new user in the database.
     *  @return User|null Retorna um valor nulo ou o objeto
     */
    public function save(): User|null
    {

        if (! $this->required()) {
            return null;
        }

        /** Atualizando um usuário existente */
        if (empty($this->id)) {
            $userId = $this->id;
        }

        /** Criando um novo usuário */
        if (empty($this->id)) {
            if ($this->find($this->email)) {
                $this->message = "O e-mail informado já está cadastrado!";
                return null;
            }

            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()) {
                $this->message = "Erro ao cadastrar, verifique os dados!";
            }

            $this->message = "Cadastro realizado com sucesso!";
        }

        $this->data = $this->read("SELECT * FROM ". self::$entity . " WHERE id = :id", "id={$userId}")->fetch();
        return $this;
    }

    /**
     *  PT-BR # Com base no id, deleta o usuário na base de dados.
     *  EN # Based on the id, delete the user from the database.
     *  @return User|null Retorna um resultado nulo ou o objeto
     */
    public function destroy(): User|null
    {
        if (! empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message = 'Não foi possível remover o usuário';
            return null;
        }

        $this->message = 'Usuário removido com sucesso!';
        $this->data = null;
        return $this;
    }

    /**
     *  PT-BR # Verifica campos obrigatórios e valida o e-mail.
     *  EN # Checks mandatory fields and validates the email.
     *  @return bool Retorna um true ou false para a validação
     */
    public function required(): bool
    {
        if (empty($this->first_name) ||  empty($this->last_name) || empty($this->email)) {
            $this->message = "Nome, sobrenome e e-mail são obrigatórios";               
            return false;
        }

        if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->message = "O e-mail informado não parece válido";
            return false;
        }

        return true;
    }

}