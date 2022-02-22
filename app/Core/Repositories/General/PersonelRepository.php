<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\PersonelInterface;
use App\Models\General\Ledger;
use App\Models\General\Personel;
use Carbon\Carbon;

class PersonelRepository implements PersonelInterface
{
    public function getAll()
    {
        $personels = Personel::orderBy('name')
                    ->paginate(10);

        $personels->getCollection()->transform(function ($items) {
            return $this->response($items);
        });      

        return $personels;
    }

    public function getNextNumber($value)
    {
    }

    public function getById($value)
    {
    }
    
    public function findById($id)
    {
        $personel = Personel::find($id);
        return $this->response($personel);
    }

    public function create($request)
    {
        $personel = Personel::create($request->all());

        return $personel;    
    }

    public function update($request, $id)
    {
        $personel = Personel::find($id);
        $personel->update($request->all());
        
        return $personel; 
    }

    public function delete($id)
    {
        $personel = Personel::find($id);
        $personel->delete();

        return $personel;
    }

    public function response($personel)
    {
        return [
            'id'         => $personel->id,
            'name'       => $personel->name,
            'address'    => $personel->address,
            'status'     => $personel->status,
            'user_name'  => $personel->user->name,
            'created_at' => Carbon::parse($personel->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($personel->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return Personel::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}