<?php
//dezend by http://www.yunlu99.com/ QQ:270656184
class CommonAction extends Action
{
	protected $uid = 0;
	protected $member = array();
	protected $_CONFIG = array();
	protected $shop_id = 0;
	protected $shop = array();
	protected $shopcates = array();

	protected function _initialize()
	{
		$this->uid = getuid();

		if (!empty($this->uid)) {
			$this->member = d('Users')->find($this->uid);
		}

		if ((strtolower(MODULE_NAME) != 'login') && (strtolower(MODULE_NAME) != 'public')) {
			if (empty($this->uid)) {
				header('Location: ' . u('login/index'));
				exit();
			}

			if ($this->uid == 1) {
				if ($this->isPost()) {
					$this->baoError('演示站不提供数据操作!请不要恶意修改演示数据！');
				}

				if (strtolower(ACTION_NAME) == 'delete') {
					$this->baoError('演示站不能删除数据！');
				}

				if (strtolower(ACTION_NAME) == 'audit') {
					$this->baoError('演示站不能审核数据');
				}
			}

			$this->shop = d('Shop')->find(array(
	'where' => array('user_id' => $this->uid, 'closed' => 0, 'audit' => 1)
	));

			if (empty($this->shop)) {
				$this->error('该用户没有开通商户', u('login/index'));
			}

			$this->shop_id = $this->shop['shop_id'];
			$this->assign('SHOP', $this->shop);
		}

		$this->_CONFIG = d('Setting')->fetchAll();
		define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
		$this->assign('CONFIG', $this->_CONFIG);
		$this->assign('MEMBER', $this->member);
		$this->shopcates = d('Shopcate')->fetchAll();
		$this->assign('shopcates', $this->shopcates);
		$this->assign('ctl', strtolower(MODULE_NAME));
		$this->assign('act', ACTION_NAME);
		$this->assign('today', TODAY);
		$this->assign('nowtime', NOW_TIME);
	}

	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '')
	{
		parent::display($this->parseTemplate($templateFile), $charset, $contentType, $content = '', $prefix = '');
	}

	private function parseTemplate($template = '')
	{
		$depr = c('TMPL_FILE_DEPR');
		$template = str_replace(':', $depr, $template);
		$theme = $this->getTemplateTheme();
		define('NOW_PATH', BASE_PATH . '/themes/' . $theme . 'Shangjia/');
		define('THEME_PATH', BASE_PATH . '/themes/default/Shangjia/');
		define('APP_TMPL_PATH', __ROOT__ . '/themes/default/Shangjia/');

		if ('' == $template) {
			$template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
		}
		else if (false === strpos($template, '/')) {
			$template = strtolower(MODULE_NAME) . $depr . strtolower($template);
		}

		$file = NOW_PATH . $template . c('TMPL_TEMPLATE_SUFFIX');

		if (file_exists($file)) {
			return $file;
		}

		return THEME_PATH . $template . c('TMPL_TEMPLATE_SUFFIX');
	}

	private function getTemplateTheme()
	{
		define('THEME_NAME', 'default');

		if ($this->theme) {
			$theme = $this->theme;
		}
		else {
			$theme = d('Template')->getDefaultTheme();

			if (c('TMPL_DETECT_THEME')) {
				$t = c('VAR_TEMPLATE');

				if (isset($_GET[$t])) {
					$theme = $_GET[$t];
				}
				else if (cookie('think_template')) {
					$theme = cookie('think_template');
				}

				if (!in_array($theme, explode(',', c('THEME_LIST')))) {
					$theme = c('DEFAULT_THEME');
				}

				cookie('think_template', $theme, 864000);
			}
		}

		return $theme ? $theme . '/' : '';
	}

	protected function baoMsg($message, $jumpUrl = '', $time = 3000, $callback = '', $parent = true)
	{
		$parents = ($parent ? 'parent.' : '');
		$str = '<script>';
		$str .= $parents . 'bmsg("' . $message . '","' . $jumpUrl . '","' . $time . '","' . $callback . '");';
		$str .= '</script>';
		exit($str);
	}

	protected function baoOpen($message, $close = true, $style)
	{
		$str = '<script>';
		$str .= 'parent.bopen("' . $message . '","' . $close . '","' . $style . '");';
		$str .= '</script>';
		exit($str);
	}

	protected function baoSuccess($message, $jumpUrl = '', $time = 3000, $parent = true)
	{
		$this->baoMsg($message, $jumpUrl, $time, '', $parent);
	}

	protected function baoErrorJump($message, $jumpUrl = '', $time = 3000)
	{
		$this->baoMsg($message, $jumpUrl, $time);
	}

	protected function baoError($message, $time = 3000, $yzm = false, $parent = true)
	{
		$parent = ($parent ? 'parent.' : '');
		$str = '<script>';

		if ($yzm) {
			$str .= $parent . 'bmsg("' . $message . '","",' . $time . ',"yzmCode()");';
		}
		else {
			$str .= $parent . 'bmsg("' . $message . '","",' . $time . ');';
		}

		$str .= '</script>';
		exit($str);
	}

	protected function checkFields($data = array(), $fields = array())
	{
		foreach ($data as $k => $val) {
			if (!in_array($k, $fields)) {
				unset($data[$k]);
			}
		}

		return $data;
	}

	protected function ipToArea($_ip)
	{
		return iptoarea($_ip);
	}
}

?>
