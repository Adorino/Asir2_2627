'''
def saludoParticular(nombre):
    print(f"Hola {nombre}")

saludoParticular("Adrián")

for i in range(100):
    saludoParticular(f"chapi{i}")
'''
def sumarDossNumeros(numero1,numero2):
    return numero1+numero2
def sumarTresNumeros(numero1,numero2,numero3):
    return numero1+numero2+numero3
def sumarCincoNumeros(numero1,numero2,numero3,numero4,numero5):
    return sumarDossNumeros(numero1,numero2)+sumarTresNumeros(numero3,numero4,numero5)
print (sumarDossNumeros(8,7))
print (sumarTresNumeros(1,2,3))
print (sumarCincoNumeros(1,2,3,4,5))