@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Product List</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<!-- Charts section -->
<div class="row mb-4">
    <div class="col-12 mb-2">
        <div class="d-flex gap-2 align-items-center">
            <label class="mb-0">Filter:</label>
            <select id="filterMonth" class="form-select form-select-sm" style="width:auto;">
                <option value="all"> Semua Bulan </option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>

            <select id="filterYear" class="form-select form-select-sm" style="width:auto;">
                <option value="all"> Semua Tahun </option>
            </select>

            <button id="filterReset" class="btn btn-sm btn-outline-secondary">Reset</button>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">Grafik Stok Produk</div>
            <div class="card-body">
                <canvas id="stockChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">Grafik Harga Produk</div>
            <div class="card-body">
                <canvas id="priceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td>
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" style="max-width:60px; height:auto;" class="me-2">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->stock }}</td>
                <td>{{ number_format($p->price, 0, '.', ',') }}</td>
                <td class="text-center">
                    <a href="{{ route('products.edit',$p->id) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>

                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-action="{{ route('products.destroy', $p->id) }}" data-name="{{ $p->name }}">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus <strong id="deleteItemName">item ini</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelDeleteBtn">Tidak</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" data-loading-text="Menghapus...">Iya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form used to submit DELETE requests -->
<form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
</form>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        // Delete modal handling (existing)
        const deleteModalEl = document.getElementById('deleteModal');
        if (deleteModalEl) {
            const deleteModal = new bootstrap.Modal(deleteModalEl);
            const deleteItemName = document.getElementById('deleteItemName');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function(){
                    const action = this.getAttribute('data-action');
                    const name = this.getAttribute('data-name') || 'item ini';
                    deleteItemName.textContent = name;
                    deleteForm.setAttribute('action', action);
                    deleteModal.show();
                });
            });

            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const cancelBtn = document.getElementById('cancelDeleteBtn');

            confirmBtn.addEventListener('click', function(){
                if (confirmBtn.disabled) return; // prevent double-click

                // disable buttons and show spinner
                confirmBtn.disabled = true;
                if (cancelBtn) cancelBtn.disabled = true;

                const loadingText = confirmBtn.getAttribute('data-loading-text') || 'Loading...';
                // store original text
                if (!confirmBtn._origHtml) confirmBtn._origHtml = confirmBtn.innerHTML;
                confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + loadingText;

                // submit the hidden form
                deleteForm.submit();
            });
        }

        // Chart.js: render stock and price charts
        // use precomputed chart data passed from the controller
        const products = @json($productsForChart);
        // prepare chart instances and update function
        let stockChartInstance = null;
        let priceChartInstance = null;

        function buildOrUpdateCharts(filtered) {
            const labels = filtered.map(p => p.name);
            const stockData = filtered.map(p => Number(p.stock));
            const priceData = filtered.map(p => Number(p.price));

            const stockCtx = document.getElementById('stockChart').getContext('2d');
            if (stockChartInstance) {
                stockChartInstance.data.labels = labels;
                stockChartInstance.data.datasets[0].data = stockData;
                stockChartInstance.update();
            } else {
                stockChartInstance = new Chart(stockCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Stock',
                            data: stockData,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            const priceCtx = document.getElementById('priceChart').getContext('2d');
            if (priceChartInstance) {
                priceChartInstance.data.labels = labels;
                priceChartInstance.data.datasets[0].data = priceData;
                priceChartInstance.update();
            } else {
                priceChartInstance = new Chart(priceCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Price',
                            data: priceData,
                            borderColor: 'rgba(255,99,132,0.8)',
                            backgroundColor: 'rgba(255,99,132,0.2)',
                            fill: true,
                            tension: 0.2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        }

        // utility: parse product created_at and filter
        function getFilteredProducts(month, year) {
            if ((!month || month === 'all') && (!year || year === 'all')) return products;

            return products.filter(p => {
                if (!p.created_at) return false; // skip if no date
                const d = new Date(p.created_at);
                const m = d.getMonth() + 1; // 1-12
                const y = d.getFullYear();
                if (month && month !== 'all' && Number(month) !== m) return false;
                if (year && year !== 'all' && Number(year) !== y) return false;
                return true;
            });
        }

        // populate year select based on available product dates
        (function populateYearSelect(){
            const yearSelect = document.getElementById('filterYear');
            if (!yearSelect) return;
            const years = new Set();
            products.forEach(p => { if (p.created_at){ years.add(new Date(p.created_at).getFullYear()); } });
            const sorted = Array.from(years).sort((a,b) => b - a);
            sorted.forEach(y => {
                const opt = document.createElement('option');
                opt.value = String(y);
                opt.textContent = String(y);
                yearSelect.appendChild(opt);
            });
        })();

        // initial render
        buildOrUpdateCharts(products);

        // wire selectors
        const monthSelect = document.getElementById('filterMonth');
        const yearSelect = document.getElementById('filterYear');
        const resetBtn = document.getElementById('filterReset');

        function applyFilters(){
            const m = monthSelect ? monthSelect.value : 'all';
            const y = yearSelect ? yearSelect.value : 'all';
            const filtered = getFilteredProducts(m, y);
            buildOrUpdateCharts(filtered.length ? filtered : []);
        }

        if (monthSelect) monthSelect.addEventListener('change', applyFilters);
        if (yearSelect) yearSelect.addEventListener('change', applyFilters);
        if (resetBtn) resetBtn.addEventListener('click', function(){
            if (monthSelect) monthSelect.value = 'all';
            if (yearSelect) yearSelect.value = 'all';
            applyFilters();
        });
    })();
</script>
@endsection
