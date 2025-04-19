<div class="store-filter clearfix">
    <div class="store-sort">
        <label>
            Sort By:
            <select class="input-select" onchange="updateFilters('sort', this.value)">
                <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="price_asc" <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>Price Low to High</option>
                <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Price High to Low</option>
                <option value="name_asc" <?= $filters['sort'] === 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                <option value="name_desc" <?= $filters['sort'] === 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
            </select>
        </label>

        <label>
            Show:
            <select class="input-select" onchange="updateFilters('per_page', this.value)">
                <option value="20" <?= $filters['per_page'] == 20 ? 'selected' : '' ?>>20</option>
                <option value="50" <?= $filters['per_page'] == 50 ? 'selected' : '' ?>>50</option>
                <option value="100" <?= $filters['per_page'] == 100 ? 'selected' : '' ?>>100</option>
            </select>
        </label>
    </div>
</div>
