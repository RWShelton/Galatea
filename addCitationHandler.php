<?php
session_start();
if ( !isset ( $_SESSION["sessionID"] ) ){
   header("Location: hahaNotLoggedIn.php");
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Citation</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </head>
  <body>
          <header class="almost-masthead text-white text-center">
            <h1 class="mb-0 pb-0">Scholarship in Classical Receptions in SF & Fantasy</h1>
          </header>
      <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Search</a>
      <!--<a class="btn btn-primary" href="#">Sign In</a>-->
        <a class="navbar-brand" href="contactUs.php">Contact Us & Suggest Scholarship</a>
      </div>
    </nav>


    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-1">Thank you for your submission!</h1>
          </div>
        </div>
      </div>
    </header>
<?php

$sectionTitle = $_POST['title'];
$sectionTitle = ltrim($sectionTitle);
$sectionTitle = rtrim($sectionTitle);
$sourceName = $_POST['name'];
$sourceName = ltrim($sourceName);
$sourceName = rtrim($sourceName);
$language = $_POST['language'];
$language = ltrim($language);
$language = rtrim($language);
$yearOfPublication = $_POST['year_of_publication'];
$yearOfPublication = ltrim($yearOfPublication);
$yearOfPublication = rtrim($yearOfPublication);
$originalYear = $_POST['original_year'];
$originalYear = ltrim($originalYear);
$originalYear = rtrim($originalYear);
$publisher = $_POST['publisher'];
$publisher = ltrim($publisher);
$publisher = rtrim($publisher);
$placeOfPublication = $_POST['place_of_publication'];
$placeOfPublication = ltrim($placeOfPublication);
$placeOfPublication = rtrim($placeOfPublication);
$pageStart = $_POST['page_start'];
$pageStart = ltrim($pageStart);
$pageStart = rtrim($pageStart);
$pageEnd = $_POST['page_end'];
$pageEnd = ltrim($pageEnd);
$pageEnd = rtrim($pageEnd);
$edition = $_POST['edition'];
$edition = ltrim($edition);
$edition = rtrim($edition);
$AuthorFirsts = $_POST['AuthorFirstName'];
$AuthorLasts = $_POST['AuthorLastName'];
$EditorFirsts = $_POST['EditorFirstName'];
$EditorLasts = $_POST['EditorLastName'];
$TranslatorFirsts = $_POST['TranslatorFirstName'];
$TranslatorLasts = $_POST['TranslatorLastName'];
$sectionID;
$sourceID;

try {
  $db = new PDO('sqlite:./CRSFF_DB/CRSFF.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if ($sourceName != null AND $sourceName != "" AND $sourceName != " ") {
    $sourceNameQuery = "SELECT source_id FROM source WHERE name = :name";
    $stmt = $db->prepare($sourceNameQuery);
    $stmt->bindValue(':name', $sourceName);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $tempArray = $result[0];
    $sourceID = $tempArray[0];
  }

  if ($sectionTitle != null AND $sectionTitle != "" AND $sectionTitle != " ") {
    $sectionNameQuery = "SELECT section_id FROM section WHERE title = :title";
    $stmt1 = $db->prepare($sectionNameQuery);
    $stmt1->bindValue(':title', $sectionTitle);
    $sectionID = $stmt1->execute();
    $result1 = $stmt1->fetchAll();
    $tempArray1 = $result1[0];
    $sectionID = $tempArray1[0];
  }
  $insertSectionQuery = "";
  if($sourceID != null and $sectionID != null)
  {
    //check if language and year exist on that source/section combo, if not then add new section to that source with that language/year
    $languageYearQuery = "SELECT * FROM source NATURAL JOIN section WHERE source_id = " . $sourceID . " and section_id = " . $sectionID . " and language = :language and year = :year";
    $stmt2 = $db->prepare($languageYearQuery);
    $stmt2->bindValue(':language', $language);
    $stmt2->bindValue(':year', $year);
    $stmt2->execute();
    $results2 = $stmt2->fetchAll();
    if($results2[0] != null)
    {
      echo "we have that already";
    }
    else {
        $insertSourceQuery = "INSERT OR IGNORE INTO Source (name, language, year";
        if($placeOfPublication != null)
        {
          $insertSourceQuery .= ", place_of_publication";
        }
        if($originalYear != null)
        {
          $insertSourceQuery .= ", original_year";
        }
        if($Edition != null)
        {
          $insertSourceQuery .= ", edition";
        }
        $insertSourceQuery .= ") VALUES (:name, :language, :year";
        if($placeOfPublication != null)
        {
          $insertSourceQuery .= ", :place_of_publication";
        }
        if($originalYear != null)
        {
          $insertSourceQuery .= ", :original_year";
        }
        if($Edition != null)
        {
          $insertSourceQuery .= ", :edition";
        }
        $insertSourceQuery .= ")";
        //bind values;
        $insertsourcestmt = $db->prepare($insertSourceQuery);
        $insertsourcestmt->bindValue(':name', $sourceName);
        $insertsourcestmt->bindValue(':language', $language);
        $insertsourcestmt->bindValue(':year', $yearOfPublication);
        if($placeOfPublication != null)
        {
          $insertsourcestmt->bindValue(':place_of_publication', $placeOfPublication);
        }
        if($originalYear != null)
        {
          $insertsourcestmt->bindValue(':original_year', $originalYear);
        }
        if($Edition != null)
        {
          $insertsourcestmt->bindValue(':edition', $edition);
        }
        $insertsourcestmt->execute();

        $getNewSourceIDQuery = "SELECT source_id from source where name = :name and year = :year and language = :language";
        $getsourceidstmt = $db->prepare($getNewSourceIDQuery);
        $getsourceidstmt->bindValue(':name', $sourceName);
        $getsourceidstmt->bindValue(':year', $yearOfPublication);
        $getsourceidstmt->bindValue(':language', $language);
        $getsourceidstmt->execute();
        $newSourceIDResult = $getsourceidstmt->fetchAll();
        $newSourceID = $newSourceIDResult[0]['source_id'];

        $insertSectionQuery = "INSERT OR IGNORE INTO Section (title, source_id";
        if($pageStart != null)
        {
          $insertSectionQuery .= ", page_start, page_end";
        }
        $insertSectionQuery .= ") VALUES (:title, " . $newSourceID;
        if($pageStart != null)
        {
          $insertSectionQuery .= ", :page_start, :page_end";
        }
        $insertSectionQuery .= ")";
        $insertsectionstmt = $db->prepare($insertSectionQuery);
        $insertsectionstmt->bindValue(':title', $sectionTitle);
        if($pageStart != null)
        {
          $insertsectionstmt->bindValue(':page_start', $pageStart);
          $insertsectionstmt->bindValue(':page_end', $pageEnd);
        }
        $insertsectionstmt->execute();

        $getNewSectionIDQuery = "SELECT section_id from section where title = :title and source_id = " . $newSourceID;
        $getsectionidstmt = $db->prepare($getNewSectionIDQuery);
        $getsectionidstmt->bindValue(':title', $sectionTitle);
        $getsectionidstmt->execute();
        $newSectionIDResult = $getsectionidstmt->fetchAll();
        $newSectionID = $newSectionIDResult[0]['section_id'];

        if($publisher != null)
        {
          $insertPublisherQuery = "INSERT OR IGNORE INTO Publisher (publisher_name) VALUES(:publisher_name)";
          $insertpublisherstmt = $db->prepare($insertPublisherQuery);
          $insertpublisherstmt->bindValue('publisher_name', $publisher);
          $insertpublisherstmt->execute();

          $selectPublisherIDQuery = "SELECT publisher_id FROM Publisher WHERE publisher_name = :publisher_name";
          $selectpublisheridstmt = $db->prepare($selectPublisherIDQuery);
          $selectpublisheridstmt->bindValue(':publisher_name', $publisher);
          $selectpublisheridstmt->execute();
          $newPublisherIDResult = $selectpublisheridstmt->fetchAll();
          $newPublisherID = $newPublisherIDResult[0]['publisher_id'];

          $insertPublishesSourceQuery = "INSERT OR IGNORE INTO publishes_source (publisher_id, source_id) VALUES (" . $newPublisherID . ", " . $newSourceID . ");";
          $db->query($insertPublishesSourceQuery);

        }

        if($AuthorFirsts != null)
        {
          $index = count($AuthorFirsts);
          for($i = 0; $i < $index; $i++)
          {
            $insertAuthorQuery = "INSERT INTO Author (author_first_name, author_last_name) VALUES (:author_first_name, :author_last_name)";

            $insertauthorstmt = $db->prepare($insertAuthorQuery);
            $insertauthorstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
            $insertauthorstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
            $insertauthorstmt->execute();

            $selectAuthorIDQuery = "SELECT author_id FROM Author WHERE author_first_name = :author_first_name and author_last_name = :author_last_name ";
            $selectauthoridstmt = $db->prepare($selectAuthorIDQuery);
            $selectauthoridstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
            $selectauthoridstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
            $selectauthoridstmt->execute();
            $newAuthorIDResult = $selectauthoridstmt->fetchAll();
            $newAuthorID = $newAuthorIDResult[0]['author_id'];

            $insertAuthorsSectionQuery = "INSERT OR IGNORE INTO authors_section (author_id, section_id) VALUES (" . $newAuthorID . ", " . $newSectionID . ");";
            $db->query($insertAuthorsSectionQuery);
          }
        }
        if($EditorFirsts != null)
        {
          $index = count($EditorFirsts);
          for($i = 0; $i < $index; $i++)
          {
            $insertEditorQuery = "INSERT INTO Editor (editor_first_name, editor_last_name) VALUES (:editor_first_name, :editor_last_name)";
            $inserteditorstmt = $db->prepare($insertEditorQuery);
            $inserteditorstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
            $inserteditorstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
            $inserteditorstmt->execute();

            $selectEditorIDQuery = "SELECT editor_id FROM Editor WHERE editor_first_name = :editor_first_name and editor_last_name = :editor_last_name";
            $selecteditoridstmt = $db->prepare($selectEditorIDQuery);
            $selecteditoridstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
            $selecteditoridstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
            $selecteditoridstmt->execute();
            $newEditorIDResult = $selecteditoridstmt->fetchAll();
            $newEditorID = $newEditorIDResult[0]['editor_id'];
            $insertEditsSectionQuery = "INSERT OR IGNORE INTO edits_section (editor_id, section_id) VALUES (" . $newEditorID . ", " . $newSectionID . ");";
            $db->query($insertEditsSectionQuery);
          }
        }

        if($TranslatorFirsts != null)
        {
          $index = count($TranslatorFirsts);
          for($i = 0; $i < $index; $i++)
          {
            $insertTranslatorQuery = "INSERT INTO Translator (translator_first_name, translator_last_name) VALUES (:translator_first_name, :translator_last_name)";
            $inserttranslatorstmt = $db->prepare($insertTranslatorQuery);
            $inserttranslatorstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
            $inserttranslatorstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
            $inserttranslatorstmt->execute();

            $selectTranslatorIDQuery = "SELECT translator_id FROM Translator WHERE translator_first_name = :translator_first_name and translator_last_name = :translator_last_name";
            $selecttranslatoridstmt = $db->prepare($selectTranslatorIDQuery);
            $selecttranslatoridstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
            $selecttranslatoridstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
            $selecttranslatoridstmt->execute();
            $newTranslatorIDResult = $selecttranslatoridstmt->fetchAll();
            $newTranslatorID = $newTranslatorIDResult[0]['translator_id'];
            $insertTranslatesSectionQuery = "INSERT OR IGNORE INTO translates_section (translator_id, section_id) VALUES (" . $newTranslatorID . ", " . $newSectionID . ");";
            $db->query($insertTranslatesSectionQuery);
          }
        }
    }
  }
  else if($sourceID != null)
  {
    //add new section to sourceID
    $insertSectionQuery = "INSERT OR IGNORE INTO Section (title, source_id";
    if($pageStart != null)
    {
      $insertSectionQuery .= ", page_start, page_end";
    }
    $insertSectionQuery .= ") VALUES (:title, " . $sourceID;
    if($pageStart != null)
    {
      $insertSectionQuery .= ", :page_start, :page_end";
    }
    $insertSectionQuery .= ")";
    $insertsectionstmt = $db->prepare($insertSectionQuery);
    $insertsectionstmt->bindValue(':title', $sectionTitle);
    if($pageStart != null)
    {
      $insertsectionstmt->bindValue(':page_start', $pageStart);
      $insertsectionstmt->bindValue(':page_end', $pageEnd);
    }
    $insertsectionstmt->execute();

    $getNewSectionIDQuery = "SELECT section_id from section where title = :title and source_id = " . $sourceID;
    $getsectionidstmt = $db->prepare($getNewSectionIDQuery);
    $getsectionidstmt->bindValue(':title', $sectionTitle);
    $getsectionidstmt->execute();
    $newSectionIDResult = $getsectionidstmt->fetchAll();
    $newSectionID = $newSectionIDResult[0]['section_id'];

    if($publisher != null)
    {
      $insertPublisherQuery = "INSERT OR IGNORE INTO Publisher (publisher_name) VALUES(:publisher_name)";
      $insertpublisherstmt = $db->prepare($insertPublisherQuery);
      $insertpublisherstmt->bindValue('publisher_name', $publisher);
      $insertpublisherstmt->execute();

      $selectPublisherIDQuery = "SELECT publisher_id FROM Publisher WHERE publisher_name = :publisher_name";
      $selectpublisheridstmt = $db->prepare($selectPublisherIDQuery);
      $selectpublisheridstmt->bindValue(':publisher_name', $publisher);
      $selectpublisheridstmt->execute();
      $newPublisherIDResult = $selectpublisheridstmt->fetchAll();
      $newPublisherID = $newPublisherIDResult[0]['publisher_id'];

      $insertPublishesSourceQuery = "INSERT OR IGNORE INTO publishes_source (publisher_id, source_id) VALUES (" . $newPublisherID . ", " . $sourceID . ");";
      $db->query($insertPublishesSourceQuery);

    }

    if($AuthorFirsts != null)
    {
      $index = count($AuthorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertAuthorQuery = "INSERT INTO Author (author_first_name, author_last_name) VALUES (:author_first_name, :author_last_name)";

        $insertauthorstmt = $db->prepare($insertAuthorQuery);
        $insertauthorstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
        $insertauthorstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
        $insertauthorstmt->execute();

        $selectAuthorIDQuery = "SELECT author_id FROM Author WHERE author_first_name = :author_first_name and author_last_name = :author_last_name ";
        $selectauthoridstmt = $db->prepare($selectAuthorIDQuery);
        $selectauthoridstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
        $selectauthoridstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
        $selectauthoridstmt->execute();
        $newAuthorIDResult = $selectauthoridstmt->fetchAll();
        $newAuthorID = $newAuthorIDResult[0]['author_id'];

        $insertAuthorsSectionQuery = "INSERT OR IGNORE INTO authors_section (author_id, section_id) VALUES (" . $newAuthorID . ", " . $newSectionID . ");";
        $db->query($insertAuthorsSectionQuery);
      }
    }
    if($EditorFirsts != null)
    {
      $index = count($EditorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertEditorQuery = "INSERT INTO Editor (editor_first_name, editor_last_name) VALUES (:editor_first_name, :editor_last_name)";
        $inserteditorstmt = $db->prepare($insertEditorQuery);
        $inserteditorstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
        $inserteditorstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
        $inserteditorstmt->execute();

        $selectEditorIDQuery = "SELECT editor_id FROM Editor WHERE editor_first_name = :editor_first_name and editor_last_name = :editor_last_name";
        $selecteditoridstmt = $db->prepare($selectEditorIDQuery);
        $selecteditoridstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
        $selecteditoridstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
        $selecteditoridstmt->execute();
        $newEditorIDResult = $selecteditoridstmt->fetchAll();
        $newEditorID = $newEditorIDResult[0]['editor_id'];
        $insertEditsSectionQuery = "INSERT OR IGNORE INTO edits_section (editor_id, section_id) VALUES (" . $newEditorID . ", " . $newSectionID . ");";
        $db->query($insertEditsSectionQuery);
      }
    }

    if($TranslatorFirsts != null)
    {
      $index = count($TranslatorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertTranslatorQuery = "INSERT INTO Translator (translator_first_name, translator_last_name) VALUES (:translator_first_name, :translator_last_name)";
        $inserttranslatorstmt = $db->prepare($insertTranslatorQuery);
        $inserttranslatorstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
        $inserttranslatorstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
        $inserttranslatorstmt->execute();

        $selectTranslatorIDQuery = "SELECT translator_id FROM Translator WHERE translator_first_name = :translator_first_name and translator_last_name = :translator_last_name";
        $selecttranslatoridstmt = $db->prepare($selectTranslatorIDQuery);
        $selecttranslatoridstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
        $selecttranslatoridstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
        $selecttranslatoridstmt->execute();
        $newTranslatorIDResult = $selecttranslatoridstmt->fetchAll();
        $newTranslatorID = $newTranslatorIDResult[0]['translator_id'];
        $insertTranslatesSectionQuery = "INSERT OR IGNORE INTO translates_section (translator_id, section_id) VALUES (" . $newTranslatorID . ", " . $newSectionID . ");";
        $db->query($insertTranslatesSectionQuery);
      }
    }
  }
  else {
    //add new source, then add section to that source
    $insertSourceQuery = "INSERT OR IGNORE INTO Source (name, language, year";
    if($placeOfPublication != null)
    {
      $insertSourceQuery .= ", place_of_publication";
    }
    if($originalYear != null)
    {
      $insertSourceQuery .= ", original_year";
    }
    if($Edition != null)
    {
      $insertSourceQuery .= ", edition";
    }
    $insertSourceQuery .= ") VALUES (:name, :language, :year";
    if($placeOfPublication != null)
    {
      $insertSourceQuery .= ", :place_of_publication";
    }
    if($originalYear != null)
    {
      $insertSourceQuery .= ", :original_year";
    }
    if($Edition != null)
    {
      $insertSourceQuery .= ", :edition";
    }
    $insertSourceQuery .= ")";
    //bind values;
    $insertsourcestmt = $db->prepare($insertSourceQuery);
    $insertsourcestmt->bindValue(':name', $sourceName);
    $insertsourcestmt->bindValue(':language', $language);
    $insertsourcestmt->bindValue(':year', $yearOfPublication);
    if($placeOfPublication != null)
    {
      -
      $insertsourcestmt->bindValue(':place_of_publication', $placeOfPublication);
    }
    if($originalYear != null)
    {
      $insertsourcestmt->bindValue(':original_year', $originalYear);
    }
    if($Edition != null)
    {
      $insertsourcestmt->bindValue(':edition', $edition);
    }
    $insertsourcestmt->execute();

    $getNewSourceIDQuery = "SELECT source_id from source where name = :name and year = :year and language = :language";
    $getsourceidstmt = $db->prepare($getNewSourceIDQuery);
    $getsourceidstmt->bindValue(':name', $sourceName);
    $getsourceidstmt->bindValue(':year', $yearOfPublication);
    $getsourceidstmt->bindValue(':language', $language);
    $getsourceidstmt->execute();
    $newSourceIDResult = $getsourceidstmt->fetchAll();
    $newSourceID = $newSourceIDResult[0]['source_id'];

    $insertSectionQuery = "INSERT OR IGNORE INTO Section (title, source_id";
    if($pageStart != null)
    {
      $insertSectionQuery .= ", page_start, page_end";
    }
    $insertSectionQuery .= ") VALUES (:title, " . $newSourceID;
    if($pageStart != null)
    {
      $insertSectionQuery .= ", :page_start, :page_end";
    }
    $insertSectionQuery .= ")";
    $insertsectionstmt = $db->prepare($insertSectionQuery);
    $insertsectionstmt->bindValue(':title', $sectionTitle);
    if($pageStart != null)
    {
      $insertsectionstmt->bindValue(':page_start', $pageStart);
      $insertsectionstmt->bindValue(':page_end', $pageEnd);
    }
    $insertsectionstmt->execute();

    $getNewSectionIDQuery = "SELECT section_id from section where title = :title and source_id = " . $newSourceID;
    $getsectionidstmt = $db->prepare($getNewSectionIDQuery);
    $getsectionidstmt->bindValue(':title', $sectionTitle);
    $getsectionidstmt->execute();
    $newSectionIDResult = $getsectionidstmt->fetchAll();
    $newSectionID = $newSectionIDResult[0]['section_id'];

    if($publisher != null)
    {
      $insertPublisherQuery = "INSERT OR IGNORE INTO Publisher (publisher_name) VALUES(:publisher_name)";
      $insertpublisherstmt = $db->prepare($insertPublisherQuery);
      $insertpublisherstmt->bindValue('publisher_name', $publisher);
      $insertpublisherstmt->execute();

      $selectPublisherIDQuery = "SELECT publisher_id FROM Publisher WHERE publisher_name = :publisher_name";
      $selectpublisheridstmt = $db->prepare($selectPublisherIDQuery);
      $selectpublisheridstmt->bindValue(':publisher_name', $publisher);
      $selectpublisheridstmt->execute();
      $newPublisherIDResult = $selectpublisheridstmt->fetchAll();
      $newPublisherID = $newPublisherIDResult[0]['publisher_id'];

      $insertPublishesSourceQuery = "INSERT OR IGNORE INTO publishes_source (publisher_id, source_id) VALUES (" . $newPublisherID . ", " . $newSourceID . ");";
      $db->query($insertPublishesSourceQuery);

    }

    if($AuthorFirsts != null)
    {
      $index = count($AuthorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertAuthorQuery = "INSERT INTO Author (author_first_name, author_last_name) VALUES (:author_first_name, :author_last_name)";

        $insertauthorstmt = $db->prepare($insertAuthorQuery);
        $insertauthorstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
        $insertauthorstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
        $insertauthorstmt->execute();

        $selectAuthorIDQuery = "SELECT author_id FROM Author WHERE author_first_name = :author_first_name and author_last_name = :author_last_name ";
        $selectauthoridstmt = $db->prepare($selectAuthorIDQuery);
        $selectauthoridstmt->bindValue(':author_first_name', $AuthorFirsts[$i]);
        $selectauthoridstmt->bindValue(':author_last_name', $AuthorLasts[$i]);
        $selectauthoridstmt->execute();
        $newAuthorIDResult = $selectauthoridstmt->fetchAll();
        $newAuthorID = $newAuthorIDResult[0]['author_id'];

        $insertAuthorsSectionQuery = "INSERT OR IGNORE INTO authors_section (author_id, section_id) VALUES (" . $newAuthorID . ", " . $newSectionID . ");";
        $db->query($insertAuthorsSectionQuery);
      }
    }
    if($EditorFirsts != null)
    {
      $index = count($EditorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertEditorQuery = "INSERT INTO Editor (editor_first_name, editor_last_name) VALUES (:editor_first_name, :editor_last_name)";
        $inserteditorstmt = $db->prepare($insertEditorQuery);
        $inserteditorstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
        $inserteditorstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
        $inserteditorstmt->execute();

        $selectEditorIDQuery = "SELECT editor_id FROM Editor WHERE editor_first_name = :editor_first_name and editor_last_name = :editor_last_name";
        $selecteditoridstmt = $db->prepare($selectEditorIDQuery);
        $selecteditoridstmt->bindValue(':editor_first_name', $EditorFirsts[$i]);
        $selecteditoridstmt->bindValue(':editor_last_name', $EditorLasts[$i]);
        $selecteditoridstmt->execute();
        $newEditorIDResult = $selecteditoridstmt->fetchAll();
        $newEditorID = $newEditorIDResult[0]['editor_id'];
        $insertEditsSectionQuery = "INSERT OR IGNORE INTO edits_section (editor_id, section_id) VALUES (" . $newEditorID . ", " . $newSectionID . ");";
        $db->query($insertEditsSectionQuery);
      }
    }

    if($TranslatorFirsts != null)
    {
      $index = count($TranslatorFirsts);
      for($i = 0; $i < $index; $i++)
      {
        $insertTranslatorQuery = "INSERT INTO Translator (translator_first_name, translator_last_name) VALUES (:translator_first_name, :translator_last_name)";
        $inserttranslatorstmt = $db->prepare($insertTranslatorQuery);
        $inserttranslatorstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
        $inserttranslatorstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
        $inserttranslatorstmt->execute();

        $selectTranslatorIDQuery = "SELECT translator_id FROM Translator WHERE translator_first_name = :translator_first_name and translator_last_name = :translator_last_name";
        $selecttranslatoridstmt = $db->prepare($selectTranslatorIDQuery);
        $selecttranslatoridstmt->bindValue(':translator_first_name', $TranslatorFirsts[$i]);
        $selecttranslatoridstmt->bindValue(':translator_last_name', $TranslatorLasts[$i]);
        $selecttranslatoridstmt->execute();
        $newTranslatorIDResult = $selecttranslatoridstmt->fetchAll();
        $newTranslatorID = $newTranslatorIDResult[0]['translator_id'];
        $insertTranslatesSectionQuery = "INSERT OR IGNORE INTO translates_section (translator_id, section_id) VALUES (" . $newTranslatorID . ", " . $newSectionID . ");";
        $db->query($insertTranslatesSectionQuery);
      }
    }
  }
  $db = null;
} catch(PDOException $e) {
    die('Exception : '.$e->getMessage());
}
?>

<!-- Footer -->
<footer class="footer bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
        <ul class="list-inline mb-2">
          <!-- <li class="list-inline-item">
            <a href="#">About</a>
          </li> -->
          <!-- <li class="list-inline-item">&sdot;</li> -->
          <li class="list-inline-item">
            <a href="contactUs.php">Contact</a>
          </li>
          <!-- <li class="list-inline-item">&sdot;</li> -->
          <!-- <li class="list-inline-item">
            <a href="#">Terms of Use</a>
          </li> -->
          <li class="list-inline-item">&sdot;</li>
          <li class="list-inline-item">
            <a href="login_page.php">Administration</a>
          </li>
          <?php
                if (isset($_SESSION["sessionID"])){
                  echo "<li class=\"list-inline-item\">&sdot;</li>
                        <li class=\"list-inline-item\"><a href=\"logout.php\">Logout</a></li>
                        <li class=\"list-inline-item\">&sdot;</li>
                        <li class=\"list-inline-item\"><a href=\"addCitation.php\">Add Citation</a></li>
                        <li class=\"list-inline-item\">&sdot;</li>
                        <li class=\"list-inline-item\"><a href=\"create_account.php\">Create New Account</a></li>";
                }
          ?>
        </ul>

      </div>
      <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
        <ul class="list-inline mb-0">
          <li class="list-inline-item mr-3">
            <a href="https://www.facebook.com/ClassicalTraditionsScienceFiction/">
              <i class="fa fa-facebook fa-2x fa-fw"></i>
            </a>
          </li>
          <li class="list-inline-item mr-3">
            <a href="https://twitter.com/CTSFMF">
              <i class="fa fa-twitter fa-2x fa-fw"></i>
            </a>
          </li>
          <li class="list-inline-item mr-3">
            <a href="https://www.facebook.com/classicaltraditionsinmodernfantasy/">
              <i class="fa fa-facebook fa-2x fa-fw"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
