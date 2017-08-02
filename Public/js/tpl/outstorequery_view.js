$(".btn").button();

function review(g) {
    window.location.href = "./index.php?s=/OutstoreQuery/doReview/osm_id/" + g
};

function sumbitOUT(g) {
    window.location.href = "./index.php?s=/OutstoreQuery/doSubmitOUT/osm_id/" + g
};

function rollbackOUT(g) {
    window.location.href = "./index.php?s=/OutstoreQuery/doRollbackOUT/osm_id/" + g
};

function editOUT(g) {
    window.location.href = "./index.php?s=/OutstoreQuery/toEdit/osm_id/" + g
};