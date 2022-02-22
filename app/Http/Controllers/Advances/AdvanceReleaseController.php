<?php

namespace App\Http\Controllers\Advances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Advance\ReleaseRequest;
use App\Core\Repositories\Advanced\ReleaseRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvanceReleaseController extends Controller
{
    use Response;
    protected $releaseRepository;

    public function __construct(ReleaseRepository $releaseRepository)
    {
        $this->releaseRepository = $releaseRepository;
    }

    public function index()
    {
        $results = $this->releaseRepository->getAll();

        if (!$results->isEmpty()){
            return view('advance-managements.release.index',compact('results'));
        }

        return view('advance-managements.release.index',compact('results'));
    }

    public function getRequestNo($transaction_date)
    {
        return $this->releaseRepository->getNextNumber($transaction_date);
    }

    public function create()
    {
        $result    = '';
        $title     = 'Release Advance Baru';
        $personels = getPersonel();
        $jobs      = getActiveJob();
        return view('advance-managements.release.create',compact('result','title','personels','jobs'));
    }

    public function store(ReleaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->releaseRepository->create($request);
            //Looping/bulk insert to detail transaction & update balande to account balance
            
            DB::commit();
            return redirect()->route('advance-releases.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result    = $this->releaseRepository->findById($id);
        $title     = 'Edit Release Advance';
        $personels = getPersonel();
        $jobs      = getActiveJob();
        return view('advance-managements.release.create',compact('result','title','personels','jobs'));
    }

    public function update(ReleaseRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->releaseRepository->update($request, $id);
            //Looping/bulk insert to detail transaction & update balande to account balance

            DB::commit();
            return redirect()->route('advance-releases.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getTransaction($id)
    {
        $transactions = $this->releaseRepository->getById($id);
        
        return $transactions;
    }
}
