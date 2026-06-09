<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'PT Benur Digital Indonesia'],
            ['key' => 'company_phone', 'value' => '081234567890'],
            ['key' => 'company_address', 'value' => 'Jl. Tambak Udang No. 1, Bandar Lampung'],
            ['key' => 'bank_name', 'value' => 'BCA'],
            ['key' => 'bank_account', 'value' => '1234567890'],
            ['key' => 'bank_owner', 'value' => 'PT BENUR DIGITAL INDONESIA'],
            ['key' => 'qris_image', 'value' => null],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}