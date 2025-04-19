(function($) {
	"use strict"

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	})

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.on('init', function(event, slick) {
			$(this).css({opacity: 1, visibility: 'visible'});
		}).slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	$(document).ready(function() {
		// Initialize main product image slider
		$('#product-main-img').on('init', function(event, slick) {
			$(this).css({opacity: 1, visibility: 'visible'});
		}).slick({
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			fade: true,
			asNavFor: '#product-imgs',
			adaptiveHeight: true,
			lazyLoad: 'ondemand'
		});

		// Initialize thumbnail slider
		$('#product-imgs').on('init', function(event, slick) {
			$(this).css({opacity: 1, visibility: 'visible'});
		}).slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: true,
			centerMode: true,
			focusOnSelect: true,
			centerPadding: '0',
			vertical: true,
			asNavFor: '#product-main-img',
			responsive: [{
				breakpoint: 991,
				settings: {
					vertical: false,
					arrows: true,
					slidesToShow: 3,
				}
			}]
		});

		// Initialize zoom
		$('#product-main-img .product-preview').zoom();
	});

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

	// Input number
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})

		up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})
	});

	var priceInputMax = document.getElementById('price-max'),
			priceInputMin = document.getElementById('price-min');

	priceInputMax.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	priceInputMin.addEventListener('change', function(){
		updatePriceSlider($(this).parent() , this.value)
	});

	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			console.log('min')
			priceSlider.noUiSlider.set([value, null]);
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
		}
	}

	// Price Slider
	$(document).ready(function() {
		var priceSlider = document.getElementById('price-slider');
		if (priceSlider) {
			// Get initial values from inputs and data attributes
			var minPrice = parseInt($('#price-min').val()) || 0;
			var maxPrice = parseInt($('#price-max').val()) || parseInt(priceSlider.dataset.maxPrice);
			var absoluteMax = parseInt(priceSlider.dataset.maxPrice);

			noUiSlider.create(priceSlider, {
				start: [minPrice, maxPrice],
				connect: true,
				step: 1,
				range: {
					'min': 0,
					'max': absoluteMax
				}
			});

			// Update input fields when slider changes
			priceSlider.noUiSlider.on('update', function(values, handle) {
				var value = Math.round(values[handle]);
				if (handle === 0) {
					$('#price-min').val(value);
				} else {
					$('#price-max').val(value);
				}
			});

			// Trigger filter update when sliding ends
			priceSlider.noUiSlider.on('change', function(values, handle) {
				var value = Math.round(values[handle]);
				if (handle === 0) {
					updateFilters('price_min', value);
				} else {
					updateFilters('price_max', value);
				}
			});

			// Update slider when input fields change
			$('#price-min').on('change', function() {
				priceSlider.noUiSlider.set([this.value, null]);
			});

			$('#price-max').on('change', function() {
				priceSlider.noUiSlider.set([null, this.value]);
			});
		}
	});

})(jQuery);

