if (!window.location.origin)
	window.location.origin = window.location.protocol+"//"+window.location.host;

var loaded = false;
function categoryClicked(id, name) {
	$urlAdd = "";
	if(window.location.pathname.indexOf("/pending.php") == 0) {
		$urlAdd = window.location.pathname;
	}

	if(cat != id && loaded) {
		window.location.href = window.location.origin + $urlAdd + "?cat="+id;
	}
	else if (loaded && id == '0' && window.location.href.indexOf("cat=0") == -1 ) {
		window.location.href = window.location.origin + $urlAdd +"?cat="+id;
	}
	loaded = true;
}

function attachEvents() {
  $('.like').on('click', function() {
    var resource_id = $(this).attr('data-resource-id');
    if( resource_id ) {
      var numLikes = parseInt($(this).text());
//      console.log(resource_id + ': ' + numLikes);
      
      var that = this;
      $.ajax({
        url: '/services/increment-like-count.php?resource_id='+resource_id,
        type: 'GET',
        statusCode: {
          200: function() {
//            console.log('submitted Like');
            numLikes++;
            $(that).text(' '+numLikes);
            $(that).addClass('liked');
          },
          304: function() {
            // do nothing when Like already submitted by this user
            alert('You already Liked this resource before');
          },
          400: function() {
            // Something went terribly wrong
            alert('Sorry, could not submit your Like. Please contact Admin.');
          },
          401: function() {
            alert('You must be Signed In to Like a resource');
          }
        }
      });    
    }
  });
  
  $('.resource-container').hover(
    function(evt) {
      $(this).css('background-color','rgb(228, 234, 245)');
//      $(this).find('.hover-show').show();
    },
    function(evt) {
      $(this).css('background-color','');
//      $(this).find('.hover-show').hide();
    }
  );

}

function initialize() {
  if( typeof category_json !== 'undefined' ) {
	$("#catbrowser").jstree(category_json).bind("select_node.jstree",
      function (e, data) {
        categoryClicked(data.rslt.obj.data("id"),
                        data.rslt.obj.data("name"));
    });  
  }
}

$(document).ready(function(){
  initialize();
  
  attachEvents();
});

/*******************************************
 * Pending Resource scripts
 ******************************************/


function deleteResource(id) {
  var r=confirm("Are you sure you want to delete this resource?");
  if (r==true) {
    window.location = window.location.origin+"/services/delete_resource.php?id="+id;
  }
}

function editResource(id) {
  window.location = window.location.origin+"/edit_resource.php?id="+id;
}
