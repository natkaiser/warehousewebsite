<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class FormNumberService
{
    public function next(string $scope, string $prefix, int $initialLastNumber = 0): string
    {
        $year = now()->year;
        $timestamp = now();

        $nextNumber = DB::transaction(function () use ($scope, $year, $timestamp, $initialLastNumber): int {
            $row = DB::table('form_sequences')
                ->where('scope', $scope)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (! $row) {
                $firstNumber = max(0, $initialLastNumber) + 1;

                DB::table('form_sequences')->insert([
                    'scope' => $scope,
                    'year' => $year,
                    'last_number' => $firstNumber,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                return $firstNumber;
            }

            $next = ((int) $row->last_number) + 1;

            DB::table('form_sequences')
                ->where('id', $row->id)
                ->update([
                    'last_number' => $next,
                    'updated_at' => $timestamp,
                ]);

            return $next;
        });

        return sprintf('%s/%d/%04d', $prefix, $year, $nextNumber);
    }
}
