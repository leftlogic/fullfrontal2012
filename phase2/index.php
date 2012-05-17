<?php
  $thanks = false;
  $error = false;
  $email = '';

  function validEmail($e) {
    return (preg_match("/^([_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))$/", $e));
  }

  if (isset($_POST['email']) && $_POST['email'] && validEmail($_POST['email'])) {
    $email = $_POST['email'];
    $fp = fopen('emails.txt', 'a+');
    fwrite($fp, $email . "\n");
    fclose($fp);
    $thanks = true;
  } elseif (isset($_POST['email'])) {
    $error = true;
  } 
?>

<!DOCTYPE html> 
<html<?= $thanks || $error ? ' class="submitted"' : '' ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full Frontal 2012 - JavaScript Conference</title>
  
  <link rel="stylesheet" href="fullfrontal.css">
  <link rel="shortcut icon" href="/favicon.ico">
  <!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
</head>
<body>

  <header>
    <div class="ledge"></div><div class="chip"></div>
    <div class="wrapper">
      <img class="logo" src="/images/logo.png" width="140" height="130" alt="Full Frontal">
      <p>tickets go live in&hellip;</p>
      <time id="countdown" datetime="2012-05-01T17:41:00+0100">
        <div class="days">
          <span class="value">13</span>
          <span class="label">days</span>
        </div>
        <div class="hour">
          <span class="value">TH</span>
          <span class="label">hour</span>
        </div>
        <div class="mins">
          <span class="value">JU</span>
          <span class="label"><abbr title="minutes">mins</abbr></span>
        </div>
        <div class="secs">
          <span class="value">LY</span>
          <span class="label"><abbr title="seconds">secs</abbr></span>
        </div>
      </time>
    </div>
  </header>

  <div class="main"><div class="wrapper">
    <p class="lede vevent">
      <strong class="summary">Full Frontal 2012</strong> is a one day <strong>JavaScript Conference</strong> 
      <br>at the <span class="location">Duke of York’s Picturehouse in Brighton, UK </span>
      <br>on the <time class="dtstart" title="2012-11-09T09:00" datetime="2012-11-09T09:00">
        <strong>9th of November 2012</strong>
      </time>
    </p>

    <div class="tabbed-area">
      <section class="tab-content tab-register">
        <h2 class="tab <?= $thanks || $error ? ' tab-selected' : '' ?>"><span>Register your interest</span></h2>
        <div class="wrapper">
          <?php if ($thanks) : ?>
            <p>Thank you for registering your interest in Full Frontal 2012</p>
          <?php else: ?>
            <p>
              Give us your email address* and we’ll keep you up to date with all of
              the latest news about Full Frontal, including speakers, tickets and more.
            </p>
            <?php if ($error) : ?>
              <p class="error">There was an error collecting your email address, please try again.</p>
            <?php endif; ?>
            <form class="register-interest" action="/" method="post">
                <input type="email" name="email" placeholder="joe@bloggs.com" required <?php echo isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : ''; ?>>
                <button type="submit">Register</button>
            </form>
            <small>* We wont share your email address with anyone. Promise.</small>
          <?php endif; ?>
        </div>
      </section>

      <section class="tab-content tab-talk">
        <h2 class="tab"><span>Propose a talk/speaker</span></h2>
        <div class="wrapper">
          <p>
            Want to speak at Full Frontal 2011? We'd love to give you the platform
            to speak to hundreds of developers and designers, so what are you waiting for,
            <a href="mailto:events@leftlogic.com?subject=FF2012%20Speaking%20Proposal">get in touch!</a>
          </p>
        </div>
      </section>

      <section class="tab-content tab-sponsor">
        <h2 class="tab"><span>Become a <br> sponsor</span></h2>
        <div class="wrapper">
          <p>
            Find out how your company can sponsor Full Frontal by reviewing our
            <a href="/sponsorship.html">sponsorship packages</a> and
            <a href="mailto:events@leftlogic.com?subject=FF2012%20Sponsorship">get in touch</a>
            with us to discuss how we can work together.
          </p>
        </div>
      </section>

    </div>

    <div class="date-twitter">
      <time class="date" datetime="2012-11-09T09:00"><strong>09.11.12</strong></time>
      <a class="twitter" href="https://twitter.com/fullfrontalconf" title="Follow Full Frontal on Twitter">@fullfrontalconf</a>
    </div>

  </div></div>

  <footer>
    <p class="previous">
      Previous years<br>
      <a href="http://2009.full-frontal.org/">2009</a>,
      <a href="http://2010.full-frontal.org/">2010</a>,
      <a href="http://2011.full-frontal.org/">2011</a>
    </p>
    <a class="left-logic" href="http://leftlogic.com">Left Logic</a>
  </footer>

</div>

  <script src="/js/jquery.js"></script>
  <script src="/js/fullfrontal.js"></script>
  <script>
    // Google Analytics
    var _gaq = _gaq || [], d = document, n = 'className', g = 'getElementById', i = 'time';
    _gaq.push(['_setAccount', 'UA-1656750-25']);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>

</body> 
</html>