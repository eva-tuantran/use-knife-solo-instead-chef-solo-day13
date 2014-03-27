<?php
use \Controller\Base_Template;

/**
 * Calendar Controller.
 *
 * @extends  Controller_Base_Template
 */
class Controller_Calendar extends Controller_Base_Template
{
    protected $year;
    protected $month;
    protected $day;
    protected $days_in_month;
    protected $action_url;

    /**
     * 事前処理
     *
     * アクション実行前の共通処理
     *
     * @access public
     * @return void
     * @author ida
     */
    public function before()
    {
        parent::before();
    }

    /**
     * action_index
     *
     * @access public
     * @return void
     * @author ida
     */
    public function action_index()
    {
        $this->year = (int) $this->param('year', date('Y'));
        $this->month = (int) $this->param('month', date('n'));

        if (is_null($this->year) || !is_int($this->year)) {
            $this->year = date('Y');
        }
        if (strlen($this->year) < 4 and $this->year) {
            $this->year = (int) str_pad($this->year, 4, 0, STR_PAD_RIGHT);
        }
        if (strlen($this->year) > 4 and $this->year) {
            $this->year = (int) substr($this->year, 0, 4);
        }

        if (is_null($this->month) || !is_int($this->month)) {
            $this->month = date('n');
        }
        $this->month > 12 and $this->month = 12;
        $this->month < 1 and $this->month = 1;


        $event_dates = \Model_Fleamarket::findByEventDate(
            $this->year, $this->month
        );
        $calendar = $this->buildCalendar($event_dates);

        return new Response(View::forge('calendar/month', $calendar));
    }

    /**
     * カレンダー情報を生成する
     *
     * @access private
     * @param array $event_dates 開催日リスト
     * @return array
     * @author ida
     */
    private function buildCalendar($event_dates = array())
    {
        $this->day = date('j');
        $this->days_in_month = $this->getDaysInMonth();
        $this->action_url = \Config::get('base_url') . 'calendar/';

        $data = array(
            'days' => $this->getDays(),
            'month' => $this->getMonth(),
            'year' => $this->year,
            'calendar' => $this->buildMonth($event_dates),
            'nav_next' => $this->createNavigation('next'),
            'nav_prev' => $this->createNavigation('prev'),
        );

        return $data;
    }

    /**
     * 月カレンダーを生成する
     *
     * @access private
     * @param array $event_dates
     * @return array
     * @author ida
     */
    private function buildMonth($event_dates)
    {
        $data = array();

        $month = str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $day_of_month = 0;
        $week = 1;
        $first_weekday = $this->getFirstWeekdayOfMonth();

        while ($day_of_month <= $this->days_in_month) {
            for ($day_of_week = 1; $day_of_week <= 7; $day_of_week++) {
                if ($day_of_week == $first_weekday && $day_of_month == 0) {
                    $day_of_month++;
                }

                if ($day_of_month > 0 && $day_of_month <= $this->days_in_month) {
                    $day = str_pad($day_of_month, 2, '0', STR_PAD_LEFT);
                    $date = $this->year . '-' . $month . '-' . $day;
                    $is_event = array_key_exists($date, $event_dates);
                    $data[$week][$day_of_week] = array(
                        'date' => $date,
                        'day' => $day_of_month,
                        'is_event' => $is_event,
                    );
                    $day_of_month++;
                } else {
                    $data[$week][$day_of_week] = array(
                        'day' => null,
                        'date' => null,
                    );
                }
            }
            $week++;
        }

        return $data;
    }

    /**
     * 対象年月の日数を取得する
     *
     * @access private
     * @return int
     * @author ida
     *
     */
    private function getDaysInMonth()
    {
        return date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
    }

	/**
	 * 対象年月の1日の曜日を取得する
	 *
     * @access private
     * @return int
     * @author ida
	 */
	private function getFirstWeekdayOfMonth()
	{
		return date('N', mktime(0, 0, 0, $this->month, 1, $this->year));
	}

    /**
     * ナビゲーションの前月・翌月のLINKを生成する
     *
     * @access private
     * @param string $direction
     * @return string
     * @author ida
     *
     */
    private function createNavigation($direction)
    {
        if ($direction == 'next') {
            // next
            $month = $this->month + 1;
            $year = $this->year;
            if ($month > 12) {
                $month = 1;
                $year++;
            }
        } elseif ($direction == 'prev') {
            // prev
            $month = $this->month - 1;
            $year = $this->year;
            if ($month <= 0) {
                $month = 12;
                $year--;
            }
        }

        return $this->action_url . $year . '/' . $month . '/';
    }

    /**
     * 曜日一覧を取得する
     *
     * @access private
     * @return array
     * @author ida
     */
    private function getDays()
    {
        $days = array(
            '1' => '月',
            '2' => '火',
            '3' => '水',
            '4' => '木',
            '5' => '金',
            '6' => '土',
            '7' => '日',
        );

        return $days;
    }

    /**
     * 対象月の名称を取得する
     *
     * @access private
     * @return string
     * @author ida
     */
    private function getMonth()
    {
        $months = array(
            '1' => '1月', '2' => '2月', '3' => '3月',
            '4' => '4月', '5' => '5月', '6' => '6月',
            '7' => '7月', '8' => '8月', '9' => '9月',
            '10' => '10月', '11' => '11月', '12' => '12月',
        );

        return $months[$this->month];
    }
}
