<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Core\Repositories\Accounting\HistoryRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class JurnalHistoryController extends Controller
{
    use Response;
    protected $historyRepository;

    public function __construct(HistoryRepository $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    public function index()
    {
        $results = $this->historyRepository->getAll();

        if (!$results->isEmpty()){
            return view('accounting.historys.index',compact('results'));
        }

        return view('accounting.historys.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    
}
