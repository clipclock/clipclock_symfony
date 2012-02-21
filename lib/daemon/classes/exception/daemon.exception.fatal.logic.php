<?php
/**daemonExceptionFatalBase
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 18.11.11
 * Time: 13:42
 * To change this template use File | Settings | File Templates.
 */
 
class daemonExceptionFatalLogic extends daemonExceptionFatalBase{
	protected $code = _EXCEPTION_FATAL_LOGIC;
	public function __construct()
	{
		System_Daemon::warning(var_export($this, true));
	}
}
