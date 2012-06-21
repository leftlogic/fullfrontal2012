<article id="locations">
  <h2>Locations</h2>

  <section class="locations">
    <h3>Conference</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.8336812,-0.1388816">
        <span class="address">Preston Circus, BN1 4BA</span>
        <a href="#"><span class="bullet">A.</span>Duke of York's Picturehouse</a>
        <p class="details">
          Full Frontal Javascript Conference is being held at the historic
          Duke of York's Picturehouse in Brighton. It is centrally located on Preston Circus.
        </p>
      </li>
    </ul>

    <h3>After Party</h3>
    <ul>
      <li class="venue primary-venue" data-latlng="50.82181097001707,-0.14180302619934082">
        <span class="address">Preston Circus, BN1 4BA</span>
        <a href="#"><span class="bullet">B.</span>The Loft</a>
        <p class="details">
          Please join us at the Full Frontal After Party at The Loft from 7pm until late &mdash;
          where XXXX and XXXX, our Full Monty sponsors have bought you a pint!
        </p>
      </li>
    </ul>
  </section>

  <div id="map"></div>

  <section class="locations">
    <h3>Hotels</h3>
    <ul>
      <?php echo renderTemplate('data/locations/hotels.json', 'includes/location.tmpl'); ?>
    </ul>

    <h3>Food &amp Drink</h3>
    <ul>
      <?php echo renderTemplate('data/locations/food.json', 'includes/location.tmpl'); ?>
    </ul>
  </section>

</article>