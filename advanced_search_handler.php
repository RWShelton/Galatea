<?php
session_start();
include 'header_footer_functions.php';
header_function();
?>


    <!-- Image Showcases -->
    <section class="showcase">
      <div class=\"container-fluid p-0\">
        <ul class="list-unstyled">
<?php
#Build WHERE constraints for main query
$titleQuery = "";
if ($_POST["title"] != null and $_POST["year_of_publication"] != null and !$_POST["language"] != null) {
  $titleQuery = " WHERE (title LIKE :title OR Source.name LIKE :title) AND year = :year_of_publication AND language LIKE :language ";
} else if ($_POST["title"] != null and $_POST["language"] != null) {
  $titleQuery = " WHERE title LIKE :title OR Source.name LIKE :title AND language LIKE :language ";
} else if ($_POST["year_of_publication"] != null and $_POST["language"] != null) {
  $titleQuery = " WHERE year= :year_of_publication AND language LIKE :language ";
} else if ($_POST["title"] != null and $_POST["year_of_publication"] != null) {
  $titleQuery = " WHERE (title LIKE :title OR Source.name LIKE :title) AND (year = :year_of_publication)";
} else if ($_POST["year_of_publication"] != null) {
  $titleQuery = " WHERE year= :year_of_publication ";
} else if ($_POST["title"] != null) {
  $titleQuery = " WHERE title LIKE :title OR Source.name LIKE :title ";
} else if ($_POST["language"] != null) {
  $titleQuery = " WHERE language LIKE :language ";
}

$authorTitleQuery = "";
if ($_POST["title"] != null and $_POST["year_of_publication"] != null and !$_POST["language"] != null) {
  $authorTitleQuery = " WHERE (Source.name LIKE :title) AND year = :year_of_publication AND language LIKE :language ";
} else if ($_POST["title"] != null and $_POST["language"] != null) {
  $authorTitleQuery = " WHERE Source.name LIKE :title AND language LIKE :language ";
} else if ($_POST["year_of_publication"] != null and $_POST["language"] != null) {
  $authorTitleQuery = " WHERE year= :year_of_publication AND language LIKE :language ";
} else if ($_POST["title"] != null and $_POST["year_of_publication"] != null) {
  $authorTitleQuery = " WHERE (Source.name LIKE :title) AND (year = :year_of_publication) ";
} else if ($_POST["year_of_publication"] != null) {
  $authorTitleQuery = " WHERE year= :year_of_publication ";
} else if ($_POST["title"] != null) {
  $authorTitleQuery = " WHERE Source.name LIKE :title ";
} else if ($_POST["language"] != null) {
  $authorTitleQuery = " WHERE language LIKE :language ";
}


$authorQuery = " NATURAL LEFT OUTER JOIN Author ";
if ($_POST["author_fname"] != null and $_POST["author_lname"] != null) {
  $authorQuery = " NATURAL JOIN (SELECT * FROM Author WHERE author_first_name LIKE :author_fname AND author_last_name LIKE :author_lname) ";
} else if ($_POST["author_fname"] != null) {
  $authorQuery = " NATURAL JOIN (SELECT * FROM Author WHERE author_first_name LIKE :author_fname) ";
} else if ($_POST["author_lname"] != null) {
  $authorQuery = " NATURAL JOIN (SELECT * FROM Author WHERE author_last_name LIKE :author_lname) ";
}

$editorQuery = " NATURAL LEFT OUTER JOIN Editor ";
if ($_POST["editor_fname"] != null and $_POST["editor_lname"] != null) {
  $editorQuery = " NATURAL JOIN (SELECT * FROM Editor WHERE editor_first_name LIKE :editor_fname AND editor_last_name LIKE :editor_lname) ";
} else if ($_POST["editor_fname"] != null) {
  $editorQuery = " NATURAL JOIN (SELECT * FROM Editor WHERE editor_first_name LIKE :editor_fname) ";
} else if ($_POST["editor_lname"] != null) {
  $editorQuery = " NATURAL JOIN (SELECT * FROM Editor WHERE editor_last_name LIKE :editor_lname) ";
}

