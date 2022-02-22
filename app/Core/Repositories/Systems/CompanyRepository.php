<?php

namespace App\Core\Repositories\Systems;

use Image;
use App\Core\Interfaces\Systems\CompanyInterface;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class CompanyRepository implements CompanyInterface
{
    public function findFirstRecord()
    {
        $result = Company::first();
        if($result != null){
            return $this->response($result);
        }
    }

    public function create($request)
    {
        //$data = Tenant::find($id);
        $image = $request->image_logo;

        /* if ($image != "") {
            $logo = time(). rand(1111, 9999) . '.' .$image->getClientOriginalExtension();

            $save_Path = public_path('images/'.$logo);
            
            if ($data->logo != "") {
                if($data->logo != $image){
                    File::delete(public_path('images/' . $data->picture_logo));
                    Image::make($image->getRealPath())->resize(300, 236)->save($save_Path);
                }
            } else {
                Image::make($image->getRealPath())->resize(300, 236)->save($save_Path);
            }
        } else {
            $logo = "";
        } */

        $data = [
            'name'                     => $request->name,
            'address'                  => $request->address,
            'city'                     => $request->city,
            'phone_no'                 => $request->phone_no,
            'fax_no'                   => $request->fax_no,
            'email'                    => $request->email,
            'postal_code'              => $request->postal_code,
            'thousand_separator'       => $request->thousand_separator,
            'decimal_separator'        => $request->decimal_separator,
            'retained_earning_account' => $request->retained_earning_account,
            'yearly_profit_account'    => $request->yearly_profit_account,
            'monthly_profit_account'   => $request->monthly_profit_account,
        ];

        $company = Company::create($data);

        return $company;    
    }

    public function update($request, $id)
    {
        $data = [
            'name'                     => $request->name,
            'address'                  => $request->address,
            'city'                     => $request->city,
            'phone_no'                 => $request->phone_no,
            'fax_no'                   => $request->fax_no,
            'email'                    => $request->email,
            'postal_code'              => $request->postal_code,
            'thousand_separator'       => $request->thousand_separator,
            'decimal_separator'        => $request->decimal_separator,
            'retained_earning_account' => $request->retained_earning_account,
            'yearly_profit_account'    => $request->yearly_profit_account,
            'monthly_profit_account'   => $request->monthly_profit_account,
        ];
        $company = Company::find($id);
        $company->update($data);
        
        return $company; 
    }

    public function response($company)
    {
        return [
            'id'                       => $company->id,
            'name'                     => $company->name,
            'subdomain'                => $company->subdomain,
            'address'                  => $company->address,
            'city'                     => $company->city,
            'phone_no'                 => $company->phone_no,
            'fax_no'                   => $company->fax_no,
            'tax_reg_no'               => $company->tax_reg_no,
            'email'                    => $company->email,
            'postal_code'              => $company->postal_code,
            'paging'                   => $company->paging,
            'thousand_separator'       => $company->thousand_separator,
            'decimal_separator'        => $company->decimal_separator,
            'retained_earning_account' => $company->retained_earning_account,
            'yearly_profit_account'    => $company->yearly_profit_account,
            'monthly_profit_account'   => $company->monthly_profit_account,
            'created_at'               => Carbon::parse($company->created_at)->format('d M Y h:m:s A'),
            'updated_at'               => Carbon::parse($company->updated_at)->format('d M Y h:m:s A'),
        ];
    }
}