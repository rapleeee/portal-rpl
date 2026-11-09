@extends('layouts.app')

@section('title', $judul)

@push('styles')
<style>
    .materi-wrap {
        margin-top: 20px;
        padding: clamp(20px, 4vw, 36px);
        background: #ffffff;
        border: 1px solid var(--line);
        border-top: 5px solid var(--orange);
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .materi-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    .materi-header h1 {
        margin: 10px 0 6px;
        font-size: clamp(1.4rem, 3vw, 1.85rem);
        color: var(--ink);
    }
    .materi-header .lead {
        color: var(--muted);
        margin: 0;
        font-size: 0.95rem;
    }

    /* Filter & Search Bar */
    .filter-panel {
        display: flex;
        flex-direction: column;
        gap: 14px;
        background: #f8fafc;
        border: 1px solid var(--line);
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 24px;
    }
    .search-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-input-group input {
        width: 100%;
        padding: 11px 16px 11px 40px;
        font-size: 0.95rem;
        border: 1.5px solid var(--line);
        border-radius: 8px;
        outline: none;
        background: #ffffff;
        color: var(--ink);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .search-input-group input:focus {
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(224, 90, 43, 0.15);
    }
    .search-icon {
        position: absolute;
        left: 14px;
        color: var(--muted);
        display: flex;
        align-items: center;
        pointer-events: none;
    }
    .category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .category-btn {
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 20px;
        border: 1px solid var(--line);
        background: #ffffff;
        color: var(--muted);
        cursor: pointer;
        transition: all .15s ease;
    }
    .category-btn:hover {
        background: #f1f5f9;
        color: var(--ink);
    }
    .category-btn.active {
        background: var(--navy);
        color: #ffffff;
        border-color: var(--navy);
    }

    /* Stats Overview */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .stat-text {
        display: flex;
        flex-direction: column;
    }
    .stat-count {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--ink);
    }
    .stat-label {
        font-size: 0.75rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Grid Kartu Materi */
    .materi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 18px;
    }
    .materi-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .materi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }
    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .meta-tag {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tag-laravel { background: #fee2e2; color: #b91c1c; }
    .tag-database { background: #e0f2fe; color: #0369a1; }
    .tag-git { background: #ffedd5; color: #c2410c; }
    .tag-frontend { background: #ede9fe; color: #6d28d9; }
    .tag-api { background: #dcfce7; color: #15803d; }

    .meta-pert {
        font-size: 0.8rem;
        color: var(--muted);
        font-weight: 600;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink);
        margin: 0 0 8px;
        line-height: 1.4;
    }
    .card-desc {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.5;
        margin: 0 0 16px;
        flex-grow: 1;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 14px;
        border-top: 1px solid var(--line);
        font-size: 0.82rem;
    }
    .guru-info {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--muted);
    }
    .btn-detail {
        padding: 6px 14px;
        background: #f1f5f9;
        color: var(--navy);
        font-weight: 600;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
    }
    .btn-detail:hover {
        background: var(--navy);
        color: #ffffff;
    }

    /* Status Kosong */
    .empty-state {
        text-align: center;
        padding: 48px 16px;
        background: #f8fafc;
        border: 2px dashed var(--line);
        border-radius: 12px;
        grid-column: 1 / -1;
    }
    .empty-state svg {
        margin-bottom: 12px;
        color: var(--muted);
    }
    .empty-state h3 {
        margin: 0 0 6px;
        color: var(--ink);
    }
    .empty-state p {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
    }

    /* Modal Detail Materi */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
        z-index: 100;
    }
    .modal-backdrop.show {
        display: flex;
    }
    .modal-content {
        background: #ffffff;
        border-radius: 14px;
        max-width: 540px;
        width: 100%;
        padding: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }
    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: var(--ink);
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.4rem;
        cursor: pointer;
        color: var(--muted);
        line-height: 1;
        padding: 4px;
    }
    .modal-close:hover {
        color: var(--ink);
    }
    .modal-body {
        font-size: 0.92rem;
        color: #334155;
        line-height: 1.6;
    }
    .modal-body ul {
        padding-left: 20px;
        margin: 10px 0;
    }
</style>
@endpush

@section('content')
    <section class="materi-wrap" aria-labelledby="judul-fitur">
        <div class="materi-header">
            <div>
                <span class="badge">Absen {{ $nomor }}</span>
                <h1 id="judul-fitur">{{ $judul }}</h1>
                <p class="lead">Kumpulan modul belajar, silabus, dan ringkasan pembelajaran kejuruan XI RPL SMK PESAT.</p>
            </div>
        </div>

        <!-- Statistik Ringkas -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fee2e2; color:#b91c1c;">LV</div>
                <div class="stat-text">
                    <span class="stat-count" id="count-total">6</span>
                    <span class="stat-label">Total Modul</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#e0f2fe; color:#0369a1;">BK</div>
                <div class="stat-text">
                    <span class="stat-count">5</span>
                    <span class="stat-label">Topik Utama</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#dcfce7; color:#15803d;">SM</div>
                <div class="stat-text">
                    <span class="stat-count">Genap</span>
                    <span class="stat-label">Semester</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="filter-panel">
            <div class="search-input-group">
                <span class="search-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Cari materi pembelajaran, topik, atau kata kunci..." autocomplete="off">
            </div>
            <div class="category-pills">
                <button type="button" class="category-btn active" data-category="semua">Semua Topik</button>
                <button type="button" class="category-btn" data-category="laravel">Laravel</button>
                <button type="button" class="category-btn" data-category="database">Database</button>
                <button type="button" class="category-btn" data-category="git">Git & GitHub</button>
                <button type="button" class="category-btn" data-category="frontend">Frontend</button>
                <button type="button" class="category-btn" data-category="api">Web API</button>
            </div>
        </div>

        <!-- Grid Materi -->
        <div class="materi-grid" id="materiGrid">
            <!-- Card 1 -->
            <article class="materi-card" data-category="git" data-title="git version control & pull request" data-desc="pengantar manajemen versi kode branching pull request di github dan kolaborasi tim">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-git">Git & GitHub</span>
                        <span class="meta-pert">Pertemuan 1-2</span>
                    </div>
                    <h2 class="card-title">Version Control & GitHub Workflow</h2>
                    <p class="card-desc">Memahami konsep Git commit, branching strategy (`feat/`, `fix/`), hingga alur Pull Request & code review kolaboratif di GitHub.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('Version Control & GitHub Workflow', 'Git & GitHub', 'Pertemuan 1-2', 'Materi ini membahas dasar-dasar version control yang menjadi standar industri software engineering.', ['Inisialisasi repo & konfigurasi Git', 'Stage, commit, checkout branch baru', 'Remote repository & Push ke GitHub', 'Membuat Pull Request dan penanganan merge conflict'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Card 2 -->
            <article class="materi-card" data-category="laravel" data-title="laravel routing & blade templating" data-desc="konsep arsitektur mvc dasar routing request controller dan inheritance layout blade">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-laravel">Laravel</span>
                        <span class="meta-pert">Pertemuan 3-4</span>
                    </div>
                    <h2 class="card-title">Routing & Blade Templating Engine</h2>
                    <p class="card-desc">Fondasi arsitektur MVC pada Laravel: konfigurasi rute web, parsing parameter URL, passing data ke View, dan template inheritance.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('Routing & Blade Templating Engine', 'Laravel', 'Pertemuan 3-4', 'Mendalami bagaimana rute HTTP memetakan request ke template Blade yang bersih dan modular.', ['Struktur direktori Laravel', 'Route Web & Route Model Binding', 'Sintaks Blade (extends, section, yield, push)', 'Komponen dan pemanfaatan asset helper'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Card 3 -->
            <article class="materi-card" data-category="database" data-title="database migration & eloquent orm" data-desc="skema tabel migrasi mysql relasi antar tabel one to many dan query builder eloquent">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-database">Database</span>
                        <span class="meta-pert">Pertemuan 5-6</span>
                    </div>
                    <h2 class="card-title">Database Migration & Eloquent ORM</h2>
                    <p class="card-desc">Perancangan struktur tabel yang aman menggunakan migration, seeding dummy data, dan manipulasi data interaktif dengan model Eloquent.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('Database Migration & Eloquent ORM', 'Database', 'Pertemuan 5-6', 'Transformasi database relasional menggunakan pendekatan Object-Relational Mapping (ORM).', ['Membuat migration table via artisan', 'Database seeder & Model factories', 'Query Eloquent CRUD (Create, Read, Update, Delete)', 'Relasi hasMany, belongsTo, dan eager loading'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Card 4 -->
            <article class="materi-card" data-category="laravel" data-title="form handling validasi input & session flash" data-desc="pengelolaan formulir csrf token validasi data request pesan error feedback session">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-laravel">Laravel</span>
                        <span class="meta-pert">Pertemuan 7-8</span>
                    </div>
                    <h2 class="card-title">Form Handling & Request Validation</h2>
                    <p class="card-desc">Teknik pemrosesan formulir yang aman dengan proteksi CSRF, validasi data pengguna di server-side, serta notifikasi flash message.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('Form Handling & Request Validation', 'Laravel', 'Pertemuan 7-8', 'Standarisasi pemrosesan input formulir pengguna agar aman dari eksploitasi dan memberikan user experience yang baik.', ['Pentingnya proteksi CSRF pada form', 'Form Request Validation class', 'Kustomisasi pesan error input dalam Bahasa Indonesia', 'Penggunaan session()->flash() untuk alert notifikasi'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Card 5 -->
            <article class="materi-card" data-category="frontend" data-title="css modern flexbox grid & responsive design" data-desc="antarmuka web responsif css variable layout flexbox css grid mobile first">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-frontend">Frontend</span>
                        <span class="meta-pert">Pertemuan 9-10</span>
                    </div>
                    <h2 class="card-title">CSS Modern: Flexbox & Layout Grid</h2>
                    <p class="card-desc">Mendesain halaman web interaktif yang responsif di berbagai perangkat menggunakan CSS Custom Properties, Flexbox, dan Grid.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('CSS Modern: Flexbox & Layout Grid', 'Frontend', 'Pertemuan 9-10', 'Memperdalam kemampuan menyusun antarmuka modern tanpa ketergantungan framework CSS yang berlebihan.', ['CSS Variables untuk color palette & spacing', 'Pola Flexbox untuk alignment navbar & card list', 'CSS Grid untuk dashboard multidimensi', 'Media query & pendekatan Mobile-first design'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Card 6 -->
            <article class="materi-card" data-category="api" data-title="restful api dasar & integrasi json" data-desc="pembuatan endpoint api status code json response fetch api javascript">
                <div>
                    <div class="card-meta">
                        <span class="meta-tag tag-api">Web API</span>
                        <span class="meta-pert">Pertemuan 11-12</span>
                    </div>
                    <h2 class="card-title">RESTful API & Integrasi JSON</h2>
                    <p class="card-desc">Konsep komunikasi client-server melalui API berformat JSON, implementasi HTTP status code, dan pemanggilan via Fetch API JavaScript.</p>
                </div>
                <div class="card-footer">
                    <span class="guru-info">👤 Tim Guru RPL</span>
                    <button type="button" class="btn-detail" onclick="openDetail('RESTful API & Integrasi JSON', 'Web API', 'Pertemuan 11-12', 'Mempersiapkan siswa memahami bagaimana backend Laravel berkomunikasi dengan frontend modern atau mobile app.', ['Prinsip arsitektur REST', 'Resource controller & API resource responses', 'HTTP status codes (200, 201, 400, 404, 500)', 'Async Fetch API pada JavaScript modern'])">Lihat Silabus</button>
                </div>
            </article>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <h3>Materi tidak ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian lain atau pilih kategori topik yang berbeda.</p>
            </div>
        </div>
    </section>

    <!-- Modal Detail Silabus -->
    <div class="modal-backdrop" id="detailModal" onclick="closeModalOnBackdrop(event)">
        <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-header">
                <div>
                    <span class="badge" id="modalBadge" style="margin-bottom:6px;">Kategori</span>
                    <h3 id="modalTitle">Judul Materi</h3>
                </div>
                <button type="button" class="modal-close" onclick="closeDetail()" aria-label="Tutup modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="modalDesc"></p>
                <strong>Poin Pembahasan:</strong>
                <ul id="modalPoints"></ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const categoryBtns = document.querySelectorAll('.category-btn');
    const cards = document.querySelectorAll('.materi-card');
    const emptyState = document.getElementById('emptyState');
    const countTotal = document.getElementById('count-total');

    let activeCategory = 'semua';
    let searchQuery = '';

    function filterMateri() {
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDesc = card.getAttribute('data-desc') || '';

            const matchesCategory = (activeCategory === 'semua' || cardCategory === activeCategory);
            const matchesSearch = !searchQuery || cardTitle.includes(searchQuery) || cardDesc.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (countTotal) {
            countTotal.textContent = visibleCount;
        }

        if (visibleCount === 0) {
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }

    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase().trim();
        filterMateri();
    });

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.getAttribute('data-category');
            filterMateri();
        });
    });

    // Modal logic
    function openDetail(title, category, pertemuan, desc, points) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalBadge').textContent = `${category} · ${pertemuan}`;
        document.getElementById('modalDesc').textContent = desc;
        
        const listContainer = document.getElementById('modalPoints');
        listContainer.innerHTML = '';
        points.forEach(point => {
            const li = document.createElement('li');
            li.textContent = point;
            listContainer.appendChild(li);
        });

        const modal = document.getElementById('detailModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    function closeModalOnBackdrop(e) {
        if (e.target.id === 'detailModal') {
            closeDetail();
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetail();
        }
    });
</script>
@endpush
