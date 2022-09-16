<?php

namespace App\Events;

use App\Abstracts\Event;
use App\Models\Jurnal;

class JurnalCreated extends Event
{
    public $jurnal;

    /**
     * Create a new event instance.
     *
     * @param $jurnal
     */
    public function __construct(Jurnal $jurnal)
    {
        $this->jurnal = $jurnal;
    }
}
