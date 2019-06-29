require(['jquery'],function(){
    jQuery(document).ready(function() {
        var refreshLinks = document.getElementsByClassName('refreshCacheLink');
        for(var i=0;i<refreshLinks.length;i++) {
            refreshLinks[i].onclick = function () {
                var mode = jQuery(this).attr('type');

                jQuery.ajax({
                    url: jQuery(this).attr('href'),
                    type: 'POST',
                    data: jQuery('#refresh_all_caches_'+mode).serialize(),
                    showLoader: true,
                    cache: false,
                    success: function (response) {
                       jQuery('#system_messages').slideUp(400);
                    }
                });

                return false;
            }
        }
    });
});
