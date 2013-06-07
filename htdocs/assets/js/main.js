if (!window.location.origin)
	window.location.origin = window.location.protocol+"//"+window.location.host;

var loaded = false;

function categoryClicked(id) {
	if(cat != id && loaded) {
		window.location.href = window.location.origin+"?cat="+id;
	}
	else if (loaded && id == '0' && window.location.href.indexOf("cat=0") == -1 ) {
		window.location.href = window.location.origin+"?cat="+id;
	}
	loaded = true;
}

$(document).ready(function(){
	$("#catbrowser").jstree(category_json).bind("select_node.jstree", function (e, data) { categoryClicked(data.rslt.obj.data("id")); });
});
