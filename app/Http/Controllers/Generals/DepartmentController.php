<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\DepartmentRequest;
use App\Core\Repositories\General\DepartmentRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use Response;
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        //$this->middleware('auth');
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $results = $this->departmentRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.departments.index',compact('results'));
        }
        return view('generals.departments.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Departemen Baru';
        return view('generals.departments.create',compact('result','title'));
    }

    public function store(DepartmentRequest $request)
    {
        $this->departmentRepository->create($request);

        return redirect()->route('departments.index');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $result = $this->departmentRepository->findById($id);
        $title = 'Edit Departemen';
        return view('generals.departments.create',compact('result','title'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        $this->departmentRepository->update($request, $id);
        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        //
    }
}
