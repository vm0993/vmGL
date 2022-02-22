<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CurrencyRequest;
use App\Core\Repositories\General\CurrenciesRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    use Response;
    //use UseTenantConnection;
    protected $currenciesRepository;

    public function __construct(CurrenciesRepository $currenciesRepository)
    {
        /* $this->database = request()->subdomain;
        Config::set('database.connections.tenant.database',$this->database);
        DB::reconnect('tenant'); */
        //$this->middleware('auth');
        $this->currenciesRepository = $currenciesRepository;
    }

    public function index()
    {
        $results = $this->currenciesRepository->getAll();
        if (!$results->isEmpty()){
            return view('accounting.currency.index',compact('results'));
        }
        return view('accounting.currency.index',compact('results'));
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
