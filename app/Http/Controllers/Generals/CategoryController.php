<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Core\Repositories\General\CategoryRepository;
use App\Response\Response;

class CategoryController extends Controller
{
    use Response;
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        //$this->middleware(['auth','tenant']);
        $this->middleware('permission:category|categoryNew|categoryEdit|categoryDelete', ['only' => ['index','show']]);
        $this->middleware('permission:categoryCreate', ['only' => ['create','store']]);
        $this->middleware('permission:categoryEdit', ['only' => ['edit','update']]);
        $this->middleware('permission:categoryDelete', ['only' => ['destroy']]);
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $results = $this->categoryRepository->getAll();

        if (!$results->isEmpty()){
            return view('generals.categorys.index',compact('results'));
        }

        return view('generals.categorys.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Kategori Baru';
        return view('generals.categorys.create',compact('result','title'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create($request);
        return redirect()->route('categories.index');
    }
    
    public function edit($id)
    {
        $result = $this->categoryRepository->findById($id);
        $title = 'Edit Kategori';
        return view('generals.categorys.create',compact('result','title'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryRepository->update($request, $id);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        //
    }
}
