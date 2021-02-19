<?php
namespace Web\Controller;
use App\Controller\Base_Controller;

class Login_Controller extends Base_Controller {

	public function index() {
		if ($this->config->setting['login_math'] === "TRUE") {
			$data['a']      = rand(1, 5);
			$data['b']      = rand(1, 5);
			$data['answer'] = $data['a'] * $data['b'];
			$data['route']  = $this->route->param1;
			$data['uri']    = $_SERVER['REQUEST_URI'];
			$login_math     = $this->config->setting['login_math'];

			$this->template->assign('a', $data['a']);
			$this->template->assign('b', $data['b']);
			$this->template->assign('answer', $data['answer']);
			$this->template->assign('route', $data['route']);
			$this->template->assign('login_math', $login_math);
			$this->template->assign('uri', $data['uri']);
		}

		$this->template->display('template/head.tpl');
		$this->template->display('template/body.tpl');
		$this->template->display('forms/login_form.tpl');
		$this->template->display('template/footer.tpl');
	}

	public function login_validate() {
		$login = $this->plugin('login');
		$login->validate($_POST);
	}

	public function logout() {

		$this->redirect('home/index');
		$this->session->flush();
		exit;
	}

}
