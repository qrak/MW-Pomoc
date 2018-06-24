<?php
// sprawdzamy, czy zmienna $submit jest pusta
if (empty($_POST['submit'])) {
    // wy+Ťwietlamy formularz
    echo "<table border=\"0\"><form method=\"post\">

<tr>
<td>Twoje imię/ksywka:</td>
<td><input type=\"text\" name=\"nick\" style=\"width: 250px\"></td>
</tr>
<tr>
<td>Twój e-mail:</td>
<td><input type=\"text\" name=\"email\" style=\"width: 250px\"></td>
</tr>

<tr>
<td>Wiadomość:</td>
<td><textarea name=\"tresc\" style=\"width: 300px; height: 250px;\"></textarea></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type=\"submit\" name=\"submit\" value=\"Wyślij\">&nbsp;
<input type=\"reset\" value=\"Od nowa\"></td></form>
</tr>
</p>
</table>";
}
// sprawdzamy, czy zmienne przes+éane z formularza nie s¦ů puste
elseif (!empty($_POST['email']) && !empty($_POST['nick']) && !empty($_POST['skrypt']) && !empty($_POST['tresc'])) {
    // je+-eli powy+-szy warunek jest spe+éniony tworzona jest wiadomo+Ť¦ç
    // zmienna $message zawiera tre+Ť¦ç wiadomo+Ťci
    $message = "Email:$_POST[email]\n Imie/ksywa:$_POST[nick]\nWiadomość: $_POST[tresc]";
    // zmienna $header zawiera przede wszystkim adres zwrotny
    $header = "From: $_POST[nick] <$_POST[email]>";
    // funkcja mail() za pomoc¦ů kt+-rej wiadomo+Ť¦ç zostanie wys+éana
    @mail("jkgrowin@gmail.com","Strona MW Pomoc - Nowa wiadomość","$message","$header")
    or die('<br>Nie udało się wysłać wiadomości');
    // wy+Ťwietlenie komunikatu w przypadku powodzenia 
    echo "<div align=\"center\"><strong><p>Wiadomość wysłana poprawnie. Spodziewaj się kontaktu ze strony administratora.</p></strong></div>";
}
// lub w przypadku nie wype+énienia formularza do ko+äca
else echo "<span style=\"color: #FF0000; text-align: center;\"><br>Wypełnij wszystkie pola formularza!</span>";

?> 

<div align="center"><h2></h2></div>