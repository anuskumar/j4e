<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('outsidesell', 'proof_file')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE outsidesell MODIFY proof_file TEXT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE outsidesell ALTER COLUMN proof_file TYPE TEXT');
        }

        $rows = DB::table('outsidesell')->whereNotNull('proof_file')->where('proof_file', '!=', '')->get(['id', 'proof_file']);
        foreach ($rows as $row) {
            $value = $row->proof_file;
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                continue;
            }

            DB::table('outsidesell')->where('id', $row->id)->update([
                'proof_file' => json_encode([$value]),
            ]);
        }
    }

    public function down(): void
    {
        // no-op: keep text column
    }
};
