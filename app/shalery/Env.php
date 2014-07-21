<?php

class Env {

	public static function viewNameFrontend($viewName)
	{
		if (Agent::isMobile()) {
			return "frontend.mobile." . $viewName;
		}else {
			return "frontend.website." . $viewName;
		}
	}

	public static function makeGoogleMapUrl($lat, $lon, $address)
	{
		$url = 'https://maps.google.com/maps/api/staticmap?language=ja&size=360x360';

		if ($address) {

			$eng_pattern = '/\([^\)]*\)/';
			$jap_pattern = '/（[^）]*）/';
			$q_addr = preg_replace($eng_pattern, '', $address);
			$q_addr = preg_replace($jap_pattern, '', $q_addr);

			$url = $url . "&center=" . $q_addr;
			$url = $url . "&markers=" . $q_addr;
			return $url;
		}

		if ($lat && $lon) {
			$url = $url . "&center=" . $lat . ',' . $lon;
			$url = $url . "&markers=" . $lat . ',' . $lon;
			return $url;
		}

		return null;
	}
}