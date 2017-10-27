setTimeout(function()
{
    $(".alert").fadeOut();
}, 5000);

$('.alert').on('click', function()
{
    $(this).fadeOut();
});