// Auto-hide flash messages after 3 seconds
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});

// Preview image before upload
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result);
            $('#imagePreview').show();
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("input[type='file']").change(function() {
    readURL(this);
}); 