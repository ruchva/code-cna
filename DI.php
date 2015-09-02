<?php
class Motor {
	public function __construct(){}
	public function arranca() {
		return "run run run run...";
	}
}
class MotorDiesel extends Motor {
	public function __construct() {}
}
class MotorBiodiesel extends Motor {
	public function __construct() {}
}
class Carro {
	private $motor;
	public function __construct(Motor $motor) {
		$this->motor = $motor;
		$this->motor->arranca();
	}
}

$motorDiesel = new MotorDiesel();
$motorBiodiesel = new MotorBiodiesel();
$carroDiesel = new Carro($motorDiesel);
$carroHipster = new Carro($motorBiodiesel); 




	
	
	