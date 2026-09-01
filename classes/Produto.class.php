<?php
class Produto{
    private $id_produto;
    private $nome;
    private $descricao;
    private $valor;
    private $pdo;

    public function conecta(){
        $dns = "mysql:dbname=loja_etim;host=localhost";
        $user = "root";
        $pass = "";
        try {
            $this->pdo = new PDO($dns, $user, $pass);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function enviarProduto($nome, $descricao, $valor, $fotos = array()){
        //inserir Produto na tabela produtos
        //================================
        $sql = "INSERT INTO produtos SET descricao = :d, nome_produto = :n, valor = :v";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":d", $descricao);
        $sql->bindValue(":n", $nome);
        $sql->bindValue(":v", $valor);

        $isOk = $sql->execute();

        if($isOk == true){
            $id_produto = $this->pdo->lastInsertId();
        }

        //inserir Imagem na tabela imagens
        //================================
        if(count($fotos) > 0){
            for($i = 0; $i < count($fotos); $i++){
                $nome_foto = $fotos[$i];

                $sql = "INSERT INTO imagens (nome_imagem, fk_id_produto) values (:n, :fk)";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":n", $nome_foto);
                $sql->bindValue(":fk", $id_produto);

                $isOk = $sql->execute();
            }
        }

        return $isOk;
    }

    public function buscarProdutos() {
        //busca cada produto e a primeira imagem para usar de capa
        $sql = "SELECT p.id_produto, p.nome_produto, p.descricao, p.valor,
                       (SELECT i.nome_imagem FROM imagens i WHERE i.fk_id_produto = p.id_produto LIMIT 1) AS capa
                FROM produtos p";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProdutosPorId($id) {
        //busca os dados do produto
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $produto = $sql->fetch(PDO::FETCH_ASSOC);

        //busca todas as imagens desse produto
        $sql = "SELECT nome_imagem FROM imagens WHERE fk_id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $produto['imagens'] = $sql->fetchAll(PDO::FETCH_COLUMN);

        return $produto;
    }
}