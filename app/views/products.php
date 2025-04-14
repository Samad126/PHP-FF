<!-- BREADCRUMB -->
<?php include_once 'partials/products/breadcrumb.php'; ?>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- ASIDE -->
            <?php include_once 'partials/products/sidebar.php'; ?>
            <!-- /ASIDE -->

            <!-- STORE -->
            <div id="store" class="col-md-9">
                <!-- store top filter -->
                <?php include_once 'partials/products/storeTopFilter.php'; ?>
                <!-- /store top filter -->

                <!-- store products -->
                <?php include_once 'partials/products/productList.php'; ?>
                <!-- /store products -->

                <!-- store bottom filter -->
                <?php include_once 'partials/products/storeBottomFilter.php'; ?>
                <!-- /store bottom filter -->
            </div>
            <!-- /STORE -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->