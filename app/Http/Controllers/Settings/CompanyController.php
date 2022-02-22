<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\CompanyRequest;
use App\Core\Repositories\Systems\CompanyRepository;
use App\Response\Response;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use Response;
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $result = $this->companyRepository->findFirstRecord();
        //dd($results);
        $equityAccounts = getAccountByType(15);
        if ($result != null ){
            $title = 'Update Company';
            return view('settings.company.index',compact('result','title','equityAccounts'));
        }
        $title = 'Setup Company';
        return view('settings.company.index',compact('result','title','equityAccounts'));
    }

    public function store(CompanyRequest $request)
    {
        $this->companyRepository->create($request);
        return redirect()->route('company.index');
    }

    public function update(CompanyRequest $request, $id)
    {
        $this->companyRepository->update($request, $id);
        return redirect()->route('company.index');
    }
}
