<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\LedgerRequest;
use App\Core\Interfaces\General\LedgerInterface;
use App\Core\Repositories\General\LedgerRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    use Response;
    private $ledgerRepository;

    public function __construct(LedgerRepository $ledgerRepository)
    {
        $this->ledgerRepository = $ledgerRepository;    
    }
    
    public function index()
    {
        $results = $this->ledgerRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.ledgers.index',compact('results'));
        }
        return view('generals.ledgers.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Ledger Baru';
        return view('generals.ledgers.create',compact('result','title'));
    }

    public function store(LedgerRequest $request)
    {
        DB::beginTransaction();
        try {
            //store here
            $this->ledgerRepository->create($request);

            DB::commit();
            return redirect()->route('ledgers.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function edit($id)
    {
        $result = $this->ledgerRepository->findById($id);
        $title = 'Edit Ledger';
        return view('generals.ledgers.create',compact('result','title'));
    }

    public function update(LedgerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            //update here
            $this->ledgerRepository->update($request, $id);

            DB::commit();
            return redirect()->route('ledgers.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            abort(500, $th->getMessage());
        }
    }

    public function delete($id)
    {
        $ledger = $this->ledgerRepository->delete($id);
        return response()->json(['result' => $ledger], 201);
    }

}
