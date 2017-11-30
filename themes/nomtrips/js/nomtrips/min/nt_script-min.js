jQuery(document).ready(function($) {
    $(".single .content--post img").each(function() {
        if ($(this).attr("alt").length > 0) {
            var t = $(this).attr("alt");
            var e = document.createElement("div");
            $(e).addClass("content--post-img");
            var n = document.createElement("div");
            $(n).addClass("content--post-img-caption").html(t);
            $(e).insertBefore($(this));
            $(this).appendTo(e);
            $(n).appendTo(e);
        }
    });
    var t = function(t) {
        var e = -1;
        var n = -1;
        var a = 10;
        t.addEventListener("mousedown", function(a) {
            t.dragFlag = 0;
            e = a.clientX;
            n = a.clientY;
        }, false);
        t.addEventListener("mouseup", function(o) {
            if (o.clientX > e - a && o.clientX < e + a && o.clientY > n - a && o.clientY < n + a) {
                t.dragFlag = 0;
            } else {
                t.dragFlag = 1;
            }
        }, false);
    };
    $(".card--location").each(function() {
        var e = t(this);
        $(this).click(function() {
            if (!this.dragFlag) {
                window.location.href = $(this).data("url");
            }
        });
    });
    var e = function() {
        var t = document.createElement("style");
        t.appendChild(document.createTextNode(""));
        document.head.appendChild(t);
        console.log(t.sheet.cssRules);
        return t.sheet;
    }();
    function n() {
        console.log("ss");
        $(".has-tip").each(function() {
            if ($(this).data("match-bg")) {
                var t = $(this).children(".fa").css("color");
                var n = $(this).data("toggle");
                $("#" + n).css({
                    "background-color": t
                });
                e.insertRule("#" + n + "::before{border-color: transparent transparent " + t + ";}", 0);
            }
        });
    }
    setTimeout(n, 1e3);
});