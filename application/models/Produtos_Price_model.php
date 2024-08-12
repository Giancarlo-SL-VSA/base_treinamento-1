<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Produtos_Price_model extends CI_Model {
	//
	//
	//Template
	//
	//
	public function quantidadeCarrinho($id_usuario){
		$this->db->select('sum(ci.quantidade) AS quantidade');
		$this->db->from('carrinho_item ci');
		$this->db->join('carrinho c','ci.id_carrinho = c.id_carrinho');
		$this->db->join('venda v', 'c.id_carrinho = v.id_carrinho', 'left');
		$this->db->where('c.id_usuario', $id_usuario['id_usuario']);
		$this->db->where('v.id_carrinho IS NULL');
		$resultado = $this->db->get()->row_array();
		
		if($resultado == null) return 0;

		return $resultado;
	}
	//
	//
	//Loja/produtos
	//
	//
	public function listarProdutosPorLoja($dados){
		$id_usuario = $dados['id_usuario'];
		$this->db->select('*');
		$this->db->from('produto');
		$this->db->where('id_usuario_loja', $id_usuario);

		$resultado = $this->db->get()->result_array();

		foreach ($resultado as $row) {
			if($row == null) return false;
		}
		return $resultado;
	}

	public function inserirProduto($produto){
		if($this->db->insert('produto', $produto)){
			return true;
		} else {
			return false;
		}
	}
	
	public function editarProduto($dados){
		$this->db->where('id_produto', $dados['id_produto']);
		$this->db->update('produto', $dados);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function excluirProduto($dados){
		$id_produto = $dados['id_produto'];

		$this->db->select('1');
		$this->db->from('carrinho_item');
		$this->db->where('id_produto', $id_produto);
		$comprado = $this->db->get()->row_array();
		
		if(!$comprado == null) return false;

		$this->db->where('id_produto', $id_produto);
		$this->db->delete('produto');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	//
	//
	//Loja/vendas
	//
	//
	public function listarVendas($dados){
		$id_usuario = $dados['id_usuario'];
		$data_inicial = $dados['data_inicial'];
		$data_final = $dados['data_final'];

		$this->db->select('p.id_produto AS id_produto, p.nome AS produto, u.nome_usuario AS cliente, (p.preco * ci.quantidade) AS valor, v.data_venda AS data');
		$this->db->from('produto p');
		$this->db->join('carrinho_item ci','p.id_produto = ci.id_produto');
		$this->db->join('carrinho c','ci.id_carrinho = c.id_carrinho');
		$this->db->join('usuario u','c.id_usuario = u.id_usuario');
		$this->db->join('venda v','c.id_carrinho = v.id_carrinho');
		$this->db->where('p.id_usuario_loja', $id_usuario);

		if($data_inicial != null && $data_final != null){
			$this->db->where('DATE(v.data_venda) >= ', $data_inicial);
			$this->db->where('DATE(v.data_venda) <= ', $data_final);
		}
		$resultado = $this->db->get()->result_array();

		foreach ($resultado as $row) {
			if($row == null) return false;
		}
		return $resultado;
	}
	//
	//
	//Cliente
	//
	//
	public function listarTodosProdutos(){
		$this->db->where('estoque > 0');
		$resultado = $this->db->get('produto')->result_array();
		
		foreach ($resultado as $row) {
			if($row == null) return false;
		}
		return $resultado;
	}

	public function adicionarItemAoCarrinho($dados){
		$id_usuario = $dados['id_usuario'];
		$id_produto = $dados['id_produto'];
		$quantidade = $dados['quantidade'];

		//pegar carrinho sem venda caso exista e adicionar um novo caso não exista
		$this->db->select('c.id_carrinho AS id_carrinho');
		$this->db->from('carrinho c');
		$this->db->join('venda v','c.id_carrinho = v.id_carrinho','left');
		$this->db->where('c.id_usuario', $id_usuario);
		$this->db->where('v.id_carrinho IS NULL');
		
		$carrinho_sem_venda = $this->db->get()->row_array();

		if($carrinho_sem_venda == null) {
			$this->db->insert('carrinho', array('id_usuario'=> $id_usuario));
			$id_carrinho = $this->db->insert_id();
		} else {
			$id_carrinho = $carrinho_sem_venda['id_carrinho'];
		}
		
		//adicionar item ao carrinho sem venda
		return $this->db->insert('carrinho_item', array(
			'id_carrinho' => $id_carrinho,
			'id_produto' => $id_produto,
			'quantidade' => $quantidade
			)
		);
	}
	//
	//
	//Cliente/carrinho
	//
	//
	public function listarCarrinho($dados){
		$id_usuario = $dados['id_usuario'];

		$this->db->select('*');
		$this->db->from('produto p');
		$this->db->join('carrinho_item ci','p.id_produto = ci.id_produto');
		$this->db->join('carrinho c', 'ci.id_carrinho = c.id_carrinho');
		$this->db->join('venda v', 'c.id_carrinho = v.id_carrinho', 'left');
		$this->db->where('c.id_usuario', $id_usuario);
		$this->db->where('v.id_carrinho IS NULL');
		return $this->db->get()->result_array();
	}

	public function alterarQuantidade($dados){
		$id_carrinho_item = $dados['id_carrinho_item'];
		$valor = $dados['valor'];

		$this->db->set('quantidade', 'quantidade + ' . $valor, false);
		$this->db->where('id_carrinho_item', $id_carrinho_item);
		$this->db->update('carrinho_item');

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function removerProduto($dados){
		$this->db->where('id_carrinho_item', $dados['id_carrinho_item']);
		if($this->db->delete('carrinho_item')){
			return true;
		} else {
			return false;
		}
	}

	public function comprar($dados){
		$id_usuario = $dados['id_usuario'];

		//pegar carrinho sem venda
		$this->db->select('carrinho.id_carrinho AS id_carrinho');
		$this->db->from('carrinho');
		$this->db->join('venda','carrinho.id_carrinho = venda.id_carrinho','left');
		$this->db->where('carrinho.id_usuario', $id_usuario);
		$this->db->where('venda.id_carrinho IS NULL');
		$select = $this->db->get()->row_array();

		if($this->db->insert('venda', array('id_carrinho'=> $select['id_carrinho']))){
			$this->db->select('*');
			$this->db->from('carrinho_item');
			$this->db->where('id_carrinho', $select['id_carrinho']);
			$carrinho_items = $this->db->get()->result_array();

			foreach($carrinho_items as $row){
				$this->db->where('id_produto', $row['id_produto']);
				$this->db->set('estoque', 'estoque - '.$row['quantidade'], false);
				$this->db->update('produto');
			}
		}
	}
}
