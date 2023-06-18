/*---------------------------------
Pagination table
---------------------------------*/
// Pagination
var $table = document.getElementById("myTable"),
    $n = 8,
    $rowCount = $table.rows.length,
    $firstRow = $table.rows[0].firstElementChild.tagName,
    $hasHead = ($firstRow === "TH"),
    $tr = [],
    $i, $ii, $j = ($hasHead) ? 1 : 0,
    $th = ($hasHead ? $table.rows[(0)].outerHTML : "");
var $pageCount = Math.ceil($rowCount / $n);
if ($pageCount > 1) {
    for ($i = $j, $ii = 0; $i < $rowCount; $i++, $ii++)
        $tr[$ii] = $table.rows[$i].outerHTML;
    document.getElementById("tables").insertAdjacentHTML("afterend", "<div id='buttons'></div");
    sort(1);
}

function sort($p) {
    var $rows = $th,
        $s = (($n * $p) - $n);
    for ($i = $s; $i < ($s + $n) && $i < $tr.length; $i++)
        $rows += $tr[$i];

    $table.innerHTML = $rows;
    document.getElementById("buttons").innerHTML = pageButtons($pageCount, $p);
    document.getElementById("id" + $p).setAttribute("class", "active");
}

function pageButtons(pCount, cur) {
    var prevDis = (cur == 1) ? "disabled" : "";
    var nextDis = (cur == pCount) ? "disabled" : "";
  
    var buttons = "<div style='text-align: center'>";
    buttons += "<input type='button' value='<< Prev' onclick='sort(" + (cur - 1) + ")' " + prevDis + " class='pagination-button'>";
    for (var i = 1; i <= pCount; i++) {
      var activeClass = (i == cur) ? "active" : "";
      buttons += "<input type='button' id='id" + i + "' value='" + i + "' onclick='sort(" + i + ")' class='pagination-button " + activeClass + "'>";
    }
    buttons += "<input type='button' value='Next >>' onclick='sort(" + (cur + 1) + ")' " + nextDis + " class='pagination-button'>";
    buttons += "</div>";
  
    return buttons;
}
  
function changeButtonColor(button) {
    var buttons = document.getElementsByClassName('pagination-button');
    for (var i = 0; i < buttons.length; i++) {
      buttons[i].classList.remove('active');
    }
    button.classList.add('active');
}