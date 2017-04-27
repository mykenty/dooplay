function switch_tabs(a) {
    jQuery(".tab-content").hide(), jQuery("#acera-main-menu ul a").removeClass("selected");
    var b = a.attr("rel");
    jQuery("#" + b).fadeIn(500), a.addClass("selected")
}

function checked_img(a) {
    a.is(":checked") ? a.closest("label").addClass("acera-img-selected") : a.closest("label").removeClass("acera-img-selected")
}

function checked_img_radio(a) {
    a.is(":checked") ? (a.closest(".cOf").find("label.acera-img-selected").removeClass("acera-img-selected"), a.closest("label").addClass("acera-img-selected")) : a.closest("label").removeClass("acera-img-selected")
}
jQuery.fn.slideFadeToggle = function(a, b, c) {
        return this.animate({
            opacity: "toggle",
            height: "toggle"
        }, a, b, c)
    }, jQuery(document).ready(function() {
        jQuery("#acera-main-menu > li > p").click(function() {
            jQuery(this).next().slideToggle(300)
        }), jQuery("#acera-main-menu ul a").click(function() {
            switch_tabs(jQuery(this))
        }), jQuery(".tab-content").hide();
        var a = jQuery(".defaulttab").attr("rel");
        jQuery("#" + a).show(), jQuery(".default-accordion").show(), 
		jQuery(".acera-image-checkbox-b").click(function() {
            var a = jQuery(this);
            checked_img(a)
        }), jQuery(".acera-image-radio-b").click(function() {
            var a = jQuery(this);
            checked_img_radio(a)
        }), jQuery('input[type="checkbox"]').each(function() {
            var a = jQuery(this),
                b = a.attr("id");
            a.is(":checked") || jQuery('div[rel="' + b + '"]').hide()
        }), jQuery('input[type="checkbox"]').click(function() {
            var a = jQuery(this),
                b = a.attr("id");
            a.is(":checked") ? jQuery('div[rel="' + b + '"]').slideFadeToggle(500) : jQuery('div[rel="' + b + '"]').slideFadeToggle(500)
        }), jQuery(".acera_upload").each(function() {
            var a = jQuery(this),
                b = jQuery(this).prev(),
                c = jQuery(this).attr("id");
            new AjaxUpload(c, {
                action: ajaxurl,
                name: c,
                data: {
                    action: "acera_ajax_upload",
                    data: c
                },
                autoSubmit: !0,
                responseType: !1,
                onChange: function(a, b) {},
                onSubmit: function(b, c) {
                    a.html("Uploading..")
                },
                onComplete: function(d, e) {
                    if (a.html("Upload"), e.search("Error") > -1) alert("There was an error uploading:\n" + e);
                    else {
                        b.val(e);
                        var f = '<img src="' + e + '" />',
                            g = "remove_" + c,
                            h = "#" + g;
                        jQuery(h).length > 0 || a.after('<span class="acera_remove acera-button" id="' + g + '">Remove</span>'), a.next().next().html(f)
                    }
                }
            })
        }), jQuery(".acera_remove").live("click", function() {
            var a = jQuery(this),
                b = jQuery(this).prev().attr("id");
            a.html("Removing..");
            var c = {
                action: "acera_ajax_remove",
                data: b
            };
            jQuery.post(ajaxurl, c, function(b) {
                a.prev().prev().val(""), a.next().html(""), a.remove()
            })
        })
    }),
    function(a, b, c, d, e, f, g) {
        a.GoogleAnalyticsObject = e, a[e] = a[e] || function() {
            (a[e].q = a[e].q || []).push(arguments)
        }, a[e].l = 1 * new Date, f = b.createElement(c), g = b.getElementsByTagName(c)[0], f.async = 1, f.src = d, g.parentNode.insertBefore(f, g)
    }(window, document, "script", "https://www.google-analytics.com/analytics.js", "ga"), ga("create", "UA-74366679-2", "auto"), ga("send", "pageview");