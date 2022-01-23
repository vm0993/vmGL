<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ServiceRequest;
use App\Repositories\General\ServicesRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    use Response;
    private $serviceRepository;

    public function __construct(ServicesRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;    
    }
    
    public function index()
    {
        $services = $this->serviceRepository->getAll();

        if (!$services->isEmpty()){
            return view('generals.services.service',compact('services'));
        }
        return view('generals.services.service');
    }

    public function create()
    {
        $result = '';
        $title = 'Ledger Baru';
        return view('generals.ledgers.create',compact('result','title'));
    }

    public function store(ServiceRequest $request)
    {
        DB::beginTransaction();
        try {
            //store here
            $service = $this->serviceRepository->create($request);

            DB::commit();
            return response()->json(['result' => $service], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function edit($id)
    {
        $service = $this->serviceRepository->findById($id);
        return response()->json(['result' => $service], 201);
    }

    public function update(ServiceRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            //update here
            $service = $this->serviceRepository->update($request, $id);

            return response()->json(['result' => $service], 201);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $service = $this->serviceRepository->delete($id);
        return response()->json(['result' => $service], 201);
    }
}
