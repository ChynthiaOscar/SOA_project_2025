/**
 * Restaurant Review System JavaScript 
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initStarRating();
    initToasts();
    initModals();
    initForms();
    initDeleteReview();
    initTabs();
    
    // Initialize the order select form if exists
    const orderSelectForm = document.getElementById('orderSelectForm');
    if (orderSelectForm) {
        orderSelectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const orderId = document.getElementById('order_id').value;
            if (orderId) {
                window.location.href = `/reviews/form?order_id=${orderId}`;
            }
        });
    }

    // Initialize the member select form if exists
    const memberSelectForm = document.getElementById('memberSelectForm');
    if (memberSelectForm) {
        memberSelectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const memberId = document.getElementById('member_id').value;
            if (memberId) {
                window.location.href = `/reviews/history?member_id=${memberId}`;
            }
        });
    }
});

/**
 * Initialize Tab Switching
 */
function initTabs() {
    const tabButtons = document.querySelectorAll('[data-tab]');
    const tabContents = document.querySelectorAll('[id$="-tab"]');
    
    if (tabButtons.length && tabContents.length) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.style.display = 'none';
                });
                
                // Show selected tab content
                const selectedTab = document.getElementById(`${tabId}-tab`);
                if (selectedTab) {
                    selectedTab.style.display = 'block';
                }
            });
        });
    }
}

/**
 * Initialize Star Rating System
 */
function initStarRating() {
    // Handle star rating in review form
    const stars = document.querySelectorAll('.star-rating .star');
    
    if (stars.length) {
        stars.forEach((star) => {
            star.addEventListener('click', function() {
                const ratingValue = parseInt(this.getAttribute('data-rating'));
                const index = parseInt(this.getAttribute('data-index') || 0);
                const starRating = this.closest('.star-rating');
                const ratingInput = document.querySelector(`input[name="ratings[${index}][rating]"]`);
                
                if (starRating) {
                    const allStars = starRating.querySelectorAll('.star');
                    
                    // Reset all stars
                    allStars.forEach(s => s.classList.remove('active'));
                    
                    // Set active stars
                    for (let i = 0; i < allStars.length; i++) {
                        if (i < ratingValue) {
                            allStars[i].classList.add('active');
                        }
                    }
                    
                    // Update hidden input value
                    if (ratingInput) {
                        ratingInput.value = ratingValue;
                    }
                }
            });
        });
    }
    
    // Handle static rating display
    const ratingContainers = document.querySelectorAll('.rating-container');
    
    ratingContainers.forEach(container => {
        const stars = container.querySelectorAll('.rating-star');
        const ratingInput = container.closest('.form-group')?.querySelector('input[type="hidden"]');
        
        // Set initial state if rating already exists
        if (ratingInput && ratingInput.value) {
            const rating = parseInt(ratingInput.value);
            setStarRating(stars, rating);
        }
        
        // Add click events to stars for interactive ratings
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const rating = 5 - index;
                setStarRating(stars, rating);
                
                // Update hidden input value
                if (ratingInput) {
                    ratingInput.value = rating;
                }
            });
        });
    });
}

/**
 * Set star rating visual state
 */
function setStarRating(stars, rating) {
    stars.forEach((star, index) => {
        if (5 - index <= rating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

/**
 * Initialize Toast Notifications
 */
function initToasts() {
    window.showToast = function(message, type = 'info', duration = 3000) {
        const toast = document.getElementById('toast');
        
        if (!toast) return;
        
        // Set message and type
        toast.textContent = message;
        toast.className = 'toast';
        toast.classList.add(type);
        
        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        
        // Hide toast after duration
        setTimeout(() => {
            toast.classList.remove('show');
            
            // Remove type class after animation
            setTimeout(() => {
                toast.className = 'toast';
            }, 300);
        }, duration);
    };
}

/**
 * Initialize Modal Dialogs
 */
function initModals() {
    // Open modal function
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        const backdrop = document.getElementById('modal-backdrop');
        
        if (modal && backdrop) {
            modal.style.display = 'block';
            backdrop.style.display = 'block';
            
            // Add close events
            const closeButtons = modal.querySelectorAll('.modal-close, .btn-cancel');
            closeButtons.forEach(button => {
                button.addEventListener('click', () => closeModal(modalId));
            });
            
            // Close on backdrop click
            backdrop.addEventListener('click', () => closeModal(modalId));
        }
    };
    
    // Close modal function
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        const backdrop = document.getElementById('modal-backdrop');
        
        if (modal && backdrop) {
            modal.style.display = 'none';
            backdrop.style.display = 'none';
        }
    };
    
    // Initialize edit review buttons
    const editButtons = document.querySelectorAll('.edit-review-btn');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            const reviewText = this.dataset.reviewText;
            
            // Set form values
            document.getElementById('editReviewId').value = reviewId;
            document.getElementById('editReviewText').value = reviewText;
            
            // Open edit modal
            openModal('editReviewModal');
        });
    });
    
    // Initialize edit review form submission
    const editReviewForm = document.getElementById('editReviewForm');
    
    if (editReviewForm) {
        editReviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reviewId = document.getElementById('editReviewId').value;
            const reviewText = document.getElementById('editReviewText').value;
            
            if (reviewId && reviewText) {
                // Show loading
                document.getElementById('loadingIndicator').style.display = 'flex';
                
                // Send update request
                axios.put(`/api/reviews/${reviewId}`, { review_text: reviewText })
                    .then(response => {
                        if (response.data.success) {
                            // Update review text in the DOM
                            const reviewElement = document.querySelector(`[data-review-id="${reviewId}"]`);
                            if (reviewElement) {
                                const reviewTextElement = reviewElement.querySelector('.review-text');
                                if (reviewTextElement) {
                                    reviewTextElement.textContent = reviewText;
                                }
                                
                                // Update the data attribute for future edits
                                const editButton = reviewElement.querySelector('.edit-review-btn');
                                if (editButton) {
                                    editButton.dataset.reviewText = reviewText;
                                }
                            }
                            
                            // Show success message
                            showToast(response.data.message || 'Review updated successfully!', 'success');
                            
                            // Close modal
                            closeModal('editReviewModal');
                        } else {
                            showToast(response.data.message || 'Failed to update review!', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred while updating the review.', 'error');
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Hide loading indicator
                        document.getElementById('loadingIndicator').style.display = 'none';
                    });
            }
        });
    }
}

