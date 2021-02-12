// import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"
//import "../scripts/routes/google-maps.js"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import waystogive from './routes/ways-to-give';
import gallery from './routes/gallery';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // ways to give
  waystogive,
  // gallery
  gallery,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