$publisherQuery = " LEFT OUTER JOIN Publisher on Publisher.publisher_id = publishes_source.publisher_id ";
if ($_POST["publisher"] != null) {
    $publisherQuery = " NATURAL JOIN (Select * from Publisher WHERE publisher_name LIKE :publisher) ";
}


$sourceKeywordsQuery = "";
$sectionKeywordsQuery = "";
if($_POST['keyword'] != null)
{
  $Keywords = $_POST['keyword'];
  $Keywords = explode(";", $Keywords);
  $sourceKeywordsQuery = " NATURAL JOIN (SELECT * FROM source_keywords WHERE ";
  $sectionKeywordsQuery = " NATURAL JOIN (SELECT * FROM section_keywords WHERE ";
  $count = 0;
  foreach($Keywords as $word)
  {
    $sourceKeywordsQuery .= " keyword LIKE :source_keyword" . $count . " OR ";
    $sectionKeywordsQuery .= " keyword LIKE :section_keyword" . $count . " OR ";
    $count++;
  }

  $sourceKeywordsQuery = substr($sourceKeywordsQuery, 0, -4);
  $sectionKeywordsQuery = substr($sectionKeywordsQuery, 0, -4);

  $sectionKeywordsQuery .= ") ";
  $sourceKeywordsQuery .= ") ";
}


$query = "SELECT * FROM (
  SELECT section.section_id, source.source_id, section.title, source.name, source.year, source.original_year, section.page_start, section.page_end, source.place_of_publication
  FROM Section JOIN Source ON Section.source_id = Source.source_id
  NATURAL LEFT OUTER JOIN authors_section
  NATURAL LEFT OUTER JOIN authors_source"
  . $authorQuery . "
  NATURAL LEFT OUTER JOIN edits_section
  NATURAL LEFT OUTER JOIN edits_source "
  . $editorQuery . "
  NATURAL LEFT OUTER JOIN translates_section
  NATURAL LEFT OUTER JOIN translates_source
  NATURAL LEFT OUTER JOIN translator
  NATURAL LEFT OUTER JOIN publishes_source "
  . $publisherQuery . $sectionKeywordsQuery . $titleQuery .  "
);";



$authorSearchQuery = "SELECT * FROM (
  SELECT source.source_id, source.name, source.year, source.original_year, source.place_of_publication FROM Source
  NATURAL LEFT OUTER JOIN authors_source "
  . $authorQuery . "
  NATURAL LEFT OUTER JOIN edits_source "
  . $editorQuery . "
  NATURAL LEFT OUTER JOIN publishes_source "
  . $publisherQuery . $sourceKeywordsQuery . $authorTitleQuery . "
);";





