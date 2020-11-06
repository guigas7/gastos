<?php

namespace App\Http\Utilities;

Class Pallete
{
	protected static $colors = [
		"Verde Piscina" => "#00796B",
		"Laranja" => "#F57C00",
		"Azul Claro" => "#03A9F4",
		"Vermelho" => "#D32F2F",
		"Verde" => "#388E3C",
		"Indigo" => "#303F9F",
		"Rosa" => "#E91E63",
		"Cinza" => "#9E9E9E",
		"Ambar" => "#FFA000",
		"Preto" => "#212121",
		"Roxo" => "#512DA8",
		"Ouro" => "#AA8139",
		"Azul" => "#1976D2",
		"Verde Claro" => "#8BC34A",
		"Amarelo" => "#FFEB3B",
		"Marrom" => "#795548",
		"Ciano" => "#0097A7",
		"Lima" => "#CDDC39",
		"Cinza Azulado" => "#607D8B",
		"Prata" => "#99948B",
	];

	public static function pick($index)
	{
		$labels = array_keys(Pallete::$colors);
		$index = $index % count($labels); // In case index is out of bounds

		return Pallete::$colors[$labels[$index]];
	}

	public static function all()
	{
		return static::$colors;
	}

	public static function size()
	{
		return count(static::$colors);
	}

	public static function jsonKeys($amnt = null)
	{
		if ($amnt == null) { 
			return json_encode(
				array_keys(
					static::$colors
				)
			);
		}
		return json_encode(
			array_keys(
				static::take($amnt)
			)
		);
	}

	public static function jsonValues($amnt = null)
	{
		if ($amnt == null) { 
			return json_encode(
				array_values(
					static::$colors
				)
			);
		}
		return json_encode(
			array_values(
				static::take($amnt)
			)
		);
	}

	public static function take($amnt)
	{
		$aux = static::$colors;
		return array_splice($aux, 0, $amnt);
	}
}
