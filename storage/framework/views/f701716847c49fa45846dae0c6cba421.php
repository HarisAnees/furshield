<?php $__env->startSection('title', 'Pet Essentials & Products — FurShield'); ?>

<?php $__env->startSection('content'); ?>
<div class="container section">

    <!-- 1. Header with Search & Sort -->
    <div class="section-head-split reveal">
        <div>
            <div class="section-label">Store Catalog</div>
            <h1>Pet Care <em>Essentials</em></h1>
            <p>Formulated pet nutrition, gentle grooming supplies and healthcare items.</p>
        </div>

        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="products-search-form">
                <?php if(request('category') && request('category') !== 'All'): ?>
                    <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                <?php endif; ?>
                <?php if(request('sort')): ?>
                    <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                <?php endif; ?>

                <div class="products-search-input-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Search products, brands..." 
                           class="form-control" aria-label="Search products">
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')]))); ?>" 
                           class="clear-search-link" title="Clear search">✕</a>
                    <?php endif; ?>
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
            <?php
                $isAllActive = empty(request('category')) || request('category') === 'All';
            ?>
            <a href="<?php echo e(route('products.index', array_filter(['category' => 'All', 'search' => request('search'), 'sort' => request('sort')]))); ?>" 
               class="products-pill-btn <?php echo e($isAllActive ? 'active' : ''); ?>">
                <span>All Products</span>
                <span class="pill-count"><?php echo e($allCount); ?></span>
            </a>

            <?php $__currentLoopData = $availableCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isCatActive = request('category') === $cat;
                    $count = $categoryCounts[$cat] ?? 0;
                ?>
                <a href="<?php echo e(route('products.index', array_filter(['category' => $cat, 'search' => request('search'), 'sort' => request('sort')]))); ?>" 
                   class="products-pill-btn <?php echo e($isCatActive ? 'active' : ''); ?>">
                    <span><?php echo e($cat); ?></span>
                    <span class="pill-count"><?php echo e($count); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Quick Sort Form -->
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted);">
            <label for="sortSelect" style="white-space: nowrap; font-weight: 600;">Sort By:</label>
            <select id="sortSelect" class="form-control" style="border-radius: 9999px; padding: 6px 14px; font-size: 12.5px; border-color: #e4e4e7;"
                    onchange="location.href=this.value;">
                <option value="<?php echo e(route('products.index', array_filter(['category' => request('category'), 'search' => request('search')]))); ?>" 
                        <?php echo e(!request('sort') ? 'selected' : ''); ?>>Featured & Newest</option>
                <option value="<?php echo e(route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => 'price_asc']))); ?>" 
                        <?php echo e(request('sort') === 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                <option value="<?php echo e(route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => 'price_desc']))); ?>" 
                        <?php echo e(request('sort') === 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- 3. Active Search / Filter Status Banner -->
    <?php if(request('search') || (request('category') && request('category') !== 'All')): ?>
        <div class="products-status-banner reveal">
            <div>
                <span>Showing <strong><?php echo e($products->total()); ?></strong> result<?php echo e($products->total() === 1 ? '' : 's'); ?></span>
                <?php if(request('search')): ?>
                    for "<strong><?php echo e(request('search')); ?></strong>"
                <?php endif; ?>
                <?php if(request('category') && request('category') !== 'All'): ?>
                    in <strong><?php echo e(request('category')); ?></strong>
                <?php endif; ?>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="clear-filter-btn">
                <span>Reset All Filters</span>
                <span>✕</span>
            </a>
        </div>
    <?php endif; ?>

    <!-- 4. Catalog Layout (Sidebar Categories + Products Grid) -->
    <div class="products-layout-grid reveal delay-1" style="display: grid; grid-template-columns: 260px 1fr; gap: 32px; align-items: start;">
        
        <!-- Categories Sidebar -->
        <div class="products-sidebar-card card card-padded" style="position: sticky; top: 100px;">
            <div class="meta-label" style="margin-bottom: 14px;">Browse Categories</div>

            <div style="display: flex; flex-direction: column; gap: 6px;">
                <a href="<?php echo e(route('products.index', array_filter(['category' => 'All', 'search' => request('search'), 'sort' => request('sort')]))); ?>" 
                   class="category-sidebar-link <?php echo e($isAllActive ? 'active' : ''); ?>">
                    <span>All Products</span>
                    <span class="side-count"><?php echo e($allCount); ?></span>
                </a>

                <?php $__currentLoopData = $availableCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isCatActive = request('category') === $cat;
                        $count = $categoryCounts[$cat] ?? 0;
                    ?>
                    <a href="<?php echo e(route('products.index', array_filter(['category' => $cat, 'search' => request('search'), 'sort' => request('sort')]))); ?>" 
                       class="category-sidebar-link <?php echo e($isCatActive ? 'active' : ''); ?>">
                        <span><?php echo e($cat); ?></span>
                        <span class="side-count"><?php echo e($count); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $nameParts = explode(' ', $p->name);
                        $keyword = count($nameParts) > 1 ? end($nameParts) : $p->name;
                        if (strlen($keyword) < 4 && count($nameParts) > 1) {
                            $keyword = $nameParts[count($nameParts) - 2];
                        }
                    ?>
                    <article class="fe-parallax-product-card">
                        <span class="product-stock-tag">
                            <?php echo e($p->stock_quantity > 0 ? '● In Stock' : 'Out of Stock'); ?>

                        </span>

                        <div class="assets">
                            <div class="assets-bg"></div>
                            <h3><?php echo e(strtoupper($keyword)); ?></h3>
                            <img src="<?php echo e($p->image_url); ?>" alt="<?php echo e($p->name); ?>" class="product-floating-img" loading="lazy">
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
                                <span><?php echo e($p->category ?? 'Care Essential'); ?></span>
                            </p>
                            <p class="parallax-title"><?php echo e($p->name); ?></p>
                            <p class="parallax-meta">
                                <i>Formulated Care &bull; $<?php echo e(number_format($p->price, 2)); ?></i>
                            </p>

                            <form action="<?php echo e(route('cart.add', $p)); ?>" method="POST" class="fe-parallax-cart-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="fe-parallax-cart-btn">
                                    <span>Add to Cart &bull; $<?php echo e(number_format($p->price, 2)); ?></span>
                                    <span class="btn-arrow">↗</span>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="card card-padded" style="grid-column: 1 / -1; text-align: center; padding: 64px 20px;">
                        <div style="font-size: 2.8rem; margin-bottom: 14px;">🐾</div>
                        <h3 style="font-size: 1.35rem; margin-bottom: 8px; color: #091a13;">No Products Found</h3>
                        <p style="color: var(--muted); max-width: 440px; margin: 0 auto 24px; font-size: 14px; line-height: 1.6;">
                            <?php if(request('search')): ?>
                                We couldn't find any products matching "<strong><?php echo e(request('search')); ?></strong>"
                                <?php if(request('category') && request('category') !== 'All'): ?>
                                    in the <strong><?php echo e(request('category')); ?></strong> category.
                                <?php else: ?>
                                    in our catalog.
                                <?php endif; ?>
                            <?php else: ?>
                                There are currently no products available in the <strong><?php echo e(request('category')); ?></strong> category.
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-sm">
                            <span>Browse All Products</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 5. Pagination Links -->
            <?php if($products->hasPages()): ?>
                <div class="fe-pagination-section">
                    <?php echo e($products->links('frontend.partials.pagination')); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/frontend/products.blade.php ENDPATH**/ ?>