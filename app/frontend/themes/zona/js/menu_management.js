document.addEventListener('DOMContentLoaded', function (eventContentLoaded) {
    (function ($) {
        $("#jstreeMain").jstree({
            "core": {
                // so that create works
                "check_callback": true,
                "data": mainMenuData
            },
            "plugins": ["dnd", "contextmenu"],
            "contextmenu": {
                "items": function (node)
                {
                    return {
                        "rename": {
                            "label": "Ganti Nama",
                            "action": function (data) {

                                var ref = $.jstree.reference(data.reference),
                                        sel = ref.get_selected();
                                if (!sel.length) {
                                    return false;
                                }
                                ref.edit(sel);
                            },
                        },
                        "remove": {
                            "label": "Hapus",
                            "action": function (data) {
                                var ref = $.jstree.reference(data.reference),
                                        sel = ref.get_selected();
                                if (!sel.length) {
                                    return false;
                                }
                                ref.delete_node(sel);

                            },
                        }
                    }
                }
            }

        }).on('create_node.jstree', function (e, data) {
            console.log('saved');
        });




        $("#jstreeUtility").jstree({
            "core": {
                // so that create works
                "check_callback": true,
                "data": utilityMenuData
            },
            "plugins": ["dnd", "contextmenu"],
            "contextmenu": {
                "items": function (node)
                {
                    return {
                        "rename": {
                            "label": "Ganti Nama",
                            "action": function (data) {

                                var ref = $.jstree.reference(data.reference),
                                        sel = ref.get_selected();
                                if (!sel.length) {
                                    return false;
                                }
                                ref.edit(sel);
                            },
                        },
                        "remove": {
                            "label": "Hapus",
                            "action": function (data) {
                                var ref = $.jstree.reference(data.reference),
                                        sel = ref.get_selected();
                                if (!sel.length) {
                                    return false;
                                }
                                ref.delete_node(sel);

                            },
                        }
                    }
                }
            }

        }).on('create_node.jstree', function (e, data) {
            console.log('saved');
        });



        $(".add-to-tree").on("click", function () {
            var newNode = $('select#availablePage').val();
            if (null === newNode || !newNode.length) {
                swal('Pilih Page', 'Silakan pilih halaman yang akan ditampilkan di menu', 'error');
                return false;
            }
            var isMainMenu = $(this).hasClass('to-main-menu');
            for (var x in newNode) {
                var splited = newNode[x].split('|');
                var node = {id: splited[0], data: {slug: splited[1]}, text: splited[2]};

                $(isMainMenu ? '#jstreeMain' : '#jstreeUtility').jstree().create_node('#', node, "last", function () {
                    //alert("done");
                });
            }
        });
        function simplify(nodes) {
            var result = [];
            for (var n in nodes) {
                var simpL = {};
                simpL.id = nodes[n].id;
                simpL.text = nodes[n].text;
                simpL.data = {};
                simpL.data.slug = nodes[n].data.slug;
                if (typeof (nodes[n].children) !== 'undefined' && nodes[n].children.length) {
                    simpL.children = simplify(nodes[n].children);
                }
                result.push(simpL);

            }
            return result;
        }
        $(".upd-btn").on("click", function () {
            var isMainMenu = $(this).hasClass('upd-main-menu');
            var v = $(isMainMenu ? '#jstreeMain' : '#jstreeUtility').jstree(true).get_json();
            $.ajax({
                url: baseUrl + 'ajax/saveMenuPosition.php',
                data: {menu: JSON.stringify(simplify(v)), menu_type: isMainMenu ? 'main' : 'utility'},
                dataType: 'JSON',
                type: 'POST',
                beforeSend: function (xhr) {

                },
                success: function () {

                }
            });
        });
    })(jQuery);
});