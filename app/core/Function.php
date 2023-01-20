<?php

function auth() {
	$headers = apache_request_headers();
	if(isset($headers["Authorization"])) {
		if(preg_match("/Bearer\s(\S+)/", $headers["Authorization"], $matches)) {
			if($matches[1] === SECRET_KEY) {
				return true;
			}
		}
	}
	return false;
}

function unauth() {
  $response=array(
    'status' => 401,
    'message' =>'Unauthorized.',
  );
  header('Content-Type: application/json');
  echo json_encode($response);
}
function nocontent() {
  $response=array(
    'status' => 204,
    'message' =>'No Content.',
  );
  header('Content-Type: application/json');
  echo json_encode($response);
}

function api($table) {
  global $url;
  $request_method=$_SERVER["REQUEST_METHOD"];
  switch ($request_method) {
    case 'GET':
      if(!empty($url[1]))
      {
        $id=intval($url[1]);
        $table->read($id);
      }
      else
      {
        $table->readAll();
      }
      break;
    case 'POST':
      if(!empty($url[1]))
      {
        $id=intval($url[1]);
        $table->update($id);
      }
      else
      {
        $table->create();
      }		
      break; 
    case 'DELETE':
      $id=intval($url[1]);
      $table->delete($id);
      break;
    default:
      // Invalid Request Method
      $response=array(
        'status' => 405,
        'message' =>'Method Not Allow.',
      );
      header('Content-Type: application/json');
      echo json_encode($response);
      break;
  }
}