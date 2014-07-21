<?php

class Sevent extends Eloquent {

	protected $table = 'events';

	protected $primaryKey = 'shalery_id';

	public function scopeRecent($query)
	{
		return $query
		->where('start_time', '>', date('Y-m-d H:i:s'))
		->select(
			array('shalery_id', 'title', 'address', 'description', 'start_time'))
		->orderBy('start_time', 'asc')
		->take(20);
	}

	public function scopeMonthEvent($query, $year, $month)
	{
		$first_second = date('Y-m-d H:i', mktime(0, 0, 0, $month, 1, $year));
		$last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$last_second = date('Y-m-d H:i', mktime(23, 59, 59, $month, $last_day, $year));

		return $query
		->whereBetween('start_time', array($first_second, $last_second))
		->select(
			array('shalery_id', 'title', 'address', 'description', 'start_time'))
		->orderBy('start_time', 'asc');
	}
}
