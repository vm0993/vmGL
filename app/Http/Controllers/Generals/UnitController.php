<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\UnitRequest;
use App\Core\Repositories\General\UnitRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use Response;
    protected $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        //$this->middleware('auth');
        $this->unitRepository = $unitRepository;
    }

    public function index()
    {
        $results = $this->unitRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.units.index',compact('results'));
        }

        return view('generals.units.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Satuan Baru';
        return view('generals.units.create',compact('result','title'));
    }

    public function store(UnitRequest $request)
    {
        $this->unitRepository->create($request);
        return redirect()->route('units.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result = $this->unitRepository->findById($id);
        $title = 'Edit Satuan';
        return view('generals.units.create',compact('result','title'));
    }

    public function update(UnitRequest $request, $id)
    {
        $this->unitRepository->update($request, $id);
        return redirect()->route('units.index');
    }

    public function destroy($id)
    {
        //
    }
}
