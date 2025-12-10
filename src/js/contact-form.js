document.addEventListener('DOMContentLoaded', function() {
  // Add animation structure to Contact Form 7 submit button
  const submitButtons = document.querySelectorAll('.wpcf7-submit');

  submitButtons.forEach(button => {
    const buttonText = button.value;

    // Create wrapper div
    const wrapper = document.createElement('div');
    wrapper.className = 'wpcf7-submit-wrapper';
    wrapper.setAttribute('data-text', buttonText + ' →');

    // Create text span
    const textSpan = document.createElement('span');
    textSpan.className = 'btn-text';
    textSpan.textContent = buttonText;

    // Hide the original button value
    button.value = '';
    button.style.color = 'transparent';

    // Wrap the button
    button.parentNode.insertBefore(wrapper, button);
    wrapper.appendChild(button);
    wrapper.appendChild(textSpan);
  });
});
