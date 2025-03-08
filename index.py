
texto_cifrado = input("Digite o texto original: ")
chave = int(input("Digite a chave de deslocamento: "))

def decodificar_cesar(texto_cifrado, chave):

  # Criar um alfabeto maiúsculo e minúsculo
  alfabeto_maiusculo = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
  alfabeto_minusculo = alfabeto_maiusculo.lower()

  # Decodificar cada letra do texto
  texto_decodificado = ""
  for letra_cifrada in texto_cifrado:

      # Decodificar letra maiúscula
    if letra_cifrada in alfabeto_maiusculo:
      indice_original = alfabeto_maiusculo.index(letra_cifrada)
      indice_deslocado = (indice_original + chave) % len(alfabeto_maiusculo)
      letra_decodificada = alfabeto_maiusculo[indice_deslocado]

      # Decodificar letra minúscula
    elif letra_cifrada in alfabeto_minusculo:
      indice_original = alfabeto_minusculo.index(letra_cifrada)
      indice_deslocado = (indice_original + chave) % len(alfabeto_minusculo)
      letra_decodificada = alfabeto_minusculo[indice_deslocado]

      # Manter outros caracteres (espaços, pontuação, etc.)
    else:
      letra_decodificada = letra_cifrada

    texto_decodificado += letra_decodificada

  return texto_decodificado

texto_decodificado = decodificar_cesar(texto_cifrado, chave)
print("O texto decodificado é:", texto_decodificado)
