function alerter(text){
	
	var divmasque = document.createElement("div");
	divmasque.setAttribute("id","masque");
	var divfenetremodale = document.createElement("div");	
	divfenetremodale.className = "fenetre-modale";	
	divmasque.appendChild(divfenetremodale);
	var fermeture  = document.createElement("a");	
	fermeture.className = "fermer";	
	fermeture.setAttribute("href","#nullerpart");	
	divfenetremodale.appendChild(fermeture);
	var imagefermer = document.createElement("img");	
	imagefermer.setAttribute("alt","Bouton fermer la fenêtre");
	imagefermer.setAttribute("title","Fermer la fenêtre");
	imagefermer.className ="btn-fermer";	
	imagefermer.src = "fmodale_fermer.png";
	fermeture.appendChild(imagefermer);	
	var imagelogo = document.createElement("img");
	imagelogo.setAttribute("alt","Logo CSS3");
	imagelogo.className="bombe";
	imagelogo.src ="css3.jpeg";
	divfenetremodale.appendChild(imagelogo);
	var paragraphe=document.createElement("p");
	divfenetremodale.appendChild(paragraphe);
	var text = document.createTextNode(text);
	paragraphe.appendChild(text);	
	document.body.appendChild(divmasque);
	
}

function confirmer(text,urlBtnOk){
	var divmasque = document.createElement("div");
	divmasque.setAttribute("id","masque");
	var divfenetremodale = document.createElement("div");	
	divfenetremodale.className = "fenetre-modale";	
	divmasque.appendChild(divfenetremodale);
	var fermeture  = document.createElement("a");	
	fermeture.className = "fermer";	
	fermeture.setAttribute("href","#masque");	
	divfenetremodale.appendChild(fermeture);
	var imagefermer = document.createElement("img");	
	imagefermer.setAttribute("alt","Bouton fermer la fenêtre");
	imagefermer.setAttribute("title","Fermer la fenêtre");
	imagefermer.className ="btn-fermer";	
	imagefermer.src = "fmodale_fermer.png";
	fermeture.appendChild(imagefermer);	
	var imagelogo = document.createElement("img");
	imagelogo.setAttribute("alt","Logo CSS3");
	imagelogo.className="bombe";
	imagelogo.src ="css3.jpeg";
	divfenetremodale.appendChild(imagelogo);
	var paragraphe=document.createElement("p");
	divfenetremodale.appendChild(paragraphe);
	var text = document.createTextNode(text);
	paragraphe.appendChild(text);	
	document.body.appendChild(divmasque);	
	
	var buttonCancel= document.createElement("button");
	buttonCancel.setAttribute("type","button");
	buttonCancel.className = "BtnCancel";
	var textAnnuler = document.createTextNode("Annuler");
	buttonCancel.appendChild(textAnnuler);
	
	
	var AFermeturebutton  = document.createElement("a");	
	AFermeturebutton.className = "fermer";	
	AFermeturebutton.setAttribute("href","#masque");	
	divfenetremodale.appendChild(AFermeturebutton);
	AFermeturebutton.appendChild(buttonCancel);	
	var buttonConfirm= document.createElement("button");
	var textConfirmer = document.createTextNode("Confirmer");
	buttonConfirm.appendChild(textConfirmer);
	buttonConfirm.className = "BtnConfirm";
	
	var AconfirmButton  = document.createElement("a");	
	AconfirmButton.className = "fermer";	
	AconfirmButton.setAttribute("href",urlBtnOk);		
	divfenetremodale.appendChild(AconfirmButton);
	AconfirmButton.appendChild(buttonConfirm);
	return false;	
	
	
}
