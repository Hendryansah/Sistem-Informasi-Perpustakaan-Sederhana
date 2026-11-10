<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Muhammad Ilham',
            'email' => 'admin@perpus.id',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $petugas = User::create([
            'name' => 'Rina Kusuma',
            'email' => 'petugas@perpus.id',
            'password' => 'password',
            'role' => 'petugas',
        ]);

        $fiksi = Category::create(['name' => 'Fiksi', 'description' => 'Novel, cerpen, dan karya sastra lainnya.']);
        $nonFiksi = Category::create(['name' => 'Non-Fiksi', 'description' => 'Buku pengembangan diri dan popular science.']);
        $sains = Category::create(['name' => 'Sains & Teknologi', 'description' => 'Buku komputer, pemrograman, dan teknologi.']);
        $sejarah = Category::create(['name' => 'Sejarah', 'description' => 'Kajian sejarah Indonesia dan dunia.']);
        $pelajaran = Category::create(['name' => 'Buku Pelajaran', 'description' => 'Penunjang pembelajaran sekolah.']);

        $books = [
            ['category_id' => $fiksi->id, 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'published_year' => 2005, 'isbn' => '978-979-3062-79-1', 'synopsis' => 'Kisah sepuluh anak Belitung yang berjuang mengejar pendidikan meski serba kekurangan.', 'stock' => 5],
            ['category_id' => $fiksi->id, 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'publisher' => 'Hasta Mitra', 'published_year' => 1980, 'isbn' => '978-979-8616-01-4', 'synopsis' => 'Novel pertama tetralogi Buru tentang Minke dan pergulatan zaman kolonial.', 'stock' => 3],
            ['category_id' => $fiksi->id, 'title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'publisher' => 'Gramedia Pustaka Utama', 'published_year' => 2009, 'isbn' => '978-979-22-4447-3', 'synopsis' => 'Enam santri bermimpi menembus batas negeri dengan mantra man jadda wajada.', 'stock' => 4],
            ['category_id' => $nonFiksi->id, 'title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'publisher' => 'Kompas Penerbit Buku', 'published_year' => 2018, 'isbn' => '978-602-412-628-7', 'synopsis' => 'Pengantar filsafat Stoa untuk mengelola emosi dan fokus pada hal yang bisa dikendalikan.', 'stock' => 6],
            ['category_id' => $nonFiksi->id, 'title' => 'Atomic Habits', 'author' => 'James Clear', 'publisher' => 'Gramedia Pustaka Utama', 'published_year' => 2018, 'isbn' => '978-602-06-3220-9', 'synopsis' => 'Perubahan kecil yang bercompound menjadi hasil besar lewat sistem kebiasaan.', 'stock' => 6],
            ['category_id' => $sains->id, 'title' => 'Pemrograman Web dengan Laravel', 'author' => 'Abdul Kadir', 'publisher' => 'Penerbit Andi', 'published_year' => 2021, 'isbn' => '978-623-01-1188-5', 'synopsis' => 'Membangun aplikasi web dari nol sampai deploy menggunakan framework Laravel.', 'stock' => 4],
            ['category_id' => $sains->id, 'title' => 'Kecerdasan Buatan untuk Pemula', 'author' => 'Teguh Arfianto', 'publisher' => 'Penerbit Informatika', 'published_year' => 2020, 'isbn' => '978-602-606-231-0', 'synopsis' => 'Pengantar konsep AI, machine learning, dan penerapannya sehari-hari.', 'stock' => 3],
            ['category_id' => $sejarah->id, 'title' => 'Sapiens: Riwayat Singkat Umat Manusia', 'author' => 'Yuval Noah Harari', 'publisher' => 'Gramedia Pustaka Utama', 'published_year' => 2017, 'isbn' => '978-602-03-7731-6', 'synopsis' => 'Perjalanan manusia dari pemburu-pengumpul hingga penguasa planet.', 'stock' => 3],
            ['category_id' => $sejarah->id, 'title' => 'Sejarah Indonesia Modern', 'author' => 'M.C. Ricklefs', 'publisher' => 'Gadjah Mada University Press', 'published_year' => 2008, 'isbn' => '978-979-3062-79-2', 'synopsis' => 'Rujukan klasik perjalanan Nusantara dari abad ke-13 hingga era modern.', 'stock' => 2],
            ['category_id' => $pelajaran->id, 'title' => 'Fisika untuk SMA Kelas X', 'author' => 'Marthen Kanginan', 'publisher' => 'Penerbit Erlangga', 'published_year' => 2016, 'isbn' => '978-602-298-114-6', 'synopsis' => 'Materi fisika kelas X lengkap dengan contoh soal dan pembahasannya.', 'stock' => 8],
            ['category_id' => $pelajaran->id, 'title' => 'Matematika Dasar Perguruan Tinggi', 'author' => 'Sartono Wirodikromo', 'publisher' => 'Penerbit Erlangga', 'published_year' => 2011, 'isbn' => '978-979-099-123-4', 'synopsis' => 'Fondasi matematika untuk mahasiswa tahun pertama.', 'stock' => 6],
            ['category_id' => $fiksi->id, 'title' => 'Sang Pemimpi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'published_year' => 2006, 'isbn' => '978-979-3062-80-7', 'synopsis' => 'Lanjutan kisah Ikal dan Arai mengejar mimpi hingga ke Sorbonne.', 'stock' => 2],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        $members = [
            ['code' => 'AGT-0001', 'name' => 'Siti Rahmawati', 'email' => 'siti.rahmawati@gmail.com', 'phone' => '081234567801', 'address' => 'Jl. Cempaka No. 12, Malang'],
            ['code' => 'AGT-0002', 'name' => 'Budi Santoso', 'email' => 'budi.santoso@yahoo.com', 'phone' => '081234567802', 'address' => 'Jl. Merdeka No. 5, Malang'],
            ['code' => 'AGT-0003', 'name' => 'Anisa Putri', 'email' => 'anisa.putri@gmail.com', 'phone' => '081234567803', 'address' => 'Perum Griya Asri Blok C3, Malang'],
            ['code' => 'AGT-0004', 'name' => 'Rizky Pratama', 'email' => null, 'phone' => '081234567804', 'address' => 'Jl. Veteran No. 88, Malang'],
            ['code' => 'AGT-0005', 'name' => 'Nadia Safitri', 'email' => 'nadia.safitri@gmail.com', 'phone' => null, 'address' => 'Jl. Soekarno Hatta No. 21, Malang'],
            ['code' => 'AGT-0006', 'name' => 'Andi Wijaya', 'email' => null, 'phone' => '081234567806', 'address' => 'Jl. Bogor No. 3, Malang'],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }

        // Sudah dikembalikan: stok tidak berubah.
        Borrowing::create([
            'code' => 'PJM-'.now()->year.'-0001',
            'user_id' => $petugas->id,
            'member_id' => 1,
            'borrow_date' => now()->subDays(20)->toDateString(),
            'due_date' => now()->subDays(13)->toDateString(),
            'return_date' => now()->subDays(15)->toDateString(),
            'status' => 'returned',
        ])->books()->attach(2, ['qty' => 1]);

        // Sedang dipinjam: stok buku dikurangi.
        $aktif = Borrowing::create([
            'code' => 'PJM-'.now()->year.'-0002',
            'user_id' => $admin->id,
            'member_id' => 2,
            'borrow_date' => now()->subDays(3)->toDateString(),
            'due_date' => now()->addDays(4)->toDateString(),
            'status' => 'borrowed',
        ]);
        $aktif->books()->attach([4 => ['qty' => 1], 5 => ['qty' => 2]]);
        Book::whereKey(4)->decrement('stock', 1);
        Book::whereKey(5)->decrement('stock', 2);

        // Contoh peminjaman terlambat.
        $telat = Borrowing::create([
            'code' => 'PJM-'.now()->year.'-0003',
            'user_id' => $petugas->id,
            'member_id' => 3,
            'borrow_date' => now()->subDays(12)->toDateString(),
            'due_date' => now()->subDays(5)->toDateString(),
            'status' => 'borrowed',
        ]);
        $telat->books()->attach(1, ['qty' => 1]);
        Book::whereKey(1)->decrement('stock', 1);
    }
}
