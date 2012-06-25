<!DOCTYPE html> 
<html class="noJS">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full Frontal 2012 - JavaScript Conference</title>
  
  <link rel="stylesheet" href="/fullfrontal.css">
  <link rel="shortcut icon" href="/favicon.ico">
  <!--[if lt IE 9]>
    <script>
      (function(g,b){function k(){var a=e.elements;return"string"==typeof a?a.split(" "):a}function l(a){var c={},f=a.createElement,b=a.createDocumentFragment,d=b();a.createElement=function(a){if(!e.shivMethods)return f(a);var b;b=c[a]?c[a].cloneNode():m.test(a)?(c[a]=f(a)).cloneNode():f(a);return b.canHaveChildren&&!n.test(a)?d.appendChild(b):b};a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+k().join().replace(/\w+/g,function(a){f(a);
      d.createElement(a);return'c("'+a+'")'})+");return n}")(e,d)}function h(a){var c;if(a.documentShived)return a;if(e.shivCSS&&!i){c=a.createElement("p");var b=a.getElementsByTagName("head")[0]||a.documentElement;c.innerHTML="x<style>article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}</style>";c=!!b.insertBefore(c.lastChild,b.firstChild)}j||(c=!l(a));if(c)a.documentShived=c;return a}var d=g.html5||{},n=/^<|^(?:button|form|map|select|textarea|object|iframe|option|optgroup)$/i,
      m=/^<|^(?:a|b|button|code|div|fieldset|form|h1|h2|h3|h4|h5|h6|i|iframe|img|input|label|li|link|ol|option|p|param|q|script|select|span|strong|style|table|tbody|td|textarea|tfoot|th|thead|tr|ul)$/i,i,j;(function(){var a=b.createElement("a");a.innerHTML="<xyz></xyz>";i="hidden"in a;if(!(a=1==a.childNodes.length))a:{try{b.createElement("a")}catch(c){a=!0;break a}a=b.createDocumentFragment();a="undefined"==typeof a.cloneNode||"undefined"==typeof a.createDocumentFragment||"undefined"==typeof a.createElement}j=
      a})();var e={elements:d.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:!1!==d.shivCSS,shivMethods:!1!==d.shivMethods,type:"default",shivDocument:h};g.html5=e;h(b)})(this,document);
  </script>
  <![endif]-->
  
</head>

<!--[if IE 8]><body class="ie pullout"><![endif]-->
<!--[if gt IE 8]><body class="pullout"><![endif]-->
<!--[if !IE]><!--><body class="pullout"><!--<![endif]-->

  <article id="pullout" class="tickets">
    <div class="pullout-controls">
      <a class="button pullout-close" href="/#?"><span>Close</span></a>
    </div>

    <h1>Tickets from <span class="tickets-price"><img src="/images/pound-symbol-alt.gif" width="24" height="40" class="pound-alt">150</span>+vat</h1>

<?php
  require('../utils.php');
  $conferenceData = array(
    'title' => 'Day Conference',
    'details' => array('price' => '£150'),
    'buylink' => 'https://leftlogic.stagehq.com/events/1505/booking/new',
    'note_md' => "<p>Conference ticket only</p>",
    'sold-out' => true
  );

  echo renderTemplate($conferenceData, '/pullouts/tickets.tmpl');

  $workshopTickets = array('html5', 'tooling', 'mobile');
  // shuffle($workshopTickets);

  foreach ($workshopTickets as $workshop) {
    echo renderTemplate('/data/workshops/' . $workshop . '.json', '/pullouts/tickets.tmpl');
  }

?>

    <small>
      Please note that due to the way StageHQ (our payment system) works,
      the VAT won't show up separately when buying the tickets (nor in PayPal).
      VAT has been separately added, and our VAT registration is: 993 1266 95.
      A VAT invoice can be <a href="mailto:events@leftlogic.com?subject=Add%20to%20node%20workshop%20waiting%20list">provided on request</a>.
    </small>
  </article>

  <script>
    // // Google Analytics
    // var _gaq = _gaq || [], d = document, n = 'className', g = 'getElementById', i = 'time';
    // _gaq.push(['_setAccount', 'UA-1656750-25']);
    // _gaq.push(['_trackPageview']);
    // (function() {
    //   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    //   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    // })();
  </script>

</body> 
</html>
