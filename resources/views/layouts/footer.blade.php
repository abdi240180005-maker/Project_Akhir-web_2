<footer class="bg-white border-top py-3 px-4 text-muted mt-auto" style="font-size: 0.85rem; border-color: rgba(0,0,0,0.08) !important;">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <div>
            &copy; {{ date('Y') }} <strong class="text-dark">Global Supply Chain Risk Intelligence System</strong>
        </div>

        <!-- API Sources Pills / Badges -->
        <div class="d-flex align-items-center flex-wrap gap-2">
            <span class="text-secondary small me-1"><i class="bi bi-cpu me-1"></i>Sumber Data API:</span>
            <span class="badge bg-light text-dark border fw-normal py-1 px-2" title="Prakiraan Cuaca Real-time"><i class="bi bi-cloud-sun text-warning me-1"></i>Open-Meteo</span>
            <span class="badge bg-light text-dark border fw-normal py-1 px-2" title="Kurs Mata Uang Global"><i class="bi bi-currency-exchange text-success me-1"></i>Open ER-API</span>
            <span class="badge bg-light text-dark border fw-normal py-1 px-2" title="Berita Logistik & Supply Chain"><i class="bi bi-newspaper text-primary me-1"></i>GNews</span>
            <span class="badge bg-light text-dark border fw-normal py-1 px-2" title="Indikator Ekonomi World Bank"><i class="bi bi-bank text-info me-1"></i>World Bank</span>
            <span class="badge bg-light text-dark border fw-normal py-1 px-2" title="Informasi Geografis Negara"><i class="bi bi-globe text-secondary me-1"></i>REST Countries</span>
            <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 ms-1 fw-semibold text-primary" data-bs-toggle="modal" data-bs-target="#apiSourcesModal" style="font-size: 0.82rem;">
                <i class="bi bi-info-circle me-1"></i>Detail API
            </button>
        </div>
    </div>
</footer>

<!-- Modal Detail API & Sumber Data -->
<div class="modal fade" id="apiSourcesModal" tabindex="-1" aria-labelledby="apiSourcesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--midnight-blue, #0B0C10);">
                <h5 class="modal-title fs-6 fw-bold" id="apiSourcesModalLabel">
                    <i class="bi bi-code-slash text-warning me-2"></i>Integrasi API & Sumber Data Terpakai
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8f9fa;">
                <p class="text-muted small mb-3">
                    Sistem Global Supply Chain Risk Intelligence terintegrasi secara langsung dengan beberapa penyedia API & Layanan Data Publik berikut:
                </p>

                <div class="row g-3">
                    <!-- Open-Meteo -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-cloud-sun text-warning me-2"></i>Open-Meteo API</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif 🟢</span>
                                </div>
                                <p class="text-muted small mb-2">Prakiraan cuaca real-time (suhu, kelembapan, kecepatan angin) berdasarkan koordinat lokasi.</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    https://api.open-meteo.com/v1/forecast
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Open ER-API -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-currency-exchange text-success me-2"></i>Open ER-API</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif 🟢</span>
                                </div>
                                <p class="text-muted small mb-2">Data nilai tukar mata uang global (Exchange Rates) real-time terhadap USD dan mata uang lain.</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    https://open.er-api.com/v6/latest/USD
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GNews API -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-newspaper text-primary me-2"></i>GNews API</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif 🟢</span>
                                </div>
                                <p class="text-muted small mb-2">Penarikan artikel berita global seputar isu logistik, rantai pasok, dan kondisi politik-ekonomi.</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    https://gnews.io/api/v4/search
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- World Bank Indicators -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bank text-info me-2"></i>World Bank API</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif 🟢</span>
                                </div>
                                <p class="text-muted small mb-2">Indikator statistik ekonomi makro makro (GDP & Tingkat Inflasi tahunan tiap negara).</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    https://api.worldbank.org/v2/country/...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REST Countries -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-globe text-secondary me-2"></i>REST Countries API</h6>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif 🟢</span>
                                </div>
                                <p class="text-muted small mb-2">Informasi demografi negara (nama, bendera, bahasa, populasi, dan wilayah geografis).</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    https://restcountries.com/v3.1/...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- World Port Index (Pub150) -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-geo-alt-fill text-danger me-2"></i>NGA World Port Index</h6>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Dataset CSV 📄</span>
                                </div>
                                <p class="text-muted small mb-2">Database pelabuhan maritim internasional beserta titik koordinat dan kode negara.</p>
                                <div class="bg-light p-2 rounded text-break font-monospace small text-secondary" style="font-size: 0.75rem;">
                                    National Geospatial-Intelligence Agency (Pub 150)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

