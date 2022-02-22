<?php

namespace Database\Seeders\General;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class GeneralPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'department',
            'departmentNew',
            'departmentEdit',
            'departmentDelete',
            'unit',
            'unitNew',
            'unitEdit',
            'unitDelete',
            'currency',
            'currencyNew',
            'currencyEdit',
            'currencyDelete',
            'account',
            'accountBaru',
            'accountEdit',
            'accountDelete',
            'category',
            'categoryNew',
            'categoryEdit',
            'categoryDelete',
            'chargeCode',
            'chargeCodeNew',
            'chargeCodeEdit',
            'chargeCodeDelete',
            'ledger',
            'ledgerNew',
            'ledgerEdit',
            'ledgerDelete',
            'personel',
            'personelNew',
            'personelEdit',
            'personelDelete',
            'tax',
            'taxNew',
            'taxEdit',
            'taxDelete',
            'advanceOperation',
            'advanceOperationNew',
            'advanceOperationEdit',
            'advanceOperationDelete',
            'approval',
            'releaseAdvance',
            'releaseAdvanceNew',
            'releaseAdvanceEdit',
            'releaseAdvanceDelete',
            'reportAdvance',
            'reportAdvanceNew',
            'reportAdvanceEdit',
            'reportAdvanceDelete',
            'jurnal',
            'jurnalNew',
            'jurnalEdit',
            'jurnalDelete',
            'cashBank',
            'cashBankNew',
            'cashBankEdit',
            'cashBankDelete',
            'jurnalHistory',
            'cashBankMutation',
            'settings',
        ];
        
        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
