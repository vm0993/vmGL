<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\PersonelRequest;
use App\Core\Repositories\General\PersonelRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonelController extends Controller
{
    use Response;
    private $personelRepository;

    public function __construct(PersonelRepository $personelRepository)
    {
        $this->personelRepository = $personelRepository;    
    }
    
    public function index()
    {
        $results = $this->personelRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.personels.index',compact('results'));
        }
        return view('generals.personels.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Personel Baru';
        return view('generals.personels.create',compact('result','title'));
    }

    public function store(PersonelRequest $request)
    {
        DB::beginTransaction();
        try {
            //store here
            $this->personelRepository->create($request);

            DB::commit();
            return redirect()->route('personels.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function edit($id)
    {
        $result = $this->personelRepository->findById($id);
        $title = 'Edit Personel';
        return view('generals.personels.create',compact('result','title'));
    }

    public function update(PersonelRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            //update here
            $this->personelRepository->update($request, $id);

            DB::commit();
            return redirect()->route('personels.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $ledger = $this->personelRepository->delete($id);
        return response()->json(['result' => $ledger], 201);
    }
}
