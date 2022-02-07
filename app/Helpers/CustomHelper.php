<?php

use App\Models\Accounting\Accounts\Account;

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

function getParentAccounts()
{
    $parentAccounts = array(
        '0' => 'Parent',
        '1' => 'Child',
    );

    return $parentAccounts;
}

function getSubAccount($account_id)
{
    
}

function getListAccount()
{
    $accounts = Account::getListAccountJurnal();

    return $accounts;
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