<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\TicketPrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Membuat kategori harga tiket
        $prices = [];

        foreach ([
            ['Weekday', 35000],
            ['Weekend', 50000],
        ] as [$category, $price]) {
            $prices[] = TicketPrice::firstOrCreate(
                ['category_day' => $category],
                ['price' => $price]
            );
        }

        // Data film dummy
        $titles = [
            ['Dunia Baru', 'Sci-Fi'],
            ['Petualangan Senja', 'Adventure'],
            ['Misteri Kota', 'Mystery'],
            ['Langit Merah', 'Drama'],
            ['Pahlawan Terakhir', 'Action'],
            ['Rumah Tua', 'Horror'],
            ['Cinta Pertama', 'Romance'],
            ['Galaksi Jauh', 'Sci-Fi'],
            ['Operasi Rahasia', 'Action'],
            ['Hutan Ajaib', 'Fantasy'],
            ['Jejak Waktu', 'Sci-Fi'],
            ['Komedi Kampung', 'Comedy'],
            ['Bayangan Malam', 'Thriller'],
            ['Samudra Biru', 'Adventure'],
            ['Hari Esok', 'Drama'],
        ];

        foreach ($titles as $i => [$title, $genre]) {
            // Membuat film
            $movie = Movie::firstOrCreate(
                ['title' => $title],
                [
                    'genre' => $genre,
                    'durasi' => 100 + ($i % 5) * 10,
                    'sypnopsis' => 'Film dummy untuk pengujian aplikasi pemesanan tiket.',
                ]
            );

            // Membuat jadwal tayang
            $showTime = Carbon::tomorrow()
                ->setTime(12 + ($i % 6), 0, 0);

            Schedule::firstOrCreate(
                [
                    'movie_id' => $movie->id,
                    'show_time' => $showTime,
                ],
                [
                    'ticket_price_id' => $prices[$i % 2]->id,
                    'studio' => 'Studio ' . (($i % 4) + 1),
                ]
            );

            // Membuat data pelanggan dummy
            Customer::firstOrCreate(
                [
                    'email' => 'penonton' . ($i + 1) . '@example.com',
                ],
                [
                    'name' => 'Penonton ' . ($i + 1),
                    'phone' => '0812345678' . str_pad(
                        (string) $i,
                        2,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'address' => 'Alamat dummy ' . ($i + 1),
                ]
            );
        }
    }
}
