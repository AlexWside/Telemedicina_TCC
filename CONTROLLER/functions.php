<?php

class Functions
{

	public function VerificaPaginaAtual()
	{
		$_pagina 		= $_SERVER["REQUEST_URI"]; /* Pega o valor da página atual */
		$_pagina 		= array_filter(explode("/", $_pagina)); /* Separa a página atual pelos parametros e limpa os parametros vazios */
        $_incluir 		= 'inicio.php'; /* Atribui o valor padrão da página para página principal */
		$_parametros	= []; /* Atribui o valor padrão dos parametros para vazios */
        //echo "<pre>"; print_r($_pagina); exit;
		$_ignorar		= array('login','cliente','medico'); // Classes que ignoram validação de login

		if (@$_SESSION['cliente_logado'] != 1 and !in_array(@$_pagina[1], $_ignorar)) {
			include_once $_SESSION['pview'] . '/login.php';
			$this->CriaFooter();
			die();
		}

		if (!empty($_pagina)) {
			$_classe = $_pagina[1];
			/* Limpa o nome da Classe - Ex: meus-dados tem que virar MeusDados */
			$_classe = str_replace("-", " ", $_classe);
			$_classe = ucwords($_classe);
			$_classe = str_replace(" ", "", $_classe);

			foreach ($_pagina as $_key => $_parametro) {
				if ($_key == 0 or $_key == 1) {
					continue;
				}
				$_parametros[] = $_parametro;
                
			}

			$_fclasse = $_SESSION['pview'] . '/classes/' . strtolower($_classe) . '_class.php';

			if (file_exists($_fclasse)) {
				//echo "<pre>"; print_r($_fclasse); exit;
				include_once $_fclasse;

				if (class_exists($_classe)) {
					
					$_pagina = new $_classe;
					$_pagina->setParametros($_parametros);
				} else {
					/* Se entrou aqui, é por que a página não existe, logo devo incluir um erro de 404 */
					include_once $_SESSION['pview'] . '/404.php';
				}
			} else {
				/* Entrou aqui se o arquivo .php não existe, logo devo incluir um erro de 404 */
				include_once $_SESSION['pview'] . '/404.php';
			}
		} else {
			/* Se entrou aqui, é por que não existe parametro e nem classe, logo devo incluir a página inicial */
			include_once $_SESSION['pview'] . '/inicio.php';
		}

		$this->CriaFooter();
	}

	public function CriaHeader($_tipo = '', $_adicionais = '')
	{
		include_once $_SESSION['pview'] . '/header.php';
		if ($_tipo == '') {
			$_objHeader = new Header();
			$_objHeader->CriaCabecalho();
		} else {
			$_objHeader = new Header($_tipo[0], $_tipo[1], $_tipo[2], $_adicionais); // $_tipo 0 = Título, $_tipo 1 = Descrição, $_tipo 2 = Keywords
			$_objHeader->CriaCabecalho();
		}
	}

	public function CriaFooter()
	{
		include_once $_SESSION['pview'] . '/footer.php';
	}



}
