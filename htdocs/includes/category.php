      <button id="topic-browser-btn" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom">
        <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true">
          <span class="topic-name-text">Choose new topic</span>
        </span>
      </button>
    
<?php
  $countOf = 'approved_count';

  $sqlQuery = "SELECT * from category where parent=0";
  if (!isAdmin()) {
      $sqlQuery.= " AND id > 0";
  }
  $sqlQuery.= " ORDER BY id";
  $r = mysql_query($sqlQuery);

  $topicHtml = "<ul>";
  while ($row = mysql_fetch_array($r)) {
    $subtopicHtml = writeTopicEntry($row, $countOf, $cat, 0);
    $topicHtml .= $subtopicHtml;
  }
  $topicHtml .= "</ul>";

?>
      <div id="topic-browser" style="display: none">
        
        <div class="tree" >
          <a href=".">Artificial Intelligence</a>
<!--
          <ul>
            <li>
              <span class="glyphicon glyphicon-plus"></span>
              <a href="">Goes somewhere (187)</a>
              <ul>
                <li>
                  <span class="glyphicon glyphicon-plus"></span>
                  <a href="">Goes somewhere</a>
                </li>
                <li>
                  <span class="glyphicon glyphicon-minus"></span>
                  <a href="">Goes somewhere (5)</a>
                </li>
              </ul>
            </li>
          </ul>
-->
          <?= $topicHtml ?>
        </div>
      </div>
