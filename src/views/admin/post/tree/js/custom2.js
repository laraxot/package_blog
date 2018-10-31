$(function() {
    jQuery("#sidebar .sub-menu > a").click(function() {
        var e = $(this).offset();
        diff = 250 - e.top;
        if (diff > 0) $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else $("#sidebar").scrollTo("+=" + Math.abs(diff), 500)
    });
    $(function() {
        function e() {
            var e = $(window).width();
            if (e <= 768) {
                $("#container").addClass("sidebar-close");
                $("#sidebar > ul").hide()
            }
            if (e > 768) {
                $("#container").removeClass("sidebar-close");
                $("#sidebar > ul").show()
            }
        }
        $(window).on("load", e);
        $(window).on("resize", e)
    });
    $(".tooltips").tooltip();
    $(".sortable").nestedSortable({
        forcePlaceholderSize: true,
        handle: ".handle",
        helper: "clone",
        listType: "ul",
        items: "li",
        maxLevels: 0,
        opacity: .6,
        placeholder: "placeholder",
        revert: 250,
        tabSize: 25,
        tolerance: "pointer",
        toleranceElement: "> div",
        expandOnHover: 700,
        startCollapsed: true,
        isTree: true,
        create: function(e, t) {},
        start: function(e, t) {
            list_original = $(".sortable").nestedSortable("serialize");
            $(t.helper).addClass("footest");
            $(t.helper).prepend('<div style="opacity: 1 !important; padding:5px;" class="alert-custom"> Note: You must expand the category in order to make it a subcategory.</div>')
        },
        stop: function(event, ui) {
            $(".alert").hide("fast");
            $(".alert").removeClass("alert-success").removeClass("alert-danger").addClass("alert-info");
            $(".alert").show("fast");
            $(".alert-info").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong><i class="fa fa-spinner fa-spin"></i></strong> This action could take a while.');
            var list = "";
            list = $(".sortable").nestedSortable("serialize");
            var array_list = $(".sortable").nestedSortable("toArray");
            var l = array_list.length;
            for (var k = 0; k < l; k++) {
                if (array_list[k].item_id == $(ui.item).find("div").attr("category_id")) {
                    if (array_list[k].parent_id == "root") {
                        $(ui.item).closest(".toggle").show()
                    }
                    break
                }
            }
            if (!$(ui.item).parent().hasClass("sortable")) {
                $(ui.item).parent().addClass("subcategory")
            }
            if (list_original != list) {
                var plist = array_list.reduce(function(e, t, n) {
                    e[n] = {
                        c: t.item_id,
                        p: t.parent_id
                    };
                    return e
                }, {});
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        list: plist,
                        action: "categories_order"
                    },
                    context: document.body,
                    success: function(res) {
                        var ret = eval("(" + res + ")");
                        if (ret.error) {
                            $(".alert").show("fast");
                            $(".alert").removeClass("alert-success").removeClass("alert-info").addClass("alert-danger");
                            $(".alert").text('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong> ' + ret.error)
                        }
                        $(".alert").show("fast");
                        $(".alert").removeClass("alert-danger").removeClass("alert-info").addClass("alert-success");
                        $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Well done!</strong> ' + ret.ok)
                    },
                    error: function() {
                        $(".alert").show("fast");
                        $(".alert").removeClass("alert-success").removeClass("alert-info").addClass("alert-danger");
                        $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong> Ajax error, try again.')
                    }
                });
                list_original = list
            }
        }
    });
    $(".toggle").bind("click", function(e) {
        var t = $(this).parents("li").first().find("ul.subcategory");
        var n = $(this).closest("li").find("ul").find("li").find("ul");
        var r = $(this).closest("li").first();
        if ($(this).hasClass("fa-chevron-right")) {
            $(r).removeClass("no-nest");
            $(t).show();
            $(n).hide();
            $(this).removeClass("fa-chevron-right").addClass("fa-chevron-down")
        } else {
            $(r).addClass("no-nest");
            $(t).hide();
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-right")
        }
    });
    $(".category_div").on("mouseenter", function() {
        $(this).addClass("cat-hover")
    }).on("mouseleave", function() {
        $(this).removeClass("cat-hover")
    });
    $(".category-enable,.category_div *").on("mouseleave", function() {
        $(".category_div").removeClass("cat-hover")
    });
    $("#category-sortable button.category-enable").on("click", function() {
        id = $(this).val();
        $(".alert").fadeIn("fast");
        $(".alert").removeClass("alert-success");
        $(".alert").removeClass("alert-danger");
        $(".alert").addClass("alert-info");
        $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong><i class="fa fa-spinner fa-spin"></i></strong> This action could take a while.');
        if ($("div[category_id=" + id + "]").hasClass("disabled")) {
            enabled = 1
        } else {
            enabled = 0
        }
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: "action=enable_category&id=" + id + "&enabled=" + enabled,
            context: document.body,
            success: function(res) {
                $(".alert").removeClass("alert-info");
                var ret = eval("(" + res + ")");
                if (ret.error) {
                    $(".alert").addClass("alert-danger");
                    $(".alert").text('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong> ' + ret.error)
                }
                if (ret.ok) {
                    if (enabled == 0) {
                        $("div[category_id=" + id + "]").addClass("disabled");
                        $("div[category_id=" + id + "]").removeClass("enabled");
                        $("div[category_id=" + id + "] ").find("button.btn-white").removeClass("btn-white").addClass("btn-success").text("Enable");
                        $("button[id=category_enable_" + id + "]").tooltip("hide").attr("data-original-title", "Enable").tooltip("fixTitle").tooltip("show");
                        for (var i = 0; i < ret.affectedIds.length; i++) {
                            id = ret.affectedIds[i].id;
                            $("div[category_id=" + id + "]").addClass("disabled");
                            $("div[category_id=" + id + "]").removeClass("enabled");
                            $("div[category_id=" + id + "] ").find("button.btn-white").removeClass("btn-white").addClass("btn-success").text("Enable")
                        }
                    } else {
                        $("div[category_id=" + id + "]").removeClass("disabled");
                        $("div[category_id=" + id + "]").addClass("enabled");
                        $("div[category_id=" + id + "] ").find("button.btn-success").removeClass("btn-success").addClass("btn-white").text("Disable");
                        $("button[id=category_enable_" + id + "]").tooltip("hide").attr("data-original-title", "Disable").tooltip("fixTitle").tooltip("show");
                        for (var i = 0; i < ret.affectedIds.length; i++) {
                            id = ret.affectedIds[i].id;
                            $("div[category_id=" + id + "]").removeClass("disabled");
                            $("div[category_id=" + id + "]").addClass("enabled");
                            $("div[category_id=" + id + "] ").find("button.btn-success").removeClass("btn-success").addClass("btn-white").text("Disable")
                        }
                    }
                }
                $(".alert").addClass("alert-success");
                $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Well done!</strong> ' + ret.ok)
            },
            error: function() {
                $(".alert").removeClass("alert-info");
                $(".alert").addClass("alert-danger");
                $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong> Ajax error, try again.')
            }
        })
    });
    $("#category-sortable a.delete").on("click", function() {
        $("#category-delete-submit").attr("data-category-id", $(this).attr("data-value"))
    });
    $("#category-delete-submit").click(function() {
        var id = $("#category-delete-submit").attr("data-category-id");
        $(".alert").removeClass("alert-success");
        $(".alert").removeClass("alert-danger");
        $(".alert").fadeIn("fast");
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: "action=category_delete&id=" + id,
            context: document.body,
            success: function(res) {
                $(".alert").fadeIn("fast");
                var ret = eval("(" + res + ")");
                if (ret.error) {
                    $(".alert").addClass("alert-danger");
                    $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong>   ' + ret.error)
                }
                if (ret.ok) {
                    $(".alert").addClass("alert-success");
                    $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Well done!</strong>   ' + ret.ok);
                    $("#list_" + id).fadeOut("slow");
                    $("#list_" + id).remove()
                }
            },
            error: function() {
                $(".alert").addClass("alert-danger");
                $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>Oh snap!</strong> Ajax error, try again.')
            }
        });
        $("#dialog-delete-category").modal("hide");
        return false
    });
    $("#category-sortable button.category-edit").click(function() {
        id = $(this).val();
        $(".alert").fadeIn("fast");
        $(".alert").removeClass("alert-success");
        $(".alert").removeClass("alert-danger");
        $(".alert").addClass("alert-info");
        $(".alert").html('<button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button><strong><i class="fa fa-spinner fa-spin"></i></strong> This action could take a while.');
        if ($(".content_list_" + id + " .iframe-category").length == 0) {
            $(".iframe-category").remove();
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: "action=edit_category&id=" + id,
                context: document.body,
                success: function(e) {
                    $("div.content_list_" + id).html(e);
                    $("div.content_list_" + id).fadeIn("fast")
                }
            })
        } else {
            $(".iframe-category").remove()
        }
        $(".alert").fadeOut("fast");
        return false
    })
})