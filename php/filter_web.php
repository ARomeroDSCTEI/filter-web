<?php
//$ini_start = microtime( true );
/*

	https://gist.github.com/iovar/9091078
	https://sourceforge.net/projects/php-proxy/?source=navbar
*/

class filterWeb {
	private $url;
	private $dataWeb;
	private $minifiz;
	private $filterData = array();
	private $extValid = array("css", "js", "img", "audio", "video");

	public function __construct( $u, $d, $m ) {
		$this->url = $u;
		$this->filterData = ( isset( $d ) ) ? $d: false;
		$this->minifiz = $m;
	}

	public function openLink () {
		$this->dataWeb = "";
		$of = fopen( $this->url, "rb" );

		while ( ($r = fgets( $of ) ) !== false ) {
			$this->dataWeb = $this->dataWeb . $r;
		}

		fclose( $of );
		$this->dataWeb = $this->filter( $this->dataWeb );
		if ( $this->minifiz ) { $this->dataWeb = $this->minifiz( $this->dataWeb ); }
	}

	public function filter ( $d ) {
		$patron = array();
		foreach ( $this->filterData as $v ) {
			if ( in_array( $v, $this->extValid ) ) {
				switch ( trim( $v ) ) {
					case 'js':
						$patron[0] = "/<script(.*)src=(.*)\.js(.*)<\/script>/i";
						$patron[1] = "/<script(\s*|.*?)*<\/script>/i";
						$nota = "un(s) Script(s)";
					break;
					case 'css':
						$patron[0] = '/<link(.*)href=(.*)\.css(.*)\/?>/i';
						$patron[1] = "/<style(\s*|.*?)*<\/style>/i";
						$nota = "un(s) Style(s)";
					break;
					case 'img':
						$patron[0] = '/<img(.*)src=(.*)\.[png|tif|tiff|gif|bmp|jpg|jpeg](.*)\/?>/i';
						$nota = "un(s) Imagen(s)";
					break;
					case 'video':
						$patron[0] = '/<video(.*)src=(.*)\.[webm|ogg|mp4](.*)<\/video>/i';
						$nota = "un(s) Video(s)";
					break;
					case 'audio':
						$patron[0] = '/<audio(.*)src=(.*)\.[ogg|mp3](.*)<\/audio>/i';
						$nota = "un(s) Audio(s)";
					break;
				}
				$nArray = count( $patron );
				for ( $i = 0; $i < $nArray; $i++ ) {
					$d = preg_replace($patron[$i], '<div class="fs-info-excluir"><strong>!Aviso!</strong> Aqui iba ' . $nota . '</div>', $d);
				}
			}
		}
		return $d;
	}

	public function showWeb () {
		return $this->dataWeb;
	}

	public function minifiz ( $s ) {
		$s = preg_replace( "/(\/\*(\s*|.*?)*\*\/)|(\/\/.*)/i", "", $s );
		$s = preg_replace( "/[\n|\r|\t]/i", "", $s );
		$s = preg_replace( "/<!--(\s*|.*?)*-->/i", "", $s );
		return $s;
	}

}

// Ejemplo: $a = new filterWeb( "http://fenixfs.hol.es", array( "js", "css", "img" ) );
if ( empty( $_GET["url"] ) && empty( $_GET["excluir"] ) && empty( $_GET["t"] ) ) { 
	echo "false 0";
	
	// Test "- OJO -"
} else if ( $_GET["t"] == "true" ) {
		$url = "http://127.0.0.1:8080/Filter_Web/interfaz.html";
		$excluir = array("css");
	
		$a = new filterWeb( $url, $excluir );

		$a->openLink();
		echo $a->showWeb();
} else {
	if ( preg_match( "/^(http|https):\/\/(.*)+$/i", $_GET["url"] ) ) {
		$url = $_GET["url"];
		$excluir = explode( ",", $_GET["excluir"], 5 );
		$mif = ( $_GET["minifiz"] == "true" ? true: false );
		
		$a = new filterWeb( $url, $excluir, $mif );

		$a->openLink();
		echo $a->showWeb();
	} else {
		echo "false 1";
	}
}

// $end_start = microtime( true );
// $sgdTime = $ini_start - $end_start;
?>
<style>.fs-info-excluir {background: #7DB5E4;border-radius: 0.3em;box-shadow: 1px 3px 4px 5px #F6F6F6, 0 2px 5px 5px #E0A02A;color: #190E0E;margin: 0.5em auto;display: block;padding: 0.5em;font-family: Cambria;text-align: center;text-shadow: 1px 2px 2px #FFF;width: 90%;}</style>
<!--
<div style="padding: 1em;position: fixed; right: 1em; bottom: 1em; background: #E0F047; color: #000; border-radius: 50%;">
<?php
// echo $sgdTime;
?>
</div>
-->
