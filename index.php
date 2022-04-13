<?php 
  include_once('csv.php');

  $display_names = '';
  if ( isset($_POST['upload']) && $_POST['upload'] == 'Upload CSV' ) {
    $upload_dir = getcwd().DIRECTORY_SEPARATOR.'/uploads';

    if ( $_FILE['csv']['error'] == UPLOAD_ERR_OK ) {
      $tmp_name = $_FILES['csv']['tmp_name'];
      $name = basename( $_FILES['csv']['name'] );
      move_uploaded_file( $tmp_name, $upload_dir.'/'.$name );
      $csv_file = $upload_dir.'/'.$name;

      $display_names = outputHtml($csv_file);
    } 
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>CSV Upload</title>
    <style type="text/css">
      header,
      .csv-app {
        margin: 0 auto;
        max-width: 600px;
        text-align: center;
      }

      h1 {
        font-size: 2em;
        text-align: center;
      }

      .csv-app__results {
        margin: 20px 0;
      }

      .results__header,
      .results__row {
        display: flex;
      }

      .results__item {
        text-align: left;
        width: 25%;
      }

      .results__row:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.3);
      }
    </style>
  </head>   
  <body>
    <header>
      <h1>Street - Upload CSV Application</h1>
    </header>
    <main class="csv-app">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="csv" />
        <input type="submit" name="upload" value="Upload CSV" />
      </form>
        <?php
          $html = '';

          if ( count($display_names) > 0 ) {
            $html = '<div class="csv-app__results results">
              <div class="results__header">
                <div class="results__item">Title</div>
                <div class="results__item">First Name</div>
                <div class="results__item">Initial</div>
                <div class="results__item">Last Name</div>
              </div>';

            foreach($display_names as $name){
              $html.= '<div class="results__row">';
                $html.= '<div class="results__item">' . $name->title . '</div>';
                $html.= '<div class="results__item">' . $name->first_name . '</div>';
                $html.= '<div class="results__item">' . $name->initial . '</div>';
                $html.= '<div class="results__item">' . $name->last_name . '</div>';
              $html.= '</div>';
            }
            
            $html.= '</div>';
          }

          echo $html;
        ?>
      </div>
    </main>
  </body>
</html>