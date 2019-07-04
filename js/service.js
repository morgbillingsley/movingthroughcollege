$(document).ready(() => {
    function changeOption(value) {
        let hash = '#contact-form';
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, () => {
            window.location.hash = hash;
        });

        $('#service').val(value);
    }
  });