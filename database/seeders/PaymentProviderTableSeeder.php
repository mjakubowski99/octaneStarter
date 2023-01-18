<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Common\ValueObject\PaymentProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentProviderTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_providers')->delete();
        DB::statement("ALTER TABLE payment_providers AUTO_INCREMENT=1");

        $insertData = [];
        foreach (PaymentProvider::getValueToNameAssociation() as $value => $name) {
            $insertData[] = [
                'id' => $value,
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('payment_providers')->insert($insertData);
    }
}
