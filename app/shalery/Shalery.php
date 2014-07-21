<?php

class Shalery {

	public static function loadRecentEventData()
	{
		$events = Sevent::recent()->get()->toArray();

		foreach ($events as $key => $event) {

			$html = strip_tags($event['description']);
			$plain_text = html_entity_decode($html, ENT_QUOTES);

			$events[$key]['start_month'] = date('n', strtotime($event['start_time']));
			$events[$key]['start_date'] = date('j', strtotime($event['start_time']));
			$events[$key]['start_time'] = date('H:i', strtotime($event['start_time']));
			$events[$key]['description'] = mb_substr($plain_text, 0, 140) . ". . .";
			$events[$key]['address'] = $event['address'] ? $event['address'] : "未公開";
		}

		return $events;
	}

	public static function loadMonthEventData($year, $month)
	{
		$events = Sevent::monthEvent($year, $month)->get()->toArray();

		$retEvents = array();
		foreach ($events as $key => $event) {

			$html = strip_tags($event['description']);
			$plain_text = html_entity_decode($html, ENT_QUOTES);

			$events[$key]['start_time'] = date('Y-m-d H:i', strtotime($event['start_time']));
			$events[$key]['description'] = mb_substr($plain_text, 0, 140) . ". . .";
			$events[$key]['address'] = $event['address'] ? $event['address'] : "未公開";

			$event_date = date('j', strtotime($event['start_time']));

			if (!array_key_exists($event_date, $retEvents)) {
				$retEvents[$event_date] = array($events[$key]);
			}else {
				array_push($retEvents[$event_date], $events[$key]);
			}
		}

		return $retEvents;
	}

}