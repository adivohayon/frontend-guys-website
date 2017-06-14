( function ( $ ) {

    function stickySidebar() {
        console.log('aaa');
        $(".sticky").stick_in_parent({offset_top: 80})
            .on("sticky_kit:stick", function(e) {
                console.log("has stuck!", e.target);
                // $('.blog-header').addClass('blog-header-small');
                // $('.sticky').css('padding-top', '3.9rem');
            })
            .on('sticky_kit:unstick', function(e) {
                console.log('unstuck');
                // $('.blog-header').removeClass('blog-header-small');
                // $('.sticky').css('padding-top', 0);
            });

        // $(window).on('scroll', function() {
        //     var scrollTop = $(this).scrollTop();
        //     var topDistance = 60;
        // });
        // var $sidebar        = $(".sidebar"),
        //     $window         = $(window),
        //     $footer         = $("#site-footer"),
        //     $fixedHeader    = $('header.site-header');

        // var offset          = $sidebar.offset(),
        //     footerOffset    = $footer.offset();

        // var threshold       = footerOffset.top - $sidebar.height(), // may need to tweak
        //     topPadding      = $fixedHeader.height() * 2;
        // // console.log(offset, footerOffset);

        // $window.scroll(function() {
        //     if ($window.scrollTop() > threshold) {
        //         console.log('test');
        //         $sidebar.stop().animate({
        //             marginTop: threshold
        //         });
        //     } else if ($window.scrollTop() > offset.top) {
        //         console.log('scroll down');
        //         $sidebar.stop().animate({
        //             marginTop: $window.scrollTop() - offset.top + topPadding
        //         });
        //     } else {
        //         console.log('scroll up');
        //         $sidebar.stop().animate({
        //             marginTop: 0
        //         });
        //     }
        // });
    }



    $(document).ready(function() {
        stickySidebar();
    });
    
} )( jQuery );