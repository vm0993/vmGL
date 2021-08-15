<?php

use App\Models\Accounting\Account;
use App\Models\Systems\Menu;
use App\Models\Systems\MenuItem;
use App\Models\Systems\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

function set_active($uri, $output = 'side-menu--active')
{
    if( is_array($uri) ) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)){
            return $output;
        }
    }
}

function setDarkMode($mode = 'dark')
{
    $uri = "";
    if( is_array($uri) ) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $mode;
            }
        }
    } else {
        if (Route::is($uri)){
            return $mode;
        }
    }
}

function setSetting()
{
    $settings = Setting::first();
    
    return $settings;
}

function getAccountByType($type)
{
    $accounts = Account::where([
                    ['account_type',$type],
                    ['is_jurnal',0],
                    ['status',0]
                ])
                ->get();

    return $accounts;
}

function MenuPermissionByUserID($user_id)
{
    $menus = Menu::select(DB::raw('menu_items.menu_id,menus.name,menu_reports.id,menu_reports.report_name,menu_reports.route_name,menu_reports.start_date,menu_reports.until_date,menu_reports.account_id,menu_reports.until_account_id,menu_reports.project_id,menu_reports.warehouse_id'))
            ->join('menu_items','menu_items.menu_id','=','menus.id')
            ->join('menu_reports','menu_reports.menu_id','=','menus.id')
            ->join('group_permissions','group_permissions.menu_item_id','=','menu_items.id')
            ->join('groups','groups.id','=','group_permissions.group_id')
            ->join('users','users.group_id','=','groups.id')
            ->where([
                ['menus.reporting_id',1],
                ['users.id',$user_id]
            ])
            ->groupByRaw('menu_items.menu_id,menus.name,menu_reports.id,menu_reports.report_name,menu_reports.route_name,menu_reports.start_date,menu_reports.until_date,menu_reports.account_id,menu_reports.until_account_id,menu_reports.project_id,menu_reports.warehouse_id')
            ->get();
    
    return $menus;
}

function getAccountByID($account_id)
{
    $accounts = Account::find($account_id);

    return $accounts;
}

function getMenuContentByMenuID($menu_id)
{
    $contents = MenuItem::select(DB::raw('id as menu_item_id,menu_id,name'))->where('menu_id',$menu_id)->get()->toArray();

    return $contents;
}

function getLanguage()
{
    $array_lang = [];
    $langs = Lang::get('language');
    foreach($langs as $key => $lang){
        $data = [
            'id' => $key,
            'name' => $lang,
        ];
        $array_lang[] = $data;
    }
    return collect($array_lang);
}

function terbilang($angka) {
    $angka=abs($angka);
    $baca =array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    $terbilang="";
    if ($angka < 12){
        $terbilang= " " . $baca[$angka];
    }else if ($angka < 20){
        $terbilang= terbilang($angka - 10) . " Belas";
    }else if ($angka < 100){
        $terbilang= terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
    }else if ($angka < 200){
        $terbilang= " Seratus" . terbilang($angka - 100);
    }else if ($angka < 1000){
        $terbilang= terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
    }else if ($angka < 2000){
        $terbilang= " Seribu" . terbilang($angka - 1000);
    }else if ($angka < 1000000){
        $terbilang= terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
    }else if ($angka < 1000000000){
        $terbilang= terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);
    }else if ($angka < 1000000000000) {
        $terbilang = terbilang($angka/1000000000) . " Milyar" . terbilang(fmod($angka,1000000000));
    }else if ($angka < 1000000000000000) {
        $terbilang = terbilang($angka/1000000000000) . " Trilyun" . terbilang(fmod($angka,1000000000000));
    } 
    return ucwords($terbilang);
}

function toEnglish($number)
{
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . toEnglish(abs($number));
    }

    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string    = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . toEnglish($remainder);
            }
            break;
        default:
            $baseUnit     = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder    = $number % $baseUnit;
            $string       = toEnglish($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= toEnglish($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            //$words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return ucwords($string);
}