<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Event extends Entity {

	protected function _getName() {
        
        return 'hitest';
    }

    protected function _getTimeList() {

		$duration = array();
		$start = strtotime('00:00');
		$end = strtotime('24:00');
		for ($halfhour = $start; $halfhour <= $end; $halfhour = $halfhour + 30 * 60) {
			$duration[date('H:i', $halfhour).':00'] = date('h:i A', $halfhour);
		}

		return $duration;
	}
}
