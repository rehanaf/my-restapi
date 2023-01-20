<?php
function App() {
  $resource = 'Home';
  // GET url
  $url = null;
  if( isset($_GET['url']) ) {
    $url = rtrim($_GET['url'], '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);
  }

  // Controller
  if( isset($url[0]) ) {
    if( file_exists('app/resource/' . $url[0] . '.php') ) {
      $resource = $url[0];
      unset($url[0]);
    }
}
  require_once 'app/resource/' . $resource . '.php';
}