function toggleWishlist(productId) {
    const button = event.currentTarget;
    const isInWishlist = button.classList.contains('in-wishlist');
    const endpoint = isInWishlist ? 'remove' : 'add';

    fetch(`/wishlist/${endpoint}/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update ALL matching wishlist buttons for this product across all sections
            const buttons = document.querySelectorAll(`.add-to-wishlist[onclick="toggleWishlist(${productId})"]`);
            buttons.forEach(btn => {
                btn.classList.toggle('in-wishlist');
                const btnIcon = btn.querySelector('i');
                const btnTooltip = btn.querySelector('.tooltipp');
                if (btnIcon) {
                    btnIcon.classList.toggle('fa-heart-o');
                    btnIcon.classList.toggle('fa-heart');
                }
                if (btnTooltip) {
                    btnTooltip.textContent = isInWishlist ? 'add to wishlist' : 'remove from wishlist';
                }
            });

            if (typeof data.wishlistCount !== 'undefined') {
                console.log('Updating wishlist count to:', data.wishlistCount); // Debug log
                updateWishlistCount(data.wishlistCount);
            }
            
            showNotification(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json().then(data => ({status: response.status, data})))
    .then(({status, data}) => {
        if (status === 200 && data.success) {
            // Update cart count in header
            if (data.cartCount !== undefined) {
                updateCartCount(data.cartCount);
            }
            
            // Update ALL matching add to cart buttons for this product across all sections
            const containers = document.querySelectorAll(`.add-to-cart button[onclick="addToCart(${productId})"]`);
            containers.forEach(button => {
                const container = button.closest('.add-to-cart');
                if (container) {
                    container.innerHTML = `
                        <button class="add-to-cart-btn in-cart" disabled>
                            <i class="fa fa-shopping-cart"></i> In Cart
                        </button>
                    `;
                }
            });
            
            showNotification(data.message || 'Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function quickView(productId) {
    fetch(`/products/${productId}/quick-view`)
    .then(response => response.text())
    .then(html => {
        // Assuming you have a modal to show the quick view
        document.getElementById('quickViewModal').innerHTML = html;
        $('#quickViewModal').modal('show');
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to load quick view', 'error');
    });
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Style the notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 4px;
        z-index: 9999;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease;
    `;

    // Add specific styles based on type
    if (type === 'success') {
        notification.style.backgroundColor = '#4CAF50';
        notification.style.color = 'white';
    } else if (type === 'error') {
        notification.style.backgroundColor = '#f44336';
        notification.style.color = 'white';
    }

    // Add to DOM
    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}

function updateWishlistCount(count) {
    console.log('updateWishlistCount called with:', count); // Debug log
    
    // Try multiple selector strategies
    let wishlistCountElement = document.querySelector('.header-ctn div:has(a[href*="wishlist"]) .qty');
    
    if (!wishlistCountElement) {
        // Fallback to alternative selector
        const wishlistElements = document.querySelectorAll('.header-ctn .qty');
        wishlistElements.forEach(element => {
            if (element.closest('div').querySelector('a[href*="wishlist"]')) {
                wishlistCountElement = element;
            }
        });
    }
    
    if (wishlistCountElement) {
        console.log('Found wishlist element, updating to:', count); // Debug log
        wishlistCountElement.textContent = count;
    } else {
        console.log('Could not find wishlist count element'); // Debug log
    }
}

// Add animation keyframes to the document
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

function updateFilters(param, value) {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (value === '') {
        urlParams.delete(param);
    } else {
        urlParams.set(param, value);
    }
    
    // Reset to page 1 when filters change
    if (param !== 'page') {
        urlParams.delete('page');
    }
    
    // Preserve search query if exists
    const searchQuery = urlParams.get('q');
    if (searchQuery) {
        urlParams.set('q', searchQuery);
    }
    
    window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
}

function updateMultipleFilters(param, value, isChecked) {
    const urlParams = new URLSearchParams(window.location.search);
    let values = urlParams.get(param) ? urlParams.get(param).split(',') : [];
    
    if (isChecked) {
        // Add value if it doesn't exist
        if (!values.includes(value)) {
            values.push(value);
        }
    } else {
        // Remove value if it exists
        values = values.filter(v => v !== value);
    }
    
    // Update or remove the parameter
    if (values.length > 0) {
        urlParams.set(param, values.join(','));
    } else {
        urlParams.delete(param);
    }
    
    // Reset to page 1 when filters change
    urlParams.delete('page');
    
    // Preserve search query if exists
    const searchQuery = urlParams.get('q');
    if (searchQuery) {
        urlParams.set('q', searchQuery);
    }
    
    window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
}

// Initialize price slider
$(document).ready(function() {
    if ($('#price-slider').length) {
        const minPrice = parseInt($('#price-min').val()) || 0;
        const maxPrice = parseInt($('#price-max').val()) || 1000;
        
        const priceSlider = document.getElementById('price-slider');
        noUiSlider.create(priceSlider, {
            start: [minPrice, maxPrice],
            connect: true,
            step: 1,
            range: {
                'min': 0,
                'max': 1000
            }
        });

        priceSlider.noUiSlider.on('update', function(values, handle) {
            const value = Math.round(values[handle]);
            if (handle === 0) {
                document.getElementById('price-min').value = value;
            } else {
                document.getElementById('price-max').value = value;
            }
        });

        priceSlider.noUiSlider.on('change', function(values, handle) {
            const value = Math.round(values[handle]);
            if (handle === 0) {
                updateFilters('price_min', value);
            } else {
                updateFilters('price_max', value);
            }
        });
    }
});
