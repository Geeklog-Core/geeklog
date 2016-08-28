var adminCommentList = function (SUFFIX) {
    var selectAll = jQuery("#select_all" + SUFFIX),
        bulkActionSelector = jQuery("#bulk_action" + SUFFIX)[0],
        bulkActionSubmit = jQuery("#bulk_action_submit" + SUFFIX)[0],
        checkBoxes = jQuery("input[name='cids" + SUFFIX + "\[\]']");

    // Initialize
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
        var i, len, checked = false;

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
};

var adminCommentListComments = new adminCommentList("_comments"),
    adminCommentListSubmissions = new adminCommentList("_submissions");
