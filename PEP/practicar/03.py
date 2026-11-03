my_string = "mi string"
mi_otro_string ="mi otro string"
print(len(my_string))
print(len(mi_otro_string))
print(my_string + " " + mi_otro_string)

mi_nuevo_string = "este es un string\n con salto de linea"

my_tab = "\tstring con tabulacion"
print(my_tab)

my_scape_string = "\\t este e sun string \\n separado"
print(my_scape_string)

name, apellido, edad = "a" , "b" , 29

print('mi nombre es {} {} y mi edad es {}'.format(name, apellido, edad))
print('mi nombre es %s %s y mi edad es %s'%(name, apellido, edad))

language = "python"
a, b, c, d, e, f = language
print(a)
print(e)

language_slice = language[1:3]
print(language_slice)
language_slice = language[1:]
print(language_slice)
language_slice = language[0:6:2]
print(language_slice)