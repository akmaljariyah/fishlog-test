<?php

namespace App\Abstracts;

use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Job
{
    use Jobs;
    
    protected $model;

    protected $request;

    public function __construct(...$arguments)
    {
        $this->booting(...$arguments);
        $this->bootCreate(...$arguments);
        $this->booted(...$arguments);
    }

    public function booting(...$arguments): void
    {
        //
    }

    public function bootCreate(...$arguments): void
    {
        $request = $this->getRequestInstance($arguments[0]);
        if ($request instanceof Request) {
            $this->request = $request;
        }
    }

    public function booted(...$arguments): void
    {
        //
    }

    public function getRequestInstance($request)
    {
        if (!is_array($request)) {
            return $request;
        }

        $class = new class() extends Request {};

        return $class->merge($request);
    }
}
