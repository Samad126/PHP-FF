<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- ASIDE -->
            <?php include_once 'partials/products/sidebar.php'; ?>
            <!-- /ASIDE -->

            <?php
            // Extract variables passed from controller
            extract($data ?? [], EXTR_SKIP);
            ?>
            <!-- STORE -->
            <div id="store" class="col-md-9">
                <!-- store top filter -->
                <div class="store-filter clearfix">
                    <div class="store-sort">
                        <label>
                            Sort By:
                            <select class="input-select" onchange="updateFilters('sort', this.value)">
                                <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
                                <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                            </select>
                        </label>
                        <label>
                            Show:
                            <select class="input-select" onchange="updateFilters('per_page', this.value)">
                                <option value="20" <?= ($filters['per_page'] ?? 20) == 20 ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($filters['per_page'] ?? 20) == 50 ? 'selected' : '' ?>>50</option>
                                <option value="100" <?= ($filters['per_page'] ?? 20) == 100 ? 'selected' : '' ?>>100</option>
                            </select>
                        </label>
                    </div>
                </div>
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
