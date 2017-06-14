( function ( $ ) {

        var $sidebar   = $(".sidebar"),
            $window    = $(window),
            $footer    = $(".footer"), // use your footer ID here
            offset     = $sidebar.offset(),
            foffset    = $footer.offset(),
            threshold  = foffset.top - $sidebar.height(), // may need to tweak
            topPadding = 15;

        $window.scroll(function() {
            if ($window.scrollTop() > threshold) {
                $sidebar.stop().animate({
                    marginTop: threshold
                });
            } else if ($window.scrollTop() > offset.top) {
                $sidebar.stop().animate({
                    marginTop: $window.scrollTop() - offset.top + topPadding
                });
            } else {
                $sidebar.stop().animate({
                    marginTop: 0
                });
            }
    });
    
} )( jQuery );