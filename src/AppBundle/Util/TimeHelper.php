<?php

namespace AppBundle\Util;

class TimeHelper {

    public static function getOneDayShift(\DateTime $start)
    {
        $start->setTime(0,0,0);
        $end = clone $start;

        try {
            $end->add(new \DateInterval('P1D'));
        } catch (\Exception $e) {
            return 0;
        }

        return (object) [
            'start' => $start,
            'end' => $end,
        ];
    }

    public static function getLast7Dates()
    {
        $endDate = new \DateTime();
        $endDate->setTime(0,0,0);
        $startDate = clone $endDate;

        try {
            $startDate->sub(new \DateInterval('P7D'));
        } catch (\Exception $e) {
            return 0;
        }

        return (object) [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }

    public static function getTomorrowDates()
    {
        $startDate = new \DateTime();
        $startDate->setTime(0,0,0);

        try {
            $startDate->add(new \DateInterval('P1D'));
        } catch (\Exception $e) {
            return 0;
        }

        $endDate = clone $startDate;

        try {
            $endDate->add(new \DateInterval('P1D'));
        } catch (\Exception $e) {
            return 0;
        }

        return (object) [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }

    public static function getTodayDates()
    {
        $startDate = new \DateTime();
        $startDate->setTime(0,0,0);
        $endDate = clone $startDate;

        try {
            $endDate->add(new \DateInterval('P1D'));
        } catch (\Exception $e) {
            return 0;
        }

        return (object) [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }

    public static function getYesterdayDates()
    {
        $endDate = new \DateTime();
        $endDate->setTime(0,0,0);
        $startDate = clone $endDate;

        try {
            $startDate->sub(new \DateInterval('P1D'));
        } catch (\Exception $e) {
            return 0;
        }

        return (object) [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }
}
