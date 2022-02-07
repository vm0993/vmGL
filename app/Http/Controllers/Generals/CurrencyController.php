<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CurrencyRequest;
use App\Repositories\General\CurrenciesRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    use Response;
    protected $currenciesRepository;

    public function __construct(CurrenciesRepository $currenciesRepository)
    {
        //$this->middleware('auth');
        $this->currenciesRepository = $currenciesRepository;
    }

    public function index()
    {
        $currencys = $this->currenciesRepository->getAll();

        if (!$currencys->isEmpty()){
            return view('accounting.currency.index',compact('currencys'));
        }
        return $this->responseDataNotFound('Data yang diminta tidak tersedia');
    }

    public function create()
    {
        $result = '';
        $title = 'Mata Uang Baru';
        return view('accounting.currency.create',compact('result','title'));
    }

    public function store(CurrencyRequest $request)
    {
        $this->currenciesRepository->create($request);

        return redirect()->route('currencies.index');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $result = $this->currenciesRepository->findById($id);
        $title = 'Edit Mata Uang';
        return view('accounting.currency.create',compact('result','title'));
    }

    public function update(CurrencyRequest $request, $id)
    {
        $this->currenciesRepository->update($request, $id);
        return redirect()->route('currencies.index');
    }

    public function destroy($id)
    {
        //
    }
}
