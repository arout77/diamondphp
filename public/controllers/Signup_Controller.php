<?php
namespace Web\Controller;
use Hal\Controller\Base_Controller;

class Signup_Controller extends Base_Controller {
	/**
	 * @param $app
	 */
	public function __construct($app) {
		parent::__construct($app);

		$this->template->assign('signup_email_confirmation', $this->config->setting('signup_email_confirmation'));
		$this->template->assign('site_url', $this->config->setting('site_url'));
	}

	/**
	 * @return mixed
	 */
	public function index() {
		$data = [];

		if ($_POST) {
			$data = $this->toolbox('sanitize')->xss($_POST);
		}
		$this->template->assign('data', $data);

		if ($this->route->action != 'complete') {
			return $this->template->assign('content', 'forms/signup_form.tpl');
		}

		if ($this->route->action == 'complete') {
			$this->template->assign('email_confirm', $this->config->setting('signup_email_confirmation'));
		}
		return $this->template->assign('content', 'static/signup_complete.tpl');
	}

	public function complete() {
		return self::index();
	}

	public function register() {
		$this->index();
	}

	public function signup_validate() {

		if (!$_POST || empty($_POST)) {
			$this->redirect('signup');
		}
		# Begin form validation by sanitizing all $_POST submitted
		$form = $this->toolbox('sanitize')->xss($_POST);

		/*
			 * Now set validation rules for each field.
			 * Pass the sanitized $form variable above
			 * to the function below
		*/
		$check_if_valid = $this->toolbox('validate')->form($_POST, [

			'username'         => 'required|alpha_numeric',
			'password'         => 'required|max_len,40|min_len,6',
			'confirm_password' => 'required|contains,' . $_POST['password'] . '',
			'first_name'       => 'required|valid_name',
			'last_name'        => 'required|valid_name',
			'email'            => 'required|valid_email',
			'dob'              => 'required',
			'city'             => 'required',
			'state'            => 'required|exact_len,2',
			'zip'              => 'required|numeric|exact_len,5',
			'phone'            => 'numeric|exact_len, 10',
		]);

		/*
			 * Now validate the form according to the rules set above.
			 * If $check_if_valid is true, form was successfully validated,
			 * so we can go ahead and process the data.
			 * Otherwise, display the errors encountered.
		*/
		if ($check_if_valid === TRUE) {
			$this->log->save('$check_if_valid returned true', 'signup-errors.log');
			# valid submission -- continue
			/*
			if( isset( $form['phone'] ) && ! empty( $form['phone'] ) ) {
			// NOTE THE []; $form must be converted to array
			foreach($form as $form[]) {

			$phone = $this->toolbox('formatter')->PhoneNumber($form['phone']);
			}
			}
			 */
			try {

				if ($this->model('Member')->create_member($form)) {
					# Send confirmation email
					if ($this->config->setting('signup_email_confirmation') === TRUE) {
						$confirmation_code = md5($form['email']);
						$to                = $form['email'];
						$recipient_name    = $form['first_name'] . ' ' . $form['last_name'];
						$from              = $this->config->setting('site_name');
						$reply_to          = $this->config->setting('site_email');
						$subject           = "Confirm your registration on {$from}";
						$message           = "<p>To activate your account, please visit the following link:</p>" .
							"<p>{$this->config->setting('site_url')}signup/activate/{$confirmation_code}</p>" .
							"<p>If you believe you received this email by mistake, no further action is necessary.</p>";

						$this->toolbox('email')->send($to, $recipient_name, $from, $reply_to, $subject, $message);
						$this->log->save('mail apparently was successful', 'signup-errors.log');
					}
				}

				$this->redirect('signup/complete');
			} catch (\Exception $e) {
				$this->log->save($e->getMessage(), 'signup_errors.log');
				$this->signup();
			}

		} else {
			// Did not pass validation -- Show errors
			echo '<div class="alert alert-danger">';
			foreach ($check_if_valid as $invalid) {
				echo '<i class="fa fa-exclamation-triangle"></i> ' . $invalid . '<br>';
			}

			echo '</div>';
			$this->load->view('forms/signup_form', $data = $form);
		}
	}
}
