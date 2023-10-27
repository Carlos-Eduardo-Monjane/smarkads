function beet_admob_close(){
	var link = document.getElementById('beetmobilefixed');
	link.style.display = 'none'; //or
	link.style.visibility = 'hidden';
}

function beet_admob_class_remove() {
  var element = document.getElementById("beetmobilefixed");
  element.classList.remove("d-block");
}

var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-136590289-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
