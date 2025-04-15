<!-- Main Part -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Photo Gallery -->
            <?php include_once __DIR__ . '/partials/productDetails/photoGallery.php'; ?>
            <!-- /Photo Gallery -->

            <!-- Product details -->
            <?php include_once __DIR__ . '/partials/productDetails/productDetails.php'; ?>
            <!-- /Product details -->

            <!-- Product tab -->
            <?php include_once __DIR__ . '/partials/productDetails/extraDetailsReview.php'; ?>
            <!-- /product tab -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /Main Part -->

<!-- Related -->
<?php include_once 'partials/productDetails/relatedProduct.php'; ?>
<!-- /Related -->