#Connect to Database
#Run Query
try {
  $db = new PDO('sqlite:./CRSFF_DB/CRSFF.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmtAuthor = $db->prepare($authorSearchQuery);
  $stmt = $db->prepare($query);


  #author_last_name, author_first_name, title, name, editor_first_name, editor_last_name, place_of_publication, publisher_name, translator_first_name, translator_last_name, year, original_year, page_start, page_end
    if($_POST['keyword'] != null)
    {
      $count = 0;
      foreach($Keywords as $word)
      {
        $boundWord = $word;
        $boundWord = "%$boundWord%";
        $stmtAuthor->bindValue(':source_keyword' . $count, $boundWord);
        $stmt->bindValue(':section_keyword' . $count, $boundWord);
        $count++;
      }
    }

    if ($_POST['title'] != null) {
        $bindTitle = $_POST['title'];
        $bindTitle= "%$bindTitle%";
        $stmt->bindValue(':title', $bindTitle);
    }
    if ($_POST['year_of_publication'] != null) {
        $bindYear = $_POST['year_of_publication'];
        $stmt->bindValue(':year_of_publication', $bindYear);
    }
    if ($_POST['language'] != null) {
      $bindLanguage = $_POST['language'];
      $bindLanguage = "%$bindLanguage%";
      $stmt->bindValue(':language', $bindLanguage);
    }
    if ($_POST['author_fname'] != null) {
      $bindAuthorfname = $_POST['author_fname'];
      $bindAuthorfname = "%$bindAuthorfname%";
      $stmt->bindValue(':author_fname', $bindAuthorfname);
      $stmtAuthor ->bindValue('author_fname', $bindAuthorfname);
    }
    if ($_POST['author_lname'] != null) {
      $bindAuthorlname = $_POST['author_lname'];
      $bindAuthorlname = "%$bindAuthorlname%";
      $stmt->bindValue(':author_lname', $bindAuthorlname);
      $stmtAuthor->bindValue(':author_lname', $bindAuthorlname);
    }
    if ($_POST['editor_fname'] != null) {
      $bindEditorfname = $_POST['editor_fname'];
      $bindEditorfname = "%$bindEditorfname%";
      $stmt->bindValue(':editor_fname', $bindEditorfname);
      $stmtAuthor->bindValue(':editor_fname', $bindEditorfname);
    }
    if ($_POST['editor_lname'] != null) {
      $bindEditorlname = $_POST['editor_lname'];
      $bindEditorlname = "%$bindEditorlname%";
      $stmt->bindValue(':editor_lname', $bindEditorlname);
      $stmtAuthor->bindValue(':editor_lname', $bindEditorlname);
    }
    if ($_POST['publisher'] != null) {
      $bindPublisher = $_POST['publisher'];
      $bindPublisher = "%$bindPublisher%";
      $stmt->bindValue(':publisher', $bindPublisher);
      $stmtAuthor->bindValue(':publisher', $bindPublisher);
    }

  $results = $stmt->execute();
  $results = $stmt->fetchAll();
  $sourceResults = $stmtAuthor->execute();
  $sourceResults = $stmtAuthor->fetchAll();
  if($results == null or $results[0] == null and $sourceResults[0] == null)
  {
    echo  "<form action=\"index.php\">
            <div class=\"row justify-content-lgcenter pb-0 pt-0\">
              <div class=\"col-md-12 pb-0 pt-0 my-auto showcase-text\">
                <div class=\"row justify-content-lgcenter pb-0 pt-0\">
                  <p class=\"lead pb-0 pt-0\" formaction=\"index.php\"> Alas, this search yields no results.
                  <button type=\"submit\" class=\"btn btn-block btn-md btn-primary mb-6\" align=\"center\">Return to Search</button>
                  <br>
                  <img src=\"brettfavoritestatue.jpg\" class=\"img-fluid\" alt=\"Responsive image\">
                  </p>
                </div>
              </div>
            </div>
          </form>";
  }
    // $tempArray = $result[0];
    // $sourceID = $tempArray[0];

  #$results = $stmt->fetchAll();

  // $result = $db->query($query);
  // $row = $result->fetch(PDO::FETCH_ASSOC);
  // $currentSectionTitle = $row['title'];
  // $currentSourceName = $row['name'];

$sectionIDs = array();
$sourceIDs = array();
foreach($results as $row) {
  #Grab the information that we can
  $sourceID = $row['source_id'];
  $sectionID = $row['section_id'];

  if(!array_key_exists($sectionID, $sectionIDs))
  {

    $sectionIDs[$sectionID] = null;
    $year = $row['year'];
    $original_year = $row['original_year'];
    $title = $row['title'];
    $name = $row['name'];
    $page_start = $row['page_start'];
    $page_end = $row['page_end'];
    $place_of_publication = $row['place_of_publication'];
    #Fill authors
    $Authors = array();
    $Editors = array();
    $Translators = array();
    $Publishers = array();

    $fillAuthorsQuery = "SELECT author_first_name, author_last_name FROM authors_section NATURAL JOIN author WHERE section_id = " . $sectionID . ";";
    $authorResult = $db->query($fillAuthorsQuery);
    $authorResult = $authorResult->fetchAll(PDO::FETCH_ASSOC);

    $index = 0;
    foreach ($authorResult as $line) {
        $authorFName = $line['author_first_name'];
        $authorLName = $line['author_last_name'];
        if($authorFName != null and $authorFName != "")
        {
          $Authors[$index] = $authorLName . ", " . $authorFName;
          $index = $index + 1;
        }
    }


    $fillEditorsQuery = "SELECT editor_first_name, editor_last_name FROM edits_section NATURAL JOIN editor WHERE section_id = " . $sectionID . ";";
    $editorResult = $db->query($fillEditorsQuery);
    $editorResult = $editorResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($editorResult as $line) {
        $editorFName = $line['editor_first_name'];
        $editorLName = $line['editor_last_name'];
        $Editors[$index] = $editorFName . " " . $editorLName;
        $index = $index + 1;
    }

    $fillTranslatorsQuery = "SELECT translator_first_name, translator_last_name FROM translates_section NATURAL JOIN translator WHERE section_id = " . $sectionID . ";";
    $translatorResult = $db->query($fillTranslatorsQuery);
    $translatorResult = $translatorResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($translatorResult as $line) {
        $translatorFName = $line['translator_first_name'];
        $translatorLName = $line['translator_last_name'];
        $Translators[$index] = $translatorFName . " " . $translatorLName;
        $index = $index + 1;
    }

    $fillPublishersQuery = "SELECT publisher_name FROM publishes_source NATURAL JOIN publisher WHERE source_id = " . $sourceID . ";";
    $publisherResult = $db->query($fillPublishersQuery);
    $publisherResult = $publisherResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($publisherResult as $line) {
        $publisherName = $line['publisher_name'];
        $Publishers[$index] = $publisherName;
        $index = $index + 1;
    }
    $toPrint = "";
    //ready author names for printing

    foreach($Authors as $author)
    {
      $toPrint = $toPrint . $author . "; ";
    }
    if($Authors[0] != " " and $Authors[0] != "")
    {
      $toPrint = substr($toPrint, 0, -2);
      if(substr($toPrint, -1) != ".")
      {
        $toPrint .= ". ";
      }else {
        $toPrint .= " ";
      }
    }
    //ready section title to print
    if($title != null)
    {
      $toPrint .= "\"" . $title . ".\" ";
    }
    //ready source name to print
    if($name != null)
    {
      $toPrint .= "<i>" . $name . "</i>. ";
    }
    //ready editor names for printing
    if($Editors[0] != " ")
    {
      $toPrint .= "Edited by ";
      foreach($Editors as $editor)
      {
        $toPrint .= $editor . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);
      $toPrint .= ". ";
    }

    //ready translator names for printing
    if($Translators[0] != " ")
    {
      $toPrint .= "Translated by ";
      foreach($Translators as $translator)
      {
        $toPrint .= $translator . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);
      $toPrint .= ". ";
    }

    if($place_of_publication != null)
    {
      $toPrint .= $place_of_publication . ": ";
    }

    if($Publishers != null and $Publishers[0] != " ")
    {
      foreach($Publishers as $publisher)
      {
        $toPrint .= $publisher . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);

      if(substr($toPrint, -1) != ".")
      {
        $toPrint .= ". ";
      }else {
        $toPrint .= " ";
      }
    }

    if($year != null)
    {
      $toPrint .= $year . ". ";
    }
    if($original_year != null and $original_year != $year)
    {
      $toPrint .= "Originally Published " . $original_year . ". ";
    }

  if (isset($_SESSION["sessionID"])){
      echo  "<div class=\"row justify-content-lgcenter pb-0 pt-0\">
                <div class=\"col-9 col-lg-9 mb-2 mb-md-0\">
                <p class=\"lead pb-0 pt-0 mb-4\">" . $toPrint . "</p>
                </div>
              <div class=\"col-3 col-lg-3 mb-2 mb-md-0\">
                <form method=\"POST\" action=\"addKeyword.php\">
                  <input type=\"hidden\" name=\"source_ID\" value=\"" . $sourceID . "\">
                  <input type=\"hidden\" name=\"section_ID\" value=\"" . $sectionID . "\">
                  <button type=\"submit\" class=\"btn btn-block btn-lg btn-primary mb-3\" align=\"center\">Add Keyword</button>
                </form>
                <form method=\"POST\" action=\"deleteCitationHandler.php\">
                  <input type=\"hidden\" name=\"source_ID\" value=\"" . $sourceID . "\">
                  <input type=\"hidden\" name=\"section_ID\" value=\"" . $sectionID . "\">
                  <button type=\"submit\" class=\"btn btn-block btn-lg btn-primary mb-5\" onclick=\"return confirm('Are you sure you want to delete this item?');\" align=\"center\">Delete</button>
                </form>
              </div>
            </div>";
    } else {
          echo  "<div class=\"row justify-content-lgcenter pb-0 pt-0\" style=\"margin-left:20px\">
                  <div class=\"col-md-12 pb-0 pt-0 my-auto showcase-text\">
                    <p class=\"lead pb-0 pt-0\">" . $toPrint . "</p>
                    </div>
                </div>";
    }
    $Authors = array();
  }

  #Fill Editors
  #fill other information from source and section

  #ptint Citation
}
foreach ($sourceResults as $row) {
  #Grab the information that we can
  $sourceID = $row['source_id'];
  if(!array_key_exists($sourceID, $sourceIDs))
  {

    $sourceIDs[$sourceID] = null;
    $year = $row['year'];
    $original_year = $row['original_year'];
    $name = $row['name'];
    $place_of_publication = $row['place_of_publication'];
    #Fill authors
    $Authors = array();
    $Editors = array();
    $Translators = array();
    $Publishers = array();

    $fillAuthorsQuery = "SELECT author_first_name, author_last_name FROM authors_source NATURAL JOIN author WHERE source_id = " . $sourceID . ";";
    $authorResult = $db->query($fillAuthorsQuery);
    $authorResult = $authorResult->fetchAll(PDO::FETCH_ASSOC);

    $index = 0;
    foreach ($authorResult as $line) {
        if($line['author_first_name'] != "" and $line['author_last_name'] != "")
        {
          $authorFName = $line['author_first_name'];
          $authorLName = $line['author_last_name'];
          $Authors[$index] = $authorLName . ", " . $authorFName;
          $index = $index + 1;
        }
    }


    $fillEditorsQuery = "SELECT editor_first_name, editor_last_name FROM edits_source NATURAL JOIN editor WHERE source_id = " . $sourceID . ";";
    $editorResult = $db->query($fillEditorsQuery);
    $editorResult = $editorResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($editorResult as $line) {
        $editorFName = $line['editor_first_name'];
        $editorLName = $line['editor_last_name'];
        $Editors[$index] = $editorFName . " " . $editorLName;
        $index = $index + 1;
    }

    $fillTranslatorsQuery = "SELECT translator_first_name, translator_last_name FROM translates_source NATURAL JOIN translator WHERE source_id = " . $sourceID . ";";
    $translatorResult = $db->query($fillTranslatorsQuery);
    $translatorResult = $translatorResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($translatorResult as $line) {
        $translatorFName = $line['translator_first_name'];
        $translatorLName = $line['translator_last_name'];
        $Translators[$index] = $translatorFName . " " . $translatorLName;
        $index = $index + 1;
    }

    $fillPublishersQuery = "SELECT publisher_name FROM publishes_source NATURAL JOIN publisher WHERE source_id = " . $sourceID . ";";
    $publisherResult = $db->query($fillPublishersQuery);
    $publisherResult = $publisherResult->fetchAll(PDO::FETCH_ASSOC);
    $index = 0;
    foreach ($publisherResult as $line) {
        $publisherName = $line['publisher_name'];
        $Publishers[$index] = $publisherName;
        $index = $index + 1;
    }
    $toPrint = "";
    //ready author names for printing
    foreach($Authors as $author)
    {
      $toPrint = $toPrint . $author . "; ";
    }

    if($Authors[0] != " " and $Authors[0] != "")
    {
      $toPrint = substr($toPrint, 0, -2);
      if(substr($toPrint, -1) != ".")
      {
        $toPrint .= ". ";
      }else {
        $toPrint .= " ";
      }
    }

    //ready source name to print
    if($name != null)
    {
      $toPrint .= "<i>" . $name . ".</i> ";
    }
    //ready editor names for printing
    if($Editors[0] != " ")
    {
      $toPrint .= "Edited by ";
      foreach($Editors as $editor)
      {
        $toPrint .= $editor . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);
      $toPrint .= ". ";
    }

    //ready translator names for printing
    if($Translators[0] != " ")
    {
      $toPrint .= "Translated by ";
      foreach($Translators as $translator)
      {
        $toPrint .= $translator . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);
      $toPrint .= ". ";
    }

    if($place_of_publication != null)
    {
      $toPrint .= $place_of_publication . ": ";
    }
    if($Publishers[0] != " " and $Publishers != null)
    {
      foreach($Publishers as $publisher)
      {
        $toPrint .= $publisher . ", ";
      }
      $toPrint = substr($toPrint, 0, -2);

      if(substr($toPrint, -1) != ".")
      {
        $toPrint .= ". ";
      }else {
        $toPrint .= " ";
      }
    }

    if($year != null)
    {
      $toPrint .= $year . ". ";
    }
    if($original_year != null and $original_year != $year)
    {
      $toPrint .= "Originally Published " . $original_year . ". ";
    }

  if (isset($_SESSION["sessionID"])){
      echo  "<div class=\"row justify-content-lgcenter pb-0 pt-0\">
                <div class=\"col-9 col-lg-9 mb-2 mb-md-0\">
                <p class=\"lead pb-0 pt-0 mb-4\">" . $toPrint . "</p>
                </div>
              <div class=\"col-3 col-lg-3 mb-2 mb-md-0\">
                <form method=\"POST\" action=\"addKeyword.php\">
                  <input type=\"hidden\" name=\"source_ID\" value=\"" . $sourceID . "\">
                  <button type=\"submit\" class=\"btn btn-block btn-lg btn-primary mb-3\" align=\"center\">Add Keyword</button>
                </form>
                <form method=\"POST\" action=\"deleteCitationHandler.php\">
                  <input type=\"hidden\" name=\"source_ID\" value=\"" . $sourceID . "\">
                  <button type=\"submit\" class=\"btn btn-block btn-lg btn-primary mb-5\" onclick=\"return confirm('Are you sure you want to delete this item?');\" align=\"center\">Delete</button>
                </form>
              </div>
            </div>";
    } else {
          echo  "<div class=\"row justify-content-lgcenter\">
                  <div class=\"col-12 col-md-12 pb-0 pt-0 my-auto showcase-text\" style=\"margin-left:10px\" >
                    <p class=\"lead pb-0 pt-0\" >" . $toPrint . "</p>
                    </div>
                </div>";
    }
    }
    $Authors = array();
   }

          $db = null;
}
catch(PDOException $e)
{
 die('Exception : '.$e->getMessage());
}
?>
</ul>
</div>
</section>

<!-- Footer -->
<?php
  footer_function();
  ?>
   <!-- Bootstrap core JavaScript -->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
