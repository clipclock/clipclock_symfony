<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 25.02.12
 * Time: 14:33
 * To change this template use File | Settings | File Templates.
 */
class HomeFilterForm extends sfForm {

	public function configure() {

		$this->disableCSRFProtection();
	}
}