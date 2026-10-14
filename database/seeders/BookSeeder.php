<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriList = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Anak', 'Agama', 'Sastra'];
        $categories = [];

        foreach ($kategoriList as $kat) {
            $categories[$kat] = Category::firstOrCreate([
                'nama' => $kat,
                'slug' => Str::slug($kat),
            ]);
        }

        $bukuContoh = [
            // Fiksi & Novel (9 Buku)
            [
                'category' => 'Fiksi',
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun_terbit' => '1980',
                'stok' => 5,
                'sampul' => 'covers/bumi-manusia.jpg',
                'sinopsis' => 'Berlatar di masa Hindia Belanda akhir abad ke-19, novel mahakarya ini mengisahkan perjalanan hidup Minke, seorang pemuda pribumi cerdas dan berjiwa merdeka yang berhasil menembus sekolah elit HBS. Kehidupannya bertransformasi ketika ia jatuh hati pada Annelies Mellema, gadis berdarah campuran Belanda-Pribumi yang lembut dan jelita. Melalui hubungannya dengan Nyai Ontosoroh—ibu Annelies yang mandiri dan gigih melawan tatanan masyarakat patriarki kolonial—Minke belajar mengenali wajah asli kolonialisme: diskriminasi hukum, pemerasan manusia, dan perampasan harkat martabat pribumi. Sebuah kisah agung tentang cinta, keberanian, dan perlawanan tanpa akhir demi meraih kemerdekaan diri dan keadilan.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2005',
                'stok' => 3,
                'sampul' => 'covers/laskar-pelangi.jpg',
                'sinopsis' => 'Berlatar di sebuah desa pertambangan timah di Belitung Timur, novel yang menggetarkan hati ini menceritakan kisah nyata masa kecil sepuluh anak yang menjuluki diri mereka "Laskar Pelangi". Bersekolah di sebuah gedung SD Muhammadiyah yang reyot dan nyaris roboh, anak-anak desa seperti Ikal, Lintang sang genius matematika, dan Mahar sang seniman cilik menemukan harapan baru berkat pengorbanan tanpa pamrih dari dua guru istimewa, Ibu Muslimah dan Bapak Harfan. Novel ini memotret ironi kemiskinan di tanah yang kaya timah, kekuatan persahabatan, ketulusan cinta belajar, serta keajaiban mimpi yang mampu mendobrak batas ketidakmungkinan.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Cantik Itu Luka',
                'pengarang' => 'Eka Kurniawan',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2002',
                'stok' => 0,
                'sampul' => 'covers/cantik-itu-luka.jpg',
                'sinopsis' => 'Sebuah epik realisme magis yang memukau berlatar di kota pesisir fiktif Halimunda. Mengisahkan Dewi Ayu, seorang perempuan pelacur tercantik yang bangkit dari kuburnya setelah dua puluh satu tahun kematiannya. Kebangkitan Dewi Ayu membongkar kembali rajutan masa lalu kelam keluarganya, masa penjajahan Belanda, pendudukan brutal tentara Jepang, euforia revolusi kemerdekaan, hingga tragedi pembantaian politik berdarah tahun 1965. Kutukan kecantikan sang ibu menitis kepada ketiga putrinya yang jelita namun bernasib nahas, hingga lahir putri keempat yang sengaja dinamai Cantik meski berparas luar biasa buruk rupa. Sebuah narasi satir yang liar, getir, dan mendalam tentang luka sejarah bangsa.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Pulang',
                'pengarang' => 'Leila S. Chudori',
                'penerbit' => 'KPG',
                'tahun_terbit' => '2012',
                'stok' => 4,
                'sampul' => 'covers/pulang.jpg',
                'sinopsis' => 'Dimas Suryo, seorang wartawan Indonesia muda yang menghadiri konferensi pers internasional di Santiago, terperangkap di luar negeri saat meletusnya Gerakan 30 September 1965 di tanah air. Paspornya dicabut dan ia dinyatakan sebagai eksil politik tanpa kewarganegaraan, hingga akhirnya terdampar di Paris bersama rekan-rekan sesama pelarian politik. Di sana, mereka mendirikan restoran Indonesia di Rue Vaugirard sebagai cara merawat ingatan dan mengobati kerinduan mendalam pada kampung halaman. Bertahun-tahun kemudian, putrinya, Lintang Utara, kembali ke Jakarta untuk menyelesaikan proyek tugas akhir film dokumenter tentang korban eks-tapol 1965, tepat ketika kota Jakarta bergolak oleh demonstrasi Reformasi Mei 1998. Novel ini menganyam kisah tentang cinta tanah air, pengasingan, rekonsiliasi sejarah, dan arti hakiki dari sebuah "pulang".',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Laut Bercerita',
                'pengarang' => 'Leila S. Chudori',
                'penerbit' => 'KPG',
                'tahun_terbit' => '2017',
                'stok' => 7,
                'sampul' => 'covers/laut-bercerita.jpg',
                'sinopsis' => 'Sebuah karya fiksi sejarah yang menggugah nurani, mengangkat babak paling kelam dalam sejarah modern Indonesia: penculikan dan penghilangan paksa para aktivis mahasiswa pro-demokrasi menjelang runtuhnya rezim Orde Baru pada tahun 1998. Bagian pertama dituturkan oleh Biru Laut, seorang mahasiswa sastra yang bersama rekan-rekan pergerakannya di organisasi Winatra harus berpindah dari satu rumah persembunyian ke rumah lainnya, hingga akhirnya diculik, disekap, dan mengalami interogasi penuh siksaan di markas rahasia sebelum tubuhnya ditenggelamkan ke dasar laut Kepulauan Seribu. Bagian kedua disuarakan oleh adik kandungnya, Asmara Jati, dan keluarga korban yang terus memelihara harapan di tengah ketidakpastian nasib orang-orang tercinta mereka, berjuang bersama menolak lupa dan menuntut keadilan.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Gadis Kretek',
                'pengarang' => 'Ratih Kumala',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2012',
                'stok' => 6,
                'sampul' => 'covers/gadis-kretek.jpg',
                'sinopsis' => 'Berawal dari detik-detik terakhir kehidupan Soeraja, pemilik pabrik Kretek Djagad Raja yang tersohor, yang meracau dan memanggil satu nama yang bukan istrinya: Jeng Yah. Didorong oleh rasa ingin tahu dan kecemasan keluarga, ketiga putranya—Tegar, Karim, dan Lebas—menempuh perjalanan melintasi kota-kota kecil di Jawa Tengah demi menyingkap rahasia masa lalu sang ayah. Pencarian ini menyingkap tabir persaingan industri tembakau lokal pasca perang kemerdekaan, sejarah racikan saus kretek istimewa yang dibuat dengan cinta oleh Dasiyah (Jeng Yah), serta tragedi cinta sejati yang terhempas oleh intrik pengkhianatan dan kekacauan politik masa lalu.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh',
                'pengarang' => 'Dee Lestari',
                'penerbit' => 'Truedee',
                'tahun_terbit' => '2001',
                'stok' => 5,
                'sampul' => 'covers/supernova-ksatria-puteri-dan-bintang-jatuh.jpg',
                'sinopsis' => 'Dimulai dari janji malam tahun baru antara Reuben dan Dimas di Washington, D.C. untuk menciptakan karya sastra revolusioner yang memadukan sains kuantum, kosmologi, filsafat mistis, dan hakikat cinta. Di belahan bumi lain di Jakarta, kisah cinta terlarang yang intens merebak antara Ferre, seorang bankir muda jenius yang kesepian, dan Rana, seorang jurnalis wanita berbakat yang telah menikah dalam kemapanan semu. Kehadiran Diva, model papan atas yang berwawasan luas dengan jalan hidupnya yang tak lazim, menyatukan kepingan-kepingan misteri realitas. Sebuah novel pendobrak tradisi sastra Indonesia yang mengajak pembaca mempertanyakan batasan persepsi tentang cinta, kebebasan, dan keterhubungan semesta.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Aroma Karsa',
                'pengarang' => 'Dee Lestari',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => '2018',
                'stok' => 8,
                'sampul' => 'covers/aroma-karsa.jpg',
                'sinopsis' => 'Dari gunungan sampah Bantar Gebang, Bekasi, lahirlah Jati Wesi, seorang pemuda yang dikaruniai indra penciuman luar biasa tajam hingga mampu membedakan aroma ribuan senyawa yang tak kasat mata. Bakat ajaib ini menarik perhatian Raras Prayagung, konglomerat pemilik perusahaan kosmetik dan parfum raksasa Kemara, yang terobsesi menemukan Puspa Karsa—tanaman legendaris beraroma pemikat mutlak dari mitos kuno yang konon sanggup menaklukkan siapa pun. Jati dipertemukan dengan Tanaya Suma, putri tunggal Raras yang mewarisi kepekaan serupa. Keduanya terseret dalam pusaran ekspedisi berbahaya ke hutan purba Gunung Lawu yang menguak misteri kelam silsilah masa lalu mereka dan kekuatan cinta yang mengikat jiwa.',
            ],
            [
                'category' => 'Fiksi',
                'judul' => 'Ronggeng Dukuh Paruk',
                'pengarang' => 'Ahmad Tohari',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '1982',
                'stok' => 3,
                'sampul' => 'covers/ronggeng-dukuh-paruk.jpg',
                'sinopsis' => 'Mengangkat potret kehidupan masyarakat Dukuh Paruk, sebuah perkampungan miskin dan terpencil di pedalaman Jawa yang melestarikan warisan mistis nenek moyang Ki Secamenggala lewat kesenian ronggeng. Ketika pedukuhan terancam kehilangan identitas budayanya, Srintil, seorang gadis yatim piatu yang jelita, terpilih dirasuki indang ronggeng. Menjadi ronggeng mengharuskan Srintil merelakan kehormatan dirinya lewat tradisi bukak-klambu, sebuah kenyataan pahit yang menghancurkan hati Rasus, sahabat masa kecil yang mencintainya dengan tulus. Rasus memilih pergi meninggalkan desa dan menjadi prajurit militer, sementara Srintil terperangkap dalam kemegahan semu, eksploitasi nafsu, dan pusaran huru-hara politik 1965 yang meluluhlantakkan Dukuh Paruk.',
            ],

            // Non-Fiksi (5 Buku)
            [
                'category' => 'Non-Fiksi',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => '2018',
                'stok' => 10,
                'sampul' => 'covers/filosofi-teras.jpg',
                'sinopsis' => 'Sebuah karya pengantar filsafat Stoikisme (Stoic) dari zaman Yunani-Romawi Kuno yang diterjemahkan ke dalam konteks keseharian masyarakat perkotaan modern di Indonesia dengan bahasa yang ringan, renyah, dan sarat humor. Henry Manampiring mengupas tuntas inti ajaran Stoik, terutama prinsip utama "Dikotomi Kendali": memisahkan hal-hal yang berada di bawah kendali kita (pikiran, persepsi, ucapan, tindakan) dari hal-hal di luar kendali kita (opini orang lain, cuaca, masa lalu, hasil akhir). Buku ini menyuguhkan resep praktis dan ilmiah untuk menjinakkan emosi negatif, membuang kebiasaan overthinking, mengatasi kekecewaan, serta membangun ketenangan batin dan ketangguhan mental menghadapi ketidakpastian hidup.',
            ],
            [
                'category' => 'Non-Fiksi',
                'judul' => 'Sebuah Seni untuk Bersikap Bodo Amat',
                'pengarang' => 'Mark Manson',
                'penerbit' => 'Grasindo',
                'tahun_terbit' => '2016',
                'stok' => 2,
                'sampul' => 'covers/sebuah-seni-untuk-bersikap-bodo-amat.jpg',
                'sinopsis' => 'Buku pengembangan diri bertaraf internasional yang memutarbalikkan norma klise buku motivasi tradisional. Mark Manson dengan gaya lugas, tajam, dan penuh humor sarkastik mengajak pembaca berhenti memaksakan diri untuk selalu berpikiran positif semu (toxic positivity). Manson mengajarkan seni yang sesungguhnya: memilih dengan bijak hal-hal apa saja yang layak dipedulikan dan mana hal-hal sepele yang harus diikhlaskan tanpa membebani pikiran kita. Melalui kisah-kisah kegagalan tokoh sejarah dan pengalaman pribadinya, buku ini mengingatkan bahwa kebahagiaan sejati tidak ditemukan dari menghindari penderitaan, melainkan dari keberanian memeluk kenyataan pahit, menerima keterbatasan diri, dan berjuang menyelesaikan masalah yang bernilai bagi hidup kita.',
            ],
            [
                'category' => 'Non-Fiksi',
                'judul' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'KPG',
                'tahun_terbit' => '2011',
                'stok' => 5,
                'sampul' => 'covers/sapiens.jpg',
                'sinopsis' => 'Mahakarya ensiklopedis dan filosofis dari sejarawan brilian Yuval Noah Harari yang memetakan evolusi luar biasa spesies Homo sapiens dari sekadar kera primata tak berdaya di sabana Afrika hingga menjadi penguasa mutlak yang mengendalikan ekosistem Bumi. Harari menelisik tiga revolusi fundamental: Revolusi Kognitif sekitar 70.000 tahun silam yang memungkinkan manusia berimajinasi bersama menciptakan mitos, uang, agama, dan hukum; Revolusi Pertanian sekitar 12.000 tahun lalu yang merombak tatanan sosial dan memicu ledakan populasi sekaligus ketimpangan; serta Revolusi Saintifik 500 tahun lalu yang membuka gerbang ke masa depan bioteknologi dan kecerdasan buatan. Sebuah telaah multidisiplin yang memukau dan mengguncang pemahaman tentang siapa diri kita dan ke mana peradaban manusia sedang melangkah.',
            ],
            [
                'category' => 'Non-Fiksi',
                'judul' => 'Atomic Habits',
                'pengarang' => 'James Clear',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2018',
                'stok' => 8,
                'sampul' => 'covers/atomic-habits.jpg',
                'sinopsis' => 'Buku panduan pembentukan kebiasaan hidup paling revolusioner dan teruji secara ilmiah karya James Clear. Bertolak dari konsep bahwa perubahan nasib yang dahsyat bukanlah hasil dari lompatan besar sekali seumur hidup, melainkan akumulasi dari perbaikan-perbaikan atomik sebesar 1% setiap hari. Clear menguraikan mekanisme kebiasaan dalam Four Laws of Behavior Change: Menjadikannya Terlihat (Cue), Menjadikannya Menarik (Craving), Menjadikannya Mudah (Response), dan Menjadikannya Memuaskan (Reward). Buku ini memberikan strategi jitu mengatasi penundaan, mematahkan lingkaran kebiasaan buruk yang melekat, membangun identitas diri baru, dan menjaga konsistensi jangka panjang demi meraih prestasi hidup yang luar biasa.',
            ],
            [
                'category' => 'Non-Fiksi',
                'judul' => 'Bicara Itu Ada Seninya',
                'pengarang' => 'Oh Su Hyang',
                'penerbit' => 'Bhuana Ilmu Populer',
                'tahun_terbit' => '2018',
                'stok' => 9,
                'sampul' => 'covers/bicara-itu-ada-seninya.jpg',
                'sinopsis' => 'Ditulis oleh pakar komunikasi dan public speaking kenamaan asal Korea Selatan, Oh Su Hyang, buku ini membongkar rahasia di balik seni komunikasi yang efektif, santun, dan mampu memenangkan hati pendengar. Melalui berbagai contoh studi kasus di dunia kerja, hubungan asmara, hingga kepemimpinan sosial, penulis menjelaskan bahwa kecakapan berbicara bukanlah sekadar bakat alami, melainkan keterampilan yang dapat dipelajari dan diasah. Buku ini mengupas teknik mendengarkan dengan empati, mengendalikan intonasi vokal dan bahasa tubuh, menyusun narasi cerita (storytelling) yang menyentuh perasaan, cara memberikan kritik yang membangun tanpa menyinggung, serta strategi memikat audiens dalam presentasi dan negosiasi.',
            ],

            // Sains (2 Buku)
            [
                'category' => 'Sains',
                'judul' => 'Kosmos',
                'pengarang' => 'Carl Sagan',
                'penerbit' => 'KPG',
                'tahun_terbit' => '1980',
                'stok' => 4,
                'sampul' => 'covers/kosmos.jpg',
                'sinopsis' => 'Sebuah adikarya literatur sains antariksa yang puitis dan menggetarkan dari astrofisikawan legendaris Carl Sagan. Mengajak pembaca mengarungi samudra kosmik luas yang memuat miliaran galaksi dan triliunan bintang, menelusuri 15 miliar tahun sejarah semesta sejak peristiwa Big Bang hingga lahirnya peradaban berakal di Bumi. Sagan memadukan astronomi, fisika, sejarah sains peradaban kuno Alexandria, biologi evolusioner, dan refleksi filosofis yang mendalam. Buku ini mengingatkan manusia akan kedudukan sejatinya di alam semesta: bahwa kita adalah perwujudan dari kosmos itu sendiri yang sedang merenungi asal-usulnya, dan bahwa planet Bumi adalah satu-satunya rumah rapuh yang wajib kita jaga bersama dengan penuh kasih dan akal sehat.',
            ],
            [
                'category' => 'Sains',
                'judul' => 'Asal Usul Spesies',
                'pengarang' => 'Charles Darwin',
                'penerbit' => 'Indoliterasi',
                'tahun_terbit' => '1859',
                'stok' => 2,
                'sampul' => 'covers/asal-usul-spesies.jpg',
                'sinopsis' => 'Buku karya monumental ilmuwan naturalis Inggris Charles Darwin yang diterbitkan pertama kali pada tahun 1859 dan secara radikal mengubah fondasi ilmu biologi modern. Berangkat dari observasi mendalam selama pelayaran penjelajahan lima tahun di atas kapal HMS Beagle—terutama di Kepulauan Galapagos—Darwin merumuskan teori evolusi melalui mekanisme Seleksi Alam (Natural Selection). Buku ini memaparkan argumentasi ilmiah yang kokoh tentang bagaimana variasi acak pada makhluk hidup, perebutan sumber daya dalam bertahan hidup (struggle for existence), dan pewarisan sifat secara bertahap menghasilkan adaptasi luar biasa dan kepunahan spesies sepanjang kurun waktu geologis bumi.',
            ],

            // Teknologi (3 Buku)
            [
                'category' => 'Teknologi',
                'judul' => 'Mastering Laravel',
                'pengarang' => 'Taylor Otwell',
                'penerbit' => 'O\'Reilly',
                'tahun_terbit' => '2023',
                'stok' => 6,
                'sampul' => 'covers/mastering-laravel.jpg',
                'sinopsis' => 'Buku panduan arsitektur tingkat lanjut bagi pengembang web profesional yang ingin menguasai seluk-beluk framework PHP terpopuler di dunia, Laravel. Ditulis dengan fokus pada arsitektur perangkat lunak yang bersih, skalabel, dan mudah dirawat. Materi mengupas tuntas Service Container dan teknik Dependency Injection, perancangan Service Providers dan Custom Middleware, optimalisasi Eloquent ORM termasuk Eager Loading, Query Scopes, dan Model Observers, implementasi Event-Driven Architecture, sistem Antrean Asinkron (Queues and Jobs), pengamanan autentikasi dan otorisasi dengan Gates/Policies, pembuatan RESTful API dengan Eloquent Resources, hingga strategi automated testing menggunakan PHPUnit dan Pest.',
            ],
            [
                'category' => 'Teknologi',
                'judul' => 'Mengenal Artificial Intelligence',
                'pengarang' => 'John McCarthy',
                'penerbit' => 'Tech Press',
                'tahun_terbit' => '2021',
                'stok' => 3,
                'sampul' => 'covers/mengenal-artificial-intelligence.jpg',
                'sinopsis' => 'Rujukan fundamental mengenai dasar-dasar kecerdasan buatan dari konsep pemikiran awal bapak pendiri AI, John McCarthy, hingga implementasi teknologi masa kini. Buku ini menelusuri sejarah lahirnya istilah Artificial Intelligence di Konferensi Dartmouth 1956, logika simbolik, algoritma pencarian cerdas (search algorithms), representasi pengetahuan, dan sistem pakar (expert systems). Lebih jauh, buku ini mengulas transisi ke paradigma modern: Machine Learning, Deep Learning, jaringan saraf tiruan (neural networks), pemrosesan bahasa alami (NLP), visi komputer, serta pertimbangan etis terkait masa depan tenaga kerja manusia dan regulasi etika otonomi kecerdasan buatan.',
            ],
            [
                'category' => 'Teknologi',
                'judul' => 'Pemrograman Web dengan PHP dan MySQL',
                'pengarang' => 'Abdul Kadir',
                'penerbit' => 'Andi Publisher',
                'tahun_terbit' => '2019',
                'stok' => 12,
                'sampul' => 'covers/pemrograman-web-dengan-php-dan-mysql.jpg',
                'sinopsis' => 'Buku referensi praktis paling populer untuk mempelajari pembuatan aplikasi web dinamis berbasis basis data relational karya penulis legendaris buku komputer Abdul Kadir. Dimulai dari pengenalan dasar sintaks PHP modern, interaksi form web HTML dengan metode GET/POST, penanganan session dan cookies untuk sistem login aman, validasi input pengguna, hingga teknik pengaksesan basis data MySQL menggunakan PDO (PHP Data Objects) dan MySQLi yang terlindungi dari serangan SQL Injection. Buku ini dilengkapi panduan praktis membangun proyek aplikasi web secara utuh dari nol, mulai dari perancangan database relasional, operasi CRUD (Create, Read, Update, Delete), hingga integrasi laporan cetak data.',
            ],

            // Sejarah (3 Buku)
            [
                'category' => 'Sejarah',
                'judul' => 'Sejarah Nasional Indonesia',
                'pengarang' => 'Nugroho Notosusanto',
                'penerbit' => 'Balai Pustaka',
                'tahun_terbit' => '1984',
                'stok' => 10,
                'sampul' => 'covers/sejarah-nasional-indonesia.jpg',
                'sinopsis' => 'Buku babon standar historiografi Indonesia yang menyajikan rekam jejak perjuangan bangsa secara ilmiah, komprehensif, dan bernafaskan nasionalisme. Jilid ini menelusuri dinamika pergerakan kebangsaan awal abad ke-20 lahirnya Budi Utomo dan Sumpah Pemuda 1928, masa pendudukan fasisme militer Jepang di tanah air, detik-detik genting perumusan dan proklamasi kemerdekaan 17 Agustus 1945, hingga periode perang kemerdekaan mempertahankan kedaulatan bangsa dari Agresi Militer Belanda I dan II. Menggambarkan diplomasi internasional yang alot di forum PBB serta perjuangan heroik gerilya tentara rakyat di berbagai front pertempuran Nusantara.',
            ],
            [
                'category' => 'Sejarah',
                'judul' => 'Nusantara: Sejarah Indonesia',
                'pengarang' => 'Bernard H.M. Vlekke',
                'penerbit' => 'KPG',
                'tahun_terbit' => '2008',
                'stok' => 5,
                'sampul' => 'covers/nusantara-sejarah-indonesia.jpg',
                'sinopsis' => 'Karya klasik sejarah Indonesia karya sejarawan terkemuka asal Belanda Bernard H.M. Vlekke yang menawarkan perspektif luas dan berimbang mengenai peradaban kepulauan zamrud khatulistiwa. Dimulai dari zaman prasejarah kepulauan Asia Tenggara, pengaruh kebudayaan India yang melahirkan kerajaan-kerajaan agraris dan maritim perkasa seperti Mataram Kuno, Sriwijaya, dan Majapahit, peranan penting jalur sutra maritim Selat Malaka, masuknya agama Islam, hingga kontak pertama dengan penjelajah Eropa. Penulis membedah dinamika berdirinya kongsi dagang VOC, keruntuhannya akibat korupsi, serta masa pembentukan administrasi kolonial Hindia Belanda yang membentuk batas-batas geografis Republik Indonesia modern.',
            ],
            [
                'category' => 'Sejarah',
                'judul' => 'Guns, Germs, and Steel',
                'pengarang' => 'Jared Diamond',
                'penerbit' => 'KPG',
                'tahun_terbit' => '1997',
                'stok' => 4,
                'sampul' => 'covers/guns-germs-and-steel.jpg',
                'sinopsis' => 'Buku peraih penghargaan bergengsi Hadiah Pulitzer karya profesor geografi dan biologi Jared Diamond yang membedah misteri terbesar peradaban manusia: mengapa bangsa-bangsa di kawasan Eurasia mampu menaklukkan dan mendominasi bangsa-bangsa di benua Amerika, Afrika, dan Australia, bukannya sebaliknya? Dengan membantah teori rasisme biologis, Diamond membuktikan bahwa kesenjangan kemajuan peradaban bukan ditentukan oleh kecerdasan genetik, melainkan oleh faktor keberuntungan geografis dan biogeografi lingkungan. Ketersediaan tumbuhan serealia berprotein tinggi dan hewan ternak mamalia besar yang bisa didomestikasi di kawasan Bulan Sabit Subur memicu lahirnya produksi surplus pangan, kekebalan tubuh terhadap kuman epidemi penyakit (germs), serta penemuan teknologi senjata api (guns) dan peleburan baja (steel).',
            ],

            // Anak (4 Buku)
            [
                'category' => 'Anak',
                'judul' => 'Kancil dan Buaya',
                'pengarang' => 'Rahim',
                'penerbit' => 'Bhuana Ilmu',
                'tahun_terbit' => '2010',
                'stok' => 12,
                'sampul' => 'covers/kancil-dan-buaya.jpg',
                'sinopsis' => 'Dongeng fabel klasik warisan tradisi lisan Nusantara yang menceritakan petualangan Si Kancil, seekor hewan kecil berbulu halus yang terkenal karena kecerdikan dan kecerdasannya di rimba raya. Suatu hari, Kancil ingin menyeberangi sungai yang dalam dan berarus deras demi menikmati lebatnya buah-buahan ranum yang tumbuh di kebun seberang sungai. Namun, sungai tersebut dihuni oleh sekawanan buaya lapar yang siap menerkam siapa pun. Tanpa rasa gentar, Kancil menggunakan akalnya dengan berpura-pura mengumumkan titah raja hutan untuk menghitung jumlah seluruh buaya di sungai guna dibagikan daging hadiah. Kisah jenaka yang kaya hikmah moral ini mengajarkan anak-anak pentingnya menggunakan kecerdikan akal budi, ketenangan pikiran, dan keberanian dalam mengatasi kesulitan besar dalam hidup.',
            ],
            [
                'category' => 'Anak',
                'judul' => 'Si Juki Seri Keroyokan',
                'pengarang' => 'Faza Meonk',
                'penerbit' => 'Bukune',
                'tahun_terbit' => '2016',
                'stok' => 7,
                'sampul' => 'covers/si-juki-seri-keroyokan.jpg',
                'sinopsis' => 'Seri komik komedi karya komikus populer Indonesia Faza Meonk yang menghadirkan petualangan seru karakter ikonik Si Juki—pemuda kocak bergaya cuek dan apa adanya—bersama rekan-rekan uniknya dalam menghadapi hiruk-pikuk kehidupan kota besar. Mengusung gaya ilustrasi kartun yang ekspresif dan humor slapstick bernas, serial komik ini memotret berbagai fenomena sosial, pergaulan anak muda, demam teknologi, hingga kebiasaan sehari-hari orang Indonesia dari kacamata satir yang jenaka dan menyegarkan. Menghibur sekaligus menyisipkan pesan moral positif bagi pembaca anak-anak, remaja, hingga dewasa untuk selalu santai namun kritis menghadapi dinamika hidup.',
            ],
            [
                'category' => 'Anak',
                'judul' => 'Petualangan Sherina',
                'pengarang' => 'Mira Lesmana',
                'penerbit' => 'Miles',
                'tahun_terbit' => '2000',
                'stok' => 3,
                'sampul' => 'covers/petualangan-sherina.jpg',
                'sinopsis' => 'Cerita petualangan anak-anak legendaris yang sarat pesan kehangatan keluarga, persahabatan sejati, dan cinta alam. Mengisahkan Sherina, seorang siswi sekolah dasar yang ceria, energik, dan cerdas yang terpaksa pindah dari Jakarta ke Bandung Utara karena ayahnya bertugas di perkebunan teh. Di sekolah barunya, Sherina harus berhadapan dengan Sadam, anak manja yang suka mengintimidasi teman-temannya. Namun situasi berubah menegangkan saat Sherina dan Sadam diculik oleh kawanan penjahat suruhan taipan serakah yang ingin merampas tanah perkebunan rakyat. Terjebak di tengah lebatnya hutan Lembang dan perbukitan Bosscha, keduanya harus menyatukan kekuatan, kecerdikan, dan keberanian untuk saling melindungi, melarikan diri, dan menyelamatkan perkebunan.',
            ],
            [
                'category' => 'Anak',
                'judul' => 'Kumpulan Dongeng Nusantara',
                'pengarang' => 'MB. Rahimsyah',
                'penerbit' => 'Lingkar Media',
                'tahun_terbit' => '2015',
                'stok' => 10,
                'sampul' => 'covers/kumpulan-dongeng-nusantara.jpg',
                'sinopsis' => 'Buku kumpulan cerita rakyat dan legenda tradisional terbaik dari berbagai kepulauan di Nusantara karya budayawan MB. Rahimsyah. Menyajikan deretan kisah legendaris yang telah diwariskan turun-temurun, seperti Malin Kundang si anak durhaka dari Sumatra Barat, Legenda Danau Toba dari Sumatra Utara, Sangkuriang dan Tangkuban Perahu dari Jawa Barat, Asal Mula Candi Prambanan (Roro Jonggrang) dari Jawa Tengah, Keberanian Cindelaras dari Jawa Timur, Legenda Putri Mandalika dari Lombok, hingga kisah persahabatan Timun Mas dan Raksasa. Setiap dongeng ditulis dengan bahasa yang memikat anak-anak serta memuat pesan moral luhur tentang kepatuhan pada orang tua, kejujuran, keteguhan hati, dan kearifan budaya nenek moyang bangsa.',
            ],

            // Agama (2 Buku)
            [
                'category' => 'Agama',
                'judul' => 'Tafsir Al-Misbah',
                'pengarang' => 'M. Quraish Shihab',
                'penerbit' => 'Lentera Hati',
                'tahun_terbit' => '2000',
                'stok' => 5,
                'sampul' => 'covers/tafsir-al-misbah.jpg',
                'sinopsis' => 'Mahakarya tafsir Al-Qur\'an monumental 15 volume terlengkap dari pakar tafsir terkemuka Indonesia, Prof. Dr. M. Quraish Shihab, M.A. Menyajikan penafsiran ayat-ayat suci Al-Qur\'an secara tematik-kontekstual yang rasional, santun, dan sejuk di hati, diselaraskan dengan realitas sosial dan budaya masyarakat Indonesia kontemporer. Penulis menekankan prinsip keserasian (munasabah) antarkata, ayat, maupun surat dalam Al-Qur\'an untuk membuktikan kesatuan pesan ilahi yang utuh. Buku ini menjadi lentera rujukan utama bagi kaum cendekiawan maupun masyarakat umum untuk menggali hikmah kedamaian, akhlak budi pekerti, dan nilai-nilai kemanusiaan universal yang terkandung dalam firman Allah SWT.',
            ],
            [
                'category' => 'Agama',
                'judul' => 'Fikih Sunnah',
                'pengarang' => 'Sayyid Sabiq',
                'penerbit' => 'Pena Pundi Aksara',
                'tahun_terbit' => '2013',
                'stok' => 8,
                'sampul' => 'covers/fikih-sunnah.jpg',
                'sinopsis' => 'Kitab rujukan fikih Islam klasik-modern paling berpengaruh di dunia karya ulama besar Al-Azhar Mesir, Syaikh Sayyid Sabiq. Buku ini menguraikan hukum-hukum syariat Islam secara jernih, sistematis, dan mudah dipahami, dengan mengembalikan setiap pembahasan langsung pada dalil-dalil shahih Al-Qur\'an dan As-Sunnah tanpa fanatisme mazhab tertentu. Mengupas tuntas tata cara bersuci (thaharah), shalat fardhu dan sunnah, pengurusan jenazah, zakat dan sedekah, puasa Ramadhan, ibadah haji dan umrah, hingga prinsip-prinsip transaksi muamalah ekonomi Islam. Rujukan esensial bagi setiap muslim yang ingin menjalankan ibadah dengan penuh keyakinan dan pemahaman dalil yang shahih.',
            ],

            // Sastra (2 Buku)
            [
                'category' => 'Sastra',
                'judul' => 'Hujan Bulan Juni',
                'pengarang' => 'Sapardi Djoko Damono',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '1994',
                'stok' => 7,
                'sampul' => 'covers/hujan-bulan-juni.jpg',
                'sinopsis' => 'Kumpulan puisi liris paling tersohor dan dicintai dalam sejarah sastra Indonesia karya begawan puisi Sapardi Djoko Damono. Berisi sajak-sajak abadi yang memancarkan keindahan magis melalui kesederhanaan diksi dan metafora alam yang subtil: rintik hujan, pohon berbunga, jejak langkah di jalan setapak, dan keheningan malam. Puisi-puisinya meresapi tema cinta yang tulus, ketabahan hati menghadapi perpisahan, serta kearifan dalam menahan rindu yang tak tersampaikan secara verbal. Salah satu larik terkenalnya berbunyi: "tak ada yang lebih tabah dari hujan bulan juni, dirahasiakannya rintik rindunya kepada pohon berbunga itu... tak ada yang lebih bijak dari hujan bulan juni, dihapuskannya jejak-jejak kakinya yang ragu-ragu di jalan itu."',
            ],
            [
                'category' => 'Sastra',
                'judul' => 'Aku Ini Binatang Jalang',
                'pengarang' => 'Chairil Anwar',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '1986',
                'stok' => 5,
                'sampul' => 'covers/aku-ini-binatang-jalang.jpg',
                'sinopsis' => 'Antologi puisi terlengkap karya pelopor Angkatan \'45 dan legenda sastra modern Indonesia, Chairil Anwar. Buku ini memuat karya-karya revolusioner seperti "Aku", "Krawang-Bekasi", "Diponegoro", "Doa", "Senja di Pelabuhan Kecil", dan "Derai-Derai Cemara". Dengan pilihan kata yang bertenaga, lugas, dan menolak kepalsuan estetika feodal, sajak-sajak Chairil memancarkan semangat vitalitas kemerdekaan, pemberontakan terhadap penindasan, keberanian mengambil risiko, serta kejujuran eksistensial menghadapi kesunyian dan maut. Sebuah monumen kesusastraan Indonesia yang terus menginspirasi generasi demi generasi untuk hidup berani, bebas, dan bermartabat.',
            ],
        ];

        foreach ($bukuContoh as $index => $buku) {
            $book = Book::firstOrNew(['judul' => $buku['judul']]);
            $isNew = ! $book->exists;

            $book->category_id = $categories[$buku['category']]->id;
            $book->pengarang = $buku['pengarang'];
            $book->penerbit = $buku['penerbit'];
            $book->tahun_terbit = $buku['tahun_terbit'];
            $book->sinopsis = $buku['sinopsis'];

            if ($isNew) {
                $book->isbn = '978-'.rand(100000000, 999999999);
                $book->stok = $buku['stok'];
                $book->lokasi_rak = 'Rak '.chr(rand(65, 70)).'-'.rand(1, 10);
                $book->sampul = $buku['sampul'] ?? null;
                $book->jumlah_halaman = rand(100, 500);
            } else {
                if (isset($buku['sampul']) && empty($book->sampul)) {
                    $book->sampul = $buku['sampul'];
                }
            }

            $book->save();
        }
    }
}
