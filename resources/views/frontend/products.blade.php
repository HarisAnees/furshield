@extends('frontend.layouts.app')

@section('title', 'Pet Essentials & Products — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Header with Search & Sort -->
    <div class="section-head-split reveal">
        <div>
            <div class="section-label">Store Catalog</div>
            <h1>Pet Care <em>Essentials</em></h1>
            <p>Formulated pet nutrition, gentle grooming supplies and healthcare items.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
            <form action="{{ route('products.index') }}" method="GET" class="products-search-form">
                @if(request('category') && request('category') !== 'All')
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <div class="products-search-input-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search products, brands..." 
                           class="form-control" aria-label="Search products">
                    @if(request('search'))
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" 
                           class="clear-search-link" title="Clear search"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>

                <button type="submit" class="btn btn-secondary btn-sm">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- 2. Horizontal Category Switcher & Sort Toolbar -->
    <div class="products-filter-bar reveal delay-1">
        <div class="products-pill-nav">
            @php
                $isAllActive = empty(request('category')) || request('category') === 'All';
            @endphp
            <a href="{{ route('products.index', array_filter(['category' => 'All', 'search' => request('search'), 'sort' => request('sort')])) }}" 
               class="products-pill-btn {{ $isAllActive ? 'active' : '' }}">
                <span>All Products</span>
                <span class="pill-count">{{ $allCount }}</span>
            </a>

            @foreach($availableCategories as $cat)
                @php
                    $isCatActive = request('category') === $cat;
                    $count = $categoryCounts[$cat] ?? 0;
                @endphp
                <a href="{{ route('products.index', array_filter(['category' => $cat, 'search' => request('search'), 'sort' => request('sort')])) }}" 
                   class="products-pill-btn {{ $isCatActive ? 'active' : '' }}">
                    <span>{{ $cat }}</span>
                    <span class="pill-count">{{ $count }}</span>
                </a>
            @endforeach
        </div>

        <!-- Quick Sort Form -->
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted);">
            <label for="sortSelect" style="white-space: nowrap; font-weight: 600;">Sort By:</label>
            <select id="sortSelect" class="form-control" style="border-radius: 9999px; padding: 6px 14px; font-size: 12.5px; border-color: #e4e4e7;"
                    onchange="location.href=this.value;">
                <option value="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search')])) }}" 
                        {{ !request('sort') ? 'selected' : '' }}>Featured & Newest</option>
                <option value="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => 'price_asc'])) }}" 
                        {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => 'price_desc'])) }}" 
                        {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- 3. Active Search / Filter Status Banner -->
    @if(request('search') || (request('category') && request('category') !== 'All'))
        <div class="products-status-banner reveal">
            <div>
                <span>Showing <strong>{{ $products->total() }}</strong> result{{ $products->total() === 1 ? '' : 's' }}</span>
                @if(request('search'))
                    for "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('category') && request('category') !== 'All')
                    in <strong>{{ request('category') }}</strong>
                @endif
            </div>
            <a href="{{ route('products.index') }}" class="clear-filter-btn">
                <span>Reset All Filters</span>
                <span><i class="fa-solid fa-xmark"></i></span>
            </a>
        </div>
    @endif

    <!-- 4. Catalog Layout (Sidebar Categories + Products Grid) -->
    <div class="products-layout-grid reveal delay-1" style="display: grid; grid-template-columns: 260px 1fr; gap: 32px; align-items: start;">
        
        <!-- Categories Sidebar -->
        <div class="products-sidebar-card card card-padded" style="position: sticky; top: 100px;">
            <div class="meta-label" style="margin-bottom: 14px;">Browse Categories</div>

            <div style="display: flex; flex-direction: column; gap: 6px;">
                <a href="{{ route('products.index', array_filter(['category' => 'All', 'search' => request('search'), 'sort' => request('sort')])) }}" 
                   class="category-sidebar-link {{ $isAllActive ? 'active' : '' }}">
                    <span>All Products</span>
                    <span class="side-count">{{ $allCount }}</span>
                </a>

                @foreach($availableCategories as $cat)
                    @php
                        $isCatActive = request('category') === $cat;
                        $count = $categoryCounts[$cat] ?? 0;
                    @endphp
                    <a href="{{ route('products.index', array_filter(['category' => $cat, 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="category-sidebar-link {{ $isCatActive ? 'active' : '' }}">
                        <span>{{ $cat }}</span>
                        <span class="side-count">{{ $count }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Quality Assurance Feature Block -->
            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f0fdf4; display: flex; flex-direction: column; gap: 14px;">
                <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #064e3b;">
                    <i class="fas fa-shield-halved" style="color: #10b981; font-size: 16px;"></i>
                    <span><strong>100% Certified</strong> clinical formulas</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #064e3b;">
                    <i class="fas fa-truck-fast" style="color: #10b981; font-size: 16px;"></i>
                    <span><strong>Free Express Delivery</strong> on orders over $49</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #064e3b;">
                    <i class="fas fa-rotate-left" style="color: #10b981; font-size: 16px;"></i>
                    <span><strong>30-Day Guarantee</strong> on companion satisfaction</span>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 28px; align-items: start;">
                @forelse($products as $p)
                    @php
                        $nameParts = explode(' ', $p->name);
                        $keyword = count($nameParts) > 1 ? end($nameParts) : $p->name;
                        if (strlen($keyword) < 4 && count($nameParts) > 1) {
                            $keyword = $nameParts[count($nameParts) - 2];
                        }
                    @endphp
                    <article class="fe-parallax-product-card">
                        <span class="product-stock-tag">
                            {{ $p->stock_quantity > 0 ? '● In Stock' : 'Out of Stock' }}
                        </span>

                        <div class="assets">
                            <div class="assets-bg"></div>
                            <h3>{{ strtoupper($keyword) }}</h3>
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="product-floating-img" loading="lazy">
                        </div>

                        <div class="blur">
                            <div class="layer" style="--index:1;"></div>
                            <div class="layer" style="--index:2;"></div>
                            <div class="layer" style="--index:3;"></div>
                            <div class="layer" style="--index:4;"></div>
                            <div class="layer" style="--index:5;"></div>
                        </div>

                        <div class="content">
                            <p class="parallax-brand">
                                <i class="fas fa-shield-cat"></i>
                                <span>{{ $p->category ?? 'Care Essential' }}</span>
                            </p>
                            <p class="parallax-title">{{ $p->name }}</p>
                            <p class="parallax-meta">
                                <i>Formulated Care &bull; ${{ number_format($p->price, 2) }}</i>
                            </p>

                            <form action="{{ route('cart.add', $p) }}" method="POST" class="fe-parallax-cart-form">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="fe-parallax-cart-btn">
                                    <span>Add to Cart &bull; ${{ number_format($p->price, 2) }}</span>
                                    <span class="btn-arrow">↗</span>
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="card card-padded" style="grid-column: 1 / -1; text-align: center; padding: 64px 20px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #ecfdf5; color: #059669; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h3 style="font-size: 1.35rem; margin-bottom: 8px; color: #091a13;">No Products Found</h3>
                        <p style="color: var(--muted); max-width: 440px; margin: 0 auto 24px; font-size: 14px; line-height: 1.6;">
                            @if(request('search'))
                                We couldn't find any products matching "<strong>{{ request('search') }}</strong>"
                                @if(request('category') && request('category') !== 'All')
                                    in the <strong>{{ request('category') }}</strong> category.
                                @else
                                    in our catalog.
                                @endif
                            @else
                                There are currently no products available in the <strong>{{ request('category') }}</strong> category.
                            @endif
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                            <span>Browse All Products</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- 5. Pagination Links -->
            @if($products->hasPages())
                <div class="fe-pagination-section">
                    {{ $products->links('frontend.partials.pagination') }}
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
