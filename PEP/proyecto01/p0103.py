texto1 = "Pepe es mejor persona que Juan"
print(texto1)
texto1modificado = texto1.replace("Pepe", "Juan")
print(texto1modificado)

posicionP = texto1.find("p")
print(f" Posicion de la P: {posicionP}")
print("numero de caracterres: "+str(len(texto1)))