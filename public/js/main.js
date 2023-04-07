$(function () {
    "use strict";
    // ==============================================================
    // Right sidebar options
    // ==============================================================


    $(document).on('click', '.close-sidebar',function(e){
        e.preventDefault();
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");

        $(this).closest('.r-panel-body').find('form').trigger('reset');
    })

    // ==============================================================
    // Table Selected Rows
    // ==============================================================
    var select_count = 0;
    $('.selected-table .select-checkbox').on('click',function(){
        if($(this).closest('tr').hasClass('selected'))
        {
            select_count--;
            $(this).closest('tr').removeClass('selected');
        }else{
            select_count++;
            $(this).closest('tr').addClass('selected');
        }

        $(document).find('.select-count').html(select_count);

        if($('.selected-table .select-checkbox:checked').length == $('.selected-table .select-checkbox').length){
            $(document).find('.select-all .off-select').css('display','none');
            $(document).find('.select-all .on-select').css('display','');
        }else{
            $(document).find('.select-all .off-select').css('display','');
            $(document).find('.select-all .on-select').css('display','none');
        }
    })

    // ==============================================================
    // Table Selected All Rows
    // ==============================================================
    $(document).on('click','.select-all',function(){
        if ($('.selected-table .select-checkbox:checked').length == $('.selected-table .select-checkbox').length)
        {
            $('.selected-table tbody tr').each(function(){
                if($(this).hasClass('selected'))
                {
                    $(this).removeClass('selected');
                }
            })
            $('.selected-table .select-checkbox').prop('checked',false);

            $(this).find('.off-select').css('display','');
            $(this).find('.on-select').css('display','none');
        }else {
            $('.selected-table tbody tr').each(function(){
                if(!$(this).hasClass('selected'))
                {
                    $(this).addClass('selected');
                }
            })
            $('.selected-table .select-checkbox').prop('checked',true);

            $(this).find('.off-select').css('display','none');
            $(this).find('.on-select').css('display','');
        }

        select_count = $('.selected-table .select-checkbox:checked').length;
        $(document).find('.select-count').html(select_count);
    })
});
