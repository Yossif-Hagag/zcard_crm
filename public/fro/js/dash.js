$('#addLead').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.css('display', 'unset');
    modal.removeClass('animate__fadeOut'); 
    modal.addClass('animate__backInDown');
});

$('.cickMe').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.removeClass('animate__backInDown'); 
    modal.addClass('animate__fadeOut');

    setTimeout(() => {
        modal.css('display', 'none');
    }, 1000);
});
$('.lite').on('click', () => {
    const modal = $('.bg-mian-dark');
    modal.removeClass('animate__backInDown'); 
    modal.addClass('animate__fadeOut');

    setTimeout(() => {
        modal.css('display', 'none');
    }, 1000);
});
