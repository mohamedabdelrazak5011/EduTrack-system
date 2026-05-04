<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferSqliteToMysqlSeeder extends Seeder
{
    public function run(): void
    {
        // نقل centers
        DB::connection('sqlite')->table('centers')->get()->each(function ($row) {
            DB::table('centers')->updateOrInsert(
                ['id' => $row->id],
                (array) $row
            );
        });

        // نقل students
        DB::connection('sqlite')->table('students')->get()->each(function ($row) {
            DB::table('students')->updateOrInsert(
                ['id' => $row->id],
                (array) $row
            );
        });

        // نقل attendances
        DB::connection('sqlite')->table('attendances')->get()->each(function ($row) {
            DB::table('attendances')->updateOrInsert(
                ['id' => $row->id],
                (array) $row
            );
        });

        // نقل results
        DB::connection('sqlite')->table('results')->get()->each(function ($row) {
            DB::table('results')->updateOrInsert(
                ['id' => $row->id],
                (array) $row
            );
        });

        $this->command->info("✅ Data transferred successfully!");
    }
}