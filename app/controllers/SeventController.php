<?php

class SeventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getApiRecentEvent()
	{
		$events = Shalery::loadRecentEventData();
		return Response::json($events);
	}

}
