function send(ak,id) {
			if(ak==0)
				document.f.ak.value = "in";
			else if (ak==1)
				document.f.ak.value = "up";
			else if (ak==2) {
				if (confirm("Datensatz mit id " +id + " wirklich löschen?\n\nDiese Aktion kann nicht rückgängig gemacht werden!"))
					document.f.ak.value = "de";
				else
					return;
			}
			document.f.id.value = id;
			document.f.submit();
		}