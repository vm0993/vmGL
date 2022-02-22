<?php

use App\Models\Accounting\Accounts\Account;
use App\Models\Accounting\Currencys\Currency;
use App\Models\General\Category;
use App\Models\General\CostCharge;
use App\Models\General\Ledger;
use App\Models\General\Personel;
use App\Models\General\Tax;
use App\Models\General\Unit;
use App\Models\Jobs\JobOrder;
use App\Models\Purchases\Bills\Bill;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

function setCompanyType()
{
    $companyType = [
        0 => 'UMUM',
        1 => 'KONTRAKTOR',
        2 => 'PELAYARAN/PPJK',
        3 => 'MANUFAKTUR',
    ];

    return $companyType;
}

function setCompanyEnglishType()
{
    $companyType = [
        0 => 'GENERAL',
        1 => 'CONTRACTOR',
        2 => 'CUSTOM SERVICES',
        3 => 'MANUFACTURE',
    ];

    return $companyType;
}

function getAccountTypes()
{
    $jenisAkun = array(
        '1' => 'Kas/Bank',
        '2' => 'Piutang Usaha',
        '3' => 'Piutang Non Usaha',
        '4' => 'Persediaan',
        '5' => 'Pekerjaan Dalam Proses',
        '6' => 'Aktiva Lancar Lainnya',
        '7' => 'Aktiva Tetap',
        '8' => 'Akumulasi Depresiasi',
        '9' => 'Hutang Usaha',
        '10' => 'Hutang Non Usaha',
        '11' => 'Hutang Pajak',
        '12' => 'Pendapatan Diterima Dimuka',
        '13' => 'Hutang Lancar Lainnya',
        '14' => 'Hutang Jangka Panjang',
        '15' => 'Modal',
        '16' => 'Pendapatan',
        '17' => 'Harga Pokok Penjualan',
        '18' => 'Biaya',
        '19' => 'Pendapatan Lain-Lain',
        '20' => 'Biaya Lain-Lain',
    );

    return $jenisAkun;
}

function getCanJurnals()
{
    $canJurnal = array(
        '0' => 'Yes',
        '1' => 'No',
    );

    return $canJurnal;
}

function getLedgerTypes()
{
    $canJurnal = array(
        '0' => 'Customer',
        '1' => 'Vendor',
        '2' => 'Both',
    );

    return $canJurnal;
}

function getChargeType()
{
    $canJurnal = array(
        'COST'    => 'Cost',
        'INVOICE' => 'Invoice',
        'OR'      => 'Official Receipt',
    );

    return $canJurnal;
}

function getParentAccounts()
{
    $parentAccounts = array(
        '0' => 'Parent',
        '1' => 'Child',
    );

    return $parentAccounts;
}

function getInvType()
{
    $parentAccounts = array(
        'INVOICE' => 'INVOICE',
        'OR' => 'OR',
    );

    return $parentAccounts;
}

function getPermission()
{
    $permissions = Permission::get();
        
    return $permissions;
}

function getRolePermission($id)
{
    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                        ->all();

    return $rolePermissions;
}

function getCategory()
{
    $categorys = Category::select('id','name')
                ->where('status',0)
                ->get();

    return $categorys;
}

function getCurrency()
{
    $categorys = Currency::select('id','name')
                ->where('status',0)
                ->get();

    return $categorys;
}

function getTaxes()
{
    $taxes = Tax::select('id','code','name','rate')
                ->where('status',0)
                ->get();

    return $taxes;
}

function getUnits()
{
    $units = Unit::select('id','name')
                ->where('status',0)
                ->get();

    return $units;
}

function getChargeCode($type)
{
    $charges = CostCharge::select(DB::raw('cost_charges.id,cost_charges.categori_id,categories.name,cost_charges.code,cost_charges.name as chargename,cost_charges.type_id'))
                ->join('categories','categories.id','=','cost_charges.categori_id')
                ->where([
                    ['cost_charges.type_id',$type],
                    ['cost_charges.status',0]
                ])
                ->get();

    return $charges;
}

function getAccountByType($type)
{
    $accounts = Account::select('id','account_no','account_name')
                ->where([
                    ['account_type',$type],
                    ['can_jurnal','YES'],
                    ['status','ACTIVE'],
                ])
                ->get();

    return $accounts;
}

function getListAccount()
{
    $accounts = Account::getListAccountJurnal();

    return $accounts;
}

function getCashBankAccount()
{
    $accounts = Account::select('id','account_no','account_name')
                ->where([
                    ['account_type',1],
                    ['can_jurnal','YES'],
                    ['status','ACTIVE'],
                ])
                ->get();

    return $accounts;
}

function getActiveJob()
{
    $jobs = JobOrder::select(DB::raw('job_orders.id,job_orders.code,ledgers.name'))
            ->join('ledgers','ledgers.id','=','job_orders.ledger_id')
            ->where('job_orders.status','ACTIVE')
            ->get();

    return $jobs;
}

function getJobByCustomer($customer_id)
{
    $jobs = JobOrder::select(DB::raw('id,code'))
            ->where('ledger_id',$customer_id)
            ->get();

    return $jobs;
}

function getBillOutstandingByLedgerId($supplier_id)
{
    $bills = Bill::select(DB::raw('bills.id,bills.code,bills.transaction_date,bills.ledger_id,ledgers.name,bills.total_bill,bills.balance'))
                ->join('ledgers','ledgers.id','=','bills.ledger_id')
                ->where([
                    ['bills.ledger_id',$supplier_id],
                    ['bills.status','ACTIVE'],
                    ['bills.balance','>',0]
                ])
                ->get();

    return $bills;
}

function getActiveLedger($type)
{
    $customers = Ledger::where([
                    ['status','ACTIVE'],
                    ['type',$type]
                ])->get();

    return $customers;
}

function getPersonel()
{
    $personels = Personel::select('id','name')
                ->where('status','ACTIVE')
                ->get();

    return $personels;
}

function getBulanRomawi()
{
    $arrBulan = array(1=>'I',2 => 'II', 3 => 'III', 4 => 'IV', 5 =>'V',6 =>'VI',7 => 'VII',8 => 'VIII',9 =>'IX',10 => 'X',11 => 'XI',12 => 'XII');

    return $arrBulan;
}

function getBulan()
{
    $arrBulan = array(1=>'Jan',2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 =>'Mei',6 =>'Jun',7 => 'Jul',8 => 'Aug',9 =>'Sep',10 => 'Oct',11 => 'Nov',12 => 'Dec');

    return $arrBulan;
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
}