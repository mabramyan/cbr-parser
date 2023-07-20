<?php

namespace App\Queue\Messages;

class CurrencyMessage extends BaseMessage
{
    public string $name = 'currency';
    public string $date;

    public function __construct($date)
    {
        $this->date = $date;
        parent::__construct();
    }


}
