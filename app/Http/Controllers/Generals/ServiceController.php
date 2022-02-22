<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ServiceRequest;
use App\Core\Repositories\General\ServicesRepository;
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
        $results = $this->serviceRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.services.index',compact('results'));
        }
        return view('generals.services.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Service Charges Baru';
        $categories = getCategory();
        $types = getChargeType();
        $wipAccounts = getAccountByType(5);
        $cogsAccounts = getAccountByType(17);
        $expAccounts = getAccountByType(18);
        return view('generals.services.create',compact('result','title','types','categories','wipAccounts','cogsAccounts','expAccounts'));
    }

    public function store(ServiceRequest $request)
    {
        DB::beginTransaction();
        try {
            //store here
            $this->serviceRepository->create($request);

            DB::commit();
            
            $notification = array(
                'message'    => 'Service Code successfull to saved!',
                'alert-type' => 'success'
            );
            return redirect()->route('services.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function edit($id)
    {
        $result = $this->serviceRepository->findById($id);
        $title = 'Edit Service Charges';
        $categories = getCategory();
        $types = getChargeType();
        $wipAccounts = getAccountByType(5);
        $cogsAccounts = getAccountByType(17);
        $expAccounts = getAccountByType(18);
        return view('generals.services.create',compact('result','title','types','categories','wipAccounts','cogsAccounts','expAccounts'));
    }

    public function update(ServiceRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            //update here
            $this->serviceRepository->update($request, $id);

            DB::commit();

            $notification = array(
                'message'    => 'Service Code successfull to updated!',
                'alert-type' => 'success'
            );
            return redirect()->route('services.index')->with($notification);

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

    public function getItemChargeByType($type)
    {
        $services = $this->serviceRepository->getById($type);

        return $services;
    }
}
