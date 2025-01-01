<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::factory()->count(5)->create();

        // Tanggal mulai dan akhir bulan yang diinginkan
        $startDate = Carbon::create(2024, 8, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // ID pengguna dan ID perusahaan untuk seeder
        $userId = 1; // Sesuaikan dengan ID pengguna yang ada
        $companyId = 1; // ID perusahaan

        // Loop untuk setiap hari dalam bulan
        while ($startDate <= $endDate) {
            // Data absensi
            $attendanceData = [
                'company_id' => $companyId,
                'date' => $startDate->toDateString(),
                'is_holiday' => false,
                'is_leave' => false,
                'user_id' => $userId,
                'leave_id' => null,
                'leave_type_id' => null,
                'holiday_id' => null,
                'clock_in_date_time' => $startDate->copy()->setTime(rand(8, 9), rand(0, 59))->toDateTimeString(),
                'clock_out_date_time' => $startDate->copy()->setTime(rand(17, 18), rand(0, 59))->toDateTimeString(),
                'total_duration' => rand(420, 540), // Durasi dalam menit (7-9 jam)
                'is_late' => rand(0, 1) == 1,
                'is_half_day' => rand(0, 1) == 1,
                'is_paid' => rand(0, 1) == 1,
                'status' => 'present',
                'reason' => 'Hadir tepat waktu',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Sisipkan data absensi ke database
            DB::table('attendances')->insert($attendanceData);

            // Log data untuk keperluan debugging jika diperlukan
            Log::info('Attendance record created: ', $attendanceData);

            // Pindah ke hari berikutnya
            $startDate->addDay();
        }
    }
}
