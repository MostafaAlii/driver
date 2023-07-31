function check_all() {
    $('input[class="item_checkbox"]:checkbox').each(function() {
        if($('input[class="check_all"]:checkbox:checked').length == 0) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }
    });
}

function delete_all() {
    $(document).on('click', '.delBtn', function() {
        var item_checked = $('input[class="item_checkbox"]:checkbox:checked').filter(":checked").length;
        if(item_checked > 0) {
            $('.record_count').html(item_checked);
            $('.not_empty_record').removeClass('d-none');
            $('.empty_record').addClass('d-none');
        } else {
            $('.record_count').html('');
            $('.not_empty_record').addClass('d-none');
            $('.empty_record').removeClass('d-none');
        }
        $('#multipleDelete').modal('show');
    });

    $(document).on('click', '.del_all', function() {
        $('#form_data').submit();
    });
}
