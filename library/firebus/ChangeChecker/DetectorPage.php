<?php

namespace firebus\ChangeChecker;

/**
 * DetectorPage
 */
class DetectorPage extends ADetector {

	public function detect() {
		\firebus\Logger\Logger::log(\firebus\Logger\Logger::DEBUG, "processing " . $this->resource);
		$lastChange = $this->retrieveLastChange();
		$results = array();
		$page = @file_get_contents($this->resource);

		if ($page === FALSE) {
			\firebus\Logger\Logger::log(\firebus\Logger\Logger::WARNING, "failed to get page at " . $this->resource);
		} else {
			$comparison = \stephen_morley\diff\Diff::toString(\StephenMorley\Diff\Diff::compare($lastChange, $page));
			$lines = explode('\n', $comparison);
			$diff = '';
			foreach ($lines as $line) {
				if (strpos($line, '+') === 0) {
					$diff .= "$line\n";
				}
			}
			if ($diff) {
				$results[] = array('text' => $diff, 'url' => $this->resource);
				$this->storeLastChange($page);
			}
		}
		return $results;
	}
}