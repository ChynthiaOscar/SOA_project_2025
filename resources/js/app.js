import './bootstrap';

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
});

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
            
            // Show loading indicator
            document.getElementById('loadingIndicator').style.display = 'flex';
            
            // Get form data
            const formData = new FormData(this);
            const formObject = {};
            
            formData.forEach((value, key) => {
                formObject[key] = value;
            });
            
            // Send AJAX request
            axios.post(this.action, formObject)
                .then(response => {
                    // Handle success
                    if (response.data.success) {
                        showToast(response.data.message || 'Review submitted successfully!', 'success');
                        
                        // Redirect if needed
                        if (response.data.redirect) {
                            setTimeout(() => {
                                window.location.href = response.data.redirect;
                            }, 1000);
                        } else {
                            // Reset form
                            reviewForm.reset();
                            
                            // Reset star ratings
                            const stars = document.querySelectorAll('.rating-star');
                            stars.forEach(star => star.classList.remove('active'));
                        }
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
