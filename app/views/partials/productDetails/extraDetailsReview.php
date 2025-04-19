<?php
use App\models\Review;
use App\core\Auth;

$reviews = $reviewData['items'];
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
                                            <p class="date">
                                                <?= date('d M Y, g:i A', strtotime($review['created_at'])) ?>
                                                <?php if ($review['updated_at'] !== $review['created_at']): ?>
                                                    <span class="edited-tag">(edited <?= date('d M Y, g:i A', strtotime($review['updated_at'])) ?>)</span>
                                                <?php endif; ?>
                                            </p>
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
                            <?php if ($reviewData['total_pages'] > 1): ?>
                                <ul class="reviews-pagination">
                                    <?php if ($reviewData['page'] > 1): ?>
                                        <li>
                                            <a href="?review_page=<?= $reviewData['page'] - 1 ?>#reviews">
                                                <i class="fa fa-angle-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $reviewData['total_pages']; $i++): ?>
                                        <li <?= $i == $reviewData['page'] ? 'class="active"' : '' ?>>
                                            <a href="?review_page=<?= $i ?>#reviews"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($reviewData['page'] < $reviewData['total_pages']): ?>
                                        <li>
                                            <a href="?review_page=<?= $reviewData['page'] + 1 ?>#reviews">
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Reviews -->

                    <!-- Review Form -->
                    <div class="col-md-3">
                        <div id="review-form">
                            <?php if (!Auth::check()): ?>
                                <p>Please <a href="/login?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">login</a> to submit a review.</p>
                            <?php else: ?>
                                <?php 
                                $userReview = null;
                                foreach ($reviews as $review) {
                                    if ($review['user_id'] === Auth::user()['id']) {
                                        $userReview = $review;
                                        break;
                                    }
                                }
                                ?>
                                
                                <form class="review-form" action="/reviews/<?= $userReview ? 'edit/' . $userReview['id'] : 'add' ?>" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    
                                    <?php if ($userReview): ?>
                                        <div class="form-actions-top">
                                            <button type="button" class="btn-edit" onclick="enableReviewEdit()">
                                                <i class="fa fa-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn-delete" onclick="deleteReview(<?= $userReview['id'] ?>)">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <input class="input" 
                                           type="text" 
                                           name="title" 
                                           placeholder="Review Title"
                                           value="<?= htmlspecialchars($userReview['title'] ?? '') ?>"
                                           <?= $userReview ? 'disabled' : '' ?>>

                                    <textarea class="input" 
                                              name="comment" 
                                              placeholder="Your Review" 
                                              required
                                              <?= $userReview ? 'disabled' : '' ?>><?= htmlspecialchars($userReview['comment'] ?? '') ?></textarea>

                                    <div class="input-rating">
                                        <span>Your Rating: </span>
                                        <div class="stars">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input id="star<?= $i ?>" 
                                                       name="rating" 
                                                       value="<?= $i ?>" 
                                                       type="radio" 
                                                       <?= ($userReview && $userReview['rating'] == $i) ? 'checked' : '' ?>
                                                       <?= $userReview ? 'disabled' : '' ?>
                                                       required>
                                                <label for="star<?= $i ?>" <?= $userReview ? 'class="disabled"' : '' ?>></label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <button type="submit" class="primary-btn" <?= $userReview ? 'style="display: none;"' : '' ?>>
                                        Submit Review
                                    </button>

                                    <?php if ($userReview): ?>
                                        <div class="edit-actions" style="display: none;">
                                            <button type="submit" class="primary-btn">Update Review</button>
                                            <button type="button" class="secondary-btn" onclick="cancelReviewEdit()">
                                                Cancel
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
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
