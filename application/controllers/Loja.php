<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loja extends CI_Controller {
	//
	//
	//Inicializar classe
	//
	//
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('check');
		$this->load->helper('url');
		$this->load->library('template'); //Carrega a biblioteca de template
		$this->load->model('produtos_Price_model');
    }
	//
	//
	//Carregar views
	//
	//
    public function index(){
		$tipo_acesso = $this->session->userdata('tipo_acesso');
		if($tipo_acesso == 2){
			$dados = [
				'title' => 'Loja'
			];
			$this->template->load('lojaPaginaPrincipal', $dados);
		} else {
			$this->output->set_status_header(404);
			$this->template->view('error_403');
			return;
		}
    }

	public function produtos(){
		$dados = [
			'title'=> 'Produtos'
			];
		$this->template->load('lojaProdutos', $dados);
	}

	public function vendas(){
		$dados = [
			'title'=> 'Vendas'
			];
		$this->template->load('lojaVendas', $dados);
	}
	//
	//
	//Loja/produtos
	//
	//
	public function ajax_listarProdutos(){
		$id_usuario = $this->input->get();

		$resultado = $this->produtos_Price_model->listarProdutosPorLoja($id_usuario);

		echo json_encode($resultado);
	}

	public function ajax_cadastrarProduto(){
		$dados = $this->input->post();

		$resultado['sucesso'] = $this->produtos_Price_model->inserirProduto($dados);

		echo json_encode($resultado);
	}

	public function ajax_editarProduto(){
		$dados = $this->input->post();

		$resultado['sucesso'] = $this->produtos_Price_model->editarProduto($dados);

		echo json_encode($resultado);
	}

	public function ajax_deletarProduto(){
		$dados = $this->input->post();

		$resultado = $this->produtos_Price_model->excluirProduto($dados);

		echo json_encode($resultado);
	}
	//
	//
	//Loja/vendas
	//
	//
	public function ajax_listarVendas(){
		$dados = $this->input->get();

		$resultado = $this->produtos_Price_model->listarVendas($dados);

		echo json_encode($resultado);
	}
}