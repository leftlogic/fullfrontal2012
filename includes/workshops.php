<article id="workshops">
  <h2><span>Workshops</span></h2>

  <?php 
  $workshopData = array();
  $files = array('tooling', 'html5', 'mobile');

  foreach ($files as $file) {
    array_push($workshopData, json_decode(file_get_contents(ROOT . '/data/workshops/' . $file . '.json'), true));
  }

  echo renderTemplate(array('workshops' => $workshopData), '/includes/workshop.tmpl'); 

  ?>
</article>