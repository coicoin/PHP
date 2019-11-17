<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	class Product {
		public $list = []; //пустой массив

		//конструктор
		public function __construct($good, $name, $type, $price) {
			$this->list[] = [
				'good' => $good,
				'name' => $name,
				'type' => $type,
				'price' => $price
			];
		}

		//добавить товар
		public function add($good, $name, $type, $price) {
			$this->list[] = [
				'good' => $good,
				'name' => $name,
				'type' => $type,
				'price' => $price
			];
		}

		//печать
		function print_all() {
			echo "<span><b>Товар в наличии</b></span><br/>";
			/* при обращении к переменной внутри класса нужно использовать $this->имя_переменной*/
			foreach ($this->list as $key => $value) {
				/* так как массив ассоциативный, то для получения доступа к какому то эллементу нужно указывать в ключ*/
				foreach ($this->list[$key] as $good => $item) {
					echo $good.": ".$item."<br/>";
				}
				echo "-----------------------------------------<br/>";
			}
		}

		//сумма стоимости товара
		function sum() {
			$result = 0;
			foreach ($this->list as $key => $value) {
				$result += $value['price'];
			}
			echo "Итого товара на общую сумму: ".$result;
		}
	}

	$fence = new Product ("whitefence", "eurofence", "metall", 20000);
	$fence->add("greenfence", "eurofence2", "metall2", 21000);
	$fence->add("bluefence", "eurofence3", "metall3", 20000);
	$fence->add("redfence", "eurofence4", "metall4", 21000);

	$fence->print_all();
	$fence->sum();
?>