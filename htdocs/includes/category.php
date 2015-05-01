  <div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
    <div id='cattitle'>
      Choose Your Topic
    </div>
<?php if(isAdmin()) { ?>
      <a href='add_category.php'>
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Category
      </a>
<?php } ?>
    <div id='catbrowser'></div>
  </div>