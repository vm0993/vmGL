<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\ItemRequest;
use App\Core\Repositories\General\ItemRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use Response;
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        //$this->middleware('auth');
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $results = $this->itemRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.items.index',compact('results'));
        }
        return view('generals.items.index',compact('results'));
    }

    public function create()
    {
        $result       = '';
        $title        = 'Item Baru';
        $categorys    = getCategory();
        $units        = getUnits();
        $taxs         = getTaxes();
        return view('generals.items.create',compact('result','title','categorys','units','taxs'));
    }

    public function store(ItemRequest $request)
    {
        $this->itemRepository->create($request);

        return redirect()->route('items.index');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $result       = $this->itemRepository->findById($id);
        $title        = 'Edit Item';
        $categorys    = getCategory();
        $units        = getUnits();
        $taxs         = getTaxes();
        return view('generals.items.create',compact('result','title','categorys','units','taxs'));
    }

    public function update(ItemRequest $request, $id)
    {
        $this->itemRepository->update($request, $id);
        return redirect()->route('items.index');
    }

    public function destroy($id)
    {
        //
    }
}
