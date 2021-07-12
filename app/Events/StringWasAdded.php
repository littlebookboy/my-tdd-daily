<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class StringWasAdded
{
    use SerializesModels;

    /**
     * @var int
     */
    public $sum;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sum)
    {
        $this->sum = $sum;
    }
}
