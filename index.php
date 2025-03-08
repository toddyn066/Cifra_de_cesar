<?php
$mensagem = ''; $texto = ''; $chave = '';

if (isset($_POST['texto'], $_POST['chave'])) {
    $texto = $_POST['texto'];
    $chave = $_POST['chave'];

    function codificarcesar($texto, $chave)
    {
        $alfabeto_maiusculo = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alfabeto_minusculo = strtolower($alfabeto_maiusculo);

        $texto_codificado = "";
        for ($i = 0; $i < strlen($texto); $i++) {
            $letra_decifrada = $texto[$i];

            if (strpos($alfabeto_maiusculo, $letra_decifrada) !== false) {
                $indice_original = strpos($alfabeto_maiusculo, $letra_decifrada);
                $indice_deslocado = ($indice_original + $chave) % strlen($alfabeto_maiusculo);
                $letra_codificada = $alfabeto_maiusculo[$indice_deslocado];
            } elseif (strpos($alfabeto_minusculo, $letra_decifrada) !== false) {
                $indice_original = strpos($alfabeto_minusculo, $letra_decifrada);
                $indice_deslocado = ($indice_original + $chave) % strlen($alfabeto_minusculo);
                $letra_codificada = $alfabeto_minusculo[$indice_deslocado];
            } else {
                $letra_codificada = $letra_decifrada;
            }

            $texto_codificado .= $letra_codificada;
        }

        return $texto_codificado;
    }

    function decodificarcesar($texto, $chave)
    {
        $alfabeto_maiusculo = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alfabeto_minusculo = strtolower($alfabeto_maiusculo);

        $texto_decodificado = "";
        for ($i = 0; $i < strlen($texto); $i++) {
            $letra_cifrada = $texto[$i];

            if (strpos($alfabeto_maiusculo, $letra_cifrada) !== false) {
                $indice_original = strpos($alfabeto_maiusculo, $letra_cifrada);
                $indice_deslocado = ($indice_original - $chave) % strlen($alfabeto_maiusculo);
                $letra_decodificada = $alfabeto_maiusculo[$indice_deslocado];
            } elseif (strpos($alfabeto_minusculo, $letra_cifrada) !== false) {
                $indice_original = strpos($alfabeto_minusculo, $letra_cifrada);
                $indice_deslocado = ($indice_original - $chave) % strlen($alfabeto_minusculo);
                $letra_decodificada = $alfabeto_minusculo[$indice_deslocado];
            } else {
                $letra_decodificada = $letra_cifrada;
            }

            $texto_decodificado .= $letra_decodificada;
        }

        return $texto_decodificado;
    }

    $texto_codificado = codificarcesar($texto, $chave);
    $texto_decodificado = decodificarcesar($texto, $chave);

    if (isset($_POST['codificar'])) {
        $mensagem = $texto_codificado;
    } elseif (isset($_POST['decodificar'])) {
        $mensagem = $texto_decodificado;
    } else {
        $mensagem = "ERRO!!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Decoder</title>
</head>
<script>
    async function clipboardCopy() {
        let text = document.getElementById('copyText').textContent;
        await navigator.clipboard.writeText(text);
        const message = document.getElementById('copy-message');
        const textNode = document.createTextNode("Copiado!");
        message.appendChild(textNode);
        message.style.padding = '0.85rem';
        setTimeout(function () {
            message.innerHTML = '';
            message.style.padding = '';
        }, 2000);
    }

    function clearInput() {
        const inputContent = document.getElementById('input')
        inputContent.value = "";
        let textContent = document.getElementById('copyText').textContent;
        textContent.value = "";
    }

</script>

<body>
    <main>
        <section class="intro">
            <h1>Cifra de César: Decoder</h1>
            <p>
                Copie o seu texto para a área em baixo, indique o deslocamento de caracteres [0-26] e clique em codificar. Para descodificar um texto previamente codificado deverá colocar esse mesmo texto na área em baixo indicando o deslocamento da codificação e clicar em descodificar.
            </p>
        </section>

        <form action="" method="post">
            <label for="texto">Texto:</label> <br>
            <textarea id="input" name="texto" rows="12" required><?php echo $texto; ?></textarea>
            <br>
            <section class="chave">
                <label for="chave">Chave de deslocamento[0-26]: </label> <br>
                <input id="text" type="number" min="0" max="25" step="1" pattern="[0-9]+" id="input" name="chave"
                    value="<?php echo $chave; ?>" required>
            </section>
            <section class="submit">
                <input type="submit" value="Codificar" name="codificar">
                <input type="submit" value="Decodificar" name="decodificar">
            </section>
        </form>

        <form action="" method="post">
            <label for="resposta">Texto Final:</label> <br>
            <textarea name="resposta" id="copyText" rows="12" readonly style="cursor: no-drop"><?php echo $mensagem; ?></textarea>
            <section class="botao">
                <button type="button" id="copyButton" class="noselect" onclick="clipboardCopy()">
                    <span class="text">Copiar</span>
                    <span class="icon">
                        <svg id="Layer_1" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                            <path d="m13 20a5.006 5.006 0 0 0 5-5v-8.757a3.972 3.972 0 0 0 -1.172-2.829l-2.242-2.242a3.972 3.972 0 0 0 -2.829-1.172h-4.757a5.006 5.006 0 0 0 -5 5v10a5.006 5.006 0 0 0 5 5zm-9-5v-10a3 3 0 0 1 3-3s4.919.014 5 .024v1.976a2 2 0 0 0 2 2h1.976c.01.081.024 9 .024 9a3 3 0 0 1 -3 3h-6a3 3 0 0 1 -3-3zm18-7v11a5.006 5.006 0 0 1 -5 5h-9a1 1 0 0 1 0-2h9a3 3 0 0 0 3-3v-11a1 1 0 0 1 2 0z" />
                        </svg>
                    </span>
                </button>
            </section>
            <section class="submit">
                <input type="submit" value="Limpar" name="limpar" id="limpar" onclick="clearInput()"
                    style="width: 10rem">
            </section>
            <br>
        </form>

        <p class="copy-message" id="copy-message"></p>
    </main>

    <hr>

    <details>
        <summary>
            <h2>Cifra de César: <b>O que é?</b><h2>
        </summary>
        <div class="content">
            <p>
                A Cifra de César é uma técnica de criptografia bastante simples e provavelmente a mais conhecida de todas.
            </p>
            <br>
            <p>
                Trata-se de um tipo de cifra de substituição, na qual cada letra de um texto a ser criptografado é substituída por outra letra, presente no alfabeto porém deslocada um certo número de posições à esquerda ou à direita
            </p>
            <br>
            <p>
                Por exemplo, se usarmos uma troca de quatro posições à esquerda, cada letra é substituída pela letra que está quatro posições adiante no alfabeto, e nesse caso a letra A seria substituída pela letra E, B por sim sucessivamente.
            </p>
            <br>
            <p>
                A cifra de César recebe esse nome pois, segundo o escritor Suetônio, foi utilizada por Júlio César para se comunicar com seus generais, protegendo mensagens militares.
            </p>
            <br>
            <p>
                Essa cifra é uma cifra de substituição monoalfabética, o que significa que cada letra do texto plano é substituída por uma outra letra do alfabeto no texto criptografado (cifrado), de forma constante (sempre as mesmas letras são utilizadas). Por conta disso, ela acaba sendo extremamente simples de ser decifrada e nunca é utilizada na prática, pois não possui absolutamente nenhuma segurança. Seu valor está em aplicações educacionais e recreativas apenas.
            </p>
            <br>
            <p>
                Como o texto cifrado acaba tendo exatamente o mesmo número de caracteres do texto plano, também classificamos a cifra de césar como Monogrâmica, sendo então classificada mais corretamente como Cifra de Substituição Monoalfabética Monogrâmica.
            </p>
        </div>
    </details>

    <div class="imgContent">
        <article class="img">
            <img src="https://miro.medium.com/v2/resize:fit:1400/1*_VoqIhRr7qxIdq2NQj4Zfg.png">
        </article>
    </div>
    
    <hr>

    <div class="flip-card">
        <h3>
            Veja o exemplo a seguir, que mostra um trecho de um poema de Fernando Pessoa criptografado com rotação de 9 posições:
        </h3>
        <div class="hover">
            <div class="hover1">POEMA CRIPTOGRAFADO <b>→</b></div>
            <div class="hover2"><b>←</b> POEMA NORMAL</div>
        </div>
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <p>
                    O poeta é um fingidor <br>
                    Finge tão completamente <br>
                    Que chega a fingir que é dor <br>
                    A dor que deveras sente.
                </p>
                <p>
                    E os que leem o que escreve,<br>
                    Na dor lida sentem bem,<br>
                    Não as duas que ele teve,<br>
                    Mas só a que eles não têm.
                </p>
            </div>
            <div class="flip-card-back">
                <p>
                    X yxncj é dv orwprmxa <br>
                    Orwpn cãx lxvyuncjvnwcn <br>
                    Zdn lqnpj j orwpra zdn é mxa <br>
                    J mxa zdn mnenajb bnwcn.
                </p>
                <p>
                    N xb zdn unnv x zdn nblanen, <br>
                    Wj mxa urmj bnwcnv knv, <br>
                    Wãx jb mdjb zdn nun cnen, <br>
                    Vjb bó j zdn nunb wãx cêv.
                </p>
            </div>
        </div>
    </div>

    <footer>
        <div id="content">
            <div class="direitos-reservados">
                <h4>Página feita por <a href="https://br.linkedin.com/in/jo%C3%A3o-pedro-marcondes-a15743290?trk=people-guest_people_search-card" target="_blank">João Pedro</a></h4>
                <h4>Todos os direitos reservados © 2024 </h4>
            </div>

            <div class="titulo um">
                <h4>Referências</h4>
            </div>

            <div class="conteudo um">
                <p>
                    <strong>Decoder:</strong> <a target="_blank" href="https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://site112.com/cifra-de-cesar-codificar-descodificar&ved=2ahUKEwje--vq47WGAxWRrpUCHWDKAUEQFnoECBYQAQ&usg=AOvVaw38aWnfM1JkFX_mQk9x6-E0">Site 112</a>
                </p>
                <br>
                <p>
                    <strong>O que é Cifra de César:</strong> <a target="_blank" href="https://www.bosontreinamentos.com.br/seguranca/criptografia-cifra-de-cesar/">Bóson Treinamentos</a>
                </p>
            </div>

            <div class="titulo dois">
                <h4>Sobre</h4>
            </div>

            <div class="conteudo dois">
                <p>O objetivo da site é o desenvolvimento de um codificador/decodificador de Cifra de César, um tipo de criptografia obsoleto nos dias de hoje por ser muito conhecida, mas útil como ferramenta para aprendizado.</p>
            </div>

        </div>
    </footer>

</body>
</html>