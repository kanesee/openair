  <div id="heading" class="hero-unit">

    <!-- ############### search bar ################## -->
    <div class="row">
      <div id="search" class="col-xs-12">
        <form id="searchform" class="form-search form-group" method="GET" action=".">

        <div id="topic-name">
  <?php if( isAdmin() && $cat>0 ) { ?>
          <a href='javascript:deleteCategory()' >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </a>
  <?php } ?>
        </div>

          <div class="row">
            <div class="col-lg-12">
              <div id="search-bar" class="input-group">
                <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
                <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/category.php'); ?>
                <input id="search-input" type="text" class="form-control"
                       name='q' value="<?= $query ?>" 
                       placeholder="Search within <?= $catTitle ?>">
                <span class="input-group-addon">
                  <button type="submit" class="btn btn-danger">Search</button>
                </span>
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
        </form>
      </div>
    </div>


    <a href="" id="search-tip"
       data-toggle="modal"
       data-target="#search-tip-modal">Advanced Search Tips</a>
  </div> <!-- end id=heading -->