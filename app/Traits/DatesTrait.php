<?php

namespace App\Traits;

use App\Models\Office;
use App\Models\Transaction;

trait DatesTrait{

    public function getMaxTimeForTransactionOffice($officeId){
        return Office::find($officeId)->transactions->max('minutes');
    }

}
