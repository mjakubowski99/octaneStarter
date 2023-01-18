<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Common\ValueObject\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_statuses')->delete();
        DB::statement("ALTER TABLE order_statuses AUTO_INCREMENT=1");

        $insertData = [];
        foreach (OrderStatus::getValueToNameAssociation() as $value => $name) {
            $insertData[] = [
                'id' => $value,
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('order_statuses')->insert($insertData);
    }
}
