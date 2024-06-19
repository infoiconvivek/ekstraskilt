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
        var mouseX, mouseY, windowWidth, windowHeight;
        var popupLeft, popupTop;
        $(document).mousemove(function (e) {
            mouseX = e.pageX;

            mouseY = e.pageY;
            // console.log(e.pageY);
            //To Get the relative position
            if (this.offsetLeft != undefined)
                mouseX = e.pageX - this.offsetLeft;
            if (this.offsetTop != undefined)
                mouseY = e.pageY; - this.offsetTop;

            if (mouseX < 0)
                mouseX = 0;
            if (mouseY < 0)
                mouseY = 0;

            windowWidth = $(window).width() - 112 + $(window).scrollLeft();
            windowHeight = $(window).height() - 112 + $(window).scrollTop();
        });

        $('.popupModal').click(function () {

            var $popupModal = $(this);
            var $popupMenu = $popupModal.closest('li').find('.popup_menu');
            $popupModal.toggleClass('open');
            $popupMenu.toggleClass('show');

            $('.popup_menu').not($popupMenu).removeClass('show');
            $('.popupModal').not($popupModal).removeClass('open');
            $('.popup_menu2').removeClass('show');


            // =================================================

            // var popupWidth = $('.popup_menu').height();
            // var popupHeight = $popupMenu.height();

            // if (mouseY + popupHeight > windowHeight) {

            //     if (popupTop > 0) {
            //         popupTop = (mouseY) - popupHeight;
            //     } else{
            //         popupTop = 112;

            //     }
            //     console.log(windowHeight, popupHeight, mouseY,popupTop)
            // } else {
            //     popupTop = mouseY;
            // }

            // if (popupTop < $(".tool-main").scrollTop()) {
            //     popupTop = $(".tool-main").scrollTop();
            // }
            // if (popupLeft < 0 || popupLeft == undefined) {
            //     popupLeft = 0;
            // }
            // if (popupTop < 0 || popupTop == undefined) {
            //     popupTop = 0;
            // }

            // $('.popup_menu').offset({ top: popupTop });


            // var toolHeight = $(".tool-main").height();
            // var listHeight = $popupModal.offset().top - 115;
            // var popupHeight = $popupMenu.height();

            // console.log("Tool-height: ", toolHeight);
            // console.log("List-height: ", listHeight);
            // console.log("Popup-height: ", popupHeight);
            // console.log("Equal-height: ", (toolHeight - popupHeight) / 2);
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

    $(".mobile-sidebar-toggle").click(function () {
        $('.aside').addClass("open");
        $('body').addClass("aside-open");
        $('.main.tool-design').append('<a class="sidebar-toggle-close" href="#"><i class="d-icon-times"></i></a>');
        $('.main.tool-design').addClass("overlay-main");
    });

    $(document).on("click", ".sidebar-toggle-close", function () {
        $('.aside').removeClass("open");
        $('body').removeClass("aside-open");
        $('.main.tool-design').find('.sidebar-toggle-close').remove();
        $('.main.tool-design').removeClass("overlay-main");
        $('.popup_menu').removeClass('show');
        $('.popupModal').removeClass('open');
        $('.popup_menu2').removeClass('show');
    });

});


