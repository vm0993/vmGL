<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Models\General\Category;
use App\Repositories\General\CategoryRepository;
use App\Response\Response;

class CategoryController extends Controller
{
    use Response;
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        //$this->middleware('auth');
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categorys = $this->categoryRepository->getAll();

        if (!$categorys->isEmpty()){
            return view('generals.categorys.index',compact('categorys'));
        }

        return view('generals.categorys.index');
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

    public function show($id)
    {
        //
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
