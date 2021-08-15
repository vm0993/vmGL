<?php

namespace App\Http\Livewire\Accounting\Coa;

use App\Imports\AccountImport;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Excel;

class ImportCoa extends Component
{
    use WithFileUploads;

    public $excelFile;
    public $fileName;
    public $isUploaded = false;

    public function render()
    {
        return view('livewire.accounting.coa.import-coa');
    }

    public function updated($value)
    {
        $this->fileName = $this->excelFile->getClientOriginalName();
    }

    public function uploadExcel()
    {
        $this->validate(
            [
                'excelFile' => 'required'
            ]
        );

        $upload = new Upload();
        $upload->file_name = $this->excelFile->getClientOriginalName();
        $upload->uploaded_at = date("Y-m-d H:i:s");
        $upload->file_size = $this->excelFile->getSize();
        $upload->file_ext = $this->excelFile->getClientOriginalExtension();
        $upload->file_type = $this->excelFile->getClientMimeType();
        $upload->created_at = date("Y-m-d H:i:s");
        $upload->status = "uploaded";
        $upload->save();

        $destinationPath = 'uploads';
        $path = Storage::putFile($destinationPath, $this->excelFile);

        ray($path);

        $import = new AccountImport($upload->id);
        Excel::import($import, $path);

        $this->isUploaded = true;
        $this->fileName = '';
    }
}
