<?php

namespace firebus\ChangeChecker;

/**
 * Description of SchedulerTwitter
 */
class SchedulerTwitter extends AScheduler {

	const LIMIT_PER_HOUR = 150;
	
	public function schedule() {
		$thisRunTime = time();
		$lastRunTime = $this->getRunTime();
		\firebus\logger\Logger::log(\firebus\Logger\Logger::DEBUG, "twitter lastRunTime: $lastRunTime");
		$runsPerHour = self::LIMIT_PER_HOUR / $this->detectorCount;
		\firebus\logger\Logger::log(\firebus\Logger\Logger::DEBUG, "twitter runsPerHour: $runsPerHour");
		
		if ($thisRunTime - $lastRunTime > 60 * 60 / $runsPerHour) {
			$this->setRunTime($thisRunTime);
			return TRUE;
		} else {
			\firebus\logger\Logger::log(\firebus\Logger\Logger::DEBUG, "it's too early to schedule twitter");
			return FALSE;
		}
	}
}