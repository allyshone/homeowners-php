<?php 

  $people = [];

  function outputHtml($csv) {
    global $people;

    $file = fopen($csv, 'r');
    $counter = 0;
    
    while ( $line = fgetcsv($file) ) {
      foreach( $line as $k => $v ) {
        if ( $counter++ == 0 ) continue;
        single($v);
      }
    }

    return $people;
  }

  function single($value) {
    global $people;

    $name = explode(" ", $value);

    // single person
    if ( count($name) === 3 ) {
      $title = $name[0];
      $first_name = '';
      $initial = '';
      $last_name = $name[2];

      // get first_name or initial
      if ( strlen($name[1]) > 2 ) {
        $first_name = $name[1];
      } else {
        $initial =  rtrim($name[1],'.');
      }

      // push to people array
      array_push($people, (object)[
        'title' => $title,
        'first_name' => $first_name,
        'initial' => $initial,
        'last_name' => $last_name
      ]);

    } else {
      couple($value);
    }
  }

  function couple($value) {

    // check if string has 'and' or '&'
    if( preg_match('/and/i', $value) === 1 ) {
      $names = explode("and", $value);
    } else {
      $names = preg_split('/&/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }

    return preSingle($names);
  }

  function preSingle($values) {
    global $people;

    foreach( $values as $k => $v ) {
      $title = trim($v);

      // if value is only a title
      if ( $title == 'Mr' || $title == 'Dr' ) {
        $other_names = explode(" ", trim($values[1]));

        // check if only two values
        if ( strlen($title) === 2 ) {
          
          // push to people array
          array_push($people, (object)[
            'title' => $title,
            'first_name' => null,
            'initial' => null,
            'last_name' => $other_names[1]
          ]);
        
        } else {

          // push to people array
          array_push($people, (object)[
            'title' => $title,
            'first_name' => $other_names[1],
            'initial' => null,
            'last_name' => $other_names[2]
          ]);

        }

      } else {
        $name = explode(" ", trim($v));

        // check if only two values
        if ( count($name) === 2 ) {

          $title = $name[0];
          $first_name = '';
          $initial = '';
          $last_name = $name[1];
          
          // push to people array
          array_push($people, (object)[
            'title' => $title,
            'first_name' => null,
            'initial' => null,
            'last_name' => $last_name
          ]);

        } else {

          $title = $name[0];
          $first_name = '';
          $initial = '';
          $last_name = $name[2];

          // get first_name or initial
          if ( strlen($name[1]) > 2 ) {
            $first_name = $name[1];
          } else {
            $initial = rtrim($name[1],'.');
          }
          
          // push to people array
          array_push($people, (object)[
            'title' => $title,
            'first_name' => $first_name,
            'initial' => $initial,
            'last_name' => $last_name
          ]);
        }
      }

    }
  }

?>