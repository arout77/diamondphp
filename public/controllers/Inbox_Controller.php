<?php
namespace Web\Controller;
use Hal\Controller\Base_Controller;

class Inbox_Controller extends Base_Controller
{
	# for the check_new() method
	public $new_message = [];

	public function __construct($app)
	{
		parent::__construct($app);

		if ($this->session->verify('email') === FALSE)
		{
			return $this->redirect('login');
		}

		$this->template->assign('inbox_limit', $this->config->setting('inbox_limit'));
		$this->template->assign('count_all', $this->toolbox('messenger')->count_all());
		$this->template->assign('count_unread', $this->toolbox('messenger')->count_unread());
		$this->template->assign('all_messages', $this->toolbox('messenger')->view_all());
		$this->template->assign('format', $this->toolbox('formatter'));
	}

	public function __toString()
	{
		return 'Inbox_Controller';
	}

	public function index()
	{
		# Show entire inbox
		$data['inbox_limit']  = $this->toolbox('messenger')->max_limit();
		$data['all_messages'] = $this->toolbox('messenger')->view_all();

		if ($data['all_messages'] !== FALSE)
		{
			$this->template->assign('content', 'inbox/view_all_messages.tpl');
		}
		else
		{
			$this->template->assign('content', 'inbox/inbox.tpl');
		}

	}

	/*-----------------------------------------------------------
		 *  Check for new messages
		 *  Do not access directly; this is for AJAX notifications
	*/
	public function check_new()
	{
		$this->load->view('inbox/index');
	}

	public function reply($reply)
	{
		# Reply to message
		$data     = $this->toolbox('sanitize')->xss($reply);
		$reply_to = $data['reply_to'];
		$subject  = $data['subject'];
		$message  = $data['message'];

		if ($this->toolbox('messenger')->send($subject, $message, $reply_to))
		{
			return TRUE;
		}

		return FALSE;
	}

	public function send()
	{
		# Send a message to a user
		$data['recipient']      = $this->route->param1;
		$data['recipient_info'] = $this->model('Member')->profile_data($data['recipient']);
		$data['history']        = $this->toolbox('messenger')->view_message_history($data['recipient']);
		foreach ($data['history'] as $prev => $v)
		{
			$date[] = $this->toolbox('formatter')->datetime($prev);
		}
		$this->template->assign('recipient', $data['recipient']);
		$this->template->assign('recipient_info', $data['recipient_info']);
		$this->template->assign('history', $data['history']);
		$this->template->assign('history', $date);
		$this->template->assign('content', 'inbox/send.tpl');
	}

	public function unread()
	{
		$this->template->assign('unread_messages', $this->toolbox('messenger')->view_unread());
		$this->template->assign('content', 'inbox/unread.tpl');
	}

	public function view()
	{
		if ($_POST)
		{
			$data       = $this->toolbox('sanitize')->xss($_POST);
			$send_reply = self::reply($data);

			if ($send_reply)
			{
				$data['saved']          = 'Message sent to ' . $data['reply_to'];
				$data['saved_message']  = 'To keep your account secure, it is recommended to change your passwords at least every 90 days, and create a unique password for different sites.';
				$data['data_saved_btn'] = '<a href="#" data-dismiss="alert" class="btn btn-dark btn-sm">Close</a>';

				$this->template->assign('message', $data['message']);
				$this->template->assign('message_sent', $data['saved']);
				$this->template->assign('data_saved_message', $data['saved_message']);
				$this->template->assign('data_saved_btn', $data['data_saved_btn']);
				$this->template->assign('view_mail', $data);

				$this->redirect('inbox');
			}
		}
		# Display selected message
		$data = $this->toolbox('messenger')->view();

		if ($data)
		{
			$this->template->assign('view_mail', $data);
			$this->template->assign('content', 'inbox/view.tpl');
		}
		else
		{
			$this->template->assign('content', 'inbox/notfound.tpl');
		}

	}

	#  Icon table toggle functions
	public function flag_important()
	{
		# Toggle flag message as important / normal
		$this->toolbox('messenger')->toggle_star($_POST['mid']);
	}

	public function flag_read()
	{
		# Toggle flag message as read / unread
		$this->toolbox('messenger')->toggle_read($_POST['mid']);
	}

	public function flag_delete()
	{
		# Toggle flag message as read / unread
		$this->toolbox('messenger')->flag_delete($_POST['mid']);
	}

	public function total()
	{
		return $this->toolbox('messenger')->count_all();
	}

	public function total_unread()
	{
		return $this->toolbox('messenger')->count_unread();
	}

	public function all()
	{
		$this->template->assign('content', 'inbox/view_all_messages.tpl');
		return $this->toolbox('messenger')->count_all();
	}

}
