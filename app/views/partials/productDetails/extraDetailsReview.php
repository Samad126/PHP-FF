<?php
use App\models\Review;
use App\core\Auth;

$reviews = Review::forProduct($product['id']);
$stats = Review::getProductStats($product['id']);
$totalReviews = (int)$stats['total_reviews'];
$avgRating = number_format((float)$stats['avg_rating'], 1);
?>
<div class="col-md-12">
    <div id="product-tab">
        <!-- product tab nav -->
        <ul class="tab-nav">
            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
            <li><a data-toggle="tab" href="#tab3">Reviews (<?= $totalReviews ?>)</a></li>
        </ul>
        <!-- /product tab nav -->

        <!-- product tab content -->
        <div class="tab-content">
            <!-- tab1  -->
            <div id="tab1" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12">
                        <p><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                </div>
            </div>
            <!-- /tab1  -->

            <!-- tab3  -->
            <div id="tab3" class="tab-pane fade in">
                <div class="row">
                    <!-- Rating -->
                    <div class="col-md-3">
                        <div id="rating">
                            <div class="rating-avg">
                                <span><?= $avgRating ?></span>
                                <div class="rating-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa fa-star<?= $i > $avgRating ? '-o' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <ul class="rating">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <li>
                                        <div class="rating-stars">
                                            <?php for ($j = 1; $j <= 5; $j++): ?>
                                                <i class="fa fa-star<?= $j > $i ? '-o' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="rating-progress">
                                            <?php 
                                            $count = $stats[$i . '_star'];
                                            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                            ?>
                                            <div style="width: <?= $percentage ?>%;"></div>
                                        </div>
                                        <span class="sum"><?= $count ?></span>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /Rating -->

                    <!-- Reviews -->
                    <div class="col-md-6">
                        <div id="reviews">
                            <ul class="reviews">
                                <?php foreach ($reviews as $review): ?>
                                    <li>
                                        <div class="review-heading">
                                            <h5 class="name"><?= htmlspecialchars($review['user_name']) ?></h5>
                                            <p class="date"><?= date('d M Y, g:i A', strtotime($review['created_at'])) ?></p>
                                            <div class="review-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fa fa-star<?= $i > $review['rating'] ? '-o' : '' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="review-body">
                                            <?php if (!empty($review['title'])): ?>
                                                <h6><?= htmlspecialchars($review['title']) ?></h6>
                                            <?php endif; ?>
                                            <p><?= htmlspecialchars($review['comment']) ?></p>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (count($reviews) > 5): ?>
                                <ul class="reviews-pagination">
                                    <li class="active">1</li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Reviews -->

                    <!-- Review Form -->
                    <div class="col-md-3">
                        <div id="review-form">
                            <form class="review-form" action="/reviews/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <?php if (!Auth::check()): ?>
                                    <input class="input" type="text" name="name" placeholder="Your Name" required>
                                    <input class="input" type="email" name="email" placeholder="Your Email" required>
                                <?php endif; ?>
                                <input class="input" type="text" name="title" placeholder="Review Title">
                                <textarea class="input" name="comment" placeholder="Your Review" required></textarea>
                                <div class="input-rating">
                                    <span>Your Rating: </span>
                                    <div class="stars">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <input id="star<?= $i ?>" name="rating" value="<?= $i ?>" type="radio" <?= $i === 5 ? 'required' : '' ?>>
                                            <label for="star<?= $i ?>"></label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <button type="submit" class="primary-btn">Submit</button>
                            </form>
                        </div>
                    </div>
                    <!-- /Review Form -->
                </div>
            </div>
            <!-- /tab3  -->
        </div>
        <!-- /product tab content  -->
    </div>
</div>
