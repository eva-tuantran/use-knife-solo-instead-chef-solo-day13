<?php
use \Controller\Base_Template;

/**
 * Calendar Controller.
 *
 * @extends  Controller_Base_Template
 */
class Controller_Calendar extends Controller_Base_Template
{
    // settings
    protected $is_navigation = true;
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
        $year = $this->param('year', date('Y'));
        $month = $this->param('month', date('n'));

        $fleamarket_list = \Fleamarket::findByEventDate($year, $month);
        $calendar = $this->buildCalendar($year, $month, array());

        return new Response(View::forge('calendar/month', $calendar));
    }

    /**
     * カレンダー情報を生成する
     *
     * @access private
     * @param int $year 年
     * @param int $month 月
     * @param array $data 年月日データ
     * @return array
     * @author ida
     *
     * @TODO: $dataを渡されたときの処理の追加
     */
    private function buildCalendar(
        $year = null, $month = null, $data = null
    ) {
        !is_int($year) && $year = (int)$year;
        !is_int($month) && $month = (int)$month;

        $year == null && $year = date('Y');
        $month == null && $month = date('n');
        $day = date('j');

        strlen($year) < 4 and $year = (int)str_pad($year, 4, 0, STR_PAD_RIGHT);
        strlen($year) > 4 and $year = (int)substr($year, 0, 4);
        $month > 12 and $month = 12;
        $month < 1 and $month = 1;

        $daysInMonth = $this->getDaysInMonth($month, $year);
        $day > $daysInMonth && $day = $daysInMonth;
        $day < 1 and $day = 1;

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->days_in_month = $daysInMonth;
        $this->action_url = \Config::get('base_url') . 'calendar/';

        // set data
        $data = array(
            'days' => $this->getDays(),
            'month' => $this->getMonth(),
            'year' => $this->year,
            'calendar' => $this->buildMonth(),
            'is_navigation' => $this->is_navigation,
            'nav_next' => ($this->is_navigation) ? $this->createNavigation('next') : null,
            'nav_prev' => ($this->is_navigation) ? $this->createNavigation('prev') : null,
        );

        return $data;
    }

    /**
     * 月カレンダーを生成する
     *
     * @access private
     * @return array
     * @author ida
     */
    private function buildMonth()
    {
        $data = array();

        //set vars for loop
        $day_of_month = 0;
        $week = 1;
        $first_weekday = $this->getFirstWeekdayOfMonth(
            $this->month, $this->year
        );

        // start data loop
        while ($day_of_month <= $this->days_in_month) {
            // loop through days in week - Sun = 1
            for ($day_of_week = 1; $day_of_week <= 7; $day_of_week++) {
                // if add 1 to start month counter when week day = first day
                if ($day_of_week == $first_weekday && $day_of_month == 0) {
                    $day_of_month++;
                }

                if ($day_of_month > 0 && $day_of_month <= $this->days_in_month) {
                    $date = $this->year . '/' . $this->month . '/' . $day_of_month;
                    $data[$week][$day_of_week] = array(
                        'day' => $day_of_month,
                        'date' => $date,
                    );
                    $day_of_month++;
                } else {
	                // blank cells
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
     * @param int $month 月
     * @param int $year 年
     * @return int
     * @author ida
     *
     */
    private static function getDaysInMonth($month, $year)
    {
        return date('t', mktime(0, 0, 0, $month, 1, $year));
    }

	/**
	 * 対象年月の1日の曜日を取得する
	 *
     * @access private
     * @param int $month 月
     * @param int $year 年
     * @return int
     * @author ida
	 */
	private static function getFirstWeekdayOfMonth($month, $year)
	{
		return date('N', mktime(0, 0, 0, $month, 1, $year));
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

        return $this->action_url . $year . '/' . $month;
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
