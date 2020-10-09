function corComum() {
  //carrega uma imagem
  var img = new Image();
  img.src = document.getElementById('logoSistema').value;

  function arredonda(v) {
      return 5 * (Math.round(v / 5));
  }

  function componentToHex(c) {
      var hex = c.toString(16);
      return hex.length == 1 ? "0" + hex : hex;
  }

  function rgbToHex(r, g, b) {
      return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
  }

  //cria um canvas invisível
  var canvas = document.createElement('canvas');
  canvas.width = img.width;
  canvas.height = img.height;
  var context = canvas.getContext('2d');

  //desenha a imagem no canvas
  context.drawImage(img, 0, 0);

  //recupera vetor de cores
  var map = context.getImageData(0, 0, img.width, img.height).data;

  //monta histograma
  var hex, r,g,b; //,alpha;
  var histograma = {};
  for (var i = 0, len = map.length; i < len; i += 4) {

      //recupera componentes de um ponto
      r = arredonda(map[i]);
      g = arredonda(map[i+1]);
      b = arredonda(map[i+2]);
      //alpha = map[i+2]; //ignora canal alpha

      //valor em hexadecimal
      hex = rgbToHex(r, g, b);

      //adiciona no histograma ou incrementa se já existir
      if (histograma[hex] === undefined) {
          histograma[hex] = 1;
      } else {
          histograma[hex]++;
      }
  }

  //recupera cor mais comum
  var corMaisComum = null;
  var frequenciaCorMaisComum = 0;
  for (var cor in histograma) {
      if (frequenciaCorMaisComum < histograma[cor]) {
          corMaisComum = cor;
          frequenciaCorMaisComum = histograma[cor];
      }
  }

}

  //console.log(corMaisComum);
