// Menunggu hingga seluruh halaman HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // --- FITUR: FLOATING BUBBLES GENERATOR ---
    const bubblesContainer = document.querySelector('.bubbles-container');
    
    // Hanya jalankan jika container ada (mencegah error di halaman yang ga pake header ini)
    if (bubblesContainer) {
        
        function createBubble() {
            const bubble = document.createElement('span');
            bubble.classList.add('bubble');

            // 1. Ukuran Random (antara 20px sampai 80px)
            const size = Math.random() * 60 + 20 + 'px';
            bubble.style.width = size;
            bubble.style.height = size;

            // 2. Posisi Horizontal Random (0% sampai 100% layar)
            bubble.style.left = Math.random() * 100 + '%';

            // 3. Kecepatan Animasi Random (antara 5s sampai 15s)
            // Semakin besar bubble, biasanya semakin lambat atau cepat (terserah logika)
            // Di sini kita buat full random
            const duration = Math.random() * 10 + 5 + 's';
            bubble.style.animationDuration = duration;

            // 4. Delay Random (biar ga muncul barengan banget)
            // bubble.style.animationDelay = Math.random() * 5 + 's';

            bubblesContainer.appendChild(bubble);

            // 5. Hapus elemen setelah animasi selesai (PENTING biar memori browser ga penuh)
            // Kita ambil angka detiknya (misal 10s -> 10000ms)
            setTimeout(() => {
                bubble.remove();
            }, parseFloat(duration) * 1000);
        }

        // Buat bubble baru setiap 500ms (setengah detik)
        setInterval(createBubble, 500);
    }
    // Dark mode
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;

    // Fungsi untuk mengaktifkan dark mode
    const enableDarkMode = () => {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark'); // Simpan preferensi
        if (darkModeToggle) {
            darkModeToggle.querySelector('span').textContent = 'light_mode'; // Ubah ikon
        }
    };

    // Fungsi untuk menonaktifkan dark mode
    const disableDarkMode = () => {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light'); // Simpan preferensi
         if (darkModeToggle) {
            darkModeToggle.querySelector('span').textContent = 'dark_mode'; // Ubah ikon
        }
    };

    // Cek preferensi tema dari local storage saat halaman dimuat
    if (localStorage.getItem('theme') === 'dark') {
        enableDarkMode();
    }

    // Event listener untuk tombol toggle
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark-mode')) {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });
    }

    // Menambahkan efek klik pada semua kartu buku agar mengarah ke halaman detail
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        card.addEventListener('click', function(event) {
            // Cek jika yang diklik bukan link di dalam card
            if (event.target.tagName !== 'A' && !event.target.closest('a')) {
                const link = card.querySelector('a');
                if (link && link.href) {
                    window.location.href = link.href; // Arahkan ke link detail
                }
            }
        });
    });

});

// --- Logika Toggle View All / View Less ---

// Temukan SEMUA tombol View All di halaman
const allViewAllButtons = document.querySelectorAll('.view-all-btn');
allViewAllButtons.forEach(button => {
    button.addEventListener('click', function() {
        // 1. Temukan section induk terdekat
        const parentSection = this.closest('.category-section, .popular-section');
        if (!parentSection) return;

        // 2. Tambahkan class 'show-all' ke section
        parentSection.classList.add('show-all');
        
        // 3. Sembunyikan tombol "View All"
        this.style.display = 'none';
        
        // 4. Tampilkan tombol "View Less"
        const viewLessBtn = parentSection.querySelector('.view-less-btn');
        if (viewLessBtn) {
            viewLessBtn.style.display = 'inline-block';
        }
    });
});

// Temukan SEMUA tombol View Less di halaman
const allViewLessButtons = document.querySelectorAll('.view-less-btn');
allViewLessButtons.forEach(button => {
    button.addEventListener('click', function() {
        // 1. Temukan section induk terdekat
        const parentSection = this.closest('.category-section, .popular-section');
        if (!parentSection) return;

        // 2. Hapus class 'show-all' dari section
        parentSection.classList.remove('show-all');
        
        // 3. Sembunyikan tombol "View Less"
        this.style.display = 'none';
        
        // 4. Tampilkan tombol "View All"
        const viewAllBtn = parentSection.querySelector('.view-all-btn');
        if (viewAllBtn) {
            viewAllBtn.style.display = 'inline-block';
        }
    });
});

// --- Search Bar ---
// --- Search Bar (Trigger: Enter Key) ---
const searchInput = document.getElementById('search-input');

if (searchInput) {
    // Gunakan 'keypress' untuk mendeteksi tombol yang ditekan
    searchInput.addEventListener('keypress', function(event) {
        
        // Cek apakah tombol yang ditekan adalah ENTER
        if (event.key === 'Enter') {
            event.preventDefault(); // Mencegah form submit default (biar ga refresh)

            const searchQuery = searchInput.value.toLowerCase().trim();
            
            // 1. DAFTAR ELEMEN PENGGANGGU (Yang mau disembunyikan)
            const distractions = document.querySelectorAll('.hero-section, .about-hero, .page-header, .about-content, .stats-grid, .team-section, .values-grid');
            
            // 2. DAFTAR SECTION BUKU
            const bookSections = document.querySelectorAll('.category-section, .popular-section, .wishlist-section, .mybooks-section');

            // --- LOGIKA PENCARIAN ---
            
            if (searchQuery.length > 0) {
                // A. MODE PENCARIAN AKTIF (Hanya jalan setelah Enter)
                
                // Sembunyikan elemen pengganggu (Hero, dll) biar buku naik ke atas
                distractions.forEach(el => el.style.display = 'none');

                // Loop setiap section buku
                bookSections.forEach(section => {
                    const bookGrid = section.querySelector('.book-grid');
                    if (!bookGrid) return; 

                    const allBooks = bookGrid.querySelectorAll('.book-card');
                    let visibleBookCount = 0;

                    allBooks.forEach(book => {
                        const title = book.querySelector('.book-info h3')?.textContent.toLowerCase() || '';
                        const author = book.querySelector('.book-info p')?.textContent.toLowerCase() || '';
                        const tag = book.querySelector('.book-cover .tag')?.textContent.toLowerCase() || '';

                        // Cek kecocokan
                        if (title.includes(searchQuery) || author.includes(searchQuery) || tag.includes(searchQuery)) {
                            book.style.display = 'block'; 
                            book.classList.remove('hidden-book'); // Paksa muncul
                            visibleBookCount++;
                        } else {
                            book.style.display = 'none'; 
                        }
                    });

                    // Cek pesan "No Results"
                    const noResultsMsg = section.querySelector('.no-results-message');
                    if (noResultsMsg) {
                        if (visibleBookCount > 0) {
                            section.style.display = 'block';
                            noResultsMsg.style.display = 'none';
                        } else {
                            section.style.display = 'none'; 
                        }
                    }
                    
                    // Sembunyikan tombol View All saat mode search
                    const viewBtns = section.querySelector('.view-all-container');
                    if(viewBtns) viewBtns.style.display = 'none';
                });

            } else {
                // B. RESET (Jika Enter ditekan saat kosong)
                // Reload halaman untuk mengembalikan tampilan semula
                window.location.reload(); 
            }
        }
    });
}


const borrowButton = document.getElementById('borrow-btn');
if (borrowButton) {
    borrowButton.addEventListener('click', function() {
        alert('Proses peminjaman buku Anda dimulai!');
    });
}




        