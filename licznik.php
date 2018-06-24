<?php
function polnoc() /* odmierza ile sekund od danej chwili jest do konca dnia*/
{
   $teraz = date("H:i:s");
   $czas = explode(":", $teraz);
   $godziny = 23-$czas[0];
   $minuty  = 59-$czas[1];
   $sekundy = 59-$czas[2];
   $waznosc = $godziny*3600 + $minuty*60 + $sekundy;
   return $waznosc;
}

        if((!isset($_COOKIE['licznik'])) && (!strstr($_SERVER['HTTP_REFERER'], "www.nazwa-strony.pl"))) 
        {
                
                $plik = fopen("licznik.txt", "r");
                $tekst = fread($plik, filesize("licznik.txt"));
                $dane = explode(";", $tekst);
                fclose($plik);
                $plik = fopen("licznik.txt", "w");
                flock($plik, 2);
                $dane[0]++;
                fwrite($plik, "$dane[0];", 15);
                flock($plik, 3);
                fclose($plik);
                
         /*LICZNIK DZIENNY - MADE BY WOWO */
        $data = date("Y-m-d"); /*zmienna przechowuj¹ca dzisiejsz¹ datê*/
        $dzienny=fopen("dzienny.txt","r"); /*otwieramy plik, plik jest formatu yyyy-mm-dd:liczba:yyyy-mm-dd:liczba, gdzie pierwsza data jest data dzisiejsza, pierwsza liczba liczb¹ odwiedzin dzisiaj, druga data, to data wczorajsza, druga liczba to liczba odwiedzin wczoraj*/
        $dzienny_tekst =fread($dzienny, filesize("dzienny.txt")); /*czytamy caly plik do zmiennej dzienny_tekst*/
        $dane2 = explode(":", $dzienny_tekst); /*rozbijamy wczytany tekst z pliku, na daty i liczby klikniec - calosc bedzie w tabeli*/
        fclose($dzienny); /*zamykamy plik, ktory otwarlismy tylko do odczytu*/
        
        if($dane2[0]==$data) /*jesli w pierwsza data w pliku jest data dzisiejsza to dzialamy jak nizej*/
      { $dane2[1]++; /*zwiekszamy liczbe klikniec dzisiaj*/
                $dzienny=fopen("dzienny.txt","w"); /*otwieramy plik do zapisu*/
                flock($dzienny, 2); /* blokujemy plik przed zapisem*/
                fwrite($dzienny, "$dane2[0]:$dane2[1]:$dane2[2]:$dane2[3]", 30); /*zapisujemy caloœæ do pliku */
          flock($dzienny, 3); /* odblokowujemy plik */
          fclose($dzienny);   /* zamykamy plik */
        }
        else/* jeœli pierwsza data w pliku nie jest dzisiejsz¹ dat¹ */
        { $dane2[2]=$dane2[0]; /* druga date w pliku ustawiamy, ta ktora byla do tej pory pierwsza*/
          $dane2[3]=$dane2[1]; /* druga liczbe odwiedzin ustawiamy, ta ktora byla do tej pory pierwsza*/
          $dane2[0]=$data; /* ustawiamy pierwsza date w pliku na date dzisiejsza*/
          $dane2[1]=1; /* liczbe klikniec ustawiamy na 1 bo sa to pierwsze odwiedziny tego dnia*/
          $dzienny=fopen("dzienny.txt","w"); /*otwieramy plik do zapisu*/
          flock($dzienny, 2); /*blokada zapisu*/
          fwrite($dzienny, "$dane2[0]:$dane2[1]:$dane2[2]:$dane2[3]", 30); /*zapisujemy caloœæ do pliku */
          flock($dzienny, 3);/* odblokowujemy plik */
          fclose($dzienny);/* zamykamy plik */
        }
                
                
         setcookie("licznik", "zliczono", time()+polnoc()+1 ); /* cookie blokuje licznik do konca doby */
        }else{
           
                $plik = fopen("licznik.txt", "r"); /* obsluga licznika stalego*/
                $tekst = fread($plik, filesize("licznik.txt"));
                $dane = explode(";", $tekst);
                fclose($plik);
                
                $dzienny=fopen("dzienny.txt","r"); /* obsluga licznika dziennego*/ 
                $dzienny_tekst =fread($dzienny, filesize("dzienny.txt")); 
                $dane2 = explode(":", $dzienny_tekst); 
                fclose($dzienny); 
        }
?>