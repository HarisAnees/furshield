<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="fs-pagination-container">
        
        <div class="fs-pagination-summary">
            Showing <span><?php echo e($paginator->firstItem()); ?></span> to <span><?php echo e($paginator->lastItem()); ?></span> of <span><?php echo e($paginator->total()); ?></span> results
        </div>

        
        <div class="fs-pagination-deck">
            
            <?php if($paginator->onFirstPage()): ?>
                <span class="fs-page-btn fs-page-nav fs-page-disabled" aria-disabled="true" aria-label="Previous Page">
                    <i class="fa fa-arrow-left fs-page-icon"></i>
                    <span class="fs-page-label">Previous</span>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="fs-page-btn fs-page-nav" rel="prev" aria-label="Previous Page">
                    <i class="fa fa-arrow-left fs-page-icon"></i>
                    <span class="fs-page-label">Previous</span>
                </a>
            <?php endif; ?>

            
            <div class="fs-pagination-numbers">
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <span class="fs-page-dots" aria-disabled="true"><?php echo e($element); ?></span>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span class="fs-page-num active" aria-current="page"><?php echo e($page); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="fs-page-num" aria-label="Go to page <?php echo e($page); ?>"><?php echo e($page); ?></a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="fs-page-btn fs-page-nav" rel="next" aria-label="Next Page">
                    <span class="fs-page-label">Next</span>
                    <i class="fa fa-arrow-right fs-page-icon"></i>
                </a>
            <?php else: ?>
                <span class="fs-page-btn fs-page-nav fs-page-disabled" aria-disabled="true" aria-label="Next Page">
                    <span class="fs-page-label">Next</span>
                    <i class="fa fa-arrow-right fs-page-icon"></i>
                </span>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH D:\pat\FurShield\resources\views/frontend/partials/pagination.blade.php ENDPATH**/ ?>