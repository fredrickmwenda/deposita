<?php

namespace App\Helpers;

use Carbon\Carbon;

class DatesValidator
{

    /**
     * Get day from date
     * @param Carbon $date
     */

    public static function validate($from, $to)
    {
        # code...
        $to = Carbon::create($to);
        $from = Carbon::create($from);
        $now = Carbon::now();
        //dd($to,$from, $now);

        //if from is in the future
        if ($from->greaterThan($now)) {
            return 'From date must be in the past.';
        }

         //if from is greater than to date
         if ($from->greaterThan($to)) {
            return 'From date must be less than to date.';
        }

        if ($to->greaterThan($now)) {
            return 'To date must be equal or less than now';
        }

        return "success";
    }



}
