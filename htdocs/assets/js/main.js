function setImage(imgID, changeTo) {
	// change the source of an image

	current = document.getElementById(imgID).src;

	if (changeTo=="plus") {
		// change the image from a plus node to a minus node
		// first check if this node is a last item
		if (current.indexOf("last.png") >= 0) {document.getElementById(imgID).src = "node_pluslast.png";}
		else {document.getElementById(imgID).src = "node_plus.png";}
		return;
	} else {
		// change the image from a minus node to a plus node
		// first check if this node is a last item
		if (current.indexOf("last.png") >= 0) {document.getElementById(imgID).src = "node_minuslast.png";}
		else {document.getElementById(imgID).src = "node_minus.png";}
		return;
	}
}

var loaded = false;

function categoryClicked(id) {
	if(cat != id && loaded) {
		window.location.href = "http://ec2-54-243-13-79.compute-1.amazonaws.com/?cat="+id;
	}
	else if (loaded && id == '0' && window.location.href.indexOf("cat=0") == -1 ) {
		window.location.href = "http://ec2-54-243-13-79.compute-1.amazonaws.com/?cat="+id;
	}
	loaded = true;
}

$(document).ready(function(){
	$("#catbrowser").jstree(category_json).bind("select_node.jstree", function (e, data) { categoryClicked(data.rslt.obj.data("id")); });
});
