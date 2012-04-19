<?php
/**
 * Created by JetBrains PhpStorm.
 * User: en0ne
 * Date: 19.04.12
 * Time: 23:14
 * To change this template use File | Settings | File Templates.
 */

class myTooltipStoreFilter extends sfFilter
{
	public function execute($filterChain)
	{
		if ($this->isFirstCall())
		{
			$userId = $this->getContext()->getUser()->getId();

			if ($userId)
			{
				$request = $this->getContext()->getRequest();
				$tooltips = substr($request->getCookie('tooltips'), 0, 255);
				$tooltipsInSession = $this->getContext()
						->getUser()
						->getAttribute('tooltips');

				if ($tooltips)
				{
					if ($request->getCookie('tooltips-changed'))
					{
						if ($tooltipsInSession != $tooltips){

							$profile = SfGuardUserProfilePeer::retrieveByPK($userId);

							if ($profile->getTooltips() != $tooltips){

								$profile->setTooltips($tooltips);
								$profile->save();

								$this->getContext()
										->getUser()
										->setAttribute('tooltips', $tooltips);
							}
						}

						$this->getContext()
								->getResponse()
								->setCookie('tooltips-changed', null);
					}

				} else {

					if (!$tooltipsInSession && $tooltipsInSession !== '')
					{
						$profile = SfGuardUserProfilePeer::retrieveByPK($userId);

						$this->getContext()
								->getUser()
								->setAttribute('tooltips', $profile->getTooltips());

						$this->getContext()
								->getResponse()
								->setCookie('tooltips', urlencode($profile->getTooltips()), '2037-01-01');

					} else {

						$this->getContext()
								->getResponse()
								->setCookie('tooltips', urlencode($tooltipsInSession), '2037-01-01');
					}
				}
			}
		}

		$filterChain->execute();
	}
}