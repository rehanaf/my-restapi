<?php
class Table 
{
  protected $table;
  protected $contents;

  function __construct($table = null, $contents = []) {
    $this->table = $table;
    $this->contents = $contents;
  }
  
	function readAll()
	{
		global $mysqli;
		$query="SELECT * FROM ". $this->table;
		$data=array();
		$result=$mysqli->query($query);
		while($row=mysqli_fetch_object($result))
		{
			$data[]=$row;
		}
		$response=array(
      'status' => 200,
      'message' =>'Get List Data Successfully.',
      'data' => $data
    );
		header('Content-Type: application/json');
		echo json_encode($response);
	}
  
	function read($id=0)
	{
    global $mysqli;
		$query="SELECT * FROM ". $this->table;
		if($id != 0)
		{
			$query.=" WHERE id=".$id;
		}
		$data=array();
		$result=$mysqli->query($query);
		while($row=mysqli_fetch_object($result))
		{
      $data[]=$row;
		}
		$response=array(
							'status' => 200,
							'message' =>'Get Data Successfully.',
							'data' => $data
						);
            header('Content-Type: application/json');
            echo json_encode($response);
		 
          }
          
          public function create()
          {
			global $mysqli;
			$hitung = count(array_intersect_key($_POST, $this->contents));
			if($hitung == count($this->contents)){
			
        $result = mysqli_query($mysqli, "INSERT INTO ". $this->table ." SET " . $this->parseContents());
        
        if($result)
        {
          $response=array(
            'status' => 201,
            'message' =>'Data Added Successfully.'
          );
        }
        else
					{
            $response=array(
              'status' => 0,
							'message' =>'Data Addition Failed.'
						);
					}
			}else{
        $response=array(
          'status' => 0,
          'message' =>'Parameter Do Not Match'
        );
			}
			header('Content-Type: application/json');
			echo json_encode($response);
		}
  
  function update($id)
  {
    global $mysqli;
    $hitung = count(array_intersect_key($_POST, $this->contents));
    if($hitung == count($this->contents)){
    
          $result = mysqli_query($mysqli, "UPDATE tbl_Data SET ". $this->parseContents() ." WHERE id='$id'");
      
      if($result)
      {
        $response=array(
          'status' => 201,
          'message' =>'Data Updated Successfully.'
        );
      }
      else
      {
        $response=array(
          'status' => 500,
          'message' =>'Data Updation Failed.'
        );
      }
    }else{
      $response=array(
        'status' => 400,
        'message' =>'Parameter Do Not Match'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  function delete($id)
  {
    global $mysqli;
    $query="DELETE FROM ". $this->table ." WHERE id=".$id;
    if(mysqli_query($mysqli, $query))
    {
      $response=array(
        'status' => 200,
        'message' =>'Deleted Successfully.'
      );
    }
    else
    {
      $response=array(
        'status' => 500,
        'message' =>'Deletion Failed.'
    );
  }
  header('Content-Type: application/json');
  echo json_encode($response);
  }

  function parseContents() {
    $query = "";
    foreach($this->contents as $content) {
      $query .= $content . "='$_POST[$content]',";
    }
    return rtrim($query, ',');
  } 
}
