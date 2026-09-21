@extends('admin.layouts.app')

@section('title', 'Marketplace Products')
@section('page_title', 'Products & Pharmacy Catalog')
@section('page_subtitle', 'Manage pet foods, medical supplies, accessories, and inventory pricing.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.products.index') }}" class="filter-pill-link {{ !request('category') ? 'active' : '' }}">
            All Products
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('admin.products.index', ['category' => $cat]) }}" class="filter-pill-link {{ request('category') === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.products.index') }}" class="toolbar-search">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search catalog items..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.products.index', request()->only('category')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createProductModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Product
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-sm" style="background: #f1f5f9; font-size: 16px;">
                                    📦
                                </div>
                                <div class="user-info-meta">
                                    <strong style="color: #0f172a;">{{ $prod->name }}</strong>
                                    <small style="color: #64748b;">{{ \Illuminate\Support\Str::limit($prod->description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-teal">{{ $prod->category }}</span>
                        </td>
                        <td>
                            <strong style="font-size: 13px; color: #0f172a;">${{ number_format($prod->price, 2) }}</strong>
                        </td>
                        <td>
                            @if($prod->stock_quantity > 15)
                                <span class="badge badge-success">{{ $prod->stock_quantity }} in stock</span>
                            @elseif($prod->stock_quantity > 0)
                                <span class="badge badge-warning">{{ $prod->stock_quantity }} low stock</span>
                            @else
                                <span class="badge badge-danger">Out of stock</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $prod->is_active ? 'badge-success' : 'badge-gray' }}">
                                <span class="badge-dot"></span> {{ $prod->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary btn-sm" onclick='editProduct(@json($prod))'>Edit</button>
                                <form method="POST" action="{{ route('admin.products.destroy', $prod) }}" onsubmit="return confirm('Delete {{ $prod->name }}?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <span class="empty-state-icon">🛍️</span>
                                <h4>No products found</h4>
                                <p>Add supplies and medication to your online marketplace catalog.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $products->links() }}
        </div>
    @endif
</div>

<!-- Create Product Modal -->
<div class="modal-overlay" id="createProductModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Store Catalog</span>
                <h3>Add New Product</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createProductModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Premium Grain-Free Salmon Recipe">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="Pet Food">Pet Food</option>
                            <option value="Health & Wellness">Health & Wellness</option>
                            <option value="Grooming">Grooming</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Toys">Toys</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Price ($) *</label>
                        <input type="number" step="0.01" name="price" class="form-control" required placeholder="24.99">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" class="form-control" required placeholder="100">
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span>Publish to Marketplace</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Detail nutritional facts, usage directions..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createProductModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal-overlay" id="editProductModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Inventory Management</span>
                <h3>Edit Product</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('editProductModal')" aria-label="Close modal">&times;</button>
        </div>
        <form id="editProductForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" id="edit_prod_name" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category" id="edit_prod_category" class="form-select" required>
                            <option value="Pet Food">Pet Food</option>
                            <option value="Health & Wellness">Health & Wellness</option>
                            <option value="Grooming">Grooming</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Toys">Toys</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Price ($) *</label>
                        <input type="number" step="0.01" name="price" id="edit_prod_price" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Stock Quantity *</label>
                        <input type="number" name="stock_quantity" id="edit_prod_stock" class="form-control" required>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="is_active" id="edit_prod_active" value="1">
                            <span>Publish to Marketplace</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" id="edit_prod_description" class="form-textarea"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editProductModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function editProduct(prod) {
    document.getElementById('editProductForm').action = '/admin/products/' + prod.id;
    document.getElementById('edit_prod_name').value = prod.name || '';
    document.getElementById('edit_prod_category').value = prod.category || 'Pet Food';
    document.getElementById('edit_prod_price').value = prod.price || '';
    document.getElementById('edit_prod_stock').value = prod.stock_quantity || 0;
    document.getElementById('edit_prod_active').checked = !!prod.is_active;
    document.getElementById('edit_prod_description').value = prod.description || '';
    openModal('editProductModal');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
