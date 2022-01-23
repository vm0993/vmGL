<?php

namespace App\Http\Controllers\Api\v1\Accounting;

use App\Http\Controllers\Controller;
use App\Repositories\General\CurrenciesRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    use Response;
    protected $models;

    public function __construct(CurrenciesRepository $currencyRepository)
    {
        $this->models = $currencyRepository;
    }

    public function index()
    {
        $currencys = $this->models->getAll();

        return response()->json($currencys);
    }
}
