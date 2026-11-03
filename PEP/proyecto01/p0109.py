#funcion que recibe el nombre el apellido1, el apellido2 y la edad
#y que devuelva el nombre completo y si es mayor de edad

def NombreApellidoEdad(Nombre,Apellido1,Apellido2,Edad):
    if (Edad < 18):
        return f"{Nombre} {Apellido1} {Apellido2} ed menor de edad"
    else:
        return f"{Nombre} {Apellido1} {Apellido2} es mayor de edad"

print(NombreApellidoEdad("Alberto", "Fernandez", "Sanchez", 32))
print(NombreApellidoEdad("Lemur", "Santos", "Vizcairo", 12))
