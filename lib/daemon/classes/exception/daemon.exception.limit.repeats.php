<?php
/**
 * Created by JetBrains PhpStorm.
 * User: madesst
 * Date: 10.11.11
 * Time: 17:23
 * To change this template use File | Settings | File Templates.
 */

final class daemonExceptionLimitRepeats extends daemonExceptionUnrepeatableBase {
	protected $code = _EXCEPTION_LIMIT_REPEATS;
}
