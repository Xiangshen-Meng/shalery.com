<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ConnpassLoader extends Command {

	protected $CONNPASS_ID = 1;

	protected $CONNPASS_URL = 'http://connpass.com/api/v1/event/';

	protected $CONNPASS_DIC = array(
		'event_id',
		'keyword',
		'keyword_or',
		'ym',
		'ymd',
		'nickname',
		'owner_nickname',
		'series_id',
		'start',
		'order',
		'count',
		'format'
		);

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dataloader:connpass';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh Connpass data using connpass API';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$log = new Logger('name');
		$log->pushHandler(new StreamHandler('/var/log/dataloader/' . date('Ymd') . '.log', Logger::INFO));

		// Update Last Month data
		$last_month_str = date('Ym', strtotime('first day of -1 month'));
		$this->loadByMonth($last_month_str);
		$log->info('Updated Last Month data - ' . $last_month_str);

		sleep(60);

		// Update This Month data
		$this_month_str = date('Ym', strtotime('first day of +0 month'));
		$this->loadByMonth($this_month_str);
		$log->info('Updated This Month data - ' . $this_month_str);

		sleep(60);

		// Update Next Month data
		$next_month_str = date('Ym', strtotime('first day of +1 month'));
		$this->loadByMonth($next_month_str);
		$log->info('Updated Next Month data - ' . $next_month_str);

		sleep(60);

		// Update Two Month later data
		$two_month_later_str = date('Ym', strtotime('first day of +2 month'));
		$this->loadByMonth($two_month_later_str);
		$log->info('Updated Two Month Later data - ' . $two_month_later_str);

		sleep(60);

		// Update Three Month later data
		$three_month_later_str = date('Ym', strtotime('first day of +3 month'));
		$this->loadByMonth($three_month_later_str);
		$log->info('Updated Three Month Later data - ' . $three_month_later_str);

		$log->info('[Done] Update All Done');

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */

	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

	/**
	 * Using connpass API to get data (BASIC)
	 *
	 * @return array
	 */

	public function connpass($option = array())
	{
		$url = $this->getURL($option, $this->CONNPASS_URL, $this->CONNPASS_DIC);

		if (!$url)
			return NULL;

		$raw_str = file_get_contents($url);

		if (!$raw_str)
			return NULL;

		$raw_json = json_decode($raw_str, true);

		return $raw_json;
	}

	public function loadByMonth($month_str)
	{

		$this->loadByOption(array('ym' => $month_str, 'count' => 50));

	}

	/**
	 * Get month data from Connpass using ym
	 *
	 * @return string
	 */

	public function loadByMonthFromMY($month, $year)
	{
		$month_str = sprintf('%d%02d', $year, $month);

		$this->loadByOption(array('ym' => $month_str, 'count' => 50));

	}

	/**
	 * Get month data from Connpass using ymd (NOT IN USE)
	 *
	 * @return string
	 */

	private function loadByMonthFromDate($month, $year)
	{
		$days_num = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$day_str = '';

		for ($day=1; $day <= $days_num; $day++) {

			$day_str = sprintf('%d%02d%02d', $year, $month, $day);

			$this->loadByOption(array('ymd' => $day_str, 'count' => 50));

			// $this->info('Connpass Data Update with ' . $day_str);
		}

	}

	/**
	 * Get All the data by option from Connpass
	 *
	 * @return string
	 */

	public function loadByOption($option = array())
	{

		do {

			$ret_json = $this->connpass($option);

			if (!$ret_json) {

				Log::error('Get Empty JSON From connpass!', array('context' => $option));

				return;
			}

			$this->saveAllEvents($ret_json);

			$has_more = ($ret_json['results_start'] + $ret_json['results_returned'] -1 < $ret_json['results_available']);

			$option['start'] = $ret_json['results_start'] + $ret_json['results_returned'];

		} while ($has_more);

	}

	/**
	 * Make access URL
	 *
	 * @return string
	 */
	private function getURL($option, $basic_url, $dictionary)
	{
		$parameter_str = '';

		foreach ($option as $key => $value) {

			if (!in_array($key, $dictionary)) {
				return NULL;
			}

			if ($parameter_str) {
				$parameter_str = $parameter_str . '&' . $key . '=' . $value;
			}
			else {
				$parameter_str = '?' . $key . '=' . $value;
			}
		}

		return $basic_url . $parameter_str;
	}

	/**
	 * Save All events data by the given json array
	 *
	 * @return string
	 */

	private function saveAllEvents($connpass_json)
	{
		foreach ($connpass_json['events'] as $event_json) {

			$this->saveEvent($event_json);

		}
	}

	private function saveEvent($event_json)
	{
		if ($event_json['event_type'] == "advertisement" || !$event_json['description']) {
			return;
		}

		$event = Sevent::where('event_id', $event_json['event_id'])->where('provider_id', $this->CONNPASS_ID)->first();

		if (!$event) {
			$event = new Sevent;
		}

		$event->event_id		= $event_json['event_id'];
		$event->provider_id		= $this->CONNPASS_ID;
		$event->title			= $event_json['title'];
		$event->address			= $event_json['address'] ?: '';
		$event->url				= $event_json['event_url'];
		$event->lat				= $event_json['lat'] ?: '';
		$event->lon				= $event_json['lon'] ?: '';
		$event->user_limit		= $event_json['limit'] ?: 0;
		$event->user_ticket		= $event_json['accepted'] ?: 0;
		$event->user_wait		= $event_json['waiting'] ?: 0;
		$event->start_time		= $event_json['started_at'] ?: 0;
		$event->end_time		= $event_json['ended_at'] ?: 0;
		$event->update_time		= $event_json['updated_at'];
		$event->description		= $event_json['description'] ?: '';

		$event->save();
	}
}
