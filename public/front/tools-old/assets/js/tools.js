$(document).ready(function () {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    if ($('.popupModal').length) {
        $('.popupModal').click(function () {
            var $popupModal = $(this);
            var $popupMenu = $popupModal.closest('li').find('.popup_menu');
            $popupModal.toggleClass('open');
            $popupMenu.toggleClass('show');

            $('.popup_menu').not($popupMenu).removeClass('show');
            $('.popupModal').not($popupModal).removeClass('open');
            $('.popup_menu2').removeClass('show');


            // =================================================

            var toolHeight = $(".tool-main").height();
            var listHeight = $popupModal.offset().top - 115;
            var popupHeight = $popupMenu.height();

            // console.log("Tool-height: ", toolHeight);
            // console.log("List-height: ", listHeight);
            // console.log("Popup-height: ", popupHeight);
            console.log("Equal-height: ", (toolHeight - popupHeight) / 2);
            // $popupMenu.css("top", (toolHeight - popupHeight) / 2);
        });

        $(".les_mer").click(function () {
            $(".popup_menu2").addClass("show");
        })

        $(".btn-finish").click(function () {
            $('.popup_menu').removeClass('show');
            $('.popupModal').removeClass('open');
            $('.popup_menu2').removeClass('show');
        })
        $(".btn-lock").click(function () {
            $('.popup_menu2').removeClass('show');
        })
    }

    if ($('.box').length) {
        $('.boxes .box').click(function () {
            var box = $(this);
            box.addClass('active').siblings().removeClass('active');

            box.find('.valgt input').prop('checked', true);
            box.find('.valgt label').show();

            box.siblings().find('.valgt label').hide();
            box.siblings().find('.valgt input').prop('checked', false);
        });

        $('.les_mer').click(function (event) {
            event.stopPropagation();
        });
    }

    if ($('.file-input').length) {
        $('.file-input').change(function () {
            var curElement = $('.image');
            console.log(curElement);
            var reader = new FileReader();

            reader.onload = function (e) {
                curElement.attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);

            $('.hidden').addClass('show');
        });
    }

    $('.tekst_pp').click(function () {
        $(".ttarea").addClass('show');
    })

    $('.box-img').click(function () {
        $('.box-img a').removeClass('active');
        $(this).find('a').addClass('active');
    })
});


