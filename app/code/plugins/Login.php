<?php
namespace App\Plugin;
use App\System\Plugins as Plugin_Core;

class Login extends Plugin_Core {

	/**
	 * @param $formData
	 */
	public function validate($formData) {
		// Begin form validation by sanitizing all $_POST submitted
		$data = $this->plugin('sanitize')->xss($formData);

		if ($this->config->setting['login_math'] === "TRUE") {
			$this->login_validate_math($data);
			$data['math_error_response'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Math answer is incorrect<br></div>';
		}

		if ($this->config->setting['login_math'] === "TRUE" && $this->login_validate_math($data) === FALSE) {
			$this->redirect('login/index/error_math');
		}

		if ($this->config->setting['login_math'] === "FALSE" || ($this->config->setting['login_math'] === "TRUE" && $this->login_validate_math($data) !== FALSE)) {
			// Now we can check the submitted form to see if it is filled out properly
			$check_if_valid = $this->plugin('validate')->form($data, [
				'email'    => 'required',
				'password' => 'required|max_len,100|min_len,6',
			]);

			if ($check_if_valid === FALSE) {

				// Did not pass form validation -- Show errors
				echo '<div class="alert alert-danger">';
				foreach ($check_if_valid as $invalid) {
					echo '<i class="fa fa-exclamation-triangle"></i> ' . $invalid . '<br>';
				}
				echo '</div>';
				$this->load->view('forms/login_form');

			} else {
				// Form is valid -- continue to login query
				$result = $this->model('Member')->check_login($data);

				if ($result == "Account not verified") {
					$this->redirect('login/index/verify');
				} elseif ($result && $result != "Account not verified") {
					// Valid login
					$this->redirect('home');
				} else {
					// Invalid login -- redirect to login error page
					$this->redirect('login/index/error');
				}
			}
		}

	}

	/**
	 * @param $data
	 */
	public function login_validate_math($data) {

		$data['a'] = rand(1, 5);
		$data['b'] = rand(1, 5);

		$response = (int) $data['math'];
		$answer   = (int) $data['math_answer'];

		if ($response !== $answer) {
			// Did not pass validation -- Show errors
			return false;
		}
		return true;
	}

	public function forgot_password() {

		/*
			 *
			 * === Program workflow ===
			 *
			 * When password reset form is submitted, the email address is recorded
			 * into the password_reset table. A sha1 token is then generated and stored
			 * along with it, as well as a Unix timestamp of when the request was made.
			 * The timestamp is necessary as a security precaution -- the user has 24 hours
			 * to reset the password.
			 * An email is then dispatched, providing a link to update their password. The
			 * link simply fetches the email, using the the hash (which is a URL parameter)
			 * as the lookup index.
			 *
		*/
		$form = $this->plugin('sanitize')->xss($_POST);

		$q      = "SELECT username, email, password FROM users WHERE email = ?";
		$result = $this->db->prepare($q);
		$result->execute([$form['email']]);

		if (!empty($result)) {

			foreach ($result as $row) {
				$data['username'] = $row['username'];
				$data['email']    = $row['email'];

				$data['create_token'] = sha1($row['username'] . $row['email'] . time() . '#$!&^*(');
				$data['create_token'] = str_replace('3', '-', $data['create_token']);
				$data['create_token'] = str_replace('9', '_', $data['create_token']);
				$data['create_token'] = urlencode($data['create_token']);

				$q2 = "INSERT INTO password_reset(email, hash, timestamp) VALUES(?, ?, ?)";
				$r  = $this->db->prepare($q2);
				$r->execute([$row['email'], $data['create_token'], time()]);

				$to      = $data['email'];
				$subject = "Did You Forget Your Password?";
				$from    = $this->config->setting('site_name');
				$message = "You (or someone claiming to be you) has requested to reset your profile password on " . $this->config->setting('site_name') . ".<br>
				If you requested your password to be reset, please do so here: " . SITE_URL . 'member/password_reset/' . $data['create_token'] . ".<br>
				If you did not request a password reset, or otherwise feel this is in error, there is no need to do anything. Your password and other information
				is safe, and has not been accessed or changed in any way.";

				$this->plugin('email')->send($to, $data['username'], $from, $this->config->setting('site_email'), $subject, $message);

			}
		}

		$this->load->view('static/forgot_password', $data);
	}

	public function password_reset() {

		$data['token'] = $this->route->param1;

		$q      = "SELECT email, hash, timestamp FROM password_reset WHERE hash = ?";
		$result = $this->db->prepare($q);
		$result->execute([$data['token']]);

		// It is only possible to have one (successful) result.
		// If zero found, it is likely a hack attempt or malformed URL
		// so just redirect them to the original password reset form
		$rows_found = $result->rowCount();

		if ($rows_found == 1) {
			foreach ($result as $row) {

				// 86400 seconds = 24 hours
				// Password must be reset within 24 hours, else must send a new request
				if (time() > ($row['timestamp'] + 86400))
				// More than 24 hours has passed; send new request
				{
					$this->redirect('member/forgot_password/expired');
				} else {

					$this->view('forms/password_reset', $data);
				}
			}
			// End foreach
		} else {
			$this->redirect('member/forgot_password');
			exit;
		} // End if/else

		if ($_POST) {
			// New password submitted
			$form = $this->input->sanitize->form($_POST);
			$this->model('Member')->update_password($_POST['password'], $row['email']);
			$this->redirect('member/login/password_reset_complete');
		}
	}

	public function change_password() {
		if ($_POST) {
			$password  = $_POST['password'];
			$cpassword = $_POST['confirm_password'];
			if ($password !== $cpassword) {
				return FALSE;
			}

			if ($this->model('Member')->update_password($password, $this->toolbox('session')->get('email'))) {
				$data['saved']          = 'Password successfully updated';
				$data['saved_message']  = 'To keep your account secure, it is recommended to change your passwords at least every 90 days, and create a unique password for different sites.';
				$data['data_saved_btn'] = '<a href="#" data-dismiss="alert" class="btn btn-dark btn-sm">Close</a>';
			} else {
				$data['saved']          = 'Problem updating password';
				$data['saved_message']  = 'There was a problem saving your password. Please make sure that your passwords match, and do not contain any illegal characters.';
				$data['data_saved_btn'] = '<a href="#" data-dismiss="alert" class="btn btn-dark btn-sm">Close</a>';
			}

			$this->template->assign('new_pw_saved', $data['saved']);
			$this->template->assign('data_saved_message', $data['saved_message']);
			$this->template->assign('data_saved_btn', $data['data_saved_btn']);
			$this->template->assign('content', 'forms/change_password.tpl');
		} else {
			$this->template->assign('content', 'forms/change_password.tpl');
		}
	}

}