/**
 * Initialize Form Submission with AJAX
 */
function initForms() {
    const reviewForm = document.getElementById('reviewForm');
    
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate ratings
            const ratingInputs = document.querySelectorAll('input[name$="[rating]"]');
            let allValid = true;
            
            ratingInputs.forEach(input => {
                if (!input.value) {
                    const menuName = input.closest('.menu-rating').querySelector('h4').textContent;
                    showToast(`Please provide a rating for ${menuName}`, 'warning');
                    allValid = false;
                }
            });
            
            if (!allValid) {
                return;
            }
            
            // Show loading indicator
            document.getElementById('loadingIndicator').style.display = 'flex';
            
            // Get form data
            const formData = new FormData(this);
            const formObject = {};
            
            formData.forEach((value, key) => {
                // Handle array notation in form fields
                if (key.includes('[') && key.includes(']')) {
                    const matches = key.match(/([^\[]+)\[([^\]]+)\]\[([^\]]+)\]/);
                    
                    if (matches) {
                        const [_, arrayName, index, propName] = matches;
                        
                        if (!formObject[arrayName]) {
                            formObject[arrayName] = [];
                        }
                        
                        if (!formObject[arrayName][index]) {
                            formObject[arrayName][index] = {};
                        }
                        
                        formObject[arrayName][index][propName] = value;
                    } else {
                        formObject[key] = value;
                    }
                } else {
                    formObject[key] = value;
                }
            });
            
            // Send AJAX request to create review/rating
            axios.post('/api/reviews', formObject)
                .then(response => {
                    // Handle success
                    if (response.data.success) {
                        showToast(response.data.message || 'Review submitted successfully!', 'success');
                        
                        // Redirect to history page
                        setTimeout(() => {
                            window.location.href = '/reviews/history';
                        }, 1500);
                    } else {
                        showToast(response.data.message || 'Something went wrong!', 'error');
                    }
                })
                .catch(error => {
                    // Handle validation errors
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        let errorMessage = 'Please check the form for errors:';
                        
                        for (const field in errors) {
                            errorMessage += `\n- ${errors[field][0]}`;
                        }
                        
                        showToast(errorMessage, 'error', 5000);
                    } else {
                        showToast('An error occurred while submitting your review.', 'error');
                        console.error('Error:', error);
                    }
                })
                .finally(() => {
                    // Hide loading indicator
                    document.getElementById('loadingIndicator').style.display = 'none';
                });
        });
    }
}

/**
 * Initialize Delete Review Functionality
 */
function initDeleteReview() {
    const deleteButtons = document.querySelectorAll('.delete-review-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            const confirmDelete = document.getElementById('confirm-delete-btn');
            
            // Set review ID for confirm button
            if (confirmDelete) {
                confirmDelete.dataset.reviewId = reviewId;
            }
            
            // Open confirmation modal
            openModal('deleteReviewModal');
        });
    });
    
    // Confirm delete button event
    const confirmDelete = document.getElementById('confirm-delete-btn');
    
    if (confirmDelete) {
        confirmDelete.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            
            if (reviewId) {
                // Show loading indicator
                document.getElementById('loadingIndicator').style.display = 'flex';
                
                // Send delete request
                axios.delete(`/api/reviews/${reviewId}`)
                    .then(response => {
                        // Handle success
                        if (response.data.success) {
                            showToast(response.data.message || 'Review deleted successfully!', 'success');
                            
                            // Remove review element from DOM
                            const reviewElement = document.querySelector(`.review-card[data-review-id="${reviewId}"]`);
                            if (reviewElement) {
                                reviewElement.remove();
                            }
                            
                            // Close modal
                            closeModal('deleteReviewModal');
                        } else {
                            showToast(response.data.message || 'Failed to delete review!', 'error');
                        }
                    })
                    .catch(error => {
                        showToast('An error occurred while deleting the review.', 'error');
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Hide loading indicator
                        document.getElementById('loadingIndicator').style.display = 'none';
                    });
            }
        });
    }
}
