<?php

include '../vendor/autoload.php';

use Recurr\Rule;
use Recurr\Transformer\ArrayTransformer;
use Recurr\Transformer\Constraint\AfterConstraint;
use Recurr\Transformer\Constraint\BetweenConstraint;

function p($data, $exit = true)
{
	echo '<pre />';
	print_r($data);
	if ($exit) exit;
}

class Repeat
{
	private $rule;
	private $repeat_rule;

	public function __construct($rule)
	{
		$this->rule = $rule;
	}

	public function test()
	{
		$rule = $this->rule;
		// 14,15,16,17,18,19,20
		$start = '2015-11-17';
		$end   = '2015-11-18';
		$rule  = $rule . ';DTSTART=' . $start . ';DTEND=' . $end;
		$this->getRule($rule);
		$repeat_date = $this->getTransformer();
		return $repeat_date;
	}

	public function getRule($rule, $starttime = null, $endtime = null)
	{
		return $this->repeat_rule = new Rule($rule, $starttime, $endtime);
	}

	public function getTransformer($limit = '', $customStart = '', $customEnd = '')
	{
		$transformer = new ArrayTransformer();
		$result      = $transformer->transform($this->repeat_rule, $limit, null, $customStart, $customEnd);
		return $result->toArray();
	}
}

$rule = 'FREQ=WEEKLY;BYDAY=TH,SA;INTERVAL=1';

$repeat = new Repeat($rule);
$date   = $repeat->test();
p($date);