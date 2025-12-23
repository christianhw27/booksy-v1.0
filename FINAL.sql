-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Des 2025 pada 14.13
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booksy_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publisher` varchar(100) DEFAULT NULL,
  `publish_year` int(4) DEFAULT NULL,
  `page_count` int(5) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 5,
  `synopsis` text DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `rating` int(1) DEFAULT 5,
  `category_id` int(11) NOT NULL,
  `is_popular` enum('No','Yes') NOT NULL DEFAULT 'No',
  `is_hidden` enum('No','Yes') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `publish_year`, `page_count`, `stock`, `synopsis`, `cover_image`, `tag`, `rating`, `category_id`, `is_popular`, `is_hidden`) VALUES
(1, 'Laut Bercerita', 'Leila S. Chudori', 'KPG (Kepustakaan Populer Gramedia)', 2017, 379, 6, 'Laut Bercerita karya Leila S. Chudori menggambarkan kisah perjuangan sekelompok aktivis pada masa Orde Baru yang berjuang melawan ketidakadilan. Melalui tokoh Biru Laut dan teman-temannya, novel ini menelusuri kisah cinta, pengorbanan, dan kehilangan yang membekas. Dengan gaya penceritaan yang puitis dan emosional, buku ini menyoroti bagaimana sejarah kelam bangsa masih bergema dalam kehidupan generasi setelahnya.', 'https://cdn.gramedia.com/uploads/items/9786024246945_Laut-Bercerita.jpg', 'Fiksi Sejarah', 5, 1, 'Yes', 'No'),
(2, 'Seporsi Mie Ayam Sebelum Mati', 'Brian Khrisna', 'Gramedia Widiasarana Indonesia', 2025, 215, 5, 'Novel ini menceritakan tentang Ale, laki-laki berusia 37 tahun yang didiagnosa mengidap depresi akut dan ingin mengakhiri hidupnya. Ale merasa tak pernah bisa memilih sesuatu atas kehendaknya sendiri. Namun sebelum mati, ia ingin makan seporsi mie ayam terakhirnya, setidaknya itu adalah keputusan yang ia ambil atas kehendaknya sendiri.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/95ob5m98ur.jpg', 'Fiksi Kehidupan Kota', 5, 1, 'Yes', 'No'),
(3, 'Home Sweet Loan', 'Almira Bastari', 'Gramedia Pustaka Utama', 2022, 312, 5, 'Home Sweet Loan menceritakan tentang empat orang sahabat sejak SMA yang kini bekerja di perusahaan yang sama, meski masing-masing punya nasib berbeda. Di usia 31 tahun, mereka berjuang keras mencari hunian idaman di sekitar Jakarta. Tokoh utama, Kaluna, bekerja sebagai pegawai reguler sekaligus model bibir untuk menyiasati gaji pas-pasan, dan ia ingin sekali keluar dari rumah keluarga besar tempatnya tinggal bersama tiga kepala keluarga. Kisah ini menggambarkan realitas finansial dan emosional kaum kelas menengah ke bawah: dari utang, tekanan sosial, impian properti, sampai perjuangan cinta dan harga diri.', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1646470594i/60129536.jpg', 'Metropop', 5, 1, 'No', 'No'),
(4, 'Pulang Pergi', 'Tere Liye', 'Sabak Grip Nusantara', 2021, 417, 5, 'Pulang Pergi menceritakan perjalanan Bujang, seorang petarung mematikan yang menjalani misi sulit di berbagai negara setelah terlibat dalam konflik besar antara kelompok-kelompok berpengaruh. Dalam petualangannya, Bujang menghadapi berbagai pengkhianatan, pertarungan, serta rahasia yang menguji prinsip dan keteguhannya. Novel ini menyuguhkan aksi cepat, kejutan dramatis, dan eksplorasi mendalam tentang loyalitas, balas dendam, serta perjalanan hidup seseorang yang mencari makna pulang.', 'https://cdn.gramedia.com/uploads/items/pulang-pergi_tere_liye.jpeg', 'Fiksi Romantis', 5, 1, 'No', 'No'),
(5, 'Your Name', 'Makoto Shinkai', 'Haru (edisi Indonesia)', 2020, 336, 4, 'Your Name mengisahkan dua remaja: Mitsuha, gadis SMA dari sebuah desa di pegunungan, dan Taki, pemuda SMA di Tokyo. Suatu hari, mereka mulai saling bertukar tubuh secara misterius — Mitsuha tiba-tiba menjalani hidup Taki di kota, sementara Taki menjalani hari-hari Mitsuha di desa. Dari pertukaran ini terjalin hubungan emosional yang mendalam, penuh kebingungan, harapan, dan takdir, saat mereka mencoba mencari satu sama lain dan memahami arti “nama”, “identitas”, serta “hubungan” di tengah jarak dan waktu.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/img508_tsC4kHS.jpg', 'Fantasy', 5, 1, 'No', 'Yes'),
(6, 'Koleksi Kasus Sherlock Holmes', 'Arthur Conan Doyle', 'Gramedia Pustaka Utama', 2019, 280, 5, 'Kumpulan 12 cerita pendek terakhir Sherlock Holmes yang ditulis oleh Sir Arthur Conan Doyle, pertama kali dipublikasikan antara tahun 1921 dan 1927. Buku ini berisi kasus-kasus seperti \"Batu Mazarin\" dan \"Misteri Profesor yang Merangkak\".', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020637099_THE_CASE_BOOK_OF_SHERLOCK.jpg', 'Novel Misteri & Detektif', 5, 1, 'No', 'Yes'),
(7, 'Solo Leveling 6', 'DUBU/CHUGONG', 'Ize Press', 2023, 312, 5, 'Setelah menyaksikan kekuatan Shadow Monarch, Jinwoo tidak sabar untuk naik level. Dia mengerahkan pasukannya melawan raksasa S-rank. Menyelamatkan negara yang ditinggalkan oleh dunia memiliki keuntungan, tetapi juga pertemuan dengan Monarch lain yang membawa kabar buruk.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/picture_meta/2024/6/21/3847kgwiyhubaaragwwgrt.jpg', 'Fiksi Fantasi', 4, 1, 'No', 'Yes'),
(8, 'Hyouka', 'Yonezawa Honobu', 'Penerbit Haru', 2017, 244, 5, 'Oreki Hotaro, pemuda hemat energi, terpaksa bergabung dengan Klub Sastra Klasik. Chitanda Eru, gadis penuh rasa penasaran, mengubah hari-harinya, memaksanya memecahkan misteri demi misteri. Mereka dihadapkan pada kasus 33 tahun lalu dengan petunjuk sebuah antologi berjudul Hyouka.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/4v-x442kk1.jpg', 'Fiksi Misteri & Detektif', 5, 1, 'No', 'Yes'),
(9, 'Max Havelaar', 'Multatuli', 'Qanita', 2014, 480, 5, 'Ditulis oleh Eduard Douwes Dekker (Multatuli), mantan asisten residen Lebak. Hatinya terusik melihat sistem tanam paksa yang menindas bumiputra. Dia mengisahkan kekejaman sistem yang menyebabkan ribuan pribumi kelaparan dan menderita, diperas oleh kolonial dan pejabat pribumi korup.', 'https://cdn.gramedia.com/uploads/items/9786021637456_Max-Havelaar.jpg', 'Fiksi Politik', 5, 1, 'No', 'Yes'),
(10, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara', 1980, 535, 5, 'Bumi Manusia mengikuti kisah Minke, seorang pemuda pribumi berpendidikan yang jatuh cinta pada Annelies, putri Indo dari keluarga Nyai Ontosoroh. Melalui perjalanan hidup mereka, novel ini menggambarkan ketidakadilan sosial, kolonialisme, dan perjuangan identitas di masa Hindia Belanda. Cerita ini menyoroti bagaimana kekuasaan dan status sosial membentuk kehidupan seseorang, sambil menampilkan keteguhan manusia dalam menghadapi penindasan dan perubahan zaman.', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1565658920i/1398034.jpg', 'Fiksi Sejarah', 5, 1, 'No', 'Yes'),
(11, 'Kecerdasan Emosional', 'Daniel Goleman', 'Gramedia Pustaka Utama', 2009, 498, 5, 'Daniel Goleman mengungkapkan bahwa kecerdasan emosional (EI) memiliki peran penting dalam kesuksesan, bahkan lebih penting daripada IQ. Buku ini membahas bagaimana EI memengaruhi aspek akademis, profesional, dan sosial, serta menegaskan bahwa EI adalah keterampilan yang dapat dipelajari.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/0i83anne6r.jpg', 'Personal Growth', 4, 2, 'No', 'No'),
(12, 'Atomic Habits', 'James Clear', 'Avery', 2018, 320, 4, 'Atomic Habits membahas bagaimana perubahan kecil yang dilakukan secara konsisten dapat menghasilkan transformasi besar dalam hidup. Buku ini menjelaskan strategi praktis untuk membangun kebiasaan baik, menghentikan kebiasaan buruk, dan menguasai rutinitas melalui sistem yang sederhana namun efektif. Dengan contoh nyata dan pendekatan ilmiah, pembaca diajak memahami bahwa kesuksesan berasal dari kebiasaan kecil yang terus diperbaiki setiap hari.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786020633176_.Atomic_Habit.jpg', 'Habit Building', 4, 2, 'Yes', 'No'),
(13, 'Slow Living Journal', 'Janeera Amba', 'C-Klik Media', 2024, 176, 5, 'Slow living adalah konsep mematikan mode \'autopilot\' dari kesibukan padat. Menyusun jurnal ini membantu kita melihat prioritas, menyediakan waktu istirahat, dan membuat hidup lebih terarah. Jurnal ini membantu mempraktikkan slow living agar kita bisa memegang kendali atas hidup kita.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/lza3vs7lzj.png', 'Journaling', 4, 2, 'No', 'No'),
(14, 'The Power of Patience', 'M.j. Ryan', 'Penerbit Baca', 2024, 224, 5, 'Di dunia yang serba cepat, kita jadi mudah lelah dan marah. Buku ini mengajarkan kesabaran bukan sebagai kelemahan, tetapi kekuatan. M.J. Ryan menawarkan cara praktis menumbuhkan sikap sabar di tengah tekanan, dari antrean panjang hingga konflik, untuk hidup yang lebih sadar dan damai.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/18fx2pn-0v.jpg', 'Emosi', 4, 2, 'No', 'No'),
(15, 'The Power of Positive Habits', 'Finaang', 'Yash Media', 2024, 188, 5, 'Buku ini mengeksplorasi mengapa kita sulit membentuk kebiasaan baik dan mudah terjebak kebiasaan buruk. Buku ini menyelidiki strategi efektif untuk menghentikan kebiasaan buruk dan menciptakan kebiasaan baru yang bertahan jangka panjang, agar hidup lebih sehat dan produktif.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/picture_meta/2024/5/29/qmr2otmevxvjfecpjkwhu7.jpg', 'Motivasi', 5, 2, 'No', 'Yes'),
(16, 'Social Intelligence', 'Daniel Goleman', 'Gramedia Pustaka Utama', 2007, 546, 5, 'Kita \'wired to connect\'. Kita terus-menerus terlibat dalam \'tarian saraf\' yang menghubungkan otak kita dengan orang lain. Goleman menjelaskan dasar karisma, kekuatan emosi, dan bagaimana kita memiliki kecenderungan alami untuk empati dan kerja sama.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/picture_meta/2023/3/3/ahyxay2mdz7bcsu3idbqru.jpg', 'Komunikasi', 4, 2, 'No', 'Yes'),
(17, 'Succesful Habits', 'Aisyah Nafiani', 'C-Klik Media', 2024, 176, 5, 'Buku ini mengajak merefleksikan kebiasaan sehari-hari. Dengan mengadopsi 10 kebiasaan mendasar, Anda akan mampu mengembangkan diri, membentuk kepribadian kuat, dan menjalin hubungan harmonis. Buku ini membantu Anda menemukan diri sendiri dan passion menuju kesuksesan.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/2fvc-45-sb.jpg', 'Sukses', 5, 2, 'No', 'Yes'),
(18, 'Life Reset', 'Senja Rindiani', 'Grasindo', 2024, 216, 5, 'Panduan praktis melepaskan beban, memaafkan diri, dan melangkah ke hidup yang lebih bermakna. Untuk kamu yang ingin berubah tapi bingung, takut gagal, tidak percaya diri, atau merasa tertinggal.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/5-5-me-19c.jpg', 'Journaling', 4, 2, 'No', 'Yes'),
(19, 'Jujutsu Kaisen 0', 'Gege Akutami', 'Shueisha', 2017, 200, 5, 'Jujutsu Kaisen 0 mengikuti kisah Yuta Okkotsu, seorang remaja yang dihantui oleh roh kutukan kuat bernama Rika, sahabat masa kecilnya. Karena tidak mampu mengendalikan kutukan tersebut, Yuta direkrut ke SMA Jujutsu oleh Satoru Gojo untuk belajar menggunakan kekuatannya demi tujuan yang benar. Di sana, ia menghadapi ancaman dari penyihir jahat Suguru Geto yang ingin memanfaatkan kekuatan Rika untuk rencananya. Cerita ini menjadi prekuel dari seri utama dan memperkenalkan dunia kutukan serta para penyihir dengan intensitas aksi yang khas.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/Cover_Depan_Jujutsu_Kaisen_0.jpg', 'Manga', 5, 3, 'No', 'No'),
(20, 'Chainsaw Man 10', 'Fujimoto Tatsuki', 'm&c!', 2023, 192, 4, 'Setelah terpaksa membunuh seorang teman, otak Denji terasa kacau karena putus asa. Tanpa motivasi, dia mencari bantuan dari Makima. Tapi Makima tidak seperti kelihatannya, dan penderitaan Denji baru saja dimulai.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/3--an61s-k.jpg', 'Manga', 4, 3, 'No', 'No'),
(21, 'Si Juki Anak Kosan #1', 'Faza Meonk', 'Falcon Publishing', 2023, 140, 4, 'Si Juki kembali dengan cerita bersama teman-teman kosan. Tidak hanya lika-liku hidup sebagai anak kos, keseharian Juki di kampus juga tidak kalah menyenangkan. Dari mencari anggota baru untuk HIMATIGA yang terancam bubar sampai mencari asal-usul paket misterius.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786026714671_SI_JUKI_SERIES_VOL_1_FA.jpg', 'Komedi', 4, 3, 'No', 'No'),
(22, 'Panji Tengkorak', 'Hans Jaladara', 'KPG (Kepustakaan Populer Gramedia)', 2011, 560, 4, 'Panji Tengkorak adalah seorang pendekar silat yang berkelana mencari pembunuh istrinya, Murni. Dalam pengembaraannya, ia dikenal sebagai pengemis sakti yang menumpas kejahatan, ditemani oleh seekor anjing dan senjata andalannya, pedang Lembubuana.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/i2n-3ck0n6.jpg', 'Kejahatan & Misteri', 4, 3, 'No', 'No'),
(23, 'Spy X Family 03', 'Endo Tatsuya', 'Elex Media Komputindo', 2021, 202, 5, 'Anya harus berjuang di sekolah elite Eden untuk mendapatkan \'Stella\'. Misi pertamanya adalah pelajaran olahraga! Sementara itu, Loid mulai curiga ada yang mengawasinya dari sekolah. Demi menjaga perdamaian dunia, Anya dan Loid harus berjuang!', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786230025334_Spy_x_Family_03.jpg', 'Manga', 5, 3, 'No', 'Yes'),
(24, 'One Piece 99', 'Eiichiro Oda', 'Elex Media Komputindo', 2022, 202, 5, 'Saat Luffy menuju puncak Onigashima untuk konfrontasi langsung dengan Kaido, anggota Topi Jerami lainnya bertarung dalam pertempuran mereka sendiri. Jumlah mereka tidak seimbang, tetapi mungkin beberapa sekutu tak terduga akan membantu menyamakan kedudukan!', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/One_Piece_99.jpeg', 'Manga', 5, 3, 'No', 'Yes'),
(25, 'Virgo and The Sparklings', 'Annisa Nisfihani dan Ellie Goh', 'Elex Media Komputindo', 2018, 124, 5, 'Bagi Riani, suara hujan itu biru, dan nada gitarnya merah muda. Kemampuan ini membuatnya lihai bermain musik, namun juga memunculkan kekuatan listrik. Saat Riani yang pemalu diajak bergabung dengan band temannya, masalah mulai terjadi.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/picture_meta/2023/3/1/hvbn3cac5emmrv3uzdhgrj.jpg', 'Fantasi', 5, 3, 'No', 'Yes'),
(26, 'Gundala Son of Lightning 1', 'Andy Wijaya', 'm&c!', 2022, 128, 5, 'Gundala kembali beraksi ketika sebuah sekte, \'Perkumpulan Tirani Keadilan\', berusaha menggulingkan pemerintahan dengan cara meracuni penduduk memakai ramuan misterius. Mampukah Gundala menghentikan mereka?', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/cover_GUNDALA_SON_OF_LIGHTNING_1.jpg', 'Aksi', 5, 3, 'No', 'Yes'),
(27, 'Madilog', 'Tan Malaka', 'Penerbit Narasi', 2014, 560, 5, 'Madilog Tan Malaka : Materialisme, Dialektika & Logika membahas tentang pandangan Tan Malaka terhadap Materialisme, Dialektika, dan Logika yang ditulis oleh Tan Malaka, filsuf asal Indonesia dan juga pejuang kemerdekaan. Teori materialisme ini diambil dari pemikiran filsuf asal Jerman, Karl Marx dan Friedrich Engels. Materialisme dijelaskan sebagai paham filsafat yang menjelaskan bahwa sesuatu yang bisa dikatakan ada kebenarannya adalah materi. Tan malaka juga menjelaskan dan memperkenalkan prinsip dasar logika dalam buku ini. Sedangkan teori dialektika berarti tidak ada suatu kebenaran yang bersifat absolut. Tan malaka menerangkan bahwa seiring waktu berjalan, akan selalu ada pergerakan yang berdampak pada kehidupan. Buku ini direkomendasikan untuk pembaca yang menyukai filsafat.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/ri7e71kaam.jpeg', 'Filsafat', 5, 4, 'Yes', 'No'),
(28, 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 300, 6, 'Filosofi Teras memperkenalkan ajaran Stoisisme dengan bahasa yang sederhana dan relevan untuk kehidupan modern. Buku ini membantu pembaca memahami bagaimana mengendalikan emosi, merespons masalah secara rasional, serta fokus pada hal yang dapat dikendalikan. Melalui contoh keseharian, Filosofi Teras memberikan panduan praktis untuk hidup lebih tenang, bijaksana, dan tidak mudah terpengaruh oleh hal di luar kendali kita.', 'https://www.gramedia.com/blog/content/images/2022/06/Filosofi-Teras.jpg', 'Filsafat', 5, 4, 'Yes', 'Yes'),
(29, 'Dunia Anna', 'Jostein Gaarder', 'Mizan Pustaka', 2015, 244, 5, 'Bumi 2082, Nova terkejut mendapat surat dari nenek buyutnya, Anna, yang ditulis 70 tahun lalu. Anna, 16 tahun, resah dengan kondisi lingkungan di masa depan. Novel ini mengajak pembaca merenungkan eksistensi manusia, semesta, dan kerusakan akibat pemanasan global.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/97897943384212_Dunia-Anna.jpg', 'Novel Filsafat', 4, 4, 'No', 'No'),
(30, 'Philosophy 101', 'Paul Kleinman', 'Elex Media Komputindo', 2025, 352, 4, 'Buku ini menukar detail dan metodologi rumit dengan diskusi prinsip filsafat yang menarik. Dari Aristoteles dan Heidegger hingga kehendak bebas dan metafisika, buku ini dikemas dengan ratusan informasi filosofis, ilustrasi, dan teka-teki pikiran.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/product-metas/ik-tsg6a2o.png', 'Filsafat', 4, 4, 'No', 'No'),
(31, 'Dunia Sophie', 'Jostein Gaarder', 'Mizan', 1991, 518, 5, 'Dunia Sophie menceritakan perjalanan seorang remaja bernama Sophie Amundsen yang menerima surat misterius berisi pertanyaan filosofis. Dari sana, ia dibimbing untuk memahami sejarah pemikiran manusia, mulai dari filsuf Yunani Kuno hingga modern. Novel ini menggabungkan cerita dan pelajaran filsafat dengan cara yang ringan, menarik, dan mudah dipahami, sehingga pembaca dapat menikmati alur cerita sembari belajar konsep filsafat yang mendasar.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786024410209_dunia-sophie-republish.jpg', 'Novel Filsafat', 4, 4, 'No', 'Yes'),
(32, 'The Republic', 'Plato', 'Penerbit Narasi', 2021, 532, 5, 'Sebuah dialog Socrates yang ditulis Plato sekitar 375 SM, membahas keadilan, tatanan negara-kota yang adil, dan manusia yang adil. Ini adalah karya Plato paling terkenal dan salah satu karya filsafat dan teori politik paling berpengaruh di dunia.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/ux0r98x5v9.jpg', 'Filsafat', 5, 4, 'No', 'Yes'),
(33, 'The Problems of Philosophy', 'Bertrand Russell', 'Anak Hebat Indonesia', 2023, 192, 5, 'Panduan singkat dan mudah diakses mengenai masalah-masalah filsafat oleh Bertrand Russell. Buku ini mencoba menjawab pertanyaan seperti: Bisakah kita membuktikan dunia eksternal? Bisakah kita memvalidasi generalisasi kita? Dan di mana letak nilai filsafat.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786236699577.jpg', 'Filsafat', 5, 4, 'No', 'Yes'),
(34, 'Meditation', 'Marcus Aurelius', 'Basabasi', 2020, 292, 5, 'Ditulis oleh kaisar Romawi Marcus Aurelius, tanpa niat publikasi. Ini adalah rangkaian refleksi spiritual dan latihan yang dikembangkan saat ia berjuang memahami diri sendiri dan alam semesta. Salah satu karya filsafat terbesar yang dikagumi selama berabad-abad.', 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/products/i2tiz2a463.jpeg', 'Filsafat', 5, 4, 'No', 'Yes'),
(35, '10 Dosa Besar Soeharto', 'Gayo, H. M. Iwan ', 'Galang Press', 2006, 200, 1, '10 Dosa Besar Soeharto membahas berbagai kritik terhadap masa pemerintahan Orde Baru, termasuk isu korupsi, pelanggaran HAM, monopoli ekonomi, serta penyalahgunaan kekuasaan. Buku ini menyajikan analisis tajam mengenai bagaimana kebijakan dan tindakan selama masa pemerintahan Soeharto berdampak besar pada kehidupan sosial, politik, dan ekonomi Indonesia. Melalui pemaparan yang lugas, pembaca diajak melihat sisi gelap kekuasaan yang jarang dibahas secara terbuka pada masa tersebut.', 'https://www.perpustakaankarmelindo.org/lib/minigalnano/createthumb.php?filename=images/docs/30.165..jpg.jpg&width=200', 'Sejarah Politik', 4, 4, 'Yes', 'No');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Novels & Literature'),
(2, 'Self Development'),
(3, 'Comic'),
(4, 'Filsafat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `loan_code` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('booked','borrowed','returned') NOT NULL DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `loans`
--

INSERT INTO `loans` (`id`, `loan_code`, `user_id`, `book_id`, `loan_date`, `due_date`, `status`) VALUES
(1, 'LN-2-1-1764392981', 2, 1, '2025-11-29', '2025-12-29', 'returned'),
(2, 'LN-4-2-1764393020', 4, 2, '2025-11-29', '2025-12-29', 'booked'),
(3, 'LN-2-28-1764393205', 2, 28, '2025-11-29', '2025-12-29', 'returned'),
(4, 'LN-4-3-1764393212', 4, 3, '2025-11-29', '2025-12-29', 'borrowed'),
(5, 'LN-2-13-1764395559', 2, 13, '2025-11-29', '2025-12-29', 'returned'),
(6, 'LN-2-20-1764398485', 2, 20, '2025-11-29', '2025-12-29', 'borrowed'),
(7, 'BKSY-3-35-1764413180', 3, 35, '2025-11-29', '2025-12-29', 'booked'),
(8, 'BKSY-2-21-1764486920', 2, 21, '2025-11-30', '2025-12-30', 'booked'),
(9, 'BKSY-2-1-1764576848', 2, 1, '2025-12-01', '2026-01-01', 'returned'),
(10, 'BKSY-2-12-1764577952', 2, 12, '2025-12-01', '2026-01-01', 'borrowed'),
(11, 'BKSY-2-22-0112202509', 2, 22, '2025-12-01', '2026-01-01', 'booked'),
(12, 'BKSY-3-30-0612202513', 3, 30, '2025-12-06', '2025-12-09', 'borrowed'),
(13, 'BKSY-6-5-07122025142', 6, 5, '2025-12-07', '2025-12-14', 'booked');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `sent_at`) VALUES
(1, 'Danny', 'dannyychr27@gmail.com', 'feedback', 'Website sudah baik, kembangkan lagi!', '2025-11-09 13:02:53'),
(2, 'tes', 'tes@gmail.com', 'request', '10 dosa besar soeharto', '2025-11-09 13:04:40'),
(3, 'sinto', 'sintogendeng@gmail.com', 'request', 'Buku 1001 Tafsir mimpi', '2025-11-09 15:16:36'),
(4, 'ana', 'anakonda@gmail.cococo', 'feedback', 'awas jatoh', '2025-11-09 15:17:50'),
(5, 'cesya', 'cesya@gmail.com', 'feedback', 'oke', '2025-11-10 07:59:41'),
(6, 'cesya2', 'cesyaaulia12@gmail.com', 'request', 'request buku tutorial phpmyadmin', '2025-11-10 08:06:21'),
(7, 'asmbdjkas', 'asjddsjkad@hjsgdk.com', 'feedback', 'asjdkahkad', '2025-11-10 08:11:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `last_active` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `last_active`) VALUES
(1, 'admin', 'admin123', 'admin', '2025-11-30 06:36:47'),
(2, 'user', 'user123', 'user', '2025-12-15 13:05:11'),
(3, 'dani', 'dani123', 'user', '2025-12-06 12:24:45'),
(4, 'cesya', '123', 'user', '2025-12-07 13:29:10'),
(5, 'wiwokdetok', '123456', 'user', '2025-11-29 08:32:34'),
(6, 'hani', 'hani', 'user', '2025-12-07 13:51:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `book_id`, `created_at`) VALUES
(2, 2, 29, '2025-11-29 05:38:20'),
(3, 2, 2, '2025-11-29 06:42:17'),
(4, 2, 10, '2025-11-29 06:42:27'),
(5, 2, 21, '2025-11-29 06:43:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_code` (`loan_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_book_unique` (`user_id`,`book_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
