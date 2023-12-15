"use strict";

const ratingStarBody = document.querySelector('.form__rating-body');
const hiddenInput = document.getElementById('rating');
const ratingStars = ratingStarBody.querySelectorAll('.form__rating-item');

ratingStarBody.addEventListener('click', (event) => {
    const star = event.target.closest('.form__rating-item');
    if (!star) return;

    const selectedValue = star.dataset.value;
    hiddenInput.value = selectedValue;
    star.parentNode.dataset.totalValue = selectedValue;

    ratingStars.forEach((star, index) => {
        star.classList.toggle('active', index < selectedValue);
    });
});


ratingStarBody.addEventListener('mouseover', (event) => {
    const star = event.target.closest('.form__rating-item');
    if (!star) return;

    const hoverIndex = Array.from(ratingStars).indexOf(star);
    ratingStars.forEach((star, index) => {
        star.classList.toggle('hover', index <= hoverIndex);
    });
});

ratingStarBody.addEventListener('mouseout', () => {
    ratingStars.forEach(star => {
        star.classList.remove('hover');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form__body');
    const errorsContainer = document.querySelector('.form__errors');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(form);

        fetch('feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                form.reset();
                errorsContainer.innerHTML = '';
                ratingStarBody.dataset.totalValue = 0;
                hiddenInput.value = 0;
                alert('Спасибо за ваш отзыв!');
            } else {
                errorsContainer.innerHTML = data.errors.map(error => `<div>${error}</div>`).join('');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз.');
        });
    });
});