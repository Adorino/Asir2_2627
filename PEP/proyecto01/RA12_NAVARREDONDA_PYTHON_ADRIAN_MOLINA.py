
import random

precio = 45.00

# Datos de entrada
edad = int(input("Introduce tu edad: "))
tipo_dia = input("Tipo de día (laboral/fin de semana): ").lower()
grupo = input("Tipo de grupo (familiar/colegio/individual): ").lower()
residencia = input("Residencia (madrid/otra provincia): ").lower()
dia_semana = input("Día de la semana (lunes-domingo): ").lower()
socio = input("¿Eres socio? (si/no): ").lower()
altura = float(input("Introduce tu altura en metros: "))

# Reglas de precio
if socio == "si" and edad > 65:
    precio = 0

elif socio == "si" and residencia == "madrid":
    precio *= 0.50

elif altura < 1.20 or edad < 4:
    precio *= 0.55

elif grupo == "colegio" and dia_semana in ["lunes", "viernes"]:
    precio *= 0.65

elif dia_semana == "jueves" and tipo_dia == "laboral":
    precio *= 0.70

elif edad < 18 and tipo_dia == "laboral":
    precio *= 0.75

elif grupo == "familiar" and residencia == "otra provincia":
    precio *= 0.80

elif 18 <= edad <= 25 and socio == "no":
    precio *= 0.90

elif dia_semana in ["sábado", "domingo"] and grupo == "familiar":
    precio *= 1.05

elif dia_semana == "miércoles" and residencia != "madrid":
    precio *= 1.10

elif tipo_dia == "fin de semana" and grupo == "individual" and residencia == "otra provincia":
    precio += 8

print(f"\nPrecio final: {precio:.2f} euros")

# Dibujar el precio en ASCII
digitos = {
    "0": [" d888  ", "d8  8b ", "888 88 ", "888 88 ", "888 88 ", "d8  8b ", " d888  "],
    "1": ["  88 ", " 888 ", "  88 ", "  88 ", "  88 ", "  88 ", "888888"],
    "2": ["d8888 ", "    88", "   d88", " d888 ", "88    ", "88    ", "888888"],
    "3": ["d8888 ", "    88", "  d888", "    88", "    88", "    88", "d8888 "],
    "4": ["88  88", "88  88", "88  88", "888888", "    88", "    88", "    88"],
    "5": ["888888", "88    ", "88    ", "d8888 ", "    88", "    88", "d8888 "],
    "6": [" d888 ", "88    ", "88    ", "d8888 ", "88  88", "88  88", " d888 "],
    "7": ["888888", "    88", "   88 ", "  88  ", " 88   ", "88    ", "88    "],
    "8": [" d888 ", "88  88", "88  88", " d888 ", "88  88", "88  88", " d888 "],
    "9": [" d888 ", "88  88", "88  88", " d8888", "    88", "    88", " d888 "],
    ".": ["   ", "   ", "   ", "   ", "   ", "   ", "  ."]
}

texto = f"{precio:.2f}"

print("\nPrecio en ASCII:\n")

for fila in range(7):
    for caracter in texto:
        print(digitos[caracter][fila], end="  ")
    print()
