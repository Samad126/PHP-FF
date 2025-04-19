<div class="store-filter clearfix">
    <div class="store-sort">
        <span>SHOWING <?= $showing_start ?? 0 ?>-<?= $showing_end ?? 0 ?> OF <?= $total ?? 0 ?> PRODUCTS</span>
    </div>
    <ul class="store-pagination">
        <?php 
        $totalPages = ceil($total / ($filters['per_page'] ?? 20));
        $currentPage = $filters['page'] ?? 1;
        
        // Previous page
        if ($currentPage > 1): ?>
            <li><a href="javascript:void(0)" onclick="updateFilters('page', <?= $currentPage - 1 ?>)"><i class="fa fa-angle-left"></i></a></li>
        <?php endif;

        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++): ?>
            <li <?= $i == $currentPage ? 'class="active"' : '' ?>>
                <a href="javascript:void(0)" onclick="updateFilters('page', <?= $i ?>)"><?= $i ?></a>
            </li>
        <?php endfor;

        // Next page
        if ($currentPage < $totalPages): ?>
            <li><a href="javascript:void(0)" onclick="updateFilters('page', <?= $currentPage + 1 ?>)"><i class="fa fa-angle-right"></i></a></li>
        <?php endif; ?>
    </ul>
</div>
