<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('template'); //Carrega a biblioteca de template
		$this->load->model('produtos_Price_model');
    }
	//
	//Carregar views
	//
    public function index(){
		$tipo_acesso = $this->session->userdata('tipo_acesso');
		if($tipo_acesso == 1){
			$dados = [
				'title' => 'Cliente'
			];
			$this->template->load('clientePaginaPrincipal', $dados);
		} else {
			$this->output->set_status_header(404);
			$this->load->view('error_403');
			return;
		}
    }

	public function carrinho(){
		$tipo_acesso = $this->session->userdata('tipo_acesso');
		if($tipo_acesso == 1){
			$dados = [
				'title' => 'Carrinho'
			];
			$this->template->load('clienteCarrinho', $dados);
		} else {
			$this->output->set_status_header(404);
			$this->load->view('error_403');
			return;
		}
	}
	//
	//Template
	//
	public function ajax_quantidadeCarrinho(){
		$id_usuario = $this->input->get();

		$resultado = $this->produtos_Price_model->quantidadeCarrinho($id_usuario);

		echo json_encode($resultado);
	}
	//
	//Cliente
	//
	public function ajax_listarProdutos(){
		$resultado = $this->produtos_Price_model->listarTodosProdutos();

		echo json_encode($resultado);
	}

	public function ajax_adicionarItemAoCarrinho(){
		$dados = $this->input->post();

		$resultado = $this->produtos_Price_model->adicionarItemAoCarrinho($dados);

		echo json_encode($resultado);
	}
	//
	//Cliente/carrinho
	//
	public function ajax_listarCarrinho(){
		$id_usuario = $this->input->get();

		$resultado = $this->produtos_Price_model->listarCarrinho($id_usuario);

		echo json_encode($resultado);
	}

	public function ajax_alterarQuantidade(){
		$dados = $this->input->post();

		$resultado = $this->produtos_Price_model->alterarQuantidade($dados);

		echo json_encode($resultado);
	}

	public function ajax_removerProduto(){
		$dados = $this->input->post();

		$resultado = $this->produtos_Price_model->removerProduto($dados);

		echo json_encode($resultado);
	}

	public function ajax_comprar(){
		$dados = $this->input->post();

		$resultado = $this->produtos_Price_model->comprar($dados);

		echo json_encode($resultado);
	}
}