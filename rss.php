 <?php
             $xmlFile = file("http://www.pcwelt.de/rss/newsfeed.xml"); // hier wird die XML-Datei als array eingelesen.
             $parser = xml_parser_create();
             xml_set_element_handler($parser, "startElement", "endElement"); // startElement verweist auf die gleichnamige funktion welche beim erreichen des Starttags aufgerufen wird.
                                                                        // endElement verweist auf die gleichnamige funktion welche beim erreichen des Endtags aufgerufen wird.
             xml_set_character_data_handler($parser, "cdata"); // cdata verweist auf die gelichnamige funktion welche für die verarbeitung dre daten zwischen den tags zuständig ist.

             $news = array(); // das array in den die news titel und deren link gespeichert wird
             $x = 0;          // dimension das $news arrays (für jedes news eine dimension) (item)
             $y = 0;          // dimension der news dinmension (für jede news-info eine weitere dinmension in der news dimension) (title und link)
                         // z.B. die erste news:  $news[0][0] = titel und $news[0][1] = link
               //      die zweite news: $news[1][0] = titel und $news[1][1] = link
               //      die dritte news: $news[2][0] = titel und $news[2][1] = link u.s.w
             foreach($xmlFile as $elem){        // jedes element, dass das $xmlFile-Array enthält...
                     xml_parse($parser, $elem); // wird an den XML-Parser ($parser) geschickt.
                     }
             function startElement($parser, $element_name, $element_attribute){
                      global $x;
                      global $y;
                      $element_name = strtolower($element_name);
                      if($element_name=="item"){ // wenn der start-tag "item" heißt...
                         $x++;                   // wird $x um eins erhöt.
                         }
                      if($element_name == "title"){       $y = 0; } // wenn der start-tag "title" heißt, wird $y auf "0" gesetzt.
                         elseif($element_name == "link"){ $y = 1; } // wenn der start-tag "link" heißt, wird $y auf "1" gesetzt.
                            else{ $y = 2; }                     // bei allem anderrem wird $y auf 2 gesetzt.
                      }
             function endElement($parser, $element_name){
                      // tut nix :)
                      }
             function cdata($parser, $element_inhalt){
                      global $x;
                      global $y;
                      global $news;
                      if(bin2hex(trim($element_inhalt)) != "" && $x >= 1){
                         $news[$x][$y] = $element_inhalt;  // hier wird der entsprechende inhalt zwischen den start- und end-tags in das news array gespeichert, entsprechend ihren bestimmten dinensionen. s. Beispiel weiter oben.
                         }
                      }
             xml_parser_free($parser);
             echo "<marquee>++";
        // hier erfolg die ausgabe des $news-arrays
             for($x=1;$x<count($news);$x++){
                 echo "++ <a href='".$news[$x][1]."'>".$news[$x][0]."</a> ++";
                 }
             echo "++</marquee>";
    ?>
