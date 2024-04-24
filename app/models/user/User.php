<?php

namespace app\models\user;

use app\models\Model;

class User extends Model
{

    /** @var array $safe Sem atualizar ou criar */
    protected static $safe = ['id', 'created_at', 'updated_at'];

    /** @var string $entity Tabela de banco de dados */
    protected static $entity = 'users';

    /** @var array $required Campos do banco de dados obrigatórios */
    protected static $required = ["first_name", "last_name", "email", "password"];

    /**
     *  PT-BR # Recebe valores padrões necessarios para criar um usuário.
     *  EN # Receives default values needed to create a user.
     *  @param string $firstName
     *  @param string $lastName
     *  @param string $email
     *  @param string $password
     *  @param string $document
     *  @return User|null
     */
    public function bootstrap(
        string $firstName, 
        string $lastName, 
        string $email,
        string $password, 
        string $document): User|null
    {  
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->document = $document;
        return $this;
    }

    /**
     *  PT-BR # Busca simples no banco de dados.
     *  EN # Simple database search.
     *  @param string $terms
     *  @param string $params
     *  @param string $columns
     *  @return User|null
     */
    public function find(string $terms, string $params, string $columns = "*"): User|null
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        
        if ($this->fail() || ! $find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    /**
     *  PT-BR # Busca na base de dados com o parametro de id com ou sem colunas específica.
     *  EN # Database search with the id parameter with or without specific columns.
     *  @param int $id
     *  @param string $columns
     *  @return null|User
     */
    public function findById(int $id, string $columns = '*'): User|null
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    /**
     *  PT-BR # Busca na base de dados com o parametro de email com ou sem colunas específica.
     *  EN # Search in the database with the email parameter with or without specific columns.
     *  @param string $email
     *  @param string $columns
     *  @return null|User
     */
    public function findByEmail(string $email, string $columns = '*'): User|null
    {
       return $this->find("email = :email", "email={$email}, $columns");
    }

    /**
     *  PT-BR # Retorna uma busca na base de dados com limites, offset e colunas se setado.
     *  EN # Returns a search in the database with limits, offset and columns if set.
     *  @param int $limit
     *  @param int $offset
     *  @param string $columns
     *  @return null|array
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = '*'): array|null
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :l OFFSET :o", "l={$limit}&o={$offset}");
        
        if ($this->fail() || ! $all->rowCount()) {
            return null;
        }

        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    /**
     *  PT-BR # Modificar um usuário na base de dados.
     *  EN # Modify a user in the database.
     *  @param array $params
     *  @param string $email
     *  @return User|null
     */
    public function modify(string $email, array $params): User|null
    {
        $findUser = $this->findByEmail($email);

        if ($this->fail() || $findUser == null) {
            $this->message = 'Nenhum usuário com o e-mail informado encontrado!';
            return null;
        }

        $update = $this->update($this::$entity, $findUser->safe(), $findUser->id, $params);
        $this->message = 'Usuário atualizado com sucesso';
        return $this;
    }

    /**
     *  PT-BR # Tenta cadastrar um novo usuário na base de dados.
     *  EN # Try to register a new user in the database.
     *  @return User|null
     */
    public function save(): User|null
    {

        if (! $this->required()) {
            $this->message->warning("Nome, sobrenome, email e senha são obrigatórios");
            return null;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return null;
        }

        if (!is_passwd($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return null;
            
        } else {
            $this->password = passwd($this->password);
        }

        /** Atualizando um usuário existente */
        if (empty($this->id)) {
            $userId = $this->id;

            if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}"))
            {
                $this->message->warning("O e-mail informado já está cadastrado");
                return null;
            }

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$userId}");

            if ($this->fail()) {
                $this->message->error("Erro ao atualizar, verifique os dados");
                return null;
            }
        }

        /** Criando um novo usuário */
        if (empty($this->id)) {
            if ($this->findByEmail($this->email)) {
                $this->message->warning("O e-mail informado já está cadastrado!");
                return null;
            }

            $userId = $this->create(self::$entity, $this->safe());

            if ($this->fail()) {
                $this->message->error("Erro ao cadastrar, verifique os dados!");
                return null;
            }
        }

        $this->data = ($this->findById($userId))->data();
        return $this;
    }

    /**
     *  PT-BR # Com base no id, deleta o usuário na base de dados.
     *  EN # Based on the id, delete the user from the database.
     *  @return User|null
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
}