<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        Movie::create([
            'title' => 'Spider-Man: No Way Home',
            'genre' => 'Action',
            'durasi' => 148,
            'sypnopsis' => 'Peter Parker meminta bantuan Doctor Strange, tetapi sebuah kesalahan membuka jalan bagi musuh dari berbagai semesta.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Interstellar',
            'genre' => 'Sci-Fi',
            'durasi' => 169,
            'sypnopsis' => 'Sekelompok penjelajah melakukan perjalanan melintasi lubang cacing untuk mencari planet baru demi kelangsungan hidup umat manusia.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Inception',
            'genre' => 'Sci-Fi',
            'durasi' => 148,
            'sypnopsis' => 'Seorang pencuri profesional memasuki mimpi orang lain untuk mencuri atau menanamkan ide.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Avengers: Endgame',
            'genre' => 'Action',
            'durasi' => 181,
            'sypnopsis' => 'Para Avengers yang tersisa berusaha membalikkan kehancuran akibat tindakan Thanos.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'The Dark Knight',
            'genre' => 'Action',
            'durasi' => 152,
            'sypnopsis' => 'Batman menghadapi Joker, penjahat yang mengancam ketertiban dan moralitas Gotham.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Titanic',
            'genre' => 'Romance',
            'durasi' => 195,
            'sypnopsis' => 'Kisah cinta Jack dan Rose yang tumbuh di tengah pelayaran kapal Titanic.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Avatar',
            'genre' => 'Sci-Fi',
            'durasi' => 162,
            'sypnopsis' => 'Seorang mantan marinir menjelajahi Pandora dan menghadapi konflik antara manusia dan penduduk asli Na’vi.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Jurassic Park',
            'genre' => 'Adventure',
            'durasi' => 127,
            'sypnopsis' => 'Sebuah taman dinosaurus hasil rekayasa genetika berubah menjadi tempat yang berbahaya.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'The Conjuring',
            'genre' => 'Horror',
            'durasi' => 112,
            'sypnopsis' => 'Pasangan penyelidik paranormal membantu sebuah keluarga yang mengalami gangguan supernatural.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Joker',
            'genre' => 'Drama',
            'durasi' => 122,
            'sypnopsis' => 'Arthur Fleck mengalami perjalanan hidup kelam yang mengubahnya menjadi sosok Joker.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Doctor Strange',
            'genre' => 'Fantasy',
            'durasi' => 115,
            'sypnopsis' => 'Seorang ahli bedah mempelajari ilmu mistis setelah kecelakaan mengubah hidupnya.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Iron Man',
            'genre' => 'Action',
            'durasi' => 126,
            'sypnopsis' => 'Tony Stark membangun baju zirah berteknologi tinggi dan menjadi pahlawan super Iron Man.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'The Shawshank Redemption',
            'genre' => 'Drama',
            'durasi' => 142,
            'sypnopsis' => 'Seorang narapidana mempertahankan harapan dan persahabatan selama menjalani hukuman penjara.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'The Lord of the Rings: The Fellowship of the Ring',
            'genre' => 'Fantasy',
            'durasi' => 178,
            'sypnopsis' => 'Frodo dan kelompoknya memulai perjalanan berbahaya untuk menghancurkan sebuah cincin berkekuatan jahat.',
            'image' => null,
        ]);

        Movie::create([
            'title' => 'Transformers',
            'genre' => 'Action',
            'durasi' => 144,
            'sypnopsis' => 'Manusia terlibat dalam peperangan antara robot alien Autobots dan Decepticons.',
            'image' => null,
        ]);
    }
}
