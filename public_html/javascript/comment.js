(function ($) {
    var selectAll = $("#select_all"),
        bulkActionSelector = $("#bulk_action")[0],
        bulkActionSubmit = $("#bulk_action_submit")[0],
        checkBoxes = $("input[name='cids\[\]']");

    bulkActionSelector.disabled = true;
    bulkActionSubmit.disabled = true;

    selectAll.on("click", function (e) {
        var selectorState = e.target.checked;

        checkBoxes.each(function () {
            this.checked = selectorState;
        });
        checkBoxes.triggerHandler("change");
    });

    checkBoxes.on("change", function () {
        var i, len, elm, checked = false;

        for (i = 0, len = checkBoxes.length; i < len; i++) {
            checked = checked || checkBoxes[i].checked;

            if (checked === true) {
                break;
            }
        }

        bulkActionSelector.disabled = !checked;
        bulkActionSubmit.disabled = !checked;
        selectAll[0].checked = checked;
    });
})(jQuery);
