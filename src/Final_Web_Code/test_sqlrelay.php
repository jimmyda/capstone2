<?php
$con = sqlrcon_alloc("localhost", 9000, "", "sofa", "sofa1111", 0, 1);
$cur = sqlrcur_alloc($con);

if(!sqlrcur_sendQuery($cur, "select * from board")) {
    echo sqlrcur_errorMessage($cur);
    echo "\n";
}

sqlrcon_endSession($con);

for($row=0; $row<sqlrcur_rowCount($cur); $row++) {
    for($col=0; $col<sqlrcur_colCount($cur); $col++) {
        echo sqlrcur_getField($cur,$row,$col);
        echo ",";
    }
    echo "\n";
}

sqlrcur_free($cur);
sqlrcon_free($con);
?>