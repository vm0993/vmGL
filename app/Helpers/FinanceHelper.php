<?php

namespace App\Helpers;

use App\Models\Accounting\Account;
use App\Models\General\Ledger;
use Illuminate\Support\Facades\DB;

class FinanceHelper
{
    public static function getAccountType()
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

    public static function getParentType()
    {
        $kelAkun = array(
            0 => 'Akun Utama',
            1 => 'Sub Akun',
        );

        return $kelAkun;
    }

    public static function getJenisFaktur()
    {
        $kelJenis = array(
            '01' => '01 - Penyerahan BKP/JKP yang terutang PPN',
            '02' => '02 - Penyerahan BKP/JKP kepada pemungut PPN bendahara pemerintah yang PPN-nya dipungut oleh pemungut PPN bendahara pemerintah',
            '03' => '03 - Penyerahan BKP/JKP kepada pemungut PPN lainnya (selain bendahara pemerintah) yang PPN-nya dipungut oleh pemungut PPN lainnya (selain bendahara pemerintah)',
            '04' => '04 - Penyerahan BKP atau JKP yang menggunakan DPP nilai lain, yang PPN-nya dipungut oleh PKP penjual yang melakukan penyerahan BKP/JKP',
            '06' => '06 - Penyerahan lain yang PPN-nya dipungut oleh PKP penjual yang melakukan penyerahan BKP/JKP serta penyerahan kepada orang pribadi yang memegang paspor luar negeri sebagaimana dimaksud dalam pasal 16 E Undang-Undang Pajak Pertambahan Nilai.',
            '07' => '07 - Penyerahan BKP/JKP yang mendapat fasilitas PPN tidak dipungut/ditanggung pemerintah (DTP)',
            '08' => '08 - Penyerahan BKP/JKP yang mendapat fasilitas dibebaskan dari pengenaan PPN.',
            '09' => '09 - Penyerahan aktiva pasal 16 D yang PPN-nya dipungut oleh PKP penjual.',
        );

        return $kelJenis;
    }

    public static function getAccountByTypeId($account_type)
    {
        $accTypes = Account::select(DB::raw('id,account_no,account_name'))
                    ->where([
                        ['status',0],
                        ['is_jurnal',0],
                        ['account_type',$account_type],
                    ])
                    ->get();

        return $accTypes;
    }

    public static function getLedger($type_id)
    {
        $results = Ledger::select(DB::raw('id,concat(code," - ",name) as name'))
                    ->where([
                        ['status',0],
                        ['type_id',$type_id],
                    ])
                    ->get();

        return $results;
    }
}