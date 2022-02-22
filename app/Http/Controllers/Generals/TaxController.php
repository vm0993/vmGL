<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\TaxRequest;
use App\Core\Repositories\General\TaxRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    use Response;
    protected $taxRepository;

    public function __construct(TaxRepository $taxRepository)
    {
        //$this->middleware('auth');
        $this->taxRepository = $taxRepository;
    }

    public function index()
    {
        $results = $this->taxRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.tax.index',compact('results'));
        }

        return view('generals.tax.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Pajak Baru';
        $purchAccount = getAccountByType(6);
        $salesAccount = getAccountByType(11);
        return view('generals.tax.create',compact('result','title','purchAccount','salesAccount'));
    }

    public function store(TaxRequest $request)
    {
        $this->taxRepository->create($request);
        return redirect()->route('taxes.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result = $this->taxRepository->findById($id);
        $title = 'Edit Pajak';
        $purchAccount = getAccountByType(6);
        $salesAccount = getAccountByType(11);
        return view('generals.tax.create',compact('result','title','purchAccount','salesAccount'));
    }

    public function update(TaxRequest $request, $id)
    {
        $this->taxRepository->update($request, $id);
        return redirect()->route('taxes.index');
    }

    public function destroy($id)
    {
        //
    }
}
