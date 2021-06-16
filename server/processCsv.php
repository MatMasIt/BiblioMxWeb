<?php
function processCsv(){
	$f=file("data/current.csv",FILE_SKIP_EMPTY_LINES);
	$dbh = new PDO('sqlite:db');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$q=$dbh->prepare("DELETE FROM Libri");
	$q->execute();
	$i=0;
	foreach($f as $row){
		if($i==0){
			$i++;
			continue;
		}
		$aL=str_getcsv($row);
		$statement=$dbh->prepare("INSERT INTO Libri(Genere,Titolo,Autore,Editore,Serie,Lingua,Argomento,Prestito,ISBN,Note1,Note2,Posizione,Data,Inventario,Npag,Lvlbibliogr,Dewey,Paesepubblicaz,Luogoeditore,Curatore,Tipo,Traduzione,Descrizione,Identificativo) VALUES(:Genere,:Titolo,:Autore,:Editore,:Serie,:Lingua,:Argomento,:Prestito,:ISBN,:Note1,:Note2,:Posizione,:Data,:Inventario,:Npag,:Lvlbibliogr,:Dewey,:Paesepubblicaz,:Luogoeditore,:Curatore,:Tipo,:Traduzione,:Descrizione,:Identificativo)");
		$statement->execute([
		":Genere"=>$aL[0],
		":Titolo"=>$aL[1],
		":Autore"=>$aL[2],
		":Editore"=>$aL[3],
		":Serie"=>$aL[4],
		":Lingua"=>$aL[5],
		":Argomento"=>$aL[6],
		":Prestito"=>$aL[7],
		":ISBN"=>$aL[8],
		":Note1"=>$aL[9],
		":Note2"=>$aL[10],
		":Posizione"=>$aL[11],
		":Data"=>$aL[12],
		":Inventario"=>$aL[13],
		":Npag"=>$aL[14],
		":Lvlbibliogr"=>$aL[15],
		":Dewey"=>$aL[16],
		":Paesepubblicaz"=>$aL[17],
		":Luogoeditore"=>$aL[18],
		":Curatore"=>$aL[19],
		":Tipo"=>$aL[20],
		":Traduzione"=>$aL[21],
		":Descrizione"=>$aL[22],
		":Identificativo"=>$aL[23]
		]);
		$i++;
	}
	$q=$dbh->prepare("VACUUM");
	$q->execute();
	file_put_contents("lastupdate.dat",time());
}
