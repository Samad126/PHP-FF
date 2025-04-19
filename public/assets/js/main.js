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

		$this.slick({
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
	$('#product-main-img').slick({
    infinite: true,
    speed: 300,
    dots: false,
    arrows: true,
    fade: true,
    asNavFor: '#product-imgs',
  });

	// Product imgs Slick
  $('#product-imgs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
		centerPadding: 0,
		vertical: true,
    asNavFor: '#product-main-img',
		responsive: [{
        breakpoint: 991,
        settings: {
					vertical: false,
					arrows: false,
					dots: true,
        }
      },
    ]
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
	var priceSlider = document.getElementById('price-slider');
	if (priceSlider) {
		noUiSlider.create(priceSlider, {
			start: [1, 999],
			connect: true,
			step: 1,
			range: {
				'min': 1,
				'max': 999
			}
		});

		priceSlider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			handle ? priceInputMax.value = value : priceInputMin.value = value
		});
	}

})(jQuery);

function addToWishlist(productId) {
    fetch(`/wishlist/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json().then(data => ({status: response.status, data})))
    .then(({status, data}) => {
        if (status === 200 && data.success) {
            showNotification(data.message || 'Product added to wishlist!', 'success');
        } else {
            showNotification(data.message || 'Failed to add product to wishlist', 'error');
            // if (status === 401) {
            //     setTimeout(() => {
            //         window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
            //     }, 2000);
            // }
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
            showNotification(data.message || 'Product added to cart!', 'success');
            // Update cart count if available
            if (data.cartCount !== undefined) {
                updateCartCount(data.cartCount);
            }
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
            // if (status === 401) {
            //     setTimeout(() => {
            //         window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
            //     }, 2000);
            // }
